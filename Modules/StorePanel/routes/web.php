<?php

use Illuminate\Support\Facades\Route;
use Modules\StorePanel\Http\Controllers\StorePanelController;

Route::middleware(['auth', 'verified'])->prefix('pdv')->name('pdv.')->group(function () {
    Route::get('/', [StorePanelController::class, 'index'])->name('index');
    Route::get('/search', [StorePanelController::class, 'searchProduct'])->name('search');
    Route::post('/checkout', [StorePanelController::class, 'checkout'])->name('checkout');
});
