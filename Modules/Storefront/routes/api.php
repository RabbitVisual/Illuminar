<?php

use Illuminate\Support\Facades\Route;
use Modules\Storefront\Http\Controllers\StorefrontController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('storefronts', StorefrontController::class)->names('storefront');
});
