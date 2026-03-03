<?php

namespace Modules\Shipping\Services;

use Modules\Shipping\Models\ShippingMethod;

class ShippingCalculatorService
{
    /**
     * Calculate available shipping rates for a given address and cart total.
     *
     * @param  string  $zipCode  CEP (pode ser com ou sem máscara)
     * @param  string  $city  Nome da cidade
     * @param  string  $state  UF (ex: BA, SP)
     * @param  int  $cartTotal  Valor total do carrinho em centavos
     * @return array Lista de opções com name, price (centavos), delivery_time_days
     */
    public function calculateRates(string $zipCode, string $city, string $state, int $cartTotal): array
    {
        $zipCode = preg_replace('/\D/', '', $zipCode);
        $city = $this->normalizeCityName($city);
        $state = strtoupper(trim($state));

        $methods = ShippingMethod::where('is_active', true)->get();
        $rates = [];

        foreach ($methods as $method) {
            if (! $this->isAvailableForAddress($method, $zipCode, $city, $state)) {
                continue;
            }

            $price = $this->calculateMethodPrice($method, $cartTotal);

            $rates[] = [
                'id' => $method->id,
                'name' => $method->name,
                'price' => $price,
                'price_formatted' => 'R$ ' . number_format($price / 100, 2, ',', '.'),
                'delivery_time_days' => $method->delivery_time_days,
                'type' => $method->type,
            ];
        }

        return $rates;
    }

    protected function isAvailableForAddress(ShippingMethod $method, string $zipCode, string $city, string $state): bool
    {
        return match ($method->coverage_type) {
            'national' => true,
            'state' => $this->isStateCovered($method, $state),
            'cities' => $this->isCityCovered($method, $city),
            'zip_codes' => $this->isZipCovered($method, $zipCode),
            default => false,
        };
    }

    protected function isStateCovered(ShippingMethod $method, string $state): bool
    {
        $data = $method->coverage_data ?? [];

        if (! is_array($data)) {
            return false;
        }

        $states = array_map(fn ($s) => strtoupper(trim($s)), $data);

        return in_array($state, $states);
    }

    protected function isCityCovered(ShippingMethod $method, string $city): bool
    {
        $data = $method->coverage_data ?? [];

        if (! is_array($data)) {
            return false;
        }

        $cities = array_map(fn ($c) => $this->normalizeCityName($c), $data);

        return in_array($city, $cities);
    }

    protected function isZipCovered(ShippingMethod $method, string $zipCode): bool
    {
        $data = $method->coverage_data ?? [];

        if (! is_array($data)) {
            return false;
        }

        $zipInt = (int) $zipCode;

        foreach ($data as $range) {
            $range = trim($range);
            if (str_contains($range, '-')) {
                [$start, $end] = array_map('intval', array_map('trim', explode('-', $range)));
                if ($zipInt >= $start && $zipInt <= $end) {
                    return true;
                }
            } else {
                $rangeClean = (int) preg_replace('/\D/', '', $range);
                if ($zipInt === $rangeClean) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function normalizeCityName(string $name): string
    {
        $name = trim($name);
        $name = mb_strtolower($name);
        $name = preg_replace('/\s+/', ' ', $name);

        return $name;
    }

    protected function calculateMethodPrice(ShippingMethod $method, int $cartTotal): int
    {
        return $method->base_price;
    }
}
