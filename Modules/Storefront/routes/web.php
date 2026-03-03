<?php

use Illuminate\Support\Facades\Route;
use Modules\Storefront\Http\Controllers\StorefrontController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('storefronts', StorefrontController::class)->names('storefront');
});
