<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Slider;

use App\Models\Category;

use DB;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home($category_id = 1)
    {
        $sliders = Slider::with('category')
            ->where('category_id', $category_id)
            ->where('is_active', true)
            ->orderBy('position', 'asc')
            ->get();



            $products = Product::with([
                'colors' => function ($query) {
                    $query->select('colors.id', 'colors.name', 'colors.sku_color'); // Không lấy image_url từ colors
                },
                'variants' => function ($query) {
                    $query->select('product_variants.id', 'product_variants.product_id', 'product_variants.size_id');
                },
                'images' => function ($query) {
                    $query->select('product_images.id', 'product_images.product_id', 'product_images.color_id', 'product_images.image_url'); // Lấy ảnh từ bảng product_images
                }
            ])
            ->select('products.id', 'products.price', 'products.brand_id', 'products.slug', 'products.product_name', 'products.sku', 'products.description', 'products.status')
            ->addSelect([
                'main_image_url' => ProductImage::select('image_url')
                    ->whereColumn('product_images.product_id', 'products.id')
                    ->inRandomOrder()
                    ->limit(1),
                'total_stock_quantity' => ProductVariant::select(DB::raw('SUM(stock_quantity)'))
                    ->whereColumn('product_variants.product_id', 'products.id')
            ])
            ->limit(10)
            ->get();


        return view('client.home', compact('sliders', 'products'));

    }
    public function show($slug)
    {
        
        $category = Category::where('slug', $slug)->where('status',1 )->first();
        if (!$category) {
            return redirect()->route('home')->with('error', 'Danh mục không tồn tại hoặc đã bị ẩn.');
        }

      
        return view('client.home', compact('slug'));
    }
   

   
}
