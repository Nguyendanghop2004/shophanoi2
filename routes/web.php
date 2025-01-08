<?php

use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\client\ErrorController;
use App\Http\Controllers\client\GioithieuController;
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
use App\Http\Controllers\Client\ForgotPasswordController;
use App\Http\Controllers\client\OrderController;
use App\Http\Controllers\Client\OutStoreController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProductDetailController;
use App\Http\Controllers\Client\Profile\ProfileOrderController;
use App\Http\Controllers\Client\ShopCollectionController;
use App\Http\Controllers\Client\ShoppingCartController;
use App\Http\Controllers\Client\TimeLineController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Client\ReviewController;



use Illuminate\Support\Facades\Route;
Route::middleware('checkPassword')->group(function () {


Route::get('/', [HomeController::class, 'home'])->name('home');

Route::get('home/{slug}', [HomeController::class, 'slug'])->name('home.slug');


Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');
Route::get('shop-collection', [ShopCollectionController::class, 'index'])->name('shop-collection');
Route::get('product-detail/{slug}', [ProductDetailController::class, 'index'])->name('product-detail');
Route::get('shop-collection/{slug}', [ShopCollectionController::class, 'index'])->name('shop-collection');
Route::get('product/{slug}', [ProductDetailController::class, 'index'])->name('product-detail');
Route::get('brand', [BrandController::class, 'index'])->name('brand');
Route::get('contactv2', [ContactController::class, 'index'])->name('contact');
Route::get('faq', [FAQController::class, 'index'])->name('faq');
Route::get('out-store', [OutStoreController::class, 'index'])->name('out-store');
Route::get('time-line', [TimeLineController::class, 'index'])->name('time-line');
Route::get('shopping-cart', [ShoppingCartController::class, 'index'])->name('shopping-cart');


Route::get('home/{slug}', [HomeController::class, 'slug'])->name('home.slug');
Route::get('gioithieu', [AboutUsController::class, 'index'])->name('index');
Route::get('error', [ErrorController::class, 'error'])->name('error');

Route::get('about-us', [AboutUsController::class, 'index'])->name('about-us');

Route::get('shop-collection/{slug}', [ShopCollectionController::class, 'index'])->name('shop-collection');
Route::get('product/{slug}', [ProductDetailController::class, 'index'])->name('product-detail');




Route::get('brand', [BrandController::class, 'index'])->name('brand');
Route::get('contactv2', [ContactController::class, 'index'])->name('contact');
Route::get('faq', [FAQController::class, 'index'])->name('faq');
Route::get('out-store', [OutStoreController::class, 'index'])->name('out-store');
Route::get('time-line', [TimeLineController::class, 'index'])->name('time-line');
Route::get('shopping-cart', [ShoppingCartController::class, 'index'])->name('shopping-cart');

//thanh toán
Route::get('check-out', [CheckOutController::class, 'checkout'])->name('checkout');
Route::post('/apply-discount', [CheckOutController::class, 'applyDiscount'])->name('apply.discount');
Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('order.place');
Route::get('/vnpay/return', [CheckoutController::class, 'vnPayReturn'])->name('vnpay.return');
Route::get('/out-of-stock', [CheckoutController::class, 'outOfStock'])->name('out-of-stock');

// routes/web.php

//end thanh toán
Route::get('payment-confirmation', [PaymentController::class, 'confirmation'])->name('payment-confirmation');
Route::get('payment-failure', [PaymentController::class, 'failure'])->name('payment-failure');

Route::get('/account/{section?}', [AccountController::class, 'acc'])->name('account');

Route::get('/accountUser/login', [AccountController::class, 'loginIndex'])->name('accountUser.login');
Route::post('/account/login', [AccountController::class, 'login'])->name('account.login');

Route::get('/accountUser/logout', [AccountController::class, 'logout'])->name('accountUser.logout');
Route::post('/accountUser/register', [AccountController::class, 'register'])->name('accountUser.register');
Route::get('/accountUser/register', [AccountController::class, 'RegisterIndex'])->name('account.register');
Route::get('/accountUser/ResePassword', [AccountController::class, 'ResePasswordIndex'])->name('account.ResePassword');

Route::get('/accountUser/profile/{id}', [AccountController::class, 'profile'])->name('account.profile');
Route::get('/accountUser/profile-address', [AccountController::class, 'profileAddress'])->name('account.profileAddress');
Route::get('/accountUser/profile-profileAccountDetails/{id}', [AccountController::class, 'profileAccountDetails'])->name('account.profileAccountDetails');
Route::put('accountsUser/profile-AccountDetails/{id}', [AccountController::class, 'storeProfile'])->name('accountsUser.storeProfile');
Route::get('/accountUser/profile-profileWishlist', [AccountController::class, 'profileWishlist'])->name('account.profileWishlist');
Route::get('/accountUser/checkPassword/{id}', [AccountController::class, 'checkPassword'])->name('account.checkPassword');
Route::get('/accountUser/change-email', [AccountController::class, 'profileEmail'])->name('account.profileEmail');
Route::put('/accountUser/update-ProfileUpdate/{id}', [AccountController::class, 'ProfileUpdate'])->name('account.ProfileUpdate');
Route::get('/accountUser/profile-password/{id}', [AccountController::class, 'editPassword'])->name('account.editPassword');
Route::put('/accountUser/profile-updatePassword/{id}', [AccountController::class, 'updatePassword'])->name('account.updatePassword');

Route::post('/check-password', [AccountController::class, 'checkPasswordProfile'])->name('check-checkPasswordProfile');


Route::put('/accountUser/update-ProfileUpdate/{id}', [AccountController::class, 'ProfileUpdate'])->name('account.ProfileUpdate');

Route::get('/accountUser/profile-order', [AccountController::class, 'profileOrders'])->name('account.profileOrders');

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetCode'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPassword'])->name('account.resetPassword');
Route::post('/check-code', [ForgotPasswordController::class, 'checkCode'])->name('account.checkcode');
Route::get('/reset-code/{token}', [ForgotPasswordController::class, 'resetCode'])->name('account.resetCode');
Route::get('/reset-change-password/{token}', [ForgotPasswordController::class, 'indexChangePassword'])->name('account.changePassword');
Route::post('/reset-change-password/{id}', [ForgotPasswordController::class, 'changePassword'])->name('account.indexchangePassword');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('home/{slug}', [HomeController::class, 'slug'])->name('home.slug');
});

//start blog
Route::get('/blog', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/{slug}/detail', [BlogController::class, 'detail'])->name('blog.detail');


//end blog

// cart
Route::get('/get-product-info', [HomeController::class, 'getProductInfo']);
Route::get('/get-product-info-quick-view', [HomeController::class, 'getProductInfoQuickView']);

Route::post('/add-to-cart', [CartController::class, 'addToCart']);
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart');
Route::get('/debug-cart', function () {

    // Session::forget('cart');
    return Session::get('cart');
});
Route::post('/remove-from-cart', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/modal-cart', [CartController::class, 'getModalCart'])->name('cart.modal');




Route::get('/order/donhang', [OrderController::class, 'index'])->name('order.donhang');
Route::get('/order/donhang/{id}', [OrderController::class, 'show'])->name('client.orders.show');
Route::post('order/cancel/{id}', [OrderController::class, 'cancel'])->name('client.orders.cancel');

Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');


Route::get('/order/{order_code}/cancel', [OrderController::class, 'showCancelReasonForm'])->name('cancel.order.page');
Route::get('/order/detail/{order_code}', [OrderController::class, 'showOrderDetail'])->name('order.detail.page');
// Route để gửi yêu cầu hủy đơn hàng qua AJAX
Route::post('/order/cancel', [OrderController::class, 'cancelOrder'])->name('cancel.order');



Route::post('/orders/confirm/{id}', [OrderController::class, 'confirmOrder'])->name('orders.confirm');
Route::get('/orders/search', [OrderController::class, 'search'])->name('order.search');



Route::get('/shop-collection/{slug?}', [ShopCollectionController::class, 'index'])->name('shop-collection.index');
Route::get('/shop/filter', [ShopCollectionController::class, 'filterProducts'])->name('shop.filter');
Route::get('/shop-collection/products', [ShopCollectionController::class, 'fetchProducts'])->name('shop-collection.fetch-products');

//profile 
Route::prefix('profile')
    ->as('profile.')
    ->group(function () {

        Route::get('/order/{id}', [ProfileOrderController::class, 'showProfileOrder'])->name('profileOrder');
    });




Route::get('/thanhtoanthanhcong/{id}', [CheckOutController::class, 'thanhtoanthanhcong'])->name('thanhtoanthanhcong');
// 1 cái của đặt hàng
Route::post('/select-address', [CheckoutController::class, 'select_address']);
// 1 cái của profile user
Route::post('/select-address', [AccountController::class, 'select_address']);



Route::get('/shop-collection/{slug?}', [ShopCollectionController::class, 'index'])->name('shop-collection.index');
Route::get('/shop/filter', [ShopCollectionController::class, 'filterProducts'])->name('shop.filter');
Route::get('/shop-collection/products', [ShopCollectionController::class, 'fetchProducts'])->name('shop-collection.fetch-products');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');

// Route cho xóa sản phẩm khỏi danh sách yêu thích
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/list', [WishlistController::class, 'getWishlist'])->name('wishlist');

Route::get('/shop-collection/{slug?}', [ShopCollectionController::class, 'index'])->name('shop-collection.index');
Route::get('/shop/filter', [ShopCollectionController::class, 'filterProducts'])->name('shop.filter');
Route::get('/shop-collection/products', [ShopCollectionController::class, 'fetchProducts'])->name('shop-collection.fetch-products');

Route::get('/reviews/create/{orderId}', [ReviewController::class, 'create'])->name('client.reviews.create');
Route::post('/reviews/store', [ReviewController::class, 'store'])->name('client.reviews.store');

    });

