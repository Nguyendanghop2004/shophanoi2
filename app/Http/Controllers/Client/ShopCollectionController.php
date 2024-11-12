<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopCollectionController extends Controller
{
    public function index($id)
{
    $categories = Category::with(['children' => function ($query) {
        $query->where('status', 1);
    }])->where('status', 1)
    ->whereNull('parent_id')
    ->get();

    $category = Category::findOrFail($id);

    $products = Category::with([
        'products' => function ($query) {
            $query->where('status', 1); 
        },
        'products.variants.color',
        'products.images'
    ])
    ->where('id', $id)
    ->where('status', 1)
    ->firstOrFail();

    return view('client.shop-collection', compact('category', 'products', 'categories'));
}
}
