<x-core::layouts.master heading="Pedido {{ $order->order_number }}">
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('customer.orders.index') }}" class="hover:text-primary transition-colors">Meus Pedidos</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">{{ $order->order_number }}</span>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success dark:bg-success/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface shadow-sm overflow-hidden" id="order-receipt">
            {{-- Cabeçalho estilo fatura --}}
            <div class="border-b border-border dark:border-border px-6 py-6 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Pedido {{ $order->order_number }}</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $order->created_at->format('d/m/Y \à\s H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="inline-flex rounded-full px-3 py-1 text-sm font-medium
                            @if ($order->status === 'paid') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                            @elseif ($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                            @elseif ($order->status === 'canceled') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                            @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                            @endif">
                            {{ $order->status_label }}
                        </span>
                        <span class="inline-flex rounded-full px-3 py-1 text-sm font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                            {{ $order->origin_label }}
                        </span>
                        <button type="button"
                                onclick="window.print()"
                                class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors print:hidden">
                            <x-icon name="print" style="solid" class="w-4 h-4" />
                            Imprimir
                        </button>
                    </div>
                </div>
            </div>

            {{-- Itens do pedido --}}
            <div class="px-6 py-4">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-4">Itens</h2>
                <table class="min-w-full divide-y divide-border dark:divide-border">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-400">Produto</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-400">Qtd</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-400">Preço unit.</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-400">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border dark:divide-border">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $item->product?->name ?? 'Produto removido' }}</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">{{ $item->product?->sku ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-3 text-right text-sm text-gray-600 dark:text-gray-400">{{ $item->quantity }}</td>
                                <td class="px-4 py-3 text-right text-sm text-gray-600 dark:text-gray-400">{{ $item->unit_price_formatted }}</td>
                                <td class="px-4 py-3 text-right text-sm font-medium text-gray-900 dark:text-white">{{ $item->subtotal_formatted }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total --}}
            <div class="px-6 py-4 border-t border-border dark:border-border bg-gray-50 dark:bg-gray-800/50">
                <div class="flex justify-end">
                    <div class="text-right">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">Total: {{ $order->total_formatted }}</p>
                        @if ($order->payment_method)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Pagamento: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="print:hidden">
            <a href="{{ route('customer.orders.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                Voltar aos pedidos
            </a>
        </div>
    </div>
</x-core::layouts.master>
