<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Sử dụng Bootstrap cho phân trang
        Paginator::useBootstrap();
        Carbon::setLocale('vi');
        // Lấy danh mục (categories) và truyền vào view menu
        View::composer('client.layouts.particals.menu', function ($view) {
            $categories = Category::with([
                'children' => function ($query) {
                    $query->where('status', 1);
                }
            ])->where('status', 1)->whereNull('parent_id')->get();

            
            $productsBestSaler = Product::query()
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
                ->where('is_best_seller',1)
                ->get();

            $productsBestSaler = $productsBestSaler->map(function ($product) {
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
            
            $view->with('categories', $categories);
            $view->with('productsBestSaler', $productsBestSaler);

        });

    }
}
