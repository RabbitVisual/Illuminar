<x-mail::message>
# {{ $title }}

{{ $messageBody }}

<x-mail::panel>
**Pedido:** {{ $order->order_number }}
**Total:** {{ \Modules\Core\Helpers\UtilsHelper::formatMoneyToDisplay($order->total_amount / 100) }}
</x-mail::panel>

<x-mail::button :url="route('customer.orders.show', $order->order_number)">
Acompanhar Pedido
</x-mail::button>

Obrigado por iluminar seus ambientes conosco,<br>
Equipe {{ config('app.name', 'Illuminar') }}
</x-mail::message>
