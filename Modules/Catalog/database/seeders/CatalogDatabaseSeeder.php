<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Catalog\Models\Brand;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Product;

class CatalogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Catálogo de iluminação completo para testes.
     */
    public function run(): void
    {
        // Marcas
        $brandsData = [
            'illuminar' => 'Illuminar Pro',
            'neoled' => 'NeoLED',
            'citylight' => 'CityLight',
            'brillux' => 'Brillux',
            'romalux' => 'Romalux',
            'tecno' => 'TecnoLite',
            'ecolux' => 'EcoLumix',
            'prime' => 'PrimeLux',
        ];

        $brands = [];
        foreach ($brandsData as $slug => $name) {
            $brands[$slug] = Brand::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'slug' => $slug,
                    'logo' => null,
                    'is_active' => true,
                ]
            );
        }

        // Categorias sob "Iluminação"
        $rootCategory = Category::firstOrCreate(
            ['slug' => 'iluminacao'],
            [
                'name' => 'Iluminação',
                'slug' => 'iluminacao',
                'parent_id' => null,
                'is_active' => true,
            ]
        );

        $categoriesData = [
            'luminarias-pendentes' => 'Luminárias Pendentes',
            'arandelas' => 'Arandelas',
            'spots-embutir' => 'Spots de Embutir',
            'spots-sobrepor' => 'Spots de Sobrepor',
            'plafons-led' => 'Plafons LED',
            'fitas-led' => 'Fitas de LED',
            'iluminacao-emergencia' => 'Iluminação de Emergência',
            'iluminacao-industrial' => 'Iluminação Industrial',
            'iluminacao-publica' => 'Iluminação Pública',
            'acessorios-iluminacao' => 'Acessórios para Iluminação',
        ];

        $categories = [];
        foreach ($categoriesData as $slug => $name) {
            $categories[$slug] = Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $name,
                    'slug' => $slug,
                    'parent_id' => $rootCategory->id,
                    'is_active' => true,
                ]
            );
        }

        // Produtos (valores em centavos)
        $productsData = [
            // Luminárias Pendentes
            [
                'name' => 'Pendente Orion Preto 1xE27',
                'sku' => 'PEN-ORION-PT-1E27',
                'brand_slug' => 'illuminar',
                'category_slug' => 'luminarias-pendentes',
                'price' => 45990,
                'voltage' => 'Bivolt',
                'power_watts' => 0,
                'description' => 'Pendente metálico preto para uma lâmpada E27. Ideal para bancadas e salas de jantar.',
            ],
            [
                'name' => 'Pendente Orion Branco 3xE27',
                'sku' => 'PEN-ORION-BR-3E27',
                'brand_slug' => 'illuminar',
                'category_slug' => 'luminarias-pendentes',
                'price' => 68990,
                'voltage' => 'Bivolt',
                'power_watts' => 0,
                'description' => 'Pendente triplo branco com soquetes E27 para lâmpadas LED até 15W cada.',
            ],
            [
                'name' => 'Pendente Tube Linear 20W 4000K',
                'sku' => 'PEN-TUBE-20W-4K',
                'brand_slug' => 'neoled',
                'category_slug' => 'luminarias-pendentes',
                'price' => 32990,
                'voltage' => 'Bivolt',
                'power_watts' => 20.0,
                'color_temperature_k' => 4000,
                'lumens' => 1600,
                'description' => 'Pendente tubular linear LED 20W neutro para escritórios e bancadas.',
            ],

            // Arandelas
            [
                'name' => 'Arandela Cubo Duplo Up&Down 2xGU10 Preta',
                'sku' => 'ARA-CUBO-UPDOWN-PT',
                'brand_slug' => 'citylight',
                'category_slug' => 'arandelas',
                'price' => 14990,
                'voltage' => 'Bivolt',
                'power_watts' => 0,
                'description' => 'Arandela em alumínio para duas lâmpadas GU10, efeito de luz para cima e para baixo.',
            ],
            [
                'name' => 'Arandela LED Slim 8W 3000K Branca',
                'sku' => 'ARA-SLIM-8W-3K',
                'brand_slug' => 'brillux',
                'category_slug' => 'arandelas',
                'price' => 9990,
                'voltage' => 'Bivolt',
                'power_watts' => 8.0,
                'color_temperature_k' => 3000,
                'lumens' => 640,
                'description' => 'Arandela LED slim 8W luz quente, ideal para corredores e quartos.',
            ],

            // Spots de embutir
            [
                'name' => 'Spot LED Embutir 5W 3000K Redondo Branco',
                'sku' => 'SPT-EMB-5W-3K-RD-BR',
                'brand_slug' => 'neoled',
                'category_slug' => 'spots-embutir',
                'price' => 1890,
                'voltage' => 'Bivolt',
                'power_watts' => 5.0,
                'color_temperature_k' => 3000,
                'lumens' => 400,
                'description' => 'Spot LED de embutir redondo 5W luz quente com driver integrado.',
            ],
            [
                'name' => 'Spot LED Embutir 7W 4000K Quadrado Branco',
                'sku' => 'SPT-EMB-7W-4K-QD-BR',
                'brand_slug' => 'neoled',
                'category_slug' => 'spots-embutir',
                'price' => 2490,
                'voltage' => 'Bivolt',
                'power_watts' => 7.0,
                'color_temperature_k' => 4000,
                'lumens' => 560,
                'description' => 'Spot LED de embutir quadrado 7W luz neutra para salas e escritórios.',
            ],
            [
                'name' => 'Spot LED Embutir 10W 6500K Redondo Branco',
                'sku' => 'SPT-EMB-10W-65K-RD-BR',
                'brand_slug' => 'neoled',
                'category_slug' => 'spots-embutir',
                'price' => 2990,
                'voltage' => 'Bivolt',
                'power_watts' => 10.0,
                'color_temperature_k' => 6500,
                'lumens' => 800,
                'description' => 'Spot LED de embutir 10W luz branca fria indicado para cozinhas e áreas de serviço.',
            ],

            // Spots de sobrepor
            [
                'name' => 'Spot Sobrepor Cilíndrico GU10 Preto',
                'sku' => 'SPT-SOB-CIL-GU10-PT',
                'brand_slug' => 'citylight',
                'category_slug' => 'spots-sobrepor',
                'price' => 3990,
                'voltage' => 'Bivolt',
                'power_watts' => 0,
                'description' => 'Spot de sobrepor cilíndrico para lâmpada GU10, corpo em alumínio preto.',
            ],
            [
                'name' => 'Spot Sobrepor LED 12W 3000K Quadrado Branco',
                'sku' => 'SPT-SOB-12W-3K-QD-BR',
                'brand_slug' => 'illuminar',
                'category_slug' => 'spots-sobrepor',
                'price' => 4590,
                'voltage' => 'Bivolt',
                'power_watts' => 12.0,
                'color_temperature_k' => 3000,
                'lumens' => 960,
                'description' => 'Spot LED de sobrepor 12W luz quente, acabamento branco.',
            ],

            // Plafons LED
            [
                'name' => 'Plafon LED Slim 18W 4000K Quadrado Branco',
                'sku' => 'PLF-SLIM-18W-4K-QD-BR',
                'brand_slug' => 'brillux',
                'category_slug' => 'plafons-led',
                'price' => 3490,
                'voltage' => 'Bivolt',
                'power_watts' => 18.0,
                'color_temperature_k' => 4000,
                'lumens' => 1440,
                'description' => 'Plafon LED slim 18W luz neutra para salas, quartos e corredores.',
            ],
            [
                'name' => 'Plafon LED Slim 24W 6500K Redondo Branco',
                'sku' => 'PLF-SLIM-24W-65K-RD-BR',
                'brand_slug' => 'brillux',
                'category_slug' => 'plafons-led',
                'price' => 4290,
                'voltage' => 'Bivolt',
                'power_watts' => 24.0,
                'color_temperature_k' => 6500,
                'lumens' => 2000,
                'description' => 'Plafon LED slim 24W luz branca fria para cozinhas e áreas comerciais.',
            ],
            [
                'name' => 'Plafon LED sobrepor 32W 3000K Quadrado Branco',
                'sku' => 'PLF-32W-3K-QD-BR',
                'brand_slug' => 'illuminar',
                'category_slug' => 'plafons-led',
                'price' => 6890,
                'voltage' => 'Bivolt',
                'power_watts' => 32.0,
                'color_temperature_k' => 3000,
                'lumens' => 2600,
                'description' => 'Plafon LED 32W luz quente com alto fluxo para ambientes amplos.',
            ],

            // Fitas de LED
            [
                'name' => 'Fita LED 5m 4,8W/m 3000K IP20',
                'sku' => 'FTA-5M-4P8W-3K-IP20',
                'brand_slug' => 'ecolux',
                'category_slug' => 'fitas-led',
                'price' => 5990,
                'voltage' => '12V',
                'power_watts' => 24.0,
                'color_temperature_k' => 3000,
                'lumens' => 900,
                'description' => 'Fita LED 5 metros luz quente para uso interno, requer fonte 12V.',
            ],
            [
                'name' => 'Fita LED 5m 9,6W/m 4000K IP65',
                'sku' => 'FTA-5M-9P6W-4K-IP65',
                'brand_slug' => 'ecolux',
                'category_slug' => 'fitas-led',
                'price' => 8990,
                'voltage' => '12V',
                'power_watts' => 48.0,
                'color_temperature_k' => 4000,
                'lumens' => 1800,
                'description' => 'Fita LED neutra com proteção IP65 para áreas úmidas e externas cobertas.',
            ],
            [
                'name' => 'Fonte 12V 60W para Fita LED',
                'sku' => 'FNT-12V-60W',
                'brand_slug' => 'tecno',
                'category_slug' => 'acessorios-iluminacao',
                'price' => 5490,
                'voltage' => 'Bivolt',
                'power_watts' => 60.0,
                'description' => 'Fonte eletrônica 12V 60W para fitas LED até 12 metros (4,8W/m).',
            ],

            // Iluminação de emergência
            [
                'name' => 'Bloco de Emergência LED 200 Lumens Bivolt',
                'sku' => 'EMG-LED-200LM',
                'brand_slug' => 'tecno',
                'category_slug' => 'iluminacao-emergencia',
                'price' => 7990,
                'voltage' => 'Bivolt',
                'power_watts' => 3.0,
                'lumens' => 200,
                'description' => 'Bloco autônomo de emergência LED com autonomia de até 3 horas.',
            ],
            [
                'name' => 'Luz de Emergência LED 400 Lumens Bivolt',
                'sku' => 'EMG-LED-400LM',
                'brand_slug' => 'tecno',
                'category_slug' => 'iluminacao-emergencia',
                'price' => 11990,
                'voltage' => 'Bivolt',
                'power_watts' => 5.0,
                'lumens' => 400,
                'description' => 'Luz de emergência LED para ambientes comerciais com alta autonomia.',
            ],

            // Iluminação Industrial
            [
                'name' => 'High Bay LED 100W 5000K Industrial',
                'sku' => 'HBAY-100W-5K',
                'brand_slug' => 'romalux',
                'category_slug' => 'iluminacao-industrial',
                'price' => 45990,
                'voltage' => 'Bivolt',
                'power_watts' => 100.0,
                'color_temperature_k' => 5000,
                'lumens' => 10000,
                'description' => 'Luminária High Bay 100W para galpões e indústrias, corpo em alumínio.',
            ],
            [
                'name' => 'High Bay LED 150W 5000K Industrial',
                'sku' => 'HBAY-150W-5K',
                'brand_slug' => 'romalux',
                'category_slug' => 'iluminacao-industrial',
                'price' => 62990,
                'voltage' => 'Bivolt',
                'power_watts' => 150.0,
                'color_temperature_k' => 5000,
                'lumens' => 15000,
                'description' => 'High Bay LED 150W para pé-direito alto em centros de distribuição.',
            ],

            // Iluminação Pública
            [
                'name' => 'Luminária Pública LED 50W 5000K IP66',
                'sku' => 'STREET-50W-5K',
                'brand_slug' => 'citylight',
                'category_slug' => 'iluminacao-publica',
                'price' => 38990,
                'voltage' => 'Bivolt',
                'power_watts' => 50.0,
                'color_temperature_k' => 5000,
                'lumens' => 5500,
                'description' => 'Luminária LED pública 50W com lente assimétrica e proteção IP66.',
            ],
            [
                'name' => 'Luminária Pública LED 100W 5000K IP66',
                'sku' => 'STREET-100W-5K',
                'brand_slug' => 'citylight',
                'category_slug' => 'iluminacao-publica',
                'price' => 58990,
                'voltage' => 'Bivolt',
                'power_watts' => 100.0,
                'color_temperature_k' => 5000,
                'lumens' => 11000,
                'description' => 'Luminária LED pública 100W para vias arteriais e estacionamentos.',
            ],

            // Acessórios
            [
                'name' => 'Trilho Eletrificado 2m Preto',
                'sku' => 'TRILHO-2M-PT',
                'brand_slug' => 'prime',
                'category_slug' => 'acessorios-iluminacao',
                'price' => 7990,
                'voltage' => 'Bivolt',
                'power_watts' => 0,
                'description' => 'Trilho eletrificado de 2 metros na cor preta para spots de trilho.',
            ],
            [
                'name' => 'Trilho Eletrificado 2m Branco',
                'sku' => 'TRILHO-2M-BR',
                'brand_slug' => 'prime',
                'category_slug' => 'acessorios-iluminacao',
                'price' => 7990,
                'voltage' => 'Bivolt',
                'power_watts' => 0,
                'description' => 'Trilho eletrificado de 2 metros na cor branca.',
            ],
            [
                'name' => 'Conector L para Trilho Eletrificado Preto',
                'sku' => 'CON-TRILHO-L-PT',
                'brand_slug' => 'prime',
                'category_slug' => 'acessorios-iluminacao',
                'price' => 1990,
                'voltage' => 'Bivolt',
                'power_watts' => 0,
                'description' => 'Conector em L para interligação de trilhos eletrificados.',
            ],
        ];

        foreach ($productsData as $data) {
            $brand = $brands[$data['brand_slug']] ?? null;
            $category = $categories[$data['category_slug']] ?? null;

            if (! $brand || ! $category) {
                continue;
            }

            $name = $data['name'];
            $sku = $data['sku'];

            $price = (int) $data['price'];
            $cost = isset($data['cost_price'])
                ? (int) $data['cost_price']
                : (int) round($price * 0.7);

            Product::updateOrCreate(
                ['sku' => $sku],
                [
                    'name' => $name,
                    'slug' => Str::slug($name . '-' . $sku),
                    'sku' => $sku,
                    'barcode' => null,
                    'description' => $data['description'] ?? null,
                    'price' => $price,
                    'cost_price' => $cost,
                    'brand_id' => $brand->id,
                    'category_id' => $category->id,
                    'is_active' => true,
                    'voltage' => $data['voltage'] ?? null,
                    'power_watts' => $data['power_watts'] ?? null,
                    'color_temperature_k' => $data['color_temperature_k'] ?? null,
                    'lumens' => $data['lumens'] ?? null,
                ]
            );
        }
    }
}

