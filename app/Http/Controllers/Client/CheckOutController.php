<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Session;
use DB;
class CheckOutController extends Controller
{
    public function checkout()
    {
        // Biến chứa thông tin giỏ hàng
        $cartDetails = [];
        $totalPrice = 0;
    
      
        if (auth()->check()) {
         
            $cart = Cart::where('user_id', auth()->id())
                ->with(['cartItems.product.images', 'cartItems.color', 'cartItems.size'])
                ->first();
    
            if ($cart && $cart->cartItems->isNotEmpty()) {
             
                $cartDetails = $cart->cartItems->map(function ($item) {
                    $product = $item->product;
                    $color = $item->color;
                    $size = $item->size;
                    $image = $product->images->firstWhere('color_id', $color->id);
                    $imageUrl = $image ? $image->image_url : '/default-image.jpg';
    
                    return [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item->quantity,
                        'price' => $item->price ?? $product->price,
                        'image_url' => $imageUrl,
                        'subtotal' => ($item->price ?? $product->price) * $item->quantity,
                    ];
                });
    
                // Tính tổng giá trị đơn hàng
                $totalPrice = $cartDetails->sum('subtotal');
            }
        } else {
            // Nếu chưa đăng nhập, lấy giỏ hàng từ session
            $cart = session()->get('cart', []);
    
            if (!empty($cart)) {
                foreach ($cart as $item) {
                    // Lấy thông tin sản phẩm từ session
                    $product = Product::find($item['product_id']);
                    $color = Color::find($item['color_id']);
                    $size = Size::find($item['size_id']);
                    $image = $product->images->firstWhere('color_id', $color->id);
    
                    // Lấy URL ảnh sản phẩm, nếu không có thì dùng ảnh mặc định
                    $imageUrl = $image ? $image->image_url : '/default-image.jpg';
    
                    $cartDetails[] = [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item['quantity'],
                        'price' => $item['price'] ?? $product->price,
                        'image_url' => $imageUrl,
                        'subtotal' => ($item['price'] ?? $product->price) * $item['quantity'],
                    ];
                }
    
                // Tính tổng giá trị đơn hàng từ giỏ hàng trong session
                $totalPrice = array_sum(array_column($cartDetails, 'subtotal'));
            }
        }
    
        return view('client.check-out', compact('cartDetails', 'totalPrice'));
    }
    
    public function placeOrder(Request $request)
    {
        $cartDetails = [];
        $totalPrice = 0;
        $orderId = null;
        $orderCode = 'HN' . strtoupper(uniqid()); 
    
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())
                ->with(['cartItems.product.images', 'cartItems.color', 'cartItems.size'])
                ->first();
    
            if ($cart && $cart->cartItems->isNotEmpty()) {
                $cartDetails = $cart->cartItems->map(function ($item) {
                    $product = $item->product;
                    $color = $item->color;
                    $size = $item->size;
                    $image = $product->images->firstWhere('color_id', $color->id);
    
                    $imageUrl = $image ? $image->image_url : '/default-image.jpg';
    
                    return [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item->quantity,
                        'price' => $item->price ?? $product->price,
                        'image_url' => $imageUrl,
                        'subtotal' => ($item->price ?? $product->price) * $item->quantity,
                    ];
                });
    
                $totalPrice = $cartDetails->sum('subtotal');
                $orderId = 'ORDER-' . strtoupper(uniqid());
    
                // Lưu đơn hàng vào database
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_id' => $orderId,
                    'order_code' => $orderCode,
                    'total_price' => $totalPrice,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'status' => 1, // Trạng thái đơn hàng
                ]);
    
                // Lưu chi tiết đơn hàng vào bảng order_items
                foreach ($cartDetails as $detail) {
                    $order->Orderitems()->create([
                        'product_id' => $detail['product_id'],
                        'color_name' => $detail['color_name'],
                        'size_name' => $detail['size_name'],
                        'quantity' => $detail['quantity'],
                        'price' => $detail['price'],
                    ]);
    
                    // Trừ kho
                    $variant = ProductVariant::where('product_id', $detail['product_id'])
                        ->where('color_id', $detail['color_id'])
                        ->where('size_id', $detail['size_id'])
                        ->first();
    
                    if ($variant) {
                        $variant->decrement('stock_quantity', $detail['quantity']);
                    }
                }
    
                // Xóa giỏ hàng
                $cart->cartItems()->delete();
                $cart->delete();
            }
        } else {
            $cart = session()->get('cart', []);
    
            if (!empty($cart)) {
                foreach ($cart as $item) {
                    $product = Product::find($item['product_id']);
                    $color = Color::find($item['color_id']);
                    $size = Size::find($item['size_id']);
                    $image = $product->images->firstWhere('color_id', $color->id);
    
                    $imageUrl = $image ? $image->image_url : '/default-image.jpg';
    
                    $cartDetails[] = [
                        'product_id' => $product->id,
                        'color_id' => $color->id ?? null,
                        'size_id' => $size->id ?? null,
                        'product_name' => $product->product_name ?? 'N/A',
                        'color_name' => $color->name ?? 'N/A',
                        'size_name' => $size->name ?? 'N/A',
                        'quantity' => $item['quantity'],
                        'price' => $item['price'] ?? $product->price,
                        'image_url' => $imageUrl,
                        'subtotal' => ($item['price'] ?? $product->price) * $item['quantity'],
                    ];
                }
    
                $totalPrice = array_sum(array_column($cartDetails, 'subtotal'));
                $orderId = 'ORDER-' . strtoupper(uniqid());
    
                // Tạo đơn hàng và lưu vào cơ sở dữ liệu
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_id' => $orderId,
                    'order_code' => $orderCode,
                    'total_price' => $totalPrice,
                    'phone_number' => $request->phone_number,
                    'address' => $request->address,
                    'status' => 1,
                ]);
    
                foreach ($cartDetails as $detail) {
                    $order->Orderitems()->create([
                        'product_id' => $detail['product_id'],
                        'color_name' => $detail['color_name'],
                        'size_name' => $detail['size_name'],
                        'quantity' => $detail['quantity'],
                        'price' => $detail['price'],
                    ]);
    
                    // Trừ kho
                    $variant = ProductVariant::where('product_id', $detail['product_id'])
                        ->where('color_id', $detail['color_id'])
                        ->where('size_id', $detail['size_id'])
                        ->first();
    
                    if ($variant) {
                        $variant->decrement('stock_quantity', $detail['quantity']);
                    }
                }
    
                // Xóa giỏ hàng
                session()->forget('cart');
            }
        }
    
        return redirect()->route('home')->with('success', 'Đặt hàng thành công!');

    }
    
    
}
