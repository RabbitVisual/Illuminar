<x-core::layouts.master heading="Métodos de Entrega">
    <div class="max-w-5xl space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ Route::has('admin.index') ? route('admin.index') : url('/core') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Métodos de Entrega</span>
            </div>
            <a href="{{ route('shipping.methods.create') }}"
               class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                <x-icon name="plus" style="solid" class="w-4 h-4" />
                Novo Método
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 px-4 py-3 text-sm text-green-700 dark:text-green-300 flex items-center gap-2">
                <x-icon name="circle-check" style="solid" class="w-5 h-5 shrink-0" />
                {{ session('success') }}
            </div>
        @endif

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Nome</th>
                        <th scope="col" class="px-4 py-3">Tipo</th>
                        <th scope="col" class="px-4 py-3">Preço Base</th>
                        <th scope="col" class="px-4 py-3">Prazo (dias)</th>
                        <th scope="col" class="px-4 py-3">Cobertura</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($methods as $method)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $method->name }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $method->type_label }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $method->base_price_formatted }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $method->delivery_time_days }}</td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $method->coverage_type_label }}</td>
                                <td class="px-4 py-3">
                                    @if ($method->is_active)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 dark:bg-green-900/30 px-2 py-0.5 text-xs font-medium text-green-700 dark:text-green-300">Ativo</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-700 px-2 py-0.5 text-xs font-medium text-gray-600 dark:text-gray-400">Inativo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('shipping.methods.edit', $method) }}"
                                       class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">Editar</a>
                                    <form method="POST" action="{{ route('shipping.methods.destroy', $method) }}" class="inline ml-2"
                                          onsubmit="return confirm('Remover este método de entrega?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline dark:text-red-400 text-sm">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum método de entrega cadastrado. <a href="{{ route('shipping.methods.create') }}" class="text-primary hover:underline">Criar o primeiro</a>.
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
            @if ($methods->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $methods->links() }}
                </div>
            @endif
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('shipping.admin.shipments.index') }}"
               class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">
                <x-icon name="truck-fast" style="duotone" class="w-4 h-4" />
                Ver Entregas e Rastreamento
            </a>
        </div>
    </div>
</x-core::layouts.master>
