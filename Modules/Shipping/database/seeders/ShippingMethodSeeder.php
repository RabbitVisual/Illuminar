<?php

namespace Modules\Shipping\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Shipping\Models\ShippingMethod;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Correios SEDEX',
                'type' => ShippingMethod::TYPE_CORREIOS,
                'base_price' => 1990, // R$ 19,90 em centavos
                'delivery_time_days' => 5,
                'is_active' => true,
                'coverage_type' => ShippingMethod::COVERAGE_NATIONAL,
                'coverage_data' => null,
            ],
            [
                'name' => 'Correios PAC',
                'type' => ShippingMethod::TYPE_CORREIOS,
                'base_price' => 1290, // R$ 12,90 em centavos
                'delivery_time_days' => 8,
                'is_active' => true,
                'coverage_type' => ShippingMethod::COVERAGE_NATIONAL,
                'coverage_data' => null,
            ],
            [
                'name' => 'Motoboy Local',
                'type' => ShippingMethod::TYPE_MOTOBOY,
                'base_price' => 1500, // R$ 15,00 em centavos
                'delivery_time_days' => 1,
                'is_active' => true,
                'coverage_type' => ShippingMethod::COVERAGE_CITIES,
                'coverage_data' => ['Salvador', 'Feira de Santana', 'Lauro de Freitas', 'Camaçari'],
            ],
        ];

        foreach ($methods as $data) {
            ShippingMethod::firstOrCreate(
                ['name' => $data['name'], 'type' => $data['type']],
                $data
            );
        }
    }
}
