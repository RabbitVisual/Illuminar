<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    public const MAILABLE_PAYMENT_APPROVED = 'payment_approved';

    public const MAILABLE_ORDER_SHIPPED = 'order_shipped';

    protected $fillable = [
        'mailable_class',
        'subject',
        'body',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Variáveis mágicas disponíveis para substituição nos templates.
     */
    public static function availablePlaceholders(): array
    {
        return [
            'customer_name' => 'Nome do cliente',
            'order_number' => 'Número do pedido',
            'order_total' => 'Total do pedido (formatado)',
            'tracking_code' => 'Código de rastreio',
            'shipping_method' => 'Método de entrega',
        ];
    }
}
