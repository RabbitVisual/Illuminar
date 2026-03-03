<?php

namespace Modules\Payment\Services;

use Modules\Payment\Models\PaymentGateway;

class GatewayResolver
{
    public function resolveForMethod(string $paymentMethod): ?PaymentGateway
    {
        $method = $paymentMethod;

        return PaymentGateway::query()
            ->where('is_active', true)
            ->orderBy('provider')
            ->orderBy('environment')
            ->get()
            ->first(function (PaymentGateway $gateway) use ($method) {
                $credentials = $gateway->credentials ?? [];
                $supported = $credentials['supported_methods'] ?? null;

                if (is_array($supported) && $supported !== []) {
                    return in_array($method, $supported, true);
                }

                // Se não houver configuração explícita, assume que o gateway aceita todos os métodos suportados.
                return in_array($method, PaymentGateway::supportedPaymentMethods(), true);
            });
    }
}

