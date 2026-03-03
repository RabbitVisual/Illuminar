<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\PaymentController;
use Modules\Payment\Http\Controllers\AdminPaymentGatewayController;
use Modules\Payment\Http\Controllers\StripeWebhookController;
use Modules\Payment\Http\Controllers\MercadoPagoWebhookController;
use Modules\Payment\Http\Controllers\PagarmeWebhookController;

// Webhooks públicos dos provedores de pagamento
Route::post('/webhook/stripe', StripeWebhookController::class)->name('payment.webhook.stripe');
Route::post('/webhook/mercadopago', MercadoPagoWebhookController::class)->name('payment.webhook.mercadopago');
Route::post('/webhook/pagarme', PagarmeWebhookController::class)->name('payment.webhook.pagarme');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('payments', PaymentController::class)->names('payment');

    Route::middleware(['role:SuperAdmin|Owner'])->prefix('payment')->name('payment.admin.')->group(function () {
        Route::get('gateways', [AdminPaymentGatewayController::class, 'index'])->name('gateways.index');
        Route::post('gateways', [AdminPaymentGatewayController::class, 'store'])->name('gateways.store');
        Route::get('gateways/{gateway}/edit', [AdminPaymentGatewayController::class, 'edit'])->name('gateways.edit');
        Route::put('gateways/{gateway}', [AdminPaymentGatewayController::class, 'update'])->name('gateways.update');
    });
});
