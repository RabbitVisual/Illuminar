<?php

use Illuminate\Support\Facades\Route;
use Modules\Storefront\Http\Controllers\StorefrontController;

Route::middleware('web')->group(function () {
    Route::get('/', [StorefrontController::class, 'index'])->name('storefront.index');
    Route::get('/produto/{slug}', [StorefrontController::class, 'product'])->name('storefront.product');
    Route::get('/carrinho', [StorefrontController::class, 'cart'])->name('storefront.cart');

    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [StorefrontController::class, 'checkout'])->name('storefront.checkout');
        Route::post('/checkout', [StorefrontController::class, 'processCheckout'])->name('storefront.checkout.process');
    });
});
