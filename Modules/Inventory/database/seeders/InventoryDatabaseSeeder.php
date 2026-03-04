<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Modules\Catalog\Models\Product;
use Modules\Inventory\Models\InventoryTransaction;
use Modules\Inventory\Models\Supplier;

class InventoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Se já existem movimentações, não recria o estoque demo para evitar duplicar quantidades.
        if (InventoryTransaction::query()->count() > 0) {
            return;
        }

        // Usuário responsável pelas movimentações (usa o primeiro usuário disponível como fallback).
        $userId = User::query()->orderBy('id')->value('id') ?? 1;

        // Fornecedor demo padrão.
        $supplier = Supplier::firstOrCreate(
            ['cnpj' => '00000000000000'],
            [
                'name' => 'Fornecedor Demo Iluminação',
                'email' => 'fornecedor-demo@illuminar.com',
                'phone' => '(11) 0000-0000',
                'address' => 'Rua Demo, 123 - Centro - São Paulo/SP',
                'is_active' => true,
            ]
        );

        // Cria estoque inicial para todos os produtos ativos do catálogo.
        $products = Product::query()
            ->where('is_active', true)
            ->get();

        foreach ($products as $product) {
            $quantity = random_int(15, 80);

            InventoryTransaction::create([
                'product_id' => $product->id,
                'supplier_id' => $supplier->id,
                'user_id' => $userId,
                'type' => InventoryTransaction::TYPE_IN,
                'quantity' => $quantity,
                'unit_cost' => $product->cost_price ?? 0,
                'description' => 'Estoque inicial demo',
            ]);
        }
    }
}
