<?php

use App\Http\Controllers\Admin\BrandController;
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
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\PriceSaleController;
use App\Http\Controllers\Admin\ProductVariantController;
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
require __DIR__ . '/auth.php';
Route::get('categories', [CategoriesController::class, 'list'])->name('categories.list');
Route::get('categories/create', [CategoriesController::class, 'create'])->name('categories.add');
Route::post('categories/store', [CategoriesController::class, 'store'])->name('categories.store');
Route::get('categories/edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');
Route::put('categories/update/{id}', [CategoriesController::class, 'update'])->name('categories.update');
Route::delete('categories/{id}', [CategoriesController::class, 'destroy'])->name('categories.delete');
Route::post('categories/toggle-status/{id}', [CategoriesController::class, 'toggleStatus'])->name('categories.toggleStatus');

Route::resource('attributes', AttributeController::class);

Route::resource('sizes', SizeController::class);
Route::resource('colors', ColorController::class);
Route::resource('prices', PriceSaleController::class);
Route::get('/prices/search', [PriceSaleController::class, 'search'])->name('prices.search');


Route::get('/search', [PriceSaleController::class, 'search'])->name('search');

Route::resource('variants', ProductVariantController::class);
Route::get('/search', [ProductVariantController::class, 'search'])->name('search');


Route::resource('brands', BrandController::class);
