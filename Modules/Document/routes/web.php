<?php

use Illuminate\Support\Facades\Route;
use Modules\Document\Http\Controllers\DocumentController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('documents/orders/{orderNumber}/receipt', [DocumentController::class, 'downloadOrderReceipt'])->name('document.order.receipt');
    Route::resource('documents', DocumentController::class)->names('document');
});
