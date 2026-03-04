<x-core::layouts.master heading="Produtos">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white">Listagem de produtos</h2>
            <a href="{{ route('catalog.products.create') }}"
               class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                <x-icon name="plus" style="solid" class="w-4 h-4" />
                Novo produto
            </a>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                {{ session('success') }}
            </div>
        @endif

        @php
            $hasFilters = request()->hasAny(['search', 'category_id', 'brand_id', 'color_temperature_k']) && (request('search') || request('category_id') || request('brand_id') || request('color_temperature_k'));
        @endphp
        <div x-data="{ searchOpen: {{ $hasFilters ? 'true' : 'false' }} }" class="space-y-4">
            <div class="flex items-center gap-2">
                <button type="button"
                        @click="searchOpen = !searchOpen"
                        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600">
                    <x-icon name="magnifying-glass" style="solid" class="w-4 h-4" />
                    <span x-text="searchOpen ? 'Ocultar busca' : 'Busca avançada'">Busca avançada</span>
                    <x-icon name="chevron-down" style="solid" class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': searchOpen }" />
                </button>
            </div>

            <form x-show="searchOpen"
                  x-cloak
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 -translate-y-2"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-150"
                  x-transition:leave-start="opacity-100 translate-y-0"
                  x-transition:leave-end="opacity-0 -translate-y-2"
                  action="{{ route('catalog.products.index') }}"
                  method="GET"
                  class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Busca (Nome/SKU/Código)</label>
                        <input type="text"
                               id="search"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Digite para buscar..."
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categoria</label>
                        <select id="category_id"
                                name="category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Todas</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Marca</label>
                        <select id="brand_id"
                                name="brand_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Todas</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="color_temperature_k" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                            Temperatura de cor (K)
                            <span data-tooltip-target="tooltip-temp" class="cursor-help">
                                <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                            </span>
                        </label>
                        <div id="tooltip-temp" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Digite 3000K para luz quente, 4000K neutra ou 6000K para luz fria.
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <select id="color_temperature_k"
                                name="color_temperature_k"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">Todas</option>
                            @foreach ($colorTemperatures as $temp)
                                <option value="{{ $temp }}" {{ request('color_temperature_k') == $temp ? 'selected' : '' }}>{{ $temp }}K</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex gap-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <x-icon name="magnifying-glass" style="solid" class="w-4 h-4" />
                        Filtrar
                    </button>
                    <a href="{{ route('catalog.products.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                        Limpar
                    </a>
                </div>
            </form>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Produto</th>
                        <th scope="col" class="px-4 py-3">SKU</th>
                        <th scope="col" class="px-4 py-3">Categoria</th>
                        <th scope="col" class="px-4 py-3">Preço</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $product->name }}</div>
                                    @if ($product->brand)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $product->brand->name }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $product->sku }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $product->category?->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $product->price_formatted }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('catalog.products.edit', $product) }}"
                                           class="rounded-lg p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                           aria-label="Editar">
                                            <x-icon name="pen" style="solid" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('catalog.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente excluir este produto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-lg p-2 text-danger hover:bg-danger/10 transition-colors"
                                                    aria-label="Excluir">
                                                <x-icon name="trash" style="solid" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Nenhum produto cadastrado.
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
            @if ($products->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
