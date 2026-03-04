<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Sales\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'user'])
            ->withCount('items')
            ->orderByDesc('created_at');

        if ($request->filled('order_number')) {
            $query->where('order_number', 'like', '%' . $request->order_number . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Export CSV (limitado para evitar respostas muito grandes)
        if ($request->get('export') === 'csv') {
            $exportQuery = clone $query;
            $orders = $exportQuery->limit(5000)->get();

            $fileName = 'pedidos-' . now()->format('Ymd-His') . '.csv';

            return response()->streamDownload(function () use ($orders) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, [
                    'Número',
                    'Data',
                    'Cliente',
                    'Itens',
                    'Total (BRL)',
                    'Status',
                    'Status Pagamento',
                    'Origem',
                ]);

                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->order_number,
                        optional($order->created_at)->format('d/m/Y H:i'),
                        optional($order->customer)->full_name ?? 'Consumidor Final',
                        $order->items_count,
                        UtilsHelper::formatMoneyToDisplay($order->total_amount / 100),
                        $order->status_label,
                        $order->payment_status ? ucfirst(str_replace('_', ' ', $order->payment_status)) : 'Aguardando',
                        $order->origin_label,
                    ]);
                }

                fclose($handle);
            }, $fileName, [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);
        }

        // Estatísticas rápidas para o resumo
        $statsQuery = clone $query;
        $totalAmount = (int) $statsQuery->sum('total_amount');
        $totalCount = (clone $query)->count();
        $avgTicket = $totalCount > 0 ? $totalAmount / $totalCount : 0;

        $orders = $query->paginate(15)->withQueryString();

        $stats = [
            'total_count' => $totalCount,
            'total_amount_formatted' => UtilsHelper::formatMoneyToDisplay($totalAmount / 100),
            'avg_ticket_formatted' => UtilsHelper::formatMoneyToDisplay($avgTicket / 100),
        ];

        return view('sales::orders.index', compact('orders', 'stats'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'customer', 'user', 'payments', 'paymentGateway']);

        return view('sales::orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,paid,canceled,shipped'],
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()
            ->route('sales.orders.show', $order)
            ->with('success', 'Status do pedido atualizado com sucesso.');
    }
}
