<?php 

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Tag;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị các dữ liệu từ trang chủ.
     */
    public function home()
    {
        // Lấy danh mục với các danh mục con
        $categories = Category::with([
            'children' => function ($query) {
                $query->where('status', 1);
            }
        ])->where('status', 1)
          ->whereNull('parent_id')
          ->get();

        // Lấy bộ sưu tập
        $collections = Tag::where('type', 'collection')->get();

        // Lấy danh sách sản phẩm
        $products = Product::with([
            'colors' => function ($query) {
                $query->select('colors.id', 'colors.name', 'colors.sku_color');
            },
            'variants' => function ($query) {
                $query->select('product_variants.id', 'product_variants.product_id', 'product_variants.size_id');
            },
            'images' => function ($query) {
                $query->select('product_images.id', 'product_images.product_id', 'product_images.color_id', 'product_images.image_url');
            }
        ])
        ->select([
            'products.id',
            'products.price',
            'products.brand_id',
            'products.slug',
            'products.product_name',
            'products.sku',
            'products.description',
            'products.status',
            DB::raw('(SELECT SUM(stock_quantity) FROM product_variants WHERE product_variants.product_id = products.id) as total_stock_quantity'),
            DB::raw('(SELECT image_url FROM product_images WHERE product_images.product_id = products.id ORDER BY RAND() LIMIT 1) as main_image_url')
        ])
        ->limit(10)
        ->get();

        // Lấy tags
        $tags = Tag::whereNotNull('background_image')->get();

        return view('client.home', compact('categories', 'products', 'collections', 'tags'));
    }

    /**
     * Lấy thông tin chi tiết sản phẩm.
     */
    public function getProductInfo(Request $request)
    {
        $product = Product::with(['variants', 'colors', 'images'])->find($request->id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Lấy ảnh ngẫu nhiên cho từng màu
        $randomImages = $product->colors->mapWithKeys(function ($color) use ($product) {
            $randomImage = $product->images
                ->where('color_id', $color->id)
                ->random(1)
                ->first();

            return [$color->id => $randomImage];
        });

        // Tạo danh sách size cho mỗi màu
        $colorSizes = [];
        foreach ($product->variants as $variant) {
            $colorId = $variant->color_id;
            $size = $variant->size;

            if (!isset($colorSizes[$colorId])) {
                $colorSizes[$colorId] = [];
            }

            if (!in_array($size, $colorSizes[$colorId])) {
                $colorSizes[$colorId][] = $size;
            }
        }

        // Trả về một view partial chứa thông tin sản phẩm
        return view('client.layouts.components.ajax-file.quick-add', compact('product', 'randomImages', 'colorSizes'))->render();
    }
}
