<?php

namespace Modules\Shipping\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Shipping\Models\Shipment;

class ShipmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Shipment::with(['order', 'order.customer', 'shippingMethod']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tracking')) {
            $query->where('tracking_code', 'like', '%' . $request->tracking . '%');
        }

        $shipments = $query->latest()->paginate(20)->withQueryString();

        return view('shipping::admin.shipments.index', compact('shipments'));
    }

    public function edit(Shipment $shipment): View
    {
        $shipment->load(['order', 'order.customer', 'shippingMethod']);

        return view('shipping::admin.shipments.edit', compact('shipment'));
    }

    public function updateTracking(Request $request, Shipment $shipment): RedirectResponse
    {
        $validated = $request->validate([
            'tracking_code' => ['required', 'string', 'max:100'],
            'status' => ['required', 'in:pending,dispatched,delivered'],
        ]);

        $shipment->update([
            'tracking_code' => $validated['tracking_code'],
            'status' => $validated['status'],
            'shipped_at' => $validated['status'] === 'dispatched' && ! $shipment->shipped_at ? now() : $shipment->shipped_at,
        ]);

        if ($validated['status'] === 'dispatched') {
            $shipment->refresh();
            $shipment->load(['order.customer', 'shippingMethod']);
            if ($shipment->order) {
                \Modules\Notification\Services\NotificationService::sendOrderShipped($shipment->order, $shipment);
            }
        }

        return redirect()
            ->route('shipping.admin.shipments.index')
            ->with('success', 'Código de rastreamento atualizado.');
    }
}
