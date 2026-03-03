<?php

namespace Modules\Storefront\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class InstitutionalPageController extends Controller
{
    public function atendimento(): View
    {
        return view('storefront::pages.atendimento');
    }

    public function faleConosco(): View
    {
        return view('storefront::pages.fale-conosco');
    }

    public function comprePorTelefone(): View
    {
        return view('storefront::pages.compre-por-telefone');
    }

    public function atendimentoCorporativo(): View
    {
        return view('storefront::pages.atendimento-corporativo');
    }

    public function meusPedidos()
    {
        if (auth()->check()) {
            return redirect()->route('customer.orders.index');
        }

        return view('storefront::pages.meus-pedidos');
    }

    public function minhasDevolucoes(): View
    {
        return view('storefront::pages.minhas-devolucoes');
    }

    public function duvidasFrequentes(): View
    {
        return view('storefront::pages.duvidas-frequentes');
    }

    public function devolucoes(): View
    {
        return view('storefront::pages.devolucoes-reembolsos');
    }

    public function formasPagamentoEntrega(): View
    {
        return view('storefront::pages.formas-pagamento-entrega');
    }

    public function politicaPrivacidade(): View
    {
        return view('storefront::pages.politica-privacidade');
    }

    public function garantias(): View
    {
        return view('storefront::pages.garantias');
    }

    public function termosCondicoes(): View
    {
        return view('storefront::pages.termos-condicoes');
    }
}
