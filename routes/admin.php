<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ColorController;

use App\Http\Controllers\Admin\ErrorController;
use App\Events\SaleUpdated;

use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;


use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ShipperController;
use App\Http\Controllers\Admin\ColorSizeController;
use App\Http\Controllers\Admin\AccoutUserController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\AccoutAdminController;
use App\Http\Controllers\Admin\HistoryUserController;
use App\Http\Controllers\Admin\SaleProductController;

use App\Http\Controllers\Admin\DiscountCodeController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ContactMessageController;

Route::get('admin/login', [LoginController::class, 'login'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'store'])->name('admin.post-login');
Route::prefix('admin')->name('admin.')->middleware(['auth:admin', 'checkAdminStatus'])->group(function () {
    // Login admin
    Route::get('error', [ErrorController::class, 'error'])->name('error');

    Route::get('trangchu', [AccoutAdminController::class, 'trangchu'])->name('trangchu');
    Route::get('admin-logout', [LoginController::class, 'logout'])->name('post-logout');
    Route::get('account', [AccoutAdminController::class, 'account'])->name('accounts.account')->middleware('permission:account_admin');
    Route::get('accounts/create', [AccoutAdminController::class, 'create'])->name('accounts.create')->middleware('permission:account_admin');
    Route::post('accounts/store', [AccoutAdminController::class, 'store'])->name('accounts.store')->middleware('permission:account_admin');
    Route::get('accounts/edit/{id}', [AccoutAdminController::class, 'edit'])->name('accounts.edit')->middleware('permission:account_admin');
    Route::put('accounts/update/{id}', [AccoutAdminController::class, 'update'])->name('accounts.update')->middleware('permission:account_admin');
    Route::delete('accounts/destroy/{id}', [AccoutAdminController::class, 'destroy'])->name('accounts.destroy')->middleware('permission:account_admin');
    Route::get('accounts/show/{id}', [AccoutAdminController::class, 'show'])->name('accounts.show')->middleware('permission:account_admin');
    Route::get('accounts/change/{id}', [AccoutAdminController::class, 'change'])->name('accounts.change')->middleware('permission:account_admin');
    Route::post('accounts/changeAdmin/{id}', [AccoutAdminController::class, 'changeAdmin'])->name('accounts.changeAdmin')->middleware('permission:account_admin');
    // start crud user
    Route::get('accountUser', [AccoutUserController::class, 'accountUser'])->name('accountsUser.accountUser')->middleware('permission:account_user');
    Route::get('accountsUser/create', [AccoutUserController::class, 'create'])->name('accountsUser.create')->middleware('permission:account_user');
    Route::post('accountsUser/store', [AccoutUserController::class, 'store'])->name('accountsUser.store')->middleware('permission:account_user');
    Route::get('accountsUser/edit/{id}', [AccoutUserController::class, 'edit'])->name('accountsUser.edit')->middleware('permission:account_user');
    Route::put('accountsUser/update/{id}', [AccoutUserController::class, 'update'])->name('accountsUser.update')->middleware('permission:account_user');
    Route::delete('accountsUser/destroy/{id}', [AccoutUserController::class, 'destroy'])->name('accountsUser.destroy')->middleware('permission:account_user');

    Route::get('accountsUser/change/{id}', [AccoutUserController::class, 'change'])->name('accountsUser.change')->middleware('permission:account_user');
    Route::post('accountsUser/change/{id}', [AccoutUserController::class, 'changeUser'])->name('accountsUser.changeUser')->middleware('permission:account_user');
    Route::get('accountsUser/show/{id}', [AccoutUserController::class, 'show'])->name('accountsUser.show')->middleware('permission:account_user');
    // end crud user

    // adress

    // end crud user


    //start status user
    Route::post('accountsUser/{id}/accountUser', [AccoutUserController::class, 'activateUser'])->name('accountsUser.activateUser')->middleware('permission:account_user');
    Route::post('accountsUser/{id}/deactivateUser', [AccoutUserController::class, 'deactivateUser'])->name('accountsUser.deactivateUser')->middleware('permission:account_user');
    //end  status user



    //start status change
    Route::post('accountsUser/select-address', [AccoutUserController::class, 'select_address'])->middleware('permission:account_admin');

    Route::get('accounts/profile/{id}', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('accounts/changePassword/{id}', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('accounts/change/{id}', [ProfileController::class, 'change'])->name('profile.change');
    //end  status  change

    // Route::get('accounts/profile', [ProfileController::class, 'index'])->name('profile.index');

    // Permission
    Route::get('permissions/index', [AccoutAdminController::class, 'permissionAdmin'])->name('permissions.index')->middleware('permission:pessmison');
    // Thêm quyền
    Route::get('permissions/phanquyen/{id}', [AccoutAdminController::class, 'phanquyen'])->name('permissions.phanquyen')->middleware('permission:pessmison');
    Route::post('permissions/insertPermission', [AccoutAdminController::class, 'insertPermission'])->name('permissions.insert')->middleware('permission:pessmison');
    // Cấp quyền
    Route::post('permissions/insert_permission/{id}', [AccoutAdminController::class, 'insert_permission'])->name('permissions.insert_permission')->middleware('permission:pessmison');
    // phân vai trò
    Route::get('permissions/phanvaitro/{id}', [AccoutAdminController::class, 'phanvaitro'])->name('permissions.phanvaitro')->middleware('permission:role');
    Route::post('permissions/insert_roles/{id}', [AccoutAdminController::class, 'insert_roles'])->name('permissions.insert_roles')->middleware('permission:role');
    // Thêm vai trò
    Route::post('permissions/insertRoles', [AccoutAdminController::class, 'insertRoles'])->name('permissions.insertRoles')->middleware('permission:role');

    // Trạng thái tài khoản
    // routes/web.php
    Route::post('accounts/{id}/activate', [AccoutAdminController::class, 'activate'])->name('accounts.activate')->middleware('permission:account_admin');
    Route::post('accounts/{id}/deactivate', [AccoutAdminController::class, 'deactivate'])->name('accounts.deactivate')->middleware('permission:account_admin');

    // Quản lý thanh trượt
    Route::resource('slider', SliderController::class)->except(['show']);
    Route::get('slider/trash', [SliderController::class, 'trash'])->name('slider.trash');


    Route::post('slider/update-order', [SliderController::class, 'updateOrder'])->name('slider.updateOrder');

    Route::patch('sliders/{id}/restore', [SliderController::class, 'restore'])->name('slider.restore');
    Route::delete('sliders/{id}/force-delete', [SliderController::class, 'forceDelete'])->name('slider.forceDelete');

    // Quản lý danh mục
    Route::get('categories', [CategoriesController::class, 'list'])->name('categories.list')->middleware('permission:categories');
    Route::get('categories/create', [CategoriesController::class, 'create'])->name('categories.add')->middleware('permission:categories');
    Route::post('categories/store', [CategoriesController::class, 'store'])->name('categories.store')->middleware('permission:categories');
    Route::get('categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit')->middleware('permission:categories');
    Route::put('categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update')->middleware('permission:categories');
    Route::delete('categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.delete')->middleware('permission:categories');

    Route::post('categories/toggle-status/{id}', [CategoriesController::class, 'toggleStatus'])->name('categories.toggleStatus')->middleware('permission:categories');

    // Quản lý sản phẩm
    // quản lí đơn hàng


    //end quản lí đơn hàng
    Route::resource('product', ProductController::class);
    //quản lí coupons
    Route::get('discount-codes', [DiscountCodeController::class, 'index'])->name('discount_codes.index');

    // Route để hiển thị form tạo mã giảm giá
    Route::get('discount-codes/create', [DiscountCodeController::class, 'create'])->name('discount_codes.create');

    // Route để lưu mã giảm giá mới
    Route::post('discount-codes', [DiscountCodeController::class, 'store'])->name('discount_codes.store');

    // Route để hiển thị form sửa mã giảm giá
    Route::get('discount-codes/{id}/edit', [DiscountCodeController::class, 'edit'])->name('discount_codes.edit');

    // Route để cập nhật mã giảm giá
    Route::put('discount-codes/{id}', [DiscountCodeController::class, 'update'])->name('discount_codes.update');

    // Route để xóa mã giảm giá
    Route::delete('discount-codes/{id}', [DiscountCodeController::class, 'destroy'])->name('discount_codes.destroy');

    Route::resource('product', ProductController::class)->middleware('permission:product');


    // Các route riêng cho sản phẩm
    Route::get('/product/get-variant-card/{colorId}', [ProductController::class, 'getVariantCard'])->name('product.getVariantCard')->middleware('permission:product');
    Route::put('product/{id}/update-main-product', [ProductController::class, 'updateMainProduct'])->name('product.updateMainProduct')->middleware('permission:product');
    Route::put('product/{id}/update-variant-product', [ProductController::class, 'updateVariantProduct'])->name('product.updateVariantProduct')->middleware('permission:product');
    Route::post('product/create-variant-product', [ProductController::class, 'createVariantProduct'])->name('product.createVariantProduct')->middleware('permission:product');

    Route::post('product/create-variant-image-product', [ProductController::class, 'createVariantImageColorProduct'])->name('product.createVariantImageColorProduct')->middleware('permission:product');
    Route::post('product/create-variant-color-product', [ProductController::class, 'createVariantColorProduct'])->name('product.createVariantColorProduct')->middleware('permission:product');
    // Xóa một biến thể cụ thể
    Route::delete('/product-variants/{id}', [ProductController::class, 'destroyVariant'])
        ->name('product-variants.destroy')->middleware('permission:product');

    // Xóa tất cả biến thể theo color_id và product_id
    Route::delete('/product-variants', [ProductController::class, 'destroyByColorAndProduct'])
        ->name('product-variants.destroyByColor')->middleware('permission:product');

    Route::resource('contact', ContactMessageController::class)->middleware('permission:contact');
    Route::get('/shippers/search', [ShipperController::class, 'search'])->name('shippers.search');

    Route::get('tags', [TagController::class, 'index'])->name('tags.index')->middleware('permission:product');
    Route::get('tags/create', [TagController::class, 'create'])->name('tags.create')->middleware('permission:product');
    Route::post('tags', [TagController::class, 'store'])->name('tags.store')->middleware('permission:product');
    Route::get('tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit')->middleware('permission:product');
    Route::put('tags/{tag}', [TagController::class, 'update'])->name('tags.update')->middleware('permission:product');
    Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy')->middleware('permission:product');

    Route::get('sizes', [SizeController::class, 'index'])->name('sizes.index')->middleware('permission:product');
    Route::get('sizes/create', [SizeController::class, 'create'])->name('sizes.create')->middleware('permission:product');
    Route::post('sizes', [SizeController::class, 'store'])->name('sizes.store')->middleware('permission:product');
    Route::get('sizes/{id}', [SizeController::class, 'show'])->name('sizes.show')->middleware('permission:product');
    Route::get('sizes/{id}/edit', [SizeController::class, 'edit'])->name('sizes.edit')->middleware('permission:product');
    Route::put('sizes/{id}', [SizeController::class, 'update'])->name('sizes.update')->middleware('permission:product');
    Route::delete('sizes/{id}', [SizeController::class, 'destroy'])->name('sizes.destroy')->middleware('permission:product');

    // Route cho ColorController
    Route::get('colors', [ColorController::class, 'index'])->name('colors.index')->middleware('permission:product');
    Route::get('colors/create', [ColorController::class, 'create'])->name('colors.create')->middleware('permission:product');
    Route::post('colors', [ColorController::class, 'store'])->name('colors.store')->middleware('permission:product');
    Route::get('colors/{id}', [ColorController::class, 'show'])->name('colors.show')->middleware('permission:product');
    Route::get('colors/{id}/edit', [ColorController::class, 'edit'])->name('colors.edit')->middleware('permission:product');
    Route::put('colors/{id}', [ColorController::class, 'update'])->name('colors.update')->middleware('permission:product');
    Route::delete('colors/{id}', [ColorController::class, 'destroy'])->name('colors.destroy')->middleware('permission:product');

    // Route cho BrandController
    Route::get('brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('brands', [BrandController::class, 'store'])->name('brands.store');
    Route::get('brands/{id}', [BrandController::class, 'show'])->name('brands.show');
    Route::get('brands/{id}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('brands/{id}/edit', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('brands/{id}', [BrandController::class, 'destroy'])->name('brands.destroy');
    Route::put('brands/{id}', [BrandController::class, 'update'])->name('brands.update');

    Route::get('colors-sizes', [ColorSizeController::class, 'index'])->name('colors_sizes.index')->middleware('permission:product');




    // lịch sử cập nhật admin.
    Route::get('history', [HistoryController::class, 'history'])->name('history')->middleware('permission:account_admin');
    Route::get('history/show/{id}', [HistoryController::class, 'show'])->name('show')->middleware('permission:account_admin');
    Route::delete('history/delete/{id}', [HistoryController::class, 'delete'])->name('delete')->middleware('permission:account_admin');
    // end  lịch sử cập nhật admin

    // lịch sử cập nhật user
    Route::get('history-user', [HistoryUserController::class, 'historyUser'])->name('historyUser')->middleware('permission:account_admin');
    Route::get('history-user/show/{id}', [HistoryUserController::class, 'showUser'])->name('showUser')->middleware('permission:account_admin');

    // end  lịch sử cập nhật admin
    //start blog
    Route::get('blog/index', [BlogController::class, 'index'])->name('blog.index')->middleware('permission:blog');
    Route::post('blog/store', [BlogController::class, 'store'])->name('blog.store')->middleware('permission:blog');
    Route::get('blog/show', [BlogController::class, 'show'])->name('blog.show')->middleware('permission:blog');
    Route::get('blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit')->middleware('permission:blog');
    Route::put('blog/{id}/update', [BlogController::class, 'update'])->name('blog.update')->middleware('permission:blog');
    Route::delete('blog/delete/{id}', [BlogController::class, 'destroy'])->name('blog.destroy')->middleware('permission:blog');

    Route::post('blog/{id}/accountBlog', [BlogController::class, 'activateBlog'])->name('accountsUser.activateBlog')->middleware('permission:blog');
    Route::post('blog/{id}/deactivateBlog', [BlogController::class, 'deactivateBlog'])->name('accountsUser.deactivateBlog')->middleware('permission:blog');
    //end blog
    // ORDERS

    Route::get('order/getList', [OrderController::class, 'getList'])->name('order.getList')->middleware('permission:order');
    Route::get('order/{id}', [OrderController::class, 'chitiet'])->name('order.chitiet')->middleware('permission:order');
    Route::post('order/{id}/update-status', [OrderController::class, 'updateStatus'])->name('order.update-status')->middleware('permission:order');
    Route::get('order/index', [OrderController::class, 'index'])->name('order.index')->middleware('permission:order');
    Route::get('order/in-hoadon/{id}', [OrderController::class, 'inhoadon'])->name('order.inHoaDon')->middleware('permission:order');
    // Shipper
    Route::resource('shippers', ShipperController::class)->middleware('permission:manager_ship');
    Route::get('orders/assign', [OrderController::class, 'showAssignShipperForm'])->name('order.assign')->middleware('permission:manager_ship');
    Route::post('order/assign/{id}', [OrderController::class, 'assignShipper'])->name('order.assignShipper')->middleware('permission:manager_ship');
    Route::get('orders/danhsachgiaohang', [OrderController::class, 'danhsachgiaohang'])->name('order.danhsachgiaohang')->middleware('permission:Shipper');
    Route::post('order/{order}/remove-shipper', [OrderController::class, 'removeShipper'])->name('order.removeShipper')->middleware('permission:Shipper');
    Route::post('order/{id}/update-updateStatusShip', [OrderController::class, 'updateStatusShip'])->name('order.update-updateStatusShip')->middleware('permission:Shipper');

    //sale product
    Route::get('sales/datatables', [SaleProductController::class, 'getSalesData'])->name('sales.datatables')->middleware('permission:product');
    Route::resource('/sales', SaleProductController::class)->middleware('permission:product');
    // thongke
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard')->middleware('permission:account_admin');
    Route::post('/filter', [AdminDashboardController::class, 'index'])->name('dashboard.index.filter');

    Route::get('reviews', [ReviewController::class, 'index'])->name('review.index');




});


