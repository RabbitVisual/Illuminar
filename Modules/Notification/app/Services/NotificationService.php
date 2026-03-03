<?php

namespace Modules\Notification\Services;

use Illuminate\Support\Facades\Mail;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Notification\Emails\OrderStatusMail;
use Modules\Notification\Models\EmailTemplate;
use Modules\Sales\Models\Order;
use Modules\Shipping\Models\Shipment;

class NotificationService
{
    /**
     * Envia e-mail de pagamento aprovado (após webhook marcar pedido como pago).
     */
    public static function sendPaymentApproved(Order $order): void
    {
        $template = EmailTemplate::where('mailable_class', EmailTemplate::MAILABLE_PAYMENT_APPROVED)
            ->where('is_active', true)
            ->first();

        if (! $template) {
            return;
        }

        $order->loadMissing('customer');

        $customerEmail = $order->customer?->email;
        if (! $customerEmail) {
            return;
        }

        $subject = self::replacePlaceholders($template->subject, $order, null);
        $body = self::replacePlaceholders($template->body, $order, null);

        Mail::to($customerEmail)->send(new OrderStatusMail(
            $order,
            $subject,
            $body,
            $subject
        ));
    }

    /**
     * Envia e-mail de pedido enviado (após atualização de rastreio/status dispatched).
     */
    public static function sendOrderShipped(Order $order, Shipment $shipment): void
    {
        $template = EmailTemplate::where('mailable_class', EmailTemplate::MAILABLE_ORDER_SHIPPED)
            ->where('is_active', true)
            ->first();

        if (! $template) {
            return;
        }

        $order->loadMissing('customer');
        $shipment->loadMissing('shippingMethod');

        $customerEmail = $order->customer?->email;
        if (! $customerEmail) {
            return;
        }

        $subject = self::replacePlaceholders($template->subject, $order, $shipment);
        $body = self::replacePlaceholders($template->body, $order, $shipment);

        Mail::to($customerEmail)->send(new OrderStatusMail(
            $order,
            $subject,
            $body,
            $subject
        ));
    }

    private static function replacePlaceholders(string $text, Order $order, ?Shipment $shipment): string
    {
        $customerName = $order->customer ? $order->customer->full_name : 'Cliente';
        $orderTotal = UtilsHelper::formatMoneyToDisplay($order->total_amount / 100);

        $replace = [
            '{customer_name}' => $customerName,
            '{order_number}' => $order->order_number,
            '{order_total}' => $orderTotal,
        ];

        if ($shipment) {
            $replace['{tracking_code}'] = $shipment->tracking_code ?? '-';
            $replace['{shipping_method}'] = $shipment->shippingMethod?->name ?? '-';
        } else {
            $replace['{tracking_code}'] = '-';
            $replace['{shipping_method}'] = '-';
        }

        return str_replace(array_keys($replace), array_values($replace), $text);
    }
}
