<?php

namespace Modules\Payment\Services;

use Modules\Payment\Models\PaymentGateway;
use Modules\Sales\Models\Order;
use Modules\Payment\Models\Payment;

class PaymentService
{
    /**
     * Process payment for an order using the given gateway.
     * Retorna um array com:
     * - status        => pending|processing
     * - external_id   => identificador no provedor
     * - payment_url   => URL para redirecionar o cliente (quando aplicável)
     * - raw_response  => payload bruto retornado pelo provedor (array serializável)
     */
    public function process(Order $order, PaymentGateway $gateway, string $paymentMethod): array
    {
        // Validate gateway is active
        if (! $gateway->is_active) {
            throw new \InvalidArgumentException('O gateway de pagamento selecionado não está ativo.');
        }

        switch ($gateway->provider) {
            case PaymentGateway::PROVIDER_MERCADOPAGO:
                return $this->processMercadoPago($order, $gateway, $paymentMethod);
            case PaymentGateway::PROVIDER_PAGARME:
                return $this->processPagarme($order, $gateway, $paymentMethod);
            case PaymentGateway::PROVIDER_STRIPE:
                return $this->processStripe($order, $gateway, $paymentMethod);
            default:
                throw new \InvalidArgumentException("Provedor de pagamento não suportado: {$gateway->provider}");
        }
    }

    protected function processMercadoPago(Order $order, PaymentGateway $gateway, string $paymentMethod): array
    {
        $credentials = $gateway->credentials ?? [];
        $accessToken = $credentials['secret_key'] ?? null;

        if (! $accessToken) {
            throw new \InvalidArgumentException('Configure as chaves do Mercado Pago antes de processar pagamentos.');
        }

        // Mercado Pago Checkout Pro - preferência de pagamento
        // Docs: https://www.mercadopago.com.br/developers/pt/docs/checkout-pro
        $successUrl = route('storefront.checkout.success', ['order' => $order->order_number, 'provider' => 'mercadopago']);
        $cancelUrl = route('storefront.checkout.cancel', ['order' => $order->order_number, 'provider' => 'mercadopago']);

        $items = [
            [
                'title' => 'Pedido '.$order->order_number,
                'quantity' => 1,
                'unit_price' => $order->total_amount / 100,
                'currency_id' => 'BRL',
            ],
        ];

        $methods = [
            'excluded_payment_methods' => [],
            'excluded_payment_types' => [],
        ];

        if ($paymentMethod === 'pix') {
            // Checkout Pro já habilita PIX automaticamente quando disponível; aqui apenas garantimos que cartão/boleto não sejam excluídos.
        } elseif ($paymentMethod === 'credit_card') {
            // Nada específico – cartão é padrão.
        } elseif ($paymentMethod === 'boleto') {
            // Em Checkout Pro boleto também é habilitado por padrão.
        }

        $client = new \MercadoPago\Client\Preference\PreferenceClient();
        \MercadoPago\MercadoPagoConfig::setAccessToken($accessToken);

        $preference = $client->create([
            'items' => $items,
            'payer' => [
                'email' => $order->customer?->email,
            ],
            'back_urls' => [
                'success' => $successUrl,
                'failure' => $cancelUrl,
                'pending' => $successUrl,
            ],
            'auto_return' => 'approved',
            'payment_methods' => $methods,
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'gateway_id' => $gateway->id,
            ],
        ]);

        return [
            'status' => Payment::STATUS_PENDING,
            'external_id' => $preference->id ?? null,
            'payment_url' => $preference->init_point ?? null,
            'raw_response' => $preference instanceof \JsonSerializable ? $preference->jsonSerialize() : (array) $preference,
        ];
    }

    protected function processPagarme(Order $order, PaymentGateway $gateway, string $paymentMethod): array
    {
        $credentials = $gateway->credentials ?? [];
        $apiKey = $credentials['secret_key'] ?? null;

        if (! $apiKey) {
            throw new \InvalidArgumentException('Configure as chaves do Pagar.me antes de processar pagamentos.');
        }

        // Docs: https://docs.pagar.me/ - uso básico de transações
        $client = new \PagarMe\Client($apiKey);

        $transactionData = [
            'amount' => $order->total_amount,
            'payment_method' => $paymentMethod === 'boleto' ? 'boleto' : ($paymentMethod === 'pix' ? 'pix' : 'credit_card'),
            'postback_url' => $credentials['webhook_url'] ?? route('payment.webhook.pagarme'),
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'gateway_id' => $gateway->id,
            ],
        ];

        if ($order->customer) {
            $transactionData['customer'] = [
                'name' => $order->customer->full_name ?? $order->customer->first_name,
                'email' => $order->customer->email,
            ];
        }

        $transaction = $client->transactions()->create($transactionData);

        $paymentUrl = null;
        $metadata = [];

        if (isset($transaction->boleto_url)) {
            $paymentUrl = $transaction->boleto_url;
        } elseif (isset($transaction->pix_qr_code_url)) {
            $paymentUrl = $transaction->pix_qr_code_url;
        }

        if (isset($transaction->boleto_barcode)) {
            $metadata['boleto_barcode'] = $transaction->boleto_barcode;
        }
        if (isset($transaction->pix_qr_code)) {
            $metadata['pix_qr_code'] = $transaction->pix_qr_code;
        }

        return [
            'status' => Payment::STATUS_PENDING,
            'external_id' => $transaction->id ?? null,
            'payment_url' => $paymentUrl,
            'raw_response' => json_decode(json_encode($transaction), true),
            'metadata' => $metadata,
        ];
    }

    protected function processStripe(Order $order, PaymentGateway $gateway, string $paymentMethod): array
    {
        $credentials = $gateway->credentials ?? [];
        $secretKey = $credentials['secret_key'] ?? null;

        if (! $secretKey) {
            throw new \InvalidArgumentException('Configure as chaves da Stripe antes de processar pagamentos.');
        }

        // Docs: https://docs.stripe.com/payments/checkout/one-time
        $stripe = new \Stripe\StripeClient($secretKey);

        $mode = 'payment';
        $paymentMethodTypes = match ($paymentMethod) {
            'pix' => ['pix'],
            'boleto' => ['boleto'],
            default => ['card'],
        };

        $successUrl = route('storefront.checkout.success', ['order' => $order->order_number, 'provider' => 'stripe']).'&session_id={CHECKOUT_SESSION_ID}';
        $cancelUrl = route('storefront.checkout.cancel', ['order' => $order->order_number, 'provider' => 'stripe']);

        $session = $stripe->checkout->sessions->create([
            'mode' => $mode,
            'payment_method_types' => $paymentMethodTypes,
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'brl',
                        'product_data' => [
                            'name' => 'Pedido '.$order->order_number,
                        ],
                        'unit_amount' => $order->total_amount,
                    ],
                    'quantity' => 1,
                ],
            ],
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'metadata' => [
                'order_id' => (string) $order->id,
                'order_number' => $order->order_number,
                'gateway_id' => (string) $gateway->id,
            ],
        ]);

        return [
            'status' => Payment::STATUS_PENDING,
            'external_id' => $session->id ?? null,
            'payment_url' => $session->url ?? null,
            'raw_response' => $session->toArray(),
        ];
    }
}
