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

// Xử lý sản phẩm
$products = $products->map(function ($product) {
    // Nhóm ảnh theo color_id
    $imagesByColor = $product->images->groupBy('color_id');

    // Gắn main_image và hover_image vào từng màu
    $product->colors = $product->colors->map(function ($color) use ($imagesByColor) {
        $images = $imagesByColor->get($color->id, collect());
        $mainImage = $images->first()?->image_url ?? null; // Ảnh đầu tiên
        $hoverImage = $images->skip(1)->first()?->image_url ?? null; // Ảnh thứ hai

        return [
            'id' => $color->id,
            'name' => $color->name,
            'sku_color' => $color->sku_color,
            'main_image' => $mainImage,
            'hover_image' => $hoverImage,
        ];
    });

    // Thiết lập main_image_url và hover_main_image_url cho sản phẩm
    $firstColor = $product->colors->first();
    $product->main_image_url = $firstColor ? $firstColor['main_image'] : null;
    $product->hover_main_image_url = $firstColor ? $firstColor['hover_image'] : null;

    // Chỉ giữ lại các trường cần thiết
    return [
        'id' => $product->id,
        'name' => $product->product_name,
        'price' => $product->price,
        'slug' => $product->slug,
        'distinct_size_count' => $product->distinct_size_count,
        'total_stock_quantity' => $product->total_stock_quantity,
        'main_image_url' => $product->main_image_url,
        'hover_main_image_url' => $product->hover_main_image_url,
        'colors' => $product->colors,
    ];
});

// Trả về view
return view('client.home', compact( 'products', 'collections', 'tags'));

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
