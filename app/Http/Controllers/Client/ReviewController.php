<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;

class ReviewController extends Controller
{
    public function create($orderId)
    {
        
        $order = Order::findOrFail($orderId);
        
        // Lấy sản phẩm từ đơn hàng (giả sử mỗi đơn hàng chỉ có một sản phẩm, nếu có nhiều sản phẩm thì xử lý thêm)
        $product = $order->orderItems->first(); 

        return view('client.reviews.create', compact('order', 'product'));
    }

    public function store(Request $request)
    {
        dd($request->all()); // In ra dữ liệu của form
        // Kiểm tra xem đơn hàng đã có đánh giá hay chưa
        $existingReview = Review::where('order_id', $request->order_id)->first();

        if ($existingReview) {
            // Nếu đã có đánh giá, không cho phép đánh giá lại
            return redirect()->route('order.donhang', ['status' => 'đã_nhận_hàng'])
                             ->with('error', 'Bạn đã đánh giá đơn hàng này rồi.');
        }

        // Validate input
       $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:255',
        ]);
        

        // Lưu đánh giá vào bảng reviews
        Review::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,  // Sử dụng product_id nhận được từ form
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Điều hướng sau khi lưu thành công
        return redirect()->route('order.donhang', ['status' => 'đã_nhận_hàng'])
                         ->with('success', 'Đánh giá của bạn đã được lưu!');
    }
}
