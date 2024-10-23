<?php

use App\Http\Controllers\Admin\AccoutAdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'store'])->name('admin.post-login');
Route::prefix('admin')->name('admin.')->middleware('auth:admin','can:admin')->group(function () {
    // Login admin
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('admin-logout', [LoginController::class, 'logout'])->name('post-logout');
    Route::get('account', [AccoutAdminController::class, 'account'])->name('accounts.account');
    Route::get('accounts/create', [AccoutAdminController::class, 'create'])->name('accounts.create');
    Route::post('accounts/store', [AccoutAdminController::class, 'store'])->name('accounts.store');
    Route::get('accounts/edit/{id}', [AccoutAdminController::class, 'edit'])->name('accounts.edit');
    Route::put('accounts/update/{id}', [AccoutAdminController::class, 'update'])->name('accounts.edit');
    Route::delete('accounts/destroy/{id}', [AccoutAdminController::class, 'destroy'])->name('accounts.destroy');
// Permission

    Route::get('permissions/index', [AccoutAdminController::class, 'permissionAdmin'])->name('permissions.index');
    Route::get('permissions/phanquyen/{id}', [AccoutAdminController::class, 'phanquyen'])->name('permissions.phanquyen');

    
    // Quản lý thanh trượt
    Route::get('slider/category/{category_id}', [SliderController::class, 'index'])->name('slider.index');
    Route::resource('slider', SliderController::class)->except(['index']);
    Route::post('slider/update-order', [SliderController::class, 'updateOrder'])->name('slider.updateOrder');

    Route::patch('sliders/{id}/restore', [SliderController::class, 'restore'])->name('slider.restore');
    Route::delete('sliders/{id}/force-delete', [SliderController::class, 'forceDelete'])->name('slider.forceDelete');
    // Quản lý danh mục
    Route::get('categories', [CategoriesController::class, 'list'])->name('categories.list');
    Route::get('categories/create', [CategoriesController::class, 'create'])->name('categories.add');
    Route::post('categories/store', [CategoriesController::class, 'store'])->name('categories.store');
    Route::get('categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::put('categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
    Route::delete('categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.delete');
    Route::post('categories/toggle-status/{id}', [CategoriesController::class, 'toggleStatus'])->name('categories.toggleStatus');
});
    