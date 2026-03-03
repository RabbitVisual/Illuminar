<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Payment\Models\Payment;
use Modules\Sales\Models\Order;

class MercadoPagoWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $payload = $request->getContent();
        $data = json_decode($payload, true) ?? [];

        $externalId = $data['data']['id'] ?? $data['id'] ?? null;
        $metadata = $data['data']['metadata'] ?? $data['metadata'] ?? [];
        $orderId = $metadata['order_id'] ?? null;
        $status = $data['data']['status'] ?? $data['status'] ?? null;

        if (in_array($status, ['approved', 'authorized', 'in_process'], true)) {
            $this->markPaymentAsPaid('mercadopago', $externalId, $orderId, $data);
        }

        return response('OK', 200);
    }

    protected function markPaymentAsPaid(string $provider, ?string $externalId, $orderId, array $payload): void
    {
        if (! $externalId) {
            return;
        }

        $payment = Payment::where('external_id', $externalId)->first();

        if (! $payment && $orderId) {
            $payment = Payment::where('order_id', $orderId)->latest()->first();
        }

        if (! $payment) {
            return;
        }

        if ($payment->status === Payment::STATUS_PAID) {
            return;
        }

        $payment->status = Payment::STATUS_PAID;
        $payment->paid_at = now();

        $existingMetadata = $payment->metadata ?? [];
        $payment->metadata = array_merge($existingMetadata, [
            'webhook_'.$provider => $payload,
        ]);

        $payment->save();

        $order = $payment->order;
        if ($order && $order->status !== Order::STATUS_PAID) {
            $order->status = Order::STATUS_PAID;
            $order->payment_status = Payment::STATUS_PAID;
            $order->save();

            \Modules\Notification\Services\NotificationService::sendPaymentApproved($order);
        }
    }
}

