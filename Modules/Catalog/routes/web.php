<?php

use Illuminate\Support\Facades\Route;
use Modules\Catalog\Http\Controllers\BrandController;
use Modules\Catalog\Http\Controllers\CategoryController;
use Modules\Catalog\Http\Controllers\ProductController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('catalog/brands', BrandController::class)->names('catalog.brands');
    Route::resource('catalog/categories', CategoryController::class)->names('catalog.categories');
    Route::resource('catalog/products', ProductController::class)->names('catalog.products');
});
