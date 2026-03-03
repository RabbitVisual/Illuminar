<x-core::layouts.master heading="Entregas e Rastreamento">
    <div class="max-w-6xl space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('shipping.methods.index') }}" class="hover:text-primary transition-colors">Métodos de Entrega</a>
                <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Entregas</span>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 px-4 py-3 text-sm text-green-700 dark:text-green-300 flex items-center gap-2">
                <x-icon name="circle-check" style="solid" class="w-5 h-5 shrink-0" />
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('shipping.admin.shipments.index') }}" class="flex flex-wrap gap-4">
            <input type="text" name="tracking" value="{{ request('tracking') }}" placeholder="Código de rastreio"
                   class="rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-sm text-gray-900 dark:text-gray-100 w-48">
            <select name="status" class="rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-sm text-gray-900 dark:text-gray-100">
                <option value="">Todos os status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
                <option value="dispatched" {{ request('status') === 'dispatched' ? 'selected' : '' }}>Enviado</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Entregue</option>
            </select>
            <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:opacity-90">Filtrar</button>
        </form>

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Pedido</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Método</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Valor Frete</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Rastreio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($shipments as $shipment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="px-4 py-3">
                                    <a href="{{ route('sales.orders.show', $shipment->order) }}" class="font-medium text-primary hover:underline">
                                        {{ $shipment->order->order_number ?? '#' . $shipment->order_id }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ optional($shipment->order->customer)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ optional($shipment->shippingMethod)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $shipment->shipping_amount_formatted }}
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400 font-mono text-sm">
                                    {{ $shipment->tracking_code ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($shipment->status === 'pending')
                                        <span class="rounded-full bg-amber-100 dark:bg-amber-900/30 px-2 py-0.5 text-xs font-medium text-amber-700 dark:text-amber-300">Pendente</span>
                                    @elseif ($shipment->status === 'dispatched')
                                        <span class="rounded-full bg-blue-100 dark:bg-blue-900/30 px-2 py-0.5 text-xs font-medium text-blue-700 dark:text-blue-300">Enviado</span>
                                    @else
                                        <span class="rounded-full bg-green-100 dark:bg-green-900/30 px-2 py-0.5 text-xs font-medium text-green-700 dark:text-green-300">Entregue</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('shipping.admin.shipments.edit', $shipment) }}"
                                       class="text-primary hover:underline text-sm">
                                        Informar Rastreio
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                    Nenhuma entrega registrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($shipments->hasPages())
                <div class="px-4 py-3 border-t border-border dark:border-border">
                    {{ $shipments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
