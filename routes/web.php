<?php

use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ShipperController;
use App\Http\Controllers\Client\AboutUsController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Client\BrandController;
use App\Http\Controllers\Client\CartController;
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

Route::get('/', [HomeController::class, 'home'])->name('home');



Route::get('home/{slug}', [HomeController::class, 'slug'])->name('home.slug');

Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('shop-collection/{slug}', [ShopCollectionController::class, 'index'])->name('shop-collection');
Route::get('product-detail/{slug}', [ProductDetailController::class, 'index'])->name('product-detail');
Route::get('brand', [BrandController::class, 'index'])->name('brand');
Route::get('contactv2', [ContactController::class, 'index'])->name('contact');
Route::get('faq', [FAQController::class, 'index'])->name('faq');
Route::get('out-store', [OutStoreController::class, 'index'])->name('out-store');
Route::get('time-line', [TimeLineController::class, 'index'])->name('time-line');
Route::get('shopping-cart', [ShoppingCartController::class, 'index'])->name('shopping-cart');

//thanh toán
Route::get('check-out', [CheckOutController::class, 'checkout'])->name('check-out');
Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('order.place');
Route::get('/vnpay/return', [CheckoutController::class, 'vnPayReturn'])->name('vnpay.return');

// routes/web.php

//end thanh toán
Route::get('payment-confirmation', [PaymentController::class, 'confirmation'])->name('payment-confirmation');
Route::get('payment-failure', [PaymentController::class, 'failure'])->name('payment-failure');

Route::get('/account/{section?}', [AccountController::class, 'acc'])->name('account');

Route::post('/account/login', [AccountController::class, 'login'])->name('account.login');
Route::get('/accountUser/login', [AccountController::class, 'loginIndex'])->name('accountUser.login');

Route::get('/accountUser/logout', [AccountController::class, 'logout'])->name('accountUser.logout');
Route::post('/accountUser/register', [AccountController::class, 'register'])->name('accountUser.register');
Route::get('/accountUser/register', [AccountController::class, 'RegisterIndex'])->name('account.register');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    //start blog
    Route::get('/blog/show', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/blog/{id}/detail', [BlogController::class, 'detail'])->name('blog.detail');

    //end blog

// cart
Route::get('/get-product-info', [HomeController::class, 'getProductInfo']);
Route::post('/add-to-cart', [CartController::class, 'addToCart']);
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');
Route::get('/debug-cart', function () {

    // Session::forget('cart');
    return Session::get('cart');


});
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');




Route::get('/thanhtoanthanhcong', [CheckOutController::class, 'thanhtoanthanhcong'])->name('thanhtoanthanhcong');
Route::post('/select-address', [CheckoutController::class, 'select_address']);

