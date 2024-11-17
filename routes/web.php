<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ShipperController;
use App\Http\Controllers\Client\AboutUsController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\CheckOutController;
use App\Http\Controllers\Client\FAQController;
use App\Http\Controllers\Client\OutStoreController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProductDetailController;
use App\Http\Controllers\Client\ShopCollectionController;
use App\Http\Controllers\Client\ShoppingCartController;
use App\Http\Controllers\Client\TimeLineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\MaterialController;
use App\Http\Controllers\Admin\PriceSaleController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TagCollectionController;
use App\Http\Controllers\Admin\TagMaterialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('home/{category_id?}', [HomeController::class, 'home'])->name('home');

Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('shop-collection', [ShopCollectionController::class, 'index'])->name('shop-collection');
Route::get('product-detail', [ProductDetailController::class, 'index'])->name('product-detail');
Route::get('brand', [BrandController::class, 'index'])->name('brand');
Route::get('contactv2', [ContactController::class, 'index'])->name('contact');
Route::get('faq', [FAQController::class, 'index'])->name('faq');
Route::get('out-store', [OutStoreController::class, 'index'])->name('out-store');
Route::get('time-line', [TimeLineController::class, 'index'])->name('time-line');
Route::get('shopping-cart', [ShoppingCartController::class, 'index'])->name('shopping-cart');
Route::get('check-out', [CheckOutController::class, 'index'])->name('check-out');
Route::get('payment-confirmation', [PaymentController::class, 'confirmation'])->name('payment-confirmation');
Route::get('payment-failure', [PaymentController::class, 'failure'])->name('payment-failure');

Route::get('/account/{section?}', [AccountController::class, 'acc'])->name('account');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// contac nào đây ?
Route::resource('contact', ContactMessageController::class);
Route::get('/shippers/search', [ShipperController::class, 'search'])->name('shippers.search');

Route::resource('shippers', ShipperController::class);

Route::get('categories', [CategoriesController::class, 'list'])->name('categories.list');
Route::get('categories/create', [CategoriesController::class, 'create'])->name('categories.add');
Route::post('categories/store', [CategoriesController::class, 'store'])->name('categories.store');
Route::get('categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
Route::put('categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
Route::delete('categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.delete');
Route::post('categories/toggle-status/{id}', [CategoriesController::class, 'toggleStatus'])->name('categories.toggleStatus');


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

// Danh sách chất liệu
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
Route::get('/materials/create', [MaterialController::class, 'create'])->name('materials.create');
Route::post('/materials', [MaterialController::class, 'store'])->name('materials.store');
Route::get('/materials/{material}/edit', [MaterialController::class, 'edit'])->name('materials.edit');
Route::put('/materials/{material}', [MaterialController::class, 'update'])->name('materials.update');
Route::delete('/materials/{material}', [MaterialController::class, 'destroy'])->name('materials.destroy');

Route::resource('variants', ProductVariantController::class);
Route::get('variants/search', [ProductVariantController::class, 'search'])->name('variants.search');

Route::resource('product', ProductController::class);

Route::resource('tag_collections', TagCollectionController::class);

Route::resource('tag_materials', TagMaterialController::class);