<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Recibo - Pedido {{ $order->order_number }}</title>
    <style type="text/css">
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #333; margin: 0; padding: 15px; }
        .header { border-bottom: 2px solid #333; padding-bottom: 12px; margin-bottom: 16px; }
        .logo { font-size: 22px; font-weight: bold; letter-spacing: 2px; margin: 0 0 6px 0; }
        .company-info { font-size: 10px; color: #555; line-height: 1.5; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; font-size: 10px; }
        .text-right { text-align: right; }
        .section-title { font-size: 12px; font-weight: bold; margin: 14px 0 8px 0; }
        .totals { margin-top: 16px; }
        .totals table { width: 280px; margin-left: auto; border: 1px solid #ddd; }
        .totals td { border: none; border-bottom: 1px solid #eee; padding: 6px 10px; }
        .totals tr:last-child td { border-bottom: none; font-weight: bold; font-size: 13px; }
        .footer { margin-top: 24px; font-size: 9px; color: #888; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <p class="logo">ILLUMINAR</p>
        <p class="company-info">
            Materiais Elétricos e Iluminação<br>
            CNPJ: 00.000.000/0001-00<br>
            Rua Exemplo, 1000 – Bairro – Cidade/UF – CEP 00000-000
        </p>
    </div>

    <p class="section-title">Dados do pedido e cliente</p>
    <table>
        <tr>
            <th style="width:25%">Nº do pedido</th>
            <th style="width:25%">Data</th>
            <th style="width:50%">Cliente</th>
        </tr>
        <tr>
            <td>{{ $order->order_number }}</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $order->customer ? $order->customer->full_name : 'Consumidor Final' }}</td>
        </tr>
        @if($order->customer && $order->customer->email)
        <tr>
            <td colspan="3" style="font-size:10px;">E-mail: {{ $order->customer->email }}</td>
        </tr>
        @endif
    </table>

    <p class="section-title">Itens do pedido</p>
    <table>
        <thead>
            <tr>
                <th>Produto</th>
                <th class="text-right" style="width:70px">Qtd</th>
                <th class="text-right" style="width:100px">Preço unit.</th>
                <th class="text-right" style="width:100px">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    {{ $item->product ? $item->product->name : 'Produto' }}
                    @if($item->product && $item->product->sku)
                        <br><span style="font-size:9px;color:#666;">{{ $item->product->sku }}</span>
                    @endif
                </td>
                <td class="text-right">{{ $item->quantity }}</td>
                <td class="text-right">{{ \Modules\Core\Helpers\UtilsHelper::formatMoneyToDisplay($item->unit_price / 100) }}</td>
                <td class="text-right">{{ \Modules\Core\Helpers\UtilsHelper::formatMoneyToDisplay($item->subtotal / 100) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal</td>
                <td class="text-right">{{ \Modules\Core\Helpers\UtilsHelper::formatMoneyToDisplay($order->items->sum('subtotal') / 100) }}</td>
            </tr>
            <tr>
                <td>Frete</td>
                <td class="text-right">{{ \Modules\Core\Helpers\UtilsHelper::formatMoneyToDisplay(($order->shipping_amount ?? 0) / 100) }}</td>
            </tr>
            <tr>
                <td>Pagamento</td>
                <td class="text-right">{{ $order->payment_method ? ucfirst(str_replace('_', ' ', $order->payment_method)) : '-' }}</td>
            </tr>
            <tr>
                <td>Total final</td>
                <td class="text-right">{{ \Modules\Core\Helpers\UtilsHelper::formatMoneyToDisplay($order->total_amount / 100) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Documento gerado em {{ now()->format('d/m/Y H:i') }} – Illuminar © {{ date('Y') }}
    </div>
</body>
</html>
