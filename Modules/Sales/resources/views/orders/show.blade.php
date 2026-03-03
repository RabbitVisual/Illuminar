<x-core::layouts.master heading="Pedido {{ $order->order_number }}">
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('sales.orders.index') }}" class="hover:text-primary transition-colors">Pedidos</a>
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

            {{-- Dados do cliente --}}
            <div class="px-6 py-4 border-b border-border dark:border-border">
                <h2 class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-2">Cliente</h2>
                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->customer?->full_name ?? 'Consumidor Final' }}</p>
                @if ($order->customer)
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->customer->email }}</p>
                @endif
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
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">{{ $item->product->sku }}</span>
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
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="text-right sm:text-left">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">Total: {{ $order->total_formatted }}</p>
                        @if ($order->payment_method)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Pagamento: {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                            </p>
                        @endif
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1 sm:text-right">
                        @if ($order->payment_status)
                            <p>
                                Status do pagamento:
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                </span>
                            </p>
                        @endif
                        @if ($order->paymentGateway)
                            <p>
                                Gateway:
                                <span class="font-medium text-gray-900 dark:text-white">
                                    {{ $order->paymentGateway->provider_label }} ({{ $order->paymentGateway->environment_label }})
                                </span>
                            </p>
                        @endif
                        @if ($order->payments->isNotEmpty())
                            @php
                                $latestPayment = $order->payments->sortByDesc('created_at')->first();
                            @endphp
                            @if ($latestPayment && $latestPayment->external_id)
                                <p class="break-all">
                                    ID externo: <span class="font-mono text-xs">{{ $latestPayment->external_id }}</span>
                                </p>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Alterar status --}}
        @if ($order->status !== 'canceled')
            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4">Alterar status</h3>
                <form action="{{ route('sales.orders.update-status', $order) }}"
                      method="POST"
                      x-data="{ loading: false }"
                      x-on:submit="loading = true; window.dispatchEvent(new CustomEvent('start-loading'))">
                    @csrf
                    <div class="flex flex-wrap items-end gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Novo status</label>
                            <select id="status"
                                    name="status"
                                    required
                                    class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendente</option>
                                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Pago</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Enviado</option>
                                <option value="canceled" {{ $order->status === 'canceled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 font-medium text-white hover:opacity-90 transition-opacity">
                            <x-icon name="check" style="solid" class="w-4 h-4" />
                            Atualizar status
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <div class="print:hidden">
            <a href="{{ route('sales.orders.index') }}"
               class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                Voltar aos pedidos
            </a>
        </div>
    </div>
</x-core::layouts.master>
