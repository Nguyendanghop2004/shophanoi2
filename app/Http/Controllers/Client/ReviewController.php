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
    // Validate dữ liệu từ form
    $validated = $request->validate([
        'order_id' => 'required|exists:orders,id',
        'ratings.*' => 'required|integer|between:1,5',
        'comments.*' => 'nullable|string|max:255',
        'product_ids' => 'required|array',
        'product_ids.*' => 'exists:products,id',
    ]);

    // Kiểm tra xem đã đánh giá đơn hàng này chưa
    $existingReviews = Review::where('order_id', $validated['order_id'])
                             ->where('user_id', auth()->id())
                             ->exists();

    if ($existingReviews) {
        return redirect()->route('order.donhang', ['status' => 'đã nhận hàng'])
                         ->with('error', 'Bạn đã đánh giá đơn hàng này rồi.');
    }

    // Lưu đánh giá cho từng sản phẩm
    foreach ($validated['product_ids'] as $productId) {
        Review::create([
            'order_id' => $validated['order_id'],
            'product_id' => $productId,
            'rating' => $validated['ratings'][$productId],
            'comment' => $validated['comments'][$productId] ?? null,
            'user_id' => auth()->id(),
        ]);
    }

    return redirect()->route('order.donhang', ['status' => 'đã nhận hàng'])
                     ->with('success', 'Đánh giá của bạn đã được lưu thành công.');
}

}
