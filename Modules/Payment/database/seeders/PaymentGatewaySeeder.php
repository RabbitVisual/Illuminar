<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        $gateways = [
            [
                'name' => 'Mercado Pago (Sandbox)',
                'provider' => PaymentGateway::PROVIDER_MERCADOPAGO,
                'credentials' => [
                    'public_key' => '',
                    'secret_key' => '',
                ],
                'environment' => PaymentGateway::ENV_SANDBOX,
                'is_active' => false,
            ],
            [
                'name' => 'Mercado Pago (Produção)',
                'provider' => PaymentGateway::PROVIDER_MERCADOPAGO,
                'credentials' => [
                    'public_key' => '',
                    'secret_key' => '',
                ],
                'environment' => PaymentGateway::ENV_PRODUCTION,
                'is_active' => false,
            ],
            [
                'name' => 'Pagarme (Sandbox)',
                'provider' => PaymentGateway::PROVIDER_PAGARME,
                'credentials' => [
                    'public_key' => '',
                    'secret_key' => '',
                ],
                'environment' => PaymentGateway::ENV_SANDBOX,
                'is_active' => false,
            ],
            [
                'name' => 'Stripe (Sandbox)',
                'provider' => PaymentGateway::PROVIDER_STRIPE,
                'credentials' => [
                    'public_key' => '',
                    'secret_key' => '',
                ],
                'environment' => PaymentGateway::ENV_SANDBOX,
                'is_active' => false,
            ],
        ];

        foreach ($gateways as $data) {
            PaymentGateway::firstOrCreate(
                ['provider' => $data['provider'], 'environment' => $data['environment']],
                $data
            );
        }
    }
}
