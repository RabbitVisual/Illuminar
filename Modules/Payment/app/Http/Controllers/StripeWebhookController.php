<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Payment\Models\Payment;
use Modules\Sales\Models\Order;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature', '');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            if ($webhookSecret) {
                $event = \Stripe\Webhook::constructEvent(
                    $payload,
                    $sigHeader,
                    $webhookSecret
                );
            } else {
                $event = json_decode($payload);
            }
        } catch (\Throwable $e) {
            return response('Invalid payload', 400);
        }

        $type = is_object($event) ? ($event->type ?? null) : null;

        if ($type === 'checkout.session.completed' || $type === 'payment_intent.succeeded') {
            $object = $event->data->object ?? null;
            $externalId = $object->id ?? null;
            $metadata = $object->metadata ?? (object) [];
            $orderId = $metadata->order_id ?? null;

            $this->markPaymentAsPaid('stripe', $externalId, $orderId, $object);
        }

        return response('OK', 200);
    }

    protected function markPaymentAsPaid(string $provider, ?string $externalId, $orderId, $payload): void
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
            'webhook_'.$provider => is_object($payload) ? json_decode(json_encode($payload), true) : (array) $payload,
        ]);

        $payment->save();

        $order = $payment->order;
        if ($order && $order->status !== Order::STATUS_PAID) {
            $order->status = Order::STATUS_PAID;
            $order->payment_status = Payment::STATUS_PAID;
            $order->save();
        }
    }
}

