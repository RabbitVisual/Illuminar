<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Sales\Models\Order;

class Payment extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const STATUS_CANCELED = 'canceled';

    protected $fillable = [
        'order_id',
        'payment_gateway_id',
        'external_id',
        'status',
        'amount',
        'payment_method',
        'metadata',
        'paid_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class, 'payment_gateway_id');
    }

    public function markAsPaid(?\DateTimeInterface $when = null): void
    {
        $this->status = self::STATUS_PAID;
        $this->paid_at = $when ?? now();
        $this->save();
    }

    public function markAsFailed(string $status = self::STATUS_FAILED): void
    {
        $this->status = $status;
        $this->save();
    }
}

