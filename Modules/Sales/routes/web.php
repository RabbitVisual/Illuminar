<?php

use Illuminate\Support\Facades\Route;
use Modules\Sales\Http\Controllers\OrderController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('sales/orders', [OrderController::class, 'index'])->name('sales.orders.index');
    Route::get('sales/orders/{order}', [OrderController::class, 'show'])->name('sales.orders.show');
    Route::post('sales/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('sales.orders.update-status');
});
