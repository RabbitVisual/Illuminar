<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    public const PROVIDER_MERCADOPAGO = 'mercadopago';

    public const PROVIDER_PAGARME = 'pagarme';

    public const PROVIDER_STRIPE = 'stripe';

    public const ENV_SANDBOX = 'sandbox';

    public const ENV_PRODUCTION = 'production';

    protected $fillable = [
        'name',
        'provider',
        'credentials',
        'environment',
        'is_active',
    ];

    protected $casts = [
        'credentials' => 'encrypted:array',
        'is_active' => 'boolean',
    ];

    public static function supportedPaymentMethods(): array
    {
        return [
            'pix',
            'credit_card',
            'debit_card',
            'boleto',
        ];
    }

    public static function defaultSupportedMethodsFor(string $provider): array
    {
        return match ($provider) {
            self::PROVIDER_MERCADOPAGO => ['pix', 'credit_card', 'boleto'],
            self::PROVIDER_PAGARME => ['pix', 'credit_card', 'debit_card', 'boleto'],
            self::PROVIDER_STRIPE => ['pix', 'credit_card', 'boleto'],
            default => self::supportedPaymentMethods(),
        };
    }

    public function getProviderLabelAttribute(): string
    {
        return match ($this->provider) {
            self::PROVIDER_MERCADOPAGO => 'Mercado Pago',
            self::PROVIDER_PAGARME => 'Pagarme',
            self::PROVIDER_STRIPE => 'Stripe',
            default => ucfirst($this->provider),
        };
    }

    public function getEnvironmentLabelAttribute(): string
    {
        return $this->environment === self::ENV_PRODUCTION ? 'Produção' : 'Sandbox';
    }

    public static function providers(): array
    {
        return [
            self::PROVIDER_MERCADOPAGO => 'Mercado Pago',
            self::PROVIDER_PAGARME => 'Pagarme',
            self::PROVIDER_STRIPE => 'Stripe',
        ];
    }
}
