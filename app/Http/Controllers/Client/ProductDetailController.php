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

        $categories = Category::with(['children' => function ($query) {
            $query->where('status', 1);
        }])->where('status', 1)
        ->whereNull('parent_id')
        ->get();
    
        
        $product = Product::with([
            'variants.color',   
            'variants.size',   
            'images',          
            'categories'         
        ])
        ->where('slug', $slug)
        ->where('status', 1) 
        ->firstOrFail();
       
        $base_price = $product->price;
        $variants = $product->variants;
        $total_stock_quantity = $variants->sum('stock_quantity');
        $variant = $variants->first();
        $additional_price = $variant ? $variant->price : 0;
        $final_price = $base_price + $additional_price;
        
        return view('client.product-detail', compact('categories', 'product', 'base_price', 'additional_price', 'final_price', 'total_stock_quantity', 'variants'));
    }
    


}
