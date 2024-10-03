<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        View::composer(['admin.layouts.sidebar', 'client.layouts.particals.navleft'], function ($view) {

            $parentCategories  = Category::whereNull('parent_id')->get();

            $view->with('parentCategories', $parentCategories );
        });
    }
}
