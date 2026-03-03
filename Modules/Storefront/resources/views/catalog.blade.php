<x-storefront::layouts.public>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
        {{-- Cabeçalho / Hero do Catálogo --}}
        <section class="relative overflow-hidden rounded-2xl mb-10 border border-amber-500/20 dark:border-amber-400/30 bg-gradient-to-r from-amber-500/10 via-white to-amber-500/5 dark:from-amber-500/15 dark:via-gray-900 dark:to-amber-500/10">
            <div class="storefront-hero-glow absolute inset-0 pointer-events-none"></div>
            <div class="relative px-6 py-10 md:px-10 md:py-12 flex flex-col md:flex-row items-start md:items-center gap-8">
                <div class="flex-1 space-y-3">
                    <div class="inline-flex items-center gap-2 rounded-full bg-amber-500/20 dark:bg-amber-400/20 px-4 py-1.5 text-xs font-medium text-amber-700 dark:text-amber-300">
                        <x-icon name="sparkles" style="duotone" class="w-4 h-4" />
                        Catálogo Completo Illuminar
                    </div>
                    <h1 class="font-display text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                        Encontre o melhor em <span class="text-amber-600 dark:text-amber-400">iluminação</span> e materiais elétricos
                    </h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 max-w-2xl">
                        Explore todo o nosso portfólio com filtros por categoria e ordenação inteligente. Ideal para residências, comércios e projetos profissionais.
                    </p>
                </div>
                <div class="hidden md:flex items-center gap-4 pr-4">
                    <div class="relative">
                        <div class="h-16 w-16 rounded-2xl bg-amber-500/20 dark:bg-amber-400/20 flex items-center justify-center">
                            <x-icon name="lightbulb" style="duotone" class="w-8 h-8 text-amber-500" />
                        </div>
                    </div>
                    <div class="space-y-1 text-sm text-gray-700 dark:text-gray-300">
                        <p class="font-semibold">Resultados: {{ $products->total() }}</p>
                        @if($currentCategory)
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Categoria selecionada:
                                <span class="font-medium text-amber-600 dark:text-amber-400">{{ $categories->firstWhere('slug', $currentCategory)?->name ?? $currentCategory }}</span>
                            </p>
                        @else
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Mostrando todas as categorias disponíveis.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- Conteúdo principal: filtros + listagem --}}
        <section class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            {{-- Sidebar de Categorias --}}
            <aside class="lg:col-span-1 space-y-6">
                <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/70 p-5 shadow-sm">
                    <h2 class="font-display text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2 mb-4">
                        <x-icon name="sliders" style="duotone" class="w-4 h-4 text-amber-500" />
                        Filtros
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-xs font-semibold tracking-wide text-gray-500 dark:text-gray-400 uppercase mb-2">
                                Categoria
                            </h3>
                            <ul class="space-y-1.5 max-h-64 overflow-y-auto pr-1 text-sm">
                                <li>
                                    <a href="{{ route('storefront.catalog', array_filter(['sort' => $sort])) }}"
                                       class="flex items-center justify-between rounded-lg px-3 py-1.5
                                              {{ $currentCategory ? 'text-gray-600 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400' : 'bg-amber-500/10 dark:bg-amber-400/15 text-amber-700 dark:text-amber-300 font-medium' }}">
                                        <span>Todas</span>
                                        @if(!$currentCategory)
                                            <x-icon name="check" style="solid" class="w-3 h-3" />
                                        @endif
                                    </a>
                                </li>
                                @foreach ($categories as $category)
                                    @php
                                        $isActive = $currentCategory === $category->slug;
                                        $urlParams = ['category' => $category->slug, 'sort' => $sort];
                                    @endphp
                                    <li>
                                        <a href="{{ route('storefront.catalog', $urlParams) }}"
                                           class="flex items-center justify-between rounded-lg px-3 py-1.5
                                                  {{ $isActive
                                                      ? 'bg-amber-500/10 dark:bg-amber-400/15 text-amber-700 dark:text-amber-300 font-medium'
                                                      : 'text-gray-600 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-500/5 dark:hover:bg-amber-400/10' }}">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-xs text-gray-400 dark:text-gray-500">{{ $category->products_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Lista de Produtos --}}
            <div class="lg:col-span-3 space-y-5">
                {{-- Topo: ordenação + resumo --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Exibindo
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }}</span>
                            de
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $products->total() }}</span>
                            produto(s).
                        </p>
                    </div>
                    <form method="GET" class="flex items-center gap-2 text-sm">
                        @if($currentCategory)
                            <input type="hidden" name="category" value="{{ $currentCategory }}">
                        @endif
                        <label for="sort" class="text-gray-600 dark:text-gray-400">Ordenar por</label>
                        <select id="sort"
                                name="sort"
                                class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-1.5 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-amber-500"
                                onchange="this.form.submit()">
                            <option value="latest" @selected($sort === 'latest')>Mais recentes</option>
                            <option value="price_asc" @selected($sort === 'price_asc')>Menor preço</option>
                            <option value="price_desc" @selected($sort === 'price_desc')>Maior preço</option>
                            <option value="name_asc" @selected($sort === 'name_asc')>Nome A–Z</option>
                            <option value="name_desc" @selected($sort === 'name_desc')>Nome Z–A</option>
                        </select>
                    </form>
                </div>

                {{-- Grid de produtos --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @forelse ($products as $product)
                        <div class="group storefront-card-hover storefront-product-glow rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/60 overflow-hidden shadow-sm">
                            <div class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-t from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <x-icon name="lightbulb" style="duotone" class="storefront-product-icon w-20 h-20 text-gray-400 dark:text-gray-500 transition-all duration-300" />
                                @if($product->category)
                                    <span class="absolute top-2 left-2 rounded-full bg-amber-500/90 dark:bg-amber-400/90 px-2.5 py-1 text-xs font-medium text-gray-900">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-4 space-y-2">
                                <h3 class="font-display font-semibold text-gray-900 dark:text-white truncate" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h3>
                                @if($product->brand)
                                    <p class="text-xs text-gray-500 dark:text-gray-500">{{ $product->brand->name }}</p>
                                @endif
                                <p class="mt-1 text-lg font-bold text-amber-600 dark:text-amber-400">
                                    {{ $product->price_formatted }}
                                </p>
                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('storefront.product', $product->slug) }}"
                                       class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:border-amber-500/50 dark:hover:border-amber-400/50 transition-all duration-300">
                                        <x-icon name="eye" style="solid" class="w-4 h-4" />
                                        Ver detalhes
                                    </a>
                                    <button type="button"
                                            @click="$dispatch('illuminar-add-to-cart', {{ json_encode(['id' => $product->id, 'name' => $product->name, 'sku' => $product->sku, 'price' => $product->price, 'stock' => $product->stock ?? 999]) }})"
                                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 dark:from-amber-500 dark:to-amber-600 px-3 py-2 text-xs sm:text-sm font-medium text-gray-900 hover:from-amber-400 hover:to-amber-500 dark:hover:from-amber-400 dark:hover:to-amber-500 transition-all duration-300">
                                        <x-icon name="cart-plus" style="solid" class="w-4 h-4" />
                                        Adicionar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full storefront-card-hover rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/60 p-10 text-center">
                            <x-icon name="box-open" style="duotone" class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-500" />
                            <p class="text-gray-600 dark:text-gray-400">Nenhum produto encontrado para os filtros selecionados.</p>
                            <a href="{{ route('storefront.catalog') }}"
                               class="mt-4 inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-2.5 text-sm font-medium text-gray-900 hover:from-amber-400 hover:to-amber-500 transition-all duration-300">
                                <x-icon name="arrow-rotate-left" style="solid" class="w-4 h-4" />
                                Limpar filtros
                            </a>
                        </div>
                    @endforelse
                </div>

                {{-- Paginação --}}
                <div class="mt-4">
                    {{ $products->onEachSide(1)->links() }}
                </div>
            </div>
        </section>
    </div>
</x-storefront::layouts.public>

