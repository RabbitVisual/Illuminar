<?php

namespace Modules\Sales\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Helpers\UtilsHelper;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_CANCELED = 'canceled';

    public const STATUS_SHIPPED = 'shipped';

    public const ORIGIN_POS = 'pos';

    public const ORIGIN_STOREFRONT = 'storefront';

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_id',
        'status',
        'total_amount',
        'payment_method',
        'origin',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalFormattedAttribute(): string
    {
        return UtilsHelper::formatMoneyToDisplay($this->total_amount / 100);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PAID => 'Pago',
            self::STATUS_PENDING => 'Pendente',
            self::STATUS_CANCELED => 'Cancelado',
            self::STATUS_SHIPPED => 'Enviado',
            default => $this->status,
        };
    }

    public function getOriginLabelAttribute(): string
    {
        return match ($this->origin) {
            self::ORIGIN_POS => 'Balcão',
            self::ORIGIN_STOREFRONT => 'Site',
            default => $this->origin,
        };
    }
}
