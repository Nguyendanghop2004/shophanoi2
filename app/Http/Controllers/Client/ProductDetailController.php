<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function index($slug)
    {
        // Lấy thông tin sản phẩm với các mối quan hệ liên quan
        $product = Product::with([
            'brand',
            'variants.color',
            'variants.size',
            'images'
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
           $price = $variant->price;

           // Nếu chưa có màu này trong danh sách $colorSizes thì tạo mới
           if (!isset($colorSizes[$colorId])) {
               $colorSizes[$colorId] = [];
           }

           // Thêm size và giá nếu chưa có
           if (!in_array($size, array_column($colorSizes[$colorId], 'size'))) {
               $colorSizes[$colorId][] = [
                   'size' => $size,
                   'price' => $price,
               ];
           }
       }

        return view('client.product-detail', compact('product',  'colorSizes'));
    }



}
