<?php

use Illuminate\Support\Facades\Route;
use Modules\Shipping\Http\Controllers\ShippingController;
use Modules\Shipping\Http\Controllers\ShippingMethodController;
use Modules\Shipping\Http\Controllers\ShipmentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('shippings', ShippingController::class)->names('shipping');

    Route::prefix('shipping')->name('shipping.')->group(function () {
        Route::resource('methods', ShippingMethodController::class)->except(['show']);
    });

    Route::middleware(['role:SuperAdmin|Owner|Manager'])->prefix('shipping/admin')->name('shipping.admin.')->group(function () {
        Route::get('shipments', [ShipmentController::class, 'index'])->name('shipments.index');
        Route::get('shipments/{shipment}/edit', [ShipmentController::class, 'edit'])->name('shipments.edit');
        Route::patch('shipments/{shipment}/tracking', [ShipmentController::class, 'updateTracking'])->name('shipments.update-tracking');
    });
});
