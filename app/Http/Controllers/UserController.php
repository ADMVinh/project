<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('user.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)->where('id', $order_id)->first();
        if ($order) {
            $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id', $order_id)->first();
            return view('user.order-details', compact('order', 'orderItems', 'transaction'));
        } else {
            return redirect()->route('login');
        }
    }

    public function order_cancel(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = 'Canceled';
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with('status', "Đơn hàng đã được hủy thành công!");
    }
    public function showAddress()
    {
        $user_id = Auth::id(); // Lấy ID của user hiện tại
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

        return view('user.address', compact('address'));
    }
  
    public function editAddress(Request $request, $id)
    {
        $address = Address::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($request->isMethod('post')) {
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

            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->locality = $request->locality;
            $address->landmark = $request->landmark;
            $address->country = $request->country ?? $address->country;
            $address->isdefault = $request->isdefault ?? $address->isdefault;
            $address->save();

            return redirect()->route('user.address')->with('success', 'Địa chỉ đã được cập nhật thành công.');
        }

        return view('user.edit_address', compact('address'));
    }

    

    
}
