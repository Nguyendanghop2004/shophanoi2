<?php

namespace App\Providers;

use App\Models\Category;
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
    public function boot(): void
    {
        // Sử dụng Bootstrap cho phân trang
        Paginator::useBootstrap();

        // Lấy danh mục (categories) và truyền vào view menu
        View::composer('client.layouts.particals.menu', function ($view) {
            $categories = Category::with([
                'children' => function ($query) {
                    $query->where('status', 1);
                }
            ])->where('status', 1)->whereNull('parent_id')->get();

            $view->with('categories', $categories);
        });
    }
}
