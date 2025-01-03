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
use App\Models\Wishlist;
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

        $sliders = Slider::where('is_active', 1)->get();

        $products = Product::query()
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id')
            ->with([
                'colors' => fn($query) => $query->select('colors.id', 'colors.name', 'colors.sku_color'),
                'images' => fn($query) => $query->select('product_images.id', 'product_images.product_id', 'product_images.color_id', 'product_images.image_url'),
                'sales' => fn($query) => $query->select('product_sales.product_id', 'product_sales.discount_type', 'product_sales.discount_value')
                    ->where('start_date', '<=', now())
                    ->where(function ($q) {
                        $q->whereNull('end_date')
                            ->orWhere('end_date', '>=', now());
                    }),
            ])
            ->select([
                'products.id',
                'products.product_name',
                'products.price',
                'products.slug',
                DB::raw('COUNT(DISTINCT product_variants.size_id) as distinct_size_count'), // Số size khác nhau
                DB::raw('(SELECT SUM(stock_quantity) FROM product_variants WHERE product_variants.product_id = products.id) as total_stock_quantity'), // Tổng tồn kho chính xác
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

            // Tính toán giá giảm nếu có sale
            $salePrice = $product->price; // Giá gốc
            if ($product->sales) {
                if ($product->sales->discount_type === 'percent') {
                    $salePrice = $product->price * (1 - $product->sales->discount_value / 100);
                } elseif ($product->sales->discount_type === 'fixed') {
                    $salePrice = $product->price - $product->sales->discount_value;
                }
            }

            // Thiết lập main_image_url và hover_main_image_url cho sản phẩm
            $firstColor = $product->colors->first();
            $product->main_image_url = $firstColor ? $firstColor['main_image'] : null;
            $product->hover_main_image_url = $firstColor ? $firstColor['hover_image'] : null;

            // Chỉ giữ lại các trường cần thiết
            return [
                'id' => $product->id,
                'name' => $product->product_name,
                'price' => $product->price,
                'sale_price' => max(0, $salePrice), // Giá sau giảm, không được âm
                'slug' => $product->slug,
                'distinct_size_count' => $product->distinct_size_count,
                'total_stock_quantity' => $product->total_stock_quantity,
                'main_image_url' => $product->main_image_url,
                'hover_main_image_url' => $product->hover_main_image_url,
                'colors' => $product->colors,
            ]; 
        });
        $wishlist = [];

        if (Auth::check()) {
           
            $wishlist = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray(); 
        }
        // return response()->json($products);
        return view('client.home', compact('products', 'collections', 'sliders','wishlist'));
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
    public function getProductInfoQuickView(Request $request)
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
        ])->find($request->id); // Sử dụng find để đơn giản hóa

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
            
            $product->sale_price = max(0, $salePrice); // Đảm bảo không có giá trị âm
            

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
        }

        // Trả về một view partial chứa thông tin sản phẩm, ảnh ngẫu nhiên, và các size theo màu
        return view('client.layouts.components.ajax-file.quick-view', compact('product', 'colorSizes'))->render();
    }

}
