<?php

use Illuminate\Support\Facades\Route;
use Modules\Inventory\Http\Controllers\InventoryTransactionController;
use Modules\Inventory\Http\Controllers\SupplierController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('inventory/kardex', [InventoryTransactionController::class, 'index'])->name('inventory.transactions.index');
    Route::get('inventory/transactions/create', [InventoryTransactionController::class, 'create'])->name('inventory.transactions.create');
    Route::post('inventory/transactions', [InventoryTransactionController::class, 'store'])->name('inventory.transactions.store');

    Route::resource('inventory/suppliers', SupplierController::class)->names('inventory.suppliers');
});
