<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomerPanel\Http\Controllers\CustomerPanelController;

Route::middleware(['auth', 'verified', 'role:Customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/', [CustomerPanelController::class, 'index'])->name('index');
    Route::get('/orders', [CustomerPanelController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order_number}', [CustomerPanelController::class, 'showOrder'])->name('orders.show');
    Route::get('/profile', [CustomerPanelController::class, 'profile'])->name('profile');
    Route::post('/profile', [CustomerPanelController::class, 'updateProfile'])->name('profile.update');
});
