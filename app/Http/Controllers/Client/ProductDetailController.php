<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Review;
use App\Models\Size;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductDetailController extends Controller
{
    public function index($slug)
    {
        // Lấy thông tin sản phẩm với các mối quan hệ liên quan
        $product = Product::with([
            'brand',
            'variants.color',
            'variants.size',
            'images',
            'sales' => fn($query) => $query->where('start_date', '<=', now())
                ->where(function ($q) {
                    $q->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })
        ])->where('slug', $slug)->first();

        // Kiểm tra nếu không tìm thấy sản phẩm
        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        // Tạo danh sách size và giá cho mỗi màu
        $colorSizes = [];
        foreach ($product->variants as $variant) {
            $colorId = $variant->color_id;
            $size = $variant->size;
            $price = (float) $variant->price; // Ép kiểu float để đảm bảo tính toán chính xác
            $stockQuantity = $variant->stock_quantity;

            // Tính giá giảm (sale price)
            $salePrice = $product->price; // Mặc định là giá gốc

            if ($product->sales) {
                $discountValue = $product->sales->discount_value;
                if ($product->sales->discount_type === 'percent') {
                    if ($discountValue > 0 && $discountValue <= 100) {
                        $salePrice = $product->price * (1 - $discountValue / 100);           
                    }
                } elseif ($product->sales->discount_type === 'fixed') {
                    if ($discountValue >= 0 && $discountValue <= $product->price) {
                        $salePrice = $product->price - $discountValue;
                    }
                }
            }

              $product->sale_price = max(0, $salePrice);// Đảm bảo không có giá trị âm
            // Nếu chưa có màu này trong danh sách $colorSizes thì tạo mới
            if (!isset($colorSizes[$colorId])) {
                $colorSizes[$colorId] = [];
            }

            // Thêm size và giá nếu chưa có
            $exists = collect($colorSizes[$colorId])->firstWhere('size', $size);
            if (!$exists) {
                $colorSizes[$colorId][] = [
                    'size' => $size,
                    'price' => $price,
                    'sale_price' => $salePrice, // Thêm giá sale
                    'stock_quantity' => $stockQuantity
                ];
            }

            // return response()->json($colorSizes);

        }
        $colors = $product->variants->pluck('color_id')->unique(); // Giả sử product có mối quan hệ với variants
    $sizes = $product->variants->pluck('size_id')->unique();

    // Lấy tên màu sắc và kích thước từ bảng liên quan
    $colorNames = Color::whereIn('id', $colors)->pluck('name', 'id');
    $sizeNames = Size::whereIn('id', $sizes)->pluck('name', 'id');
        $reviews = Review::where('product_id', $product->id)
        ->with('user') // Load thông tin người dùng
        ->latest()
        ->get();
        $wishlist = [];

        if (Auth::check()) {
           
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray(); 
        }
        return view('client.product-detail', compact('product', 'colorSizes','wishlist','reviews','colorNames','sizeNames'));
    }




}
