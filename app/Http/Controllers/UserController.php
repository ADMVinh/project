<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
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

    
            // Hiển thị form đánh giá sản phẩm
        public function review_product($order_item_id)
        {
            $orderItem = OrderItem::with('product', 'order')
                ->where('id', $order_item_id)
                ->whereHas('order', function($query) {
                    $query->where('user_id', Auth::id())
                        ->where('status', 'delivered');
                })
                ->firstOrFail();
            
            // Check if already reviewed
            $existingReview = Review::where('order_item_id', $order_item_id)
                ->where('user_id', Auth::id())
                ->first();
            
            if ($existingReview) {
                return redirect()->route('user.orders')
                    ->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
            }
            
            return view('user.review-product', compact('orderItem'));
        }

        // Lưu đánh giá
        public function review_store(Request $request)
        {
            $request->validate([
                'order_item_id' => 'required|exists:order_items,id',
                'product_id' => 'required|exists:products,id',
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'nullable|string|max:255',
                'comment' => 'required|string|max:1000'
            ]);
            
            // Verify order item belongs to user and is delivered
            $orderItem = OrderItem::with('order')
                ->where('id', $request->order_item_id)
                ->whereHas('order', function($query) {
                    $query->where('user_id', Auth::id())
                        ->where('status', 'delivered');
                })
                ->firstOrFail();
            
            // Check if already reviewed
            $existingReview = Review::where('order_item_id', $request->order_item_id)
                ->where('user_id', Auth::id())
                ->first();
            
            if ($existingReview) {
                return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
            }
            
            $review = new Review();
            $review->product_id = $request->product_id;
            $review->user_id = Auth::id();
            $review->order_item_id = $request->order_item_id;
            $review->rating = $request->rating;
            $review->title = $request->title;
            $review->comment = $request->comment;
            $review->verified_purchase = true;
            $review->status = 'pending'; // Requires admin approval
            $review->save();
            
            return redirect()->route('user.orders')
                ->with('status', 'Đánh giá của bạn đã được gửi và đang chờ duyệt!');
        }

        // Hiển thị đánh giá của user
        public function my_reviews()
        {
            $reviews = Review::with(['product', 'replies.user'])
                ->where('user_id', Auth::id())
                ->parentReviews()
                ->orderBy('created_at', 'DESC')
                ->paginate(10);
            
            return view('user.my-reviews', compact('reviews'));
        }

        // Chỉnh sửa đánh giá (trong vòng 24h)
        public function review_edit($id)
        {
            $review = Review::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            if (!$review->canEdit(Auth::id())) {
                return redirect()->route('user.my.reviews')
                    ->with('error', 'Bạn chỉ có thể chỉnh sửa đánh giá trong vòng 24 giờ!');
            }
            
            return view('user.review-edit', compact('review'));
        }

        // Cập nhật đánh giá
        public function review_update(Request $request)
        {
            $request->validate([
                'review_id' => 'required|exists:reviews,id',
                'rating' => 'required|integer|min:1|max:5',
                'title' => 'nullable|string|max:255',
                'comment' => 'required|string|max:1000'
            ]);
            
            $review = Review::where('id', $request->review_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            
            if (!$review->canEdit(Auth::id())) {
                return back()->with('error', 'Bạn chỉ có thể chỉnh sửa đánh giá trong vòng 24 giờ!');
            }
            
            $review->rating = $request->rating;
            $review->title = $request->title;
            $review->comment = $request->comment;
            $review->status = 'pending'; // Reset to pending after edit
            $review->save();
            
            return redirect()->route('user.my.reviews')
                ->with('status', 'Đánh giá đã được cập nhật và đang chờ duyệt!');
        }

    
}
