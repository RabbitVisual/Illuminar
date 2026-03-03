<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Document\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Document\Services\PdfService;
use Modules\Sales\Models\Order;
use Symfony\Component\HttpKernel\Exception\HttpException;

class DocumentController extends Controller
{
    public function __construct(
        protected PdfService $pdfService
    ) {}

    /**
     * Stream order receipt PDF (A4 for storefront, 80mm for POS).
     */
    public function downloadOrderReceipt(string $orderNumber): Response
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items.product', 'customer', 'paymentGateway'])
            ->firstOrFail();

        if (auth()->user()->hasRole('Customer') && (int) $order->customer_id !== (int) auth()->id()) {
            throw new HttpException(403, 'Acesso não autorizado a este pedido.');
        }

        $isPos = $order->origin === Order::ORIGIN_POS;

        if ($isPos) {
            $view = 'document::templates.pos-receipt-80mm';
            $paperSize = [0, 0, 226.77, 1000];
            $orientation = 'portrait';
        } else {
            $view = 'document::templates.order-receipt-a4';
            $paperSize = 'a4';
            $orientation = 'portrait';
        }

        $pdf = $this->pdfService->generate($view, ['order' => $order], $paperSize, $orientation);

        return $pdf->stream('recibo-' . $orderNumber . '.pdf');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('document::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('document::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('document::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('document::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
