<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use DB;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []); // Lấy giỏ hàng từ session hoặc mảng rỗng

        // Dữ liệu sản phẩm thêm vào giỏ hàng
        $newItem = [
            'product_id' => $request->input('product_id'),
            'color_id' => $request->input('color_id'),
            'size' => $request->input('size'),
            'quantity' => $request->input('quantity'),
            'price' => $request->input('price'),
        ];

        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa (cùng ID, màu, size)
        $found = false;
        foreach ($cart as &$item) {
            if (
                $item['product_id'] == $newItem['product_id'] &&
                $item['color_id'] == $newItem['color_id'] &&
                $item['size'] == $newItem['size']
            ) {
                $item['quantity'] += $newItem['quantity']; // Cập nhật số lượng
                $found = true;
                break;
            }
        }

        // Nếu sản phẩm chưa tồn tại, thêm mới
        if (!$found) {
            $cart[] = $newItem;
        }

        // Cập nhật lại session
        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart' => $cart,
        ]);
    }
    public function findVariantId($productId, $colorId, $sizeId)
    {
        $variant = ProductVariant::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->first();

        if ($variant) {
            return $variant->id;
        }

        return null; // Nếu không tìm thấy
    }
    public function viewCart()
    {
        $cart = Session::get('cart', []); // Lấy dữ liệu từ session

        // Nếu giỏ hàng trống, trả về view với thông báo
        if (empty($cart)) {
            return view('client.shopping-cart', ['cartDetails' => []]);
        }

        // Lấy danh sách product_id và color_id từ giỏ hàng
        $productIds = array_column($cart, 'product_id');
        $colorIds = array_column($cart, 'color_id');

        // Truy vấn thông tin sản phẩm sử dụng Model
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Truy vấn thông tin màu sắc sử dụng Model
        $colors = Color::whereIn('id', $colorIds)->get()->keyBy('id');

        // Truy vấn ảnh ngẫu nhiên thuộc màu và sản phẩm sử dụng Model
        $images = ProductImage::whereIn('product_id', $productIds)
            ->whereIn('color_id', $colorIds)
            ->get()
            ->groupBy('product_id');

        // Kết hợp dữ liệu từ giỏ hàng và dữ liệu sản phẩm
        $cartDetails = [];
        foreach ($cart as $item) {
            // Lấy thông tin sản phẩm, màu và ảnh cho từng item trong giỏ hàng
            $product = $products[$item['product_id']] ?? null;
            $color = $colors[$item['color_id']] ?? null;
            $image = $images[$item['product_id']]->firstWhere('color_id', $item['color_id']) ?? null;

            $cartDetails[] = [
                'product_id' => $item['product_id'],
                'color_id' => $color->id,
                'product_name' => $product->product_name ?? 'N/A',
                'color_name' => $color->name ?? 'N/A',
                'size' => $item['size'],
                'quantity' => $item['quantity'],
                'price' => $product->price ?? 0,
                'image_url' => $image->image_url ?? '/default-image.jpg',
                'subtotal' => (floatval($product->price) ?? 0) * (intval($item['quantity']) ?? 0),
            ];
        }

        return view('client.shopping-cart', compact('cartDetails'));
    }



    public function removeFromCart(Request $request)
    {
        $cart = Session::get('cart', []);  // Lấy giỏ hàng từ session

        // Lọc bỏ sản phẩm muốn xóa dựa trên product_id (và các trường khác nếu cần)
        $cart = array_filter($cart, function ($item) use ($request) {
            return $item['product_id'] != $request->input('product_id');  // Xóa theo product_id
        });

        // Reset lại chỉ số mảng để đảm bảo giỏ hàng có chỉ số liên tục
        $cart = array_values($cart);

        // Cập nhật lại giỏ hàng vào session
        Session::put('cart', $cart);

        // Trả về kết quả dưới dạng JSON
        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart' => $cart,  // Giỏ hàng đã được cập nhật
        ]);
    }


    public function updateCart(Request $request)
    {
        $cart = Session::get('cart', []);

        // Tìm và cập nhật số lượng sản phẩm
        foreach ($cart as &$item) {
            if (
                $item['product_id'] == $request->input('product_id') &&
                $item['color_id'] == $request->input('color_id') &&
                $item['size'] == $request->input('size')
            ) {
                $item['quantity'] = $request->input('quantity'); // Cập nhật số lượng
                break;
            }
        }

        // Cập nhật lại session
        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart' => $cart,
        ]);
    }

    public function clearCart()
    {
        Session::forget('cart'); // Xóa giỏ hàng khỏi session

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }



}
