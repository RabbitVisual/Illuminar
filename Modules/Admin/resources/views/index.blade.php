<x-core::layouts.master heading="Dashboard">
    <div class="space-y-8">
        {{-- Top Cards (Flowbite) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                    <x-icon name="chart-pie" style="duotone" class="w-6 h-6" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        Faturamento do Mês
                        <span data-tooltip-target="tooltip-faturamento-mes" class="cursor-help">
                            <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                        </span>
                    </p>
                    <div id="tooltip-faturamento-mes" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Soma total das vendas pagas no mês atual.
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <p class="mt-1 font-display text-xl font-semibold text-gray-900 dark:text-white truncate">
                        {{ $monthlySalesFormatted }}
                    </p>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                    <x-icon name="coins" style="duotone" class="w-6 h-6" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        Faturamento Hoje
                        <span data-tooltip-target="tooltip-faturamento-hoje" class="cursor-help">
                            <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                        </span>
                    </p>
                    <div id="tooltip-faturamento-hoje" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Total de vendas realizadas hoje (status pago).
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <p class="mt-1 font-display text-xl font-semibold text-gray-900 dark:text-white truncate">
                        {{ $todaySalesFormatted }}
                    </p>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400">
                    <x-icon name="clock" style="duotone" class="w-6 h-6" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        Pedidos Pendentes
                        <span data-tooltip-target="tooltip-pendentes" class="cursor-help">
                            <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                        </span>
                    </p>
                    <div id="tooltip-pendentes" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Pedidos aguardando pagamento ou confirmação.
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <p class="mt-1 font-display text-xl font-semibold text-gray-900 dark:text-white">
                        {{ $pendingOrdersCount }}
                    </p>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                    <x-icon name="receipt" style="duotone" class="w-6 h-6" />
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        Pedidos Hoje
                        <span data-tooltip-target="tooltip-pedidos-hoje" class="cursor-help">
                            <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                        </span>
                    </p>
                    <div id="tooltip-pedidos-hoje" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Quantidade de pedidos criados hoje (qualquer status).
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <p class="mt-1 font-display text-xl font-semibold text-gray-900 dark:text-white">
                        {{ $todayOrdersCount }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Body: 2 columns --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            {{-- Últimos Pedidos --}}
            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                <div class="flex items-center justify-between gap-4 border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                    <h3 class="font-display text-lg font-semibold text-gray-900 dark:text-white">Últimos Pedidos</h3>
                    @if (Route::has('sales.orders.index'))
                        <a href="{{ route('sales.orders.index') }}"
                           class="inline-flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium text-primary-700 hover:bg-primary-100 dark:text-primary-300 dark:hover:bg-primary-900/30 transition-colors">
                            <x-icon name="arrow-right" style="solid" class="w-4 h-4" />
                            Ver todos
                        </a>
                    @endif
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Número</th>
                                <th scope="col" class="px-4 py-3">Status</th>
                                <th scope="col" class="px-4 py-3 text-right">Valor</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($recentOrders as $order)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
            <div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                <div class="flex items-center justify-between gap-4 border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                    <h3 class="font-display text-lg font-semibold text-gray-900 dark:text-white">Alerta de Estoque Baixo</h3>
                    @if (Route::has('inventory.transactions.create'))
                        <a href="{{ route('inventory.transactions.create') }}"
                           class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <x-icon name="plus" style="solid" class="w-4 h-4" />
                            Repor Estoque
                        </a>
                    @endif
                </div>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">Produto</th>
                                <th scope="col" class="px-4 py-3">SKU</th>
                                <th scope="col" class="px-4 py-3 text-right">Qtd</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @forelse ($lowStockProducts as $product)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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

        {{-- Ações rápidas e visão geral --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 lg:col-span-2">
                <h3 class="font-display text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="bolt" style="duotone" class="w-5 h-5" />
                    Ações rápidas
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-3">
                    @if (Route::has('pdv.index'))
                        <a href="{{ route('pdv.index') }}"
                           class="inline-flex items-center justify-between gap-3 rounded-lg border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="flex items-center gap-2">
                                <x-icon name="cash-register" style="duotone" class="w-5 h-5 text-primary-600 dark:text-primary-400" />
                                Nova venda (PDV)
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-4 h-4 text-gray-400" />
                        </a>
                    @endif

                    @if (Route::has('catalog.products.create'))
                        <a href="{{ route('catalog.products.create') }}"
                           class="inline-flex items-center justify-between gap-3 rounded-lg border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="flex items-center gap-2">
                                <x-icon name="box-open" style="duotone" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                                Cadastrar produto
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-4 h-4 text-gray-400" />
                        </a>
                    @endif

                    @if (Route::has('user.create'))
                        <a href="{{ route('user.create') }}"
                           class="inline-flex items-center justify-between gap-3 rounded-lg border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="flex items-center gap-2">
                                <x-icon name="user-plus" style="duotone" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                Novo usuário / colaborador
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-4 h-4 text-gray-400" />
                        </a>
                    @endif

                    @if (Route::has('shipping.methods.index'))
                        <a href="{{ route('shipping.methods.index') }}"
                           class="inline-flex items-center justify-between gap-3 rounded-lg border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="flex items-center gap-2">
                                <x-icon name="truck-fast" style="duotone" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                                Métodos de entrega
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-4 h-4 text-gray-400" />
                        </a>
                    @endif

                    @if (Route::has('payment.admin.gateways.index'))
                        <a href="{{ route('payment.admin.gateways.index') }}"
                           class="inline-flex items-center justify-between gap-3 rounded-lg border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="flex items-center gap-2">
                                <x-icon name="credit-card" style="duotone" class="w-5 h-5 text-fuchsia-600 dark:text-fuchsia-400" />
                                Gateways de pagamento
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-4 h-4 text-gray-400" />
                        </a>
                    @endif

                    @if (Route::has('admin.notification.templates.index'))
                        <a href="{{ route('admin.notification.templates.index') }}"
                           class="inline-flex items-center justify-between gap-3 rounded-lg border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-medium text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="flex items-center gap-2">
                                <x-icon name="envelope-open-text" style="duotone" class="w-5 h-5 text-cyan-600 dark:text-cyan-400" />
                                E-mails automáticos
                            </span>
                            <x-icon name="arrow-right" style="solid" class="w-4 h-4 text-gray-400" />
                        </a>
                    @endif
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <h3 class="font-display text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="gauge-high" style="duotone" class="w-5 h-5" />
                    Visão rápida
                </h3>
                <dl class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                    <div class="flex items-center justify-between">
                        <dt class="flex items-center gap-1.5">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                <x-icon name="calendar-days" style="duotone" class="w-3.5 h-3.5" />
                            </span>
                            Faturamento do mês
                        </dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $monthlySalesFormatted }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="flex items-center gap-1.5">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400">
                                <x-icon name="sun" style="duotone" class="w-3.5 h-3.5" />
                            </span>
                            Faturamento hoje
                        </dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $todaySalesFormatted }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="flex items-center gap-1.5">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-600 dark:text-yellow-400">
                                <x-icon name="clock" style="duotone" class="w-3.5 h-3.5" />
                            </span>
                            Pedidos pendentes
                        </dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $pendingOrdersCount }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="flex items-center gap-1.5">
                            <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                <x-icon name="receipt" style="duotone" class="w-3.5 h-3.5" />
                            </span>
                            Pedidos hoje
                        </dt>
                        <dd class="font-medium text-gray-900 dark:text-white">{{ $todayOrdersCount }}</dd>
                    </div>
                    <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 text-xs text-gray-500 dark:text-gray-400">
                        Dados resumidos com base nas vendas mais recentes. Para detalhes, acesse o módulo de Vendas.
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-core::layouts.master>
