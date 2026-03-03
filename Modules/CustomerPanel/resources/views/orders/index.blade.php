<x-core::layouts.master heading="Meus Pedidos">
    <div class="space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('customer.index') }}" class="hover:text-primary transition-colors">Meu Painel</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Meus Pedidos</span>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success dark:bg-success/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-border dark:border-border bg-white dark:bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border dark:divide-border">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Número</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Data</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Total</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Status</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border dark:divide-border bg-white dark:bg-surface">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $order->order_number }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $order->total_formatted }}</td>
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
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('customer.orders.show', $order->order_number) }}"
                                       class="inline-flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                        <x-icon name="eye" style="solid" class="w-4 h-4" />
                                        Ver Detalhes
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Nenhum pedido encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($orders->hasPages())
                <div class="border-t border-border dark:border-border px-4 py-3">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
