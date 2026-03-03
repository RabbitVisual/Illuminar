<?php

use Illuminate\Support\Facades\Route;
use Modules\Storefront\Http\Controllers\StorefrontController;
use Modules\Storefront\Http\Controllers\InstitutionalPageController;

Route::middleware('web')->group(function () {
    Route::get('/', [StorefrontController::class, 'index'])->name('storefront.index');
    Route::get('/catalogo', [StorefrontController::class, 'catalog'])->name('storefront.catalog');
    Route::get('/produto/{slug}', [StorefrontController::class, 'product'])->name('storefront.product');
    Route::get('/carrinho', [StorefrontController::class, 'cart'])->name('storefront.cart');
    Route::post('/calcular-frete', [StorefrontController::class, 'calculateShipping'])->name('storefront.calculate-shipping');

    Route::get('/checkout/sucesso', [StorefrontController::class, 'checkoutSuccess'])->name('storefront.checkout.success');
    Route::get('/checkout/cancelado', [StorefrontController::class, 'checkoutCancel'])->name('storefront.checkout.cancel');

    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [StorefrontController::class, 'checkout'])->name('storefront.checkout');
        Route::post('/checkout', [StorefrontController::class, 'processCheckout'])->name('storefront.checkout.process');
    });

    // Páginas institucionais e de atendimento
    Route::get('/atendimento', [InstitutionalPageController::class, 'atendimento'])->name('storefront.page.atendimento');
    Route::get('/fale-conosco', [InstitutionalPageController::class, 'faleConosco'])->name('storefront.page.fale-conosco');
    Route::get('/compre-por-telefone', [InstitutionalPageController::class, 'comprePorTelefone'])->name('storefront.page.compre-por-telefone');
    Route::get('/atendimento-corporativo', [InstitutionalPageController::class, 'atendimentoCorporativo'])->name('storefront.page.atendimento-corporativo');
    Route::get('/meus-pedidos', [InstitutionalPageController::class, 'meusPedidos'])->name('storefront.page.meus-pedidos');
    Route::get('/minhas-devolucoes', [InstitutionalPageController::class, 'minhasDevolucoes'])->name('storefront.page.minhas-devolucoes');

    // Páginas de dúvidas e políticas
    Route::get('/duvidas-frequentes', [InstitutionalPageController::class, 'duvidasFrequentes'])->name('storefront.page.duvidas-frequentes');
    Route::get('/devolucoes-reembolsos', [InstitutionalPageController::class, 'devolucoes'])->name('storefront.page.devolucoes-reembolsos');
    Route::get('/formas-pagamento-entrega', [InstitutionalPageController::class, 'formasPagamentoEntrega'])->name('storefront.page.formas-pagamento-entrega');

    // Páginas legais
    Route::get('/politica-privacidade', [InstitutionalPageController::class, 'politicaPrivacidade'])->name('storefront.page.politica-privacidade');
    Route::get('/garantias', [InstitutionalPageController::class, 'garantias'])->name('storefront.page.garantias');
    Route::get('/termos-condicoes', [InstitutionalPageController::class, 'termosCondicoes'])->name('storefront.page.termos-condicoes');
});
