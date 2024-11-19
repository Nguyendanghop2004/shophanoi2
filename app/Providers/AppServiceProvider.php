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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
       
        View::composer(['admin.layouts.sidebar', 'client.layouts.particals.navleft'], function ($view) {

            $parentCategories  = Category::whereNull('parent_id')->get();

            $view->with('parentCategories', $parentCategories );
        });
    }
}
