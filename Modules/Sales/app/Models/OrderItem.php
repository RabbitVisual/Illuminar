<?php

namespace Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Catalog\Models\Product;
use Modules\Core\Helpers\UtilsHelper;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getUnitPriceFormattedAttribute(): string
    {
        return UtilsHelper::formatMoneyToDisplay($this->unit_price / 100);
    }

    public function getSubtotalFormattedAttribute(): string
    {
        return UtilsHelper::formatMoneyToDisplay($this->subtotal / 100);
    }
}
