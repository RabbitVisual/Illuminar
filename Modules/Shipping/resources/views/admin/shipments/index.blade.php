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
                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-48 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                <option value="">Todos os status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
                <option value="dispatched" {{ request('status') === 'dispatched' ? 'selected' : '' }}>Enviado</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Entregue</option>
            </select>
            <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">Filtrar</button>
        </form>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Pedido</th>
                        <th scope="col" class="px-4 py-3">Cliente</th>
                        <th scope="col" class="px-4 py-3">Método</th>
                        <th scope="col" class="px-4 py-3">Valor Frete</th>
                        <th scope="col" class="px-4 py-3">Rastreio</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($shipments as $shipment)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
                                       class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">
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
            @if ($shipments->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $shipments->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
