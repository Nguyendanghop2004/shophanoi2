<?php

use App\Http\Controllers\Admin\AccoutAdminController;
use App\Http\Controllers\Admin\AccoutUserController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'store'])->name('admin.post-login');
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'checkAdminStatus' ,'checkPassword'])->group( function () {
    // Login admin
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('admin-logout', [LoginController::class, 'logout'])->name('post-logout');
    Route::get('account', [AccoutAdminController::class, 'account'])->name('accounts.account')->middleware('permission:index_account_admin');
    Route::get('accounts/create', [AccoutAdminController::class, 'create'])->name('accounts.create');
    Route::post('accounts/store', [AccoutAdminController::class, 'store'])->name('accounts.store');
    Route::get('accounts/edit/{id}', [AccoutAdminController::class, 'edit'])->name('accounts.edit');
    Route::put('accounts/update/{id}', [AccoutAdminController::class, 'update'])->name('accounts.update');
    Route::delete('accounts/destroy/{id}', [AccoutAdminController::class, 'destroy'])->name('accounts.destroy');
    Route::get('accounts/show/{id}', [AccoutAdminController::class, 'show'])->name('accounts.show');
    Route::get('accounts/change/{id}', [AccoutAdminController::class, 'change'])->name('accounts.change');
    Route::post('accounts/changeAdmin/{id}', [AccoutAdminController::class, 'changeAdmin'])->name('accounts.changeAdmin');

    Route::get('accountUser', [AccoutUserController::class, 'accountUser'])->name('accountsUser.accountUser');
    // start crud user
    Route::get('accountsUser/create', [AccoutUserController::class, 'create'])->name('accountsUser.create');
    Route::post('accountsUser/store', [AccoutUserController::class, 'store'])->name('accountsUser.store');
    Route::get('accountsUser/edit/{id}', [AccoutUserController::class, 'edit'])->name('accountsUser.edit');
    Route::put('accountsUser/update/{id}', [AccoutUserController::class, 'update'])->name('accountsUser.update');
    Route::delete('accountsUser/destroy/{id}', [AccoutUserController::class, 'destroy'])->name('accountsUser.destroy');

    Route::get('accountsUser/change/{id}', [AccoutUserController::class, 'change'])->name('accountsUser.change');
    Route::post('accountsUser/change/{id}', [AccoutUserController::class, 'changeUser'])->name('accountsUser.changeUser');
    Route::get('accountsUser/show/{id}', [AccoutUserController::class, 'show'])->name('accountsUser.show');
    // end crud user 

    // adress
    Route::post('accountsUser/select-address', [AccoutUserController::class, 'select_address']);

    // end crud user


    //start status user
    
    Route::post('accountsUser/{id}/accountUser', [AccoutUserController::class, 'activateUser'])->name('accountsUser.activateUser')->middleware('permission:activate_Account');
    Route::post('accountsUser/{id}/deactivateUser', [AccoutUserController::class, 'deactivateUser'])->name('accountsUser.deactivateUser')->middleware('permission:deactivate_Account');
    //end  status user

    
//start status change
    Route::get('accounts/profile/{id}', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('accounts/changePassword/{id}', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('accounts/change/{id}', [ProfileController::class, 'change'])->name('profile.change');
//end  status  change

    // Route::get('accounts/profile', [ProfileController::class, 'index'])->name('profile.index');

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
    Route::resource('product', ProductController::class)->middleware('permission:product');

    // Các route riêng cho sản phẩm
    Route::get('/product/get-variant-card/{colorId}', [ProductController::class, 'getVariantCard'])->name('product.getVariantCard');
    Route::put('product/{id}/update-main-product', [ProductController::class, 'updateMainProduct'])->name('product.updateMainProduct');
    Route::put('product/{id}/update-variant-product', [ProductController::class, 'updateVariantProduct'])->name('product.updateVariantProduct');
    Route::post('product/create-variant-product', [ProductController::class, 'createVariantProduct'])->name('product.createVariantProduct');
    Route::post('product/create-variant-image-product', [ProductController::class, 'createVariantImageColorProduct'])->name('product.createVariantImageColorProduct');
    Route::post('product/create-variant-color-product', [ProductController::class, 'createVariantColorProduct'])->name('product.createVariantColorProduct');
    Route::delete('/product-variants/{id}', [ProductController::class, 'destroyVariant'])->name('product-variants.destroy');




    Route::post('accountsUser/select-address', [AccoutUserController::class, 'select_address']);
    // lịch sử cập nhật admin.
    Route::get('history', [HistoryController::class, 'history'])->name('history');
    Route::get('history/show/{id}', [HistoryController::class, 'show'])->name('show');
    Route::delete('history/delete/{id}', [HistoryController::class, 'delete'])->name('delete');


});
