<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cupom - {{ $order->order_number }}</title>
    <style type="text/css">
        body { font-family: "Courier New", Courier, monospace; font-size: 11px; color: #000; margin: 0; padding: 8px; width: 280px; }
        .center { text-align: center; }
        .line { border-bottom: 1px dashed #000; margin: 8px 0; }
        .item-line { margin: 4px 0; }
        .item-name { display: block; }
        .item-detail { font-size: 10px; }
        .total-line { margin-top: 8px; font-weight: bold; font-size: 12px; text-align: center; }
        .logo { font-size: 14px; font-weight: bold; letter-spacing: 1px; margin-bottom: 4px; }
        .date { font-size: 10px; margin-bottom: 6px; }
    </style>
</head>
<body>
    <div class="center">
        <p class="logo">ILLUMINAR</p>
        <p class="date">Pedido {{ $order->order_number }} – {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>
    <div class="line"></div>

    <div class="item-line">
        <span class="item-name">Item</span>
        <span class="item-detail" style="float:right">Qtd x Unit. – Subtotal</span>
    </div>
    <div class="line"></div>

    @foreach($order->items as $item)
    <div class="item-line">
        <span class="item-name">{{ $item->product ? $item->product->name : 'Produto' }}</span>
    </div>
    <div class="item-detail center">
        {{ $item->quantity }} x {{ \Modules\Core\Helpers\UtilsHelper::formatMoneyToDisplay($item->unit_price / 100) }} = {{ \Modules\Core\Helpers\UtilsHelper::formatMoneyToDisplay($item->subtotal / 100) }}
    </div>
    @endforeach

    <div class="line"></div>
    <div class="total-line">
        TOTAL: {{ \Modules\Core\Helpers\UtilsHelper::formatMoneyToDisplay($order->total_amount / 100) }}
    </div>
    <div class="line"></div>
    <div class="center" style="font-size:9px; margin-top:8px;">
        Cupom não fiscal – Illuminar
    </div>
</body>
</html>
