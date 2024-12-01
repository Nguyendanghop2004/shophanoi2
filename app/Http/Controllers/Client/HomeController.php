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

        $categories = Category::with(relations: [
            'children' => function ($query) {
                $query->where('status', 1);
            }
        ])->where('status', 1)
            ->whereNull('parent_id')->get();

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


        return view('client.home', compact('sliders', 'products', 'categories'));
    }
    public function show($slug)
    {

        $category = Category::where('slug', $slug)->where('status', 1)->first();
        if (!$category) {
            return redirect()->route('home')->with('error', 'Danh mục không tồn tại hoặc đã bị ẩn.');
        }


        return view('client.home', compact('slug'));
    }
    public function getProductInfo(Request $request)
    {
        $product = Product::with(['variants', 'colors', 'images'])->find($request->id);

        // Lấy ảnh ngẫu nhiên cho từng màu
        $randomImages = $product->colors->mapWithKeys(function ($color) use ($product) {
            $randomImage = $product->images
                ->where('color_id', $color->id)
                ->random(1)
                ->first();

            return [$color->id => $randomImage];
        });
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        // Tạo danh sách size cho mỗi màu
        $colorSizes = [];
        foreach ($product->variants as $variant) {
            $colorId = $variant->color_id;
            $size = $variant->size;

            if (!isset($colorSizes[$colorId])) {
                $colorSizes[$colorId] = [];
            }

            // Chỉ thêm size nếu chưa có
            if (!in_array($size, $colorSizes[$colorId])) {
                $colorSizes[$colorId][] = $size;
            }
        }

        // Tạo danh sách size cho mỗi màu
        $colorSizes = [];
        foreach ($product->variants as $variant) {
            $colorId = $variant->color_id;
            $size = $variant->size;

            // Nếu chưa có màu này trong danh sách $colorSizes thì tạo mới
            if (!isset($colorSizes[$colorId])) {
                $colorSizes[$colorId] = [];
            }

            // Chỉ thêm size nếu chưa có
            if (!in_array($size, $colorSizes[$colorId])) {
                $colorSizes[$colorId][] = $size;
            }
        }

        // Trả về một view partial chứa thông tin sản phẩm, ảnh ngẫu nhiên, và các size theo màu
        return view('client.layouts.components.ajax-file.quick-add', compact('product', 'randomImages', 'colorSizes'))->render();
    }
}
