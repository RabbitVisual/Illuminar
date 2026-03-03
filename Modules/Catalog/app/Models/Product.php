<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Helpers\UtilsHelper;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'description',
        'price',
        'cost_price',
        'stock',
        'brand_id',
        'category_id',
        'is_active',
        'voltage',
        'power_watts',
        'color_temperature_k',
        'lumens',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'power_watts' => 'decimal:2',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(\Modules\Inventory\Models\InventoryTransaction::class);
    }

    public function getPriceFormattedAttribute(): string
    {
        return UtilsHelper::formatMoneyToDisplay($this->price / 100);
    }

    public function getCostPriceFormattedAttribute(): string
    {
        return UtilsHelper::formatMoneyToDisplay($this->cost_price / 100);
    }
}
