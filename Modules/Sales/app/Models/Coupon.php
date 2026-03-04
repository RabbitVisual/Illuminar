<?php

namespace Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_total',
        'valid_from',
        'valid_until',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'bool',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
    ];

    public const TYPE_FIXED = 'fixed';

    public const TYPE_PERCENT = 'percent';
}

