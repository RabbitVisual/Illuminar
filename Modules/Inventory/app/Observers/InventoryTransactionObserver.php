<?php

namespace Modules\Inventory\Observers;

use Modules\Catalog\Models\Product;
use Modules\Inventory\Models\InventoryTransaction;

class InventoryTransactionObserver
{
    public function created(InventoryTransaction $transaction): void
    {
        $product = Product::find($transaction->product_id);

        if (! $product) {
            return;
        }

        $currentStock = (int) $product->stock;

        if ($transaction->isIn()) {
            $product->update(['stock' => $currentStock + $transaction->quantity]);
        } else {
            $newStock = max(0, $currentStock - $transaction->quantity);
            $product->update(['stock' => $newStock]);
        }
    }
}
