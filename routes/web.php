<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ShipperController;
use App\Http\Controllers\Client\AboutUsController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\BrandController;
use App\Http\Controllers\Client\CheckOutController;
use App\Http\Controllers\Client\FAQController;
use App\Http\Controllers\Client\OutStoreController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProductDetailController;
use App\Http\Controllers\Client\ShopCollectionController;
use App\Http\Controllers\Client\ShoppingCartController;
use App\Http\Controllers\Client\TimeLineController;
use App\Http\Controllers\ProfileController;
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
Route::get('home/{slug}', [HomeController::class, 'slug'])->name('home.slug');

Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('/shop-collection/{id}', [ShopCollectionController::class, 'index'])->name('shop-collection');
Route::get('product-detail/{slug}', [ProductDetailController::class, 'index'])->name('product-detail');
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



