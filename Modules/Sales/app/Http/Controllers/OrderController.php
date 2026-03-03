<?php

namespace Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Sales\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request): View
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

        $orders = $query->paginate(15)->withQueryString();

        return view('sales::orders.index', compact('orders'));
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
