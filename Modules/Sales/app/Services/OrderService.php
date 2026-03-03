<?php

namespace Modules\Sales\Services;

use Illuminate\Support\Facades\DB;
use Modules\Catalog\Models\Product;
use Modules\Inventory\Models\InventoryTransaction;
use Modules\Sales\Models\Order;
use Modules\Sales\Models\OrderItem;

class OrderService
{
    public function createOrder(array $data, array $items): Order
    {
        return DB::transaction(function () use ($data, $items) {
            $orderNumber = $this->generateOrderNumber();
            $totalAmount = 0;
            $orderItems = [];

            foreach ($items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $quantity = (int) $item['quantity'];
                $unitPrice = $product->price;

                if ($product->stock < $quantity) {
                    throw new \InvalidArgumentException("Estoque insuficiente para o produto {$product->name}. Disponível: {$product->stock}");
                }

                $subtotal = $unitPrice * $quantity;
                $totalAmount += $subtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ];
            }

            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $data['user_id'] ?? auth()->id(),
                'customer_id' => $data['customer_id'] ?? null,
                'status' => $data['status'] ?? Order::STATUS_PENDING,
                'total_amount' => $totalAmount,
                'payment_method' => $data['payment_method'] ?? null,
                'origin' => $data['origin'] ?? Order::ORIGIN_POS,
            ]);

            foreach ($orderItems as $itemData) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product_id'],
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'subtotal' => $itemData['subtotal'],
                ]);

                InventoryTransaction::create([
                    'product_id' => $orderItem->product_id,
                    'supplier_id' => null,
                    'user_id' => auth()->id() ?? $order->user_id ?? 1,
                    'type' => InventoryTransaction::TYPE_OUT,
                    'quantity' => $orderItem->quantity,
                    'unit_cost' => 0,
                    'description' => "Venda - Pedido {$order->order_number}",
                ]);
            }

            return $order->fresh(['items', 'items.product']);
        });
    }

    protected function generateOrderNumber(): string
    {
        $prefix = 'PED-' . now()->format('Ym') . '-';
        $lastOrder = Order::where('order_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $sequence = 1;
        if ($lastOrder) {
            $parts = explode('-', $lastOrder->order_number);
            $sequence = (int) end($parts) + 1;
        }

        return $prefix . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
