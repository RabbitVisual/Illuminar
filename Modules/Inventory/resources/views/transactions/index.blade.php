<x-core::layouts.master heading="Kardex - Histórico de estoque">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white">Relatório Kardex</h2>
            <a href="{{ route('inventory.transactions.create') }}"
               class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                <x-icon name="plus" style="solid" class="w-4 h-4" />
                Nova movimentação
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success dark:bg-success/20">
                {{ session('success') }}
            </div>
        @endif

        @php
            $hasFilters = request()->hasAny(['product_id', 'type', 'date_from', 'date_to']) && (request('product_id') || request('type') || request('date_from') || request('date_to'));
        @endphp
        <div x-data="{ filterOpen: {{ $hasFilters ? 'true' : 'false' }} }" class="space-y-4">
            <div class="flex items-center gap-2">
                <button type="button"
                        @click="filterOpen = !filterOpen"
                        class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    <x-icon name="filter" style="solid" class="w-4 h-4" />
                    <span x-text="filterOpen ? 'Ocultar filtros' : 'Filtros'">Filtros</span>
                    <x-icon name="chevron-down" style="solid" class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': filterOpen }" />
                </button>
            </div>

            <form x-show="filterOpen"
                  x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-y-2"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-y-0"
                  x-transition:leave-end="opacity-0 -translate-y-2"
                  action="{{ route('inventory.transactions.index') }}"
                  method="GET"
                  class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produto</label>
                        <select id="product_id"
                                name="product_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Todos</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }} ({{ $product->sku }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                        <select id="type"
                                name="type"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Todos</option>
                            <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>Entrada</option>
                            <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Saída</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data inicial</label>
                        <input type="date"
                               id="date_from"
                               name="date_from"
                               value="{{ request('date_from') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    </div>
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data final</label>
                        <input type="date"
                               id="date_to"
                               name="date_to"
                               value="{{ request('date_to') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    </div>
                </div>
                <div class="mt-4 flex flex-wrap gap-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <x-icon name="magnifying-glass" style="solid" class="w-4 h-4" />
                        Filtrar
                    </button>
                    <a href="{{ route('inventory.transactions.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Limpar
                    </a>
                    <button type="submit"
                            name="export"
                            value="csv"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                        <x-icon name="file-export" style="duotone" class="w-4 h-4" />
                        Exportar CSV
                    </button>
                </div>
            </form>
        </div>

        @isset($stats)
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Movimentações no período</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $stats['total_movements'] }}</p>
                </div>
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total de entradas</p>
                    <p class="mt-1 text-lg font-semibold text-green-600 dark:text-green-400">+{{ $stats['total_in'] }}</p>
                </div>
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Total de saídas</p>
                    <p class="mt-1 text-lg font-semibold text-red-600 dark:text-red-400">-{{ $stats['total_out'] }}</p>
                </div>
            </div>
        @endisset

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Data/Hora</th>
                        <th scope="col" class="px-4 py-3">Produto</th>
                        <th scope="col" class="px-4 py-3">Tipo</th>
                        <th scope="col" class="px-4 py-3">Quantidade</th>
                        <th scope="col" class="px-4 py-3">Responsável</th>
                        <th scope="col" class="px-4 py-3">Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $transaction)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->product->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $transaction->product->sku }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $transaction->isIn() ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                        {{ $transaction->isIn() ? 'Entrada' : 'Saída' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-medium {{ $transaction->isIn() ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    {{ $transaction->isIn() ? '+' : '-' }}{{ $transaction->quantity }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $transaction->user->full_name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $transaction->description ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Nenhuma movimentação registrada.
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
            @if ($transactions->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
