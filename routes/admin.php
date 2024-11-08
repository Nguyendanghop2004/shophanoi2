<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // quản lí thanh trượt
    Route::get('slider/category/{category_id}', [SliderController::class, 'index'])->name('slider.index');
    Route::resource('slider', SliderController::class)->except(['index']);
    Route::post('slider/update-order', [SliderController::class, 'updateOrder'])->name('slider.updateOrder');

    Route::patch('sliders/{id}/restore', [SliderController::class, 'restore'])->name('slider.restore');
    Route::delete('sliders/{id}/force-delete', [SliderController::class, 'forceDelete'])->name('slider.forceDelete');

    // quan li danh muc
    Route::get('categories', [CategoriesController::class, 'list'])->name('categories.list');
    Route::get('categories/create', [CategoriesController::class, 'create'])->name('categories.add');
    Route::post('categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    Route::get('categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.delete');
    Route::post('categories/toggle-status/{id}', [CategoriesController::class, 'toggleStatus'])->name('categories.toggleStatus');

    // Quản lý sản phẩm
    Route::resource('product', ProductController::class);

    // Các route riêng cho sản phẩm
    Route::get('/product/get-variant-card/{colorId}', [ProductController::class, 'getVariantCard'])->name('product.getVariantCard');
    Route::put('product/{id}/update-main-product', [ProductController::class, 'updateMainProduct'])->name('product.updateMainProduct');
    Route::put('product/{id}/update-variant-product', [ProductController::class, 'updateVariantProduct'])->name('product.updateVariantProduct');
    Route::post('product/create-variant-product', [ProductController::class, 'createVariantProduct'])->name('product.createVariantProduct');
    Route::post('product/create-variant-color-product', [ProductController::class, 'createVariantColorProduct'])->name('product.createVariantColorProduct');
    Route::delete('/product-variants/{id}', [ProductController::class, 'destroyVariant'])->name('product-variants.destroy');


});
