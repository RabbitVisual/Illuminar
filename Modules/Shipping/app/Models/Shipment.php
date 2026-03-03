<?php

namespace Modules\Shipping\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Sales\Models\Order;

class Shipment extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_DISPATCHED = 'dispatched';

    public const STATUS_DELIVERED = 'delivered';

    protected $fillable = [
        'order_id',
        'shipping_method_id',
        'tracking_code',
        'status',
        'shipped_at',
        'shipping_amount',
    ];

    protected $casts = [
        'shipped_at' => 'datetime',
        'shipping_amount' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pendente',
            self::STATUS_DISPATCHED => 'Enviado',
            self::STATUS_DELIVERED => 'Entregue',
            default => $this->status,
        };
    }

    public function getShippingAmountFormattedAttribute(): string
    {
        return UtilsHelper::formatMoneyToDisplay($this->shipping_amount / 100);
    }
}
