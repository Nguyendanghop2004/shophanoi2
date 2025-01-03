<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Hiển thị danh sách đánh giá cho sản phẩm.
     */
    public function index($productId)
    {
        // Lấy tất cả các đánh giá của sản phẩm, kèm theo thông tin người dùng (eager loading)
        $reviews = Review::with('user')->where('product_id', $productId)->get();

        // Trả về view với dữ liệu đánh giá
        return view('client.reviews.index', compact('reviews'));
    }

    /**
     * Hiển thị form để người dùng có thể đánh giá cho sản phẩm trong đơn hàng.
     */
    public function create($orderId)
    {
        // Lấy đơn hàng theo ID
        $order = Order::findOrFail($orderId);

        // Lấy sản phẩm từ đơn hàng (giả sử mỗi đơn hàng chỉ có một sản phẩm, nếu có nhiều sản phẩm thì xử lý thêm)
        $product = $order->orderItems->first();

        // Trả về view để người dùng có thể đánh giá
        return view('client.reviews.create', compact('order', 'product'));
    }

    /**
     * Lưu đánh giá của người dùng vào cơ sở dữ liệu.
     */
    public function store(Request $request)
    {
        // Kiểm tra xem người dùng đã đánh giá cho đơn hàng này chưa
        $existingReview = Review::where('order_id', $request->order_id)
                                ->where('user_id', auth()->id()) // Kiểm tra người dùng hiện tại đã đánh giá chưa
                                ->first();

        if ($existingReview) {
            // Nếu đã có đánh giá, không cho phép đánh giá lại
            return redirect()->route('order.donhang', ['status' => 'đã_nhận_hàng'])
                             ->with('error', 'Bạn đã đánh giá đơn hàng này rồi.');
        }

        // Validate input
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5', // Đánh giá từ 1 đến 5
            'comment' => 'nullable|string|max:255', // Bình luận tối đa 255 ký tự
        ]);

        // Lưu đánh giá vào bảng reviews, thêm user_id
        Review::create([
            'order_id' => $request->order_id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => auth()->id(),  // Lưu ID người dùng hiện tại
        ]);

        // Điều hướng sau khi lưu thành công
        return redirect()->route('order.donhang', ['status' => 'đã_nhận_hàng'])
                         ->with('success', 'Đánh giá của bạn đã được lưu!');
    }
}
