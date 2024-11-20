<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopCollectionController extends Controller
{
    public function index()
{
    $categories = Category::with(['children' => function ($query) {
        $query->where('status', 1);
    }])->where('status', 1)
    ->whereNull('parent_id')
    ->get();


    $products = Product::with([
        'variants.color', // Lấy biến thể và màu sắc
        'images'          // Lấy hình ảnh của sản phẩm
    ])
    ->where('status', 1) // Chỉ lấy sản phẩm có status = 1
    ->get();

    return view('client.shop-collection', compact( 'products', 'categories'));
}
}
