<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Auth;
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

            $view->with('categories', $categories);
        });
        View::composer('*', function ($view) {
            $wishlistCount = 0;
    
            if (Auth::check()) {
                $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
            }
    
            // Truyền biến wishlistCount vào view
            $view->with('wishlistCount', $wishlistCount);
        });
    }
}
