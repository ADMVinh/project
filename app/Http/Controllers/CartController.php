<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    public function apply_coupon_code(Request $request)
{
    $coupon_code = $request->coupon_code;
    if (isset($coupon_code)) {
        // ✅ Chuyển subtotal thành số để so sánh
        $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
        
        $coupon = Coupon::where('code', $coupon_code)
            ->where('expiry_date', '>=', Carbon::today())
            ->where('cart_value', '<=', $cartSubtotal)
            ->first();
            
        if (!$coupon) {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ!');
        } else {
            Session::put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value
            ]);
            $this->calculateDiscount();
            return redirect()->back()->with('success', 'Đã áp dụng phiếu giảm giá thành công!');
        }
    } else {
        return redirect()->back()->with('error', 'Vui lòng nhập mã giảm giá!');
    }
}

public function calculateDiscount()
{
    $discount = 0;
    if (Session::has('coupon')) {
        // ✅ Chuyển subtotal thành số
        $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
        
        if (Session::get('coupon')['type'] == 'fixed') {
            $discount = Session::get('coupon')['value'];
        } else {
            $discount = ($cartSubtotal * Session::get('coupon')['value']) / 100;
        }

        $subtotalAfterDiscount = $cartSubtotal - $discount;
        $taxAfterDiscount = ($subtotalAfterDiscount * config('cart.tax')) / 100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

        Session::put('discounts', [
            'discount' => number_format(floatval($discount), 2, '.', ''),
            'subtotal' => number_format(floatval($subtotalAfterDiscount), 2, '.', ''),
            'tax' => number_format(floatval($taxAfterDiscount), 2, '.', ''),
            'total' => number_format(floatval($totalAfterDiscount), 2, '.', '')
        ]);
    }
}

    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return back()->with('success', 'Đã xóa phiếu giảm giá thành công!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }

            public function place_an_order(Request $request)
        {
            $user_id = Auth::user()->id;
            $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

            if (!$address) {
                $request->validate([
                    'name' => 'required|max:100',
                    'phone' => 'required|numeric|digits:10',
                    'zip' => 'required|numeric|digits:6',
                    'state' => 'required',
                    'city' => 'required',
                    'address' => 'required',
                    'locality' => 'required',
                    'landmark' => 'required',
                ]);
                $address = new Address;
                $address->fill($request->only([
                    'name', 'phone', 'zip', 'state', 'city',
                    'address', 'locality', 'landmark', 'country'
                ]));
                $address->user_id = $user_id;
                $address->isdefault = true;
                $address->save();
            }

            // ✅ Làm sạch dữ liệu tiền tệ trước khi lưu
            $this->setAmountforCheckout();

            $subtotal = floatval(str_replace(',', '', Session::get('checkout')['subtotal']));
            $discount = floatval(str_replace(',', '', Session::get('checkout')['discount']));
            $tax = floatval(str_replace(',', '', Session::get('checkout')['tax']));
            $total = floatval(str_replace(',', '', Session::get('checkout')['total']));
            

            // ✅ Tạo đơn hàng
            $order = new Order();
            $order->user_id = $user_id;
            $order->subtotal = $subtotal;
            $order->discount = $discount;
            $order->tax  = $tax;
            $order->total = $total;
            $order->name = $address->name;
            $order->phone  = $address->phone;
            $order->locality = $address->locality;
            $order->address = $address->address;
            $order->city = $address->city;
            $order->state  = $address->state;
            $order->country = $address->country;
            $order->landmark = $address->landmark;
            $order->zip = $address->zip;
            $order->save();

            foreach (Cart::instance('cart')->content() as $item) {
                $orderItem = new OrderItem();
                $orderItem->product_id = $item->id;
                $orderItem->order_id = $order->id;
                $orderItem->price = $item->price;
                $orderItem->quantity = $item->qty;
                $orderItem->save();
            }

            if ($request->mode == "cod") {
                $transaction = new Transaction();
                $transaction->user_id = $user_id;
                $transaction->order_id = $order->id;
                $transaction->mode = $request->mode;
                $transaction->status = "pending";
                $transaction->save();
            }

            Cart::instance('cart')->destroy();
            Session::forget(['checkout', 'coupon', 'discounts']);
            Session::put('order_id', $order->id);

            return redirect()->route('cart.order.confirmation');
        }


    

    public function setAmountforCheckout()
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
                'coupon' => Session::get('coupon')['code']
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total()
            ]);
        }
    }

    public function order_confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}
