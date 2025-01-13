<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index($productId)
    {
        $reviews = Review::with('user')->where('product_id', $productId)->get();

        return view('client.reviews.index', compact('reviews'));
    }

    public function create($orderId)
    {
        $order = Order::findOrFail($orderId);

        $product = $order->orderItems->first();

        $reviews = Review::where('order_id', $order->id)->get();
        $reviewedProducts = $reviews->pluck('product_id')->toArray(); 
        return view('client.reviews.create', compact('order', 'product' ,'reviewedProducts'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'order_id' => 'required|exists:orders,id',
        'ratings.*' => 'required|integer|between:1,5',
        'comments.*' => 'nullable|string|max:255',
        'product_ids' => 'required|array',
        'product_ids.*' => 'exists:products,id',
    ]);
    $existingReviews = Review::where('order_id', $validated['order_id'])
                             ->where('user_id', auth()->id())
                             ->exists();

    if ($existingReviews) {
        return redirect()->route('order.donhang', ['status' => 'đã nhận hàng'])
                         ->with('error', 'Bạn đã đánh giá đơn hàng này rồi.');
    }

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
