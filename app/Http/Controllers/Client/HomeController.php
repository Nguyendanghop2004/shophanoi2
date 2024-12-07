<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Slider;

use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Tag;
use Auth;
use DB;

use Illuminate\Http\Request;
use Log;
use Session;

class HomeController extends Controller
{

    /**
     * Hiển thị các dữ liệu từ trang chủ.
     */
    public function home()
    {

        $collections = Tag::where('type', 'collection')->get();

        $products = Product::query()
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->with([
                'colors' => fn($query) => $query->select('colors.id', 'colors.name', 'colors.sku_color'),
                'images' => fn($query) => $query->select('product_images.id', 'product_images.product_id', 'product_images.color_id', 'product_images.image_url'),
            ])
            ->select([
                'products.id',
                'products.product_name',
                'products.price',
                'products.slug',
                DB::raw('COUNT(DISTINCT product_variants.size_id) as distinct_size_count'), // Số size khác nhau
                DB::raw('(SELECT SUM(stock_quantity) FROM product_variants WHERE product_variants.product_id = products.id) as total_stock_quantity') // Tổng tồn kho chính xác
            ])
            ->groupBy('products.id')
            ->limit(10)
            ->get();

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

        // return response()->json($products);
        return view('client.home', compact('products', 'collections'));
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

        // Trả về một view partial chứa thông tin sản phẩm, ảnh ngẫu nhiên, và các size theo màu
        return view('client.layouts.components.ajax-file.quick-add', compact('product', 'randomImages', 'colorSizes'))->render();
    }

}
