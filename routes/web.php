<?php

use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\ShipperController;
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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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
