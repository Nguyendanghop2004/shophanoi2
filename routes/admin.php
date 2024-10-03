<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SliderController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

    // quản lí thanh trượt
    Route::get('slider/category/{category_id}', [SliderController::class, 'index'])->name('slider.index');
    Route::resource('slider', SliderController::class)->except(['index']);
    Route::post('slider/update-order', [SliderController::class, 'updateOrder'])->name('slider.updateOrder');

    Route::patch('sliders/{id}/restore', [SliderController::class, 'restore'])->name('slider.restore');
    Route::delete('sliders/{id}/force-delete', [SliderController::class, 'forceDelete'])->name('slider.forceDelete');
});
