<x-core::layouts.master heading="Dashboard">
    <div class="space-y-8">
        {{-- Top Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                    <x-icon name="chart-pie" style="duotone" class="w-6 h-6" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Faturamento do Mês</p>
                    <p class="mt-1 font-display text-xl font-semibold text-gray-900 dark:text-white truncate">
                        {{ $monthlySalesFormatted }}
                    </p>
                </div>
            </div>

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                    <x-icon name="coins" style="duotone" class="w-6 h-6" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Faturamento Hoje</p>
                    <p class="mt-1 font-display text-xl font-semibold text-gray-900 dark:text-white truncate">
                        {{ $todaySalesFormatted }}
                    </p>
                </div>
            </div>

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400">
                    <x-icon name="clock" style="duotone" class="w-6 h-6" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pedidos Pendentes</p>
                    <p class="mt-1 font-display text-xl font-semibold text-gray-900 dark:text-white">
                        {{ $pendingOrdersCount }}
                    </p>
                </div>
            </div>

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <x-icon name="receipt" style="duotone" class="w-6 h-6" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pedidos Hoje</p>
                    <p class="mt-1 font-display text-xl font-semibold text-gray-900 dark:text-white">
                        {{ $todayOrdersCount }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Body: 2 columns --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            {{-- Últimos Pedidos --}}
            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface shadow-sm overflow-hidden">
                <div class="flex items-center justify-between gap-4 border-b border-border dark:border-border px-4 py-2">
                    <h3 class="font-display text-lg font-semibold text-gray-900 dark:text-white">Últimos Pedidos</h3>
                    @if (Route::has('sales.orders.index'))
                        <a href="{{ route('sales.orders.index') }}"
                           class="inline-flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium text-primary hover:bg-primary/10 transition-colors">
                            <x-icon name="arrow-right" style="solid" class="w-4 h-4" />
                            Ver todos
                        </a>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border dark:divide-border">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Número</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Status</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Valor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border dark:divide-border bg-white dark:bg-surface">
                            @forelse ($recentOrders as $order)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-4 py-3">
                                        @if (Route::has('sales.orders.show'))
                                            <a href="{{ route('sales.orders.show', $order) }}"
                                               class="text-sm font-medium text-primary hover:underline">
                                                {{ $order->order_number }}
                                            </a>
                                        @else
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->order_number }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $statusBadge = match($order->status) {
                                                'paid' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                                'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                'canceled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                                'shipped' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                                default => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400',
                                            };
                                        @endphp
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $statusBadge }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $order->total_formatted }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Nenhum pedido encontrado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Alerta de Estoque Baixo --}}
            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface shadow-sm overflow-hidden">
                <div class="flex items-center justify-between gap-4 border-b border-border dark:border-border px-4 py-2">
                    <h3 class="font-display text-lg font-semibold text-gray-900 dark:text-white">Alerta de Estoque Baixo</h3>
                    @if (Route::has('inventory.transactions.create'))
                        <a href="{{ route('inventory.transactions.create') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-primary px-3 py-1.5 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                            <x-icon name="plus" style="solid" class="w-4 h-4" />
                            Repor Estoque
                        </a>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-border dark:divide-border">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Produto</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">SKU</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Qtd</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border dark:divide-border bg-white dark:bg-surface">
                            @forelse ($lowStockProducts as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $product->name }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $product->sku ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Nenhum produto com estoque baixo. Todos os itens estão com quantidade adequada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-core::layouts.master>
