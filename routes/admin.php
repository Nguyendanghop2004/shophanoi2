<?php

use App\Http\Controllers\Admin\AccoutAdminController;
use App\Http\Controllers\Admin\AccoutUserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PriceSaleController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'store'])->name('admin.post-login');
Route::prefix('admin')->name('admin.')->middleware('auth:admin', 'checkAdminStatus')->group(callback: function () {
    // Login admin
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('admin-logout', [LoginController::class, 'logout'])->name('post-logout');
    Route::get('account', [AccoutAdminController::class, 'account'])->name('accounts.account')->middleware('permission:index_account_admin');
    Route::get('accounts/create', [AccoutAdminController::class, 'create'])->name('accounts.create');
    Route::post('accounts/store', [AccoutAdminController::class, 'store'])->name('accounts.store');
    Route::get('accounts/edit/{id}', [AccoutAdminController::class, 'edit'])->name('accounts.edit');
    Route::put('accounts/update/{id}', [AccoutAdminController::class, 'update'])->name('accounts.update');
    Route::delete('accounts/destroy/{id}', [AccoutAdminController::class, 'destroy'])->name('accounts.destroy');

    Route::get('accountUser', [AccoutUserController::class, 'accountUser'])->name('accountsUser.accountUser');
    // start crud user
    Route::get('accountsUser/create', [AccoutUserController::class, 'create'])->name('accountsUser.create');
    Route::post('accountsUser/store', [AccoutUserController::class, 'store'])->name('accountsUser.store');
    Route::get('accountsUser/edit/{id}', [AccoutUserController::class, 'edit'])->name('accountsUser.edit');
    Route::put('accountsUser/update/{id}', [AccoutUserController::class, 'update'])->name('accountsUser.update');
    Route::delete('accountsUser/destroy/{id}', [AccoutUserController::class, 'destroy'])->name('accountsUser.destroy');
    // end crud user 

    //start status user
    Route::post('accountsUser/{id}/accountUser', [AccoutUserController::class, 'activateUser'])->name('accountsUser.activateUser')->middleware('permission:activate_Account');
    Route::post('accountsUser/{id}/deactivateUser', [AccoutUserController::class, 'deactivateUser'])->name('accountsUser.deactivateUser')->middleware('permission:deactivate_Account');
    //end  status user
    Route::get('accounts/profile', [ProfileController::class, 'index'])->name('profile.index');
    // Permission
    Route::get('permissions/index', [AccoutAdminController::class, 'permissionAdmin'])->name('permissions.index')->middleware('permission:indexPermission');
    // Thêm quyền
    Route::get('permissions/phanquyen/{id}', [AccoutAdminController::class, 'phanquyen'])->name('permissions.phanquyen')->middleware('permission:ListPermission');
    Route::post('permissions/insertPermission', [AccoutAdminController::class, 'insertPermission'])->name('permissions.insert')->middleware('permission:insertPermission');
    // Cấp quyền
    Route::post('permissions/insert_permission/{id}', [AccoutAdminController::class, 'insert_permission'])->name('permissions.insert_permission')->middleware('permission:grant_permission');
    // phân vai trò
    Route::get('permissions/phanvaitro/{id}', [AccoutAdminController::class, 'phanvaitro'])->name('permissions.phanvaitro')->middleware('permission:listRole');
    Route::post('permissions/insert_roles/{id}', [AccoutAdminController::class, 'insert_roles'])->name('permissions.insert_roles')->middleware('permission:insert_roles');
    // Thêm vai trò
    Route::post('permissions/insertRoles', [AccoutAdminController::class, 'insertRoles'])->name('permissions.insertRoles')->middleware('permission:Grant_roles');
    
    // Trạng thái tài khoản
    // routes/web.php
    Route::post('accounts/{id}/activate', [AccoutAdminController::class, 'activate'])->name('accounts.activate')->middleware('permission:activate_Account');
    Route::post('accounts/{id}/deactivate', [AccoutAdminController::class, 'deactivate'])->name('accounts.deactivate')->middleware('permission:deactivate_Account');

    // Quản lý thanh trượt
    Route::get('slider/category/{category_id}', [SliderController::class, 'index'])->name('slider.index');
    Route::resource('slider', SliderController::class)->except(['index']);
    Route::post('slider/update-order', [SliderController::class, 'updateOrder'])->name('slider.updateOrder');

    Route::patch('sliders/{id}/restore', [SliderController::class, 'restore'])->name('slider.restore');
    Route::delete('sliders/{id}/force-delete', [SliderController::class, 'forceDelete'])->name('slider.forceDelete');

    // Quản lý danh mục
    Route::get('categories', [CategoriesController::class, 'list'])->name('categories.list')->middleware('permission:listCategories');
    Route::get('categories/create', [CategoriesController::class, 'create'])->name('categories.add')->middleware('permission:addCategories');
    Route::post('categories/store', [CategoriesController::class, 'store'])->name('categories.store')->middleware('permission:addCategories');
    Route::get('categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit')->middleware('permission:editCategories');
    Route::put('categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update')->middleware('permission:editCategories');
    Route::delete('categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.delete')->middleware('permission:deleteCategories');

    Route::post('categories/toggle-status/{id}', [CategoriesController::class, 'toggleStatus'])->name('categories.toggleStatus');

    // Quản lý sản phẩm
    Route::resource('product', ProductController::class);
    Route::get('/get-variant-card/{color}', [ProductController::class, 'getVariantCard']);
    Route::get('/product/get-variant-card/{colorId}', [ProductController::class, 'getVariantCard']);


    Route::get('sizes', [SizeController::class, 'index'])->name('sizes.index');
    Route::get('sizes/create', [SizeController::class, 'create'])->name('sizes.create');
    Route::post('sizes', [SizeController::class, 'store'])->name('sizes.store');
    Route::get('sizes/{id}', [SizeController::class, 'show'])->name('sizes.show');
    Route::get('sizes/{id}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
    Route::put('sizes/{id}', [SizeController::class, 'update'])->name('sizes.update');
    Route::delete('sizes/{id}', [SizeController::class, 'destroy'])->name('sizes.destroy');

    // Route cho ColorController
    Route::get('colors', [ColorController::class, 'index'])->name('colors.index');
    Route::get('colors/create', [ColorController::class, 'create'])->name('colors.create');
    Route::post('colors', [ColorController::class, 'store'])->name('colors.store');
    Route::get('colors/{id}', [ColorController::class, 'show'])->name('colors.show');
    Route::get('colors/{id}/edit', [ColorController::class, 'edit'])->name('colors.edit');
    Route::put('colors/{id}', [ColorController::class, 'update'])->name('colors.update');
    Route::delete('colors/{id}', [ColorController::class, 'destroy'])->name('colors.destroy');

    // Route cho PriceSaleController
    Route::get('pricesales', [PriceSaleController::class, 'index'])->name('pricesales.index');
    Route::get('pricesales/create', [PriceSaleController::class, 'create'])->name('pricesales.create');
    Route::post('pricesales', [PriceSaleController::class, 'store'])->name('pricesales.store');
    Route::get('pricesales/{id}', [PriceSaleController::class, 'show'])->name('pricesales.show');
    Route::get('pricesales/{id}/edit', [PriceSaleController::class, 'edit'])->name('pricesales.edit');
    Route::put('pricesales/{id}', [PriceSaleController::class, 'update'])->name('pricesales.update');
    Route::delete('pricesales/{id}', [PriceSaleController::class, 'destroy'])->name('pricesales.destroy');

    // Route cho BrandController
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('brands/{id}', [BrandController::class, 'show'])->name('brands.show');
    Route::get('brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('brands/{id}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');

    Route::get('tags', [TagController::class, 'index'])->name('tags.index'); 
    Route::get('tags/create', [TagController::class, 'create'])->name('tags.create'); 
    Route::post('tags', [TagController::class, 'store'])->name('tags.store'); 
    Route::get('tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit'); 
    Route::put('tags/{tag}', [TagController::class, 'update'])->name('tags.update'); 
    Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

});
