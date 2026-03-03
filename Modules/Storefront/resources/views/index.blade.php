<x-storefront::layouts.public>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        {{-- Banner --}}
        <section class="mb-16 rounded-2xl bg-gradient-to-r from-primary/20 to-primary/5 dark:from-primary/30 dark:to-primary/10 border border-primary/20 dark:border-primary/30 p-8 md:p-12 text-center">
            <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                Ilumine seus Ambientes
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Materiais elétricos e iluminação de qualidade para sua casa ou empresa.
            </p>
        </section>

        {{-- Grid de Produtos --}}
        <section>
            <h2 class="font-display text-2xl font-semibold text-gray-900 dark:text-white mb-6">Produtos em Destaque</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="aspect-square bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                            <x-icon name="lightbulb" style="duotone" class="w-24 h-24 text-gray-400 dark:text-gray-500" />
                        </div>
                        <div class="p-4">
                            <h3 class="font-display font-semibold text-gray-900 dark:text-white truncate" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            <p class="mt-1 text-lg font-bold text-primary dark:text-primary">
                                {{ $product->price_formatted }}
                            </p>
                            <a href="{{ route('storefront.product', $product->slug) }}"
                               class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                                <x-icon name="eye" style="solid" class="w-4 h-4" />
                                Ver Produto
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                        <x-icon name="box-open" style="duotone" class="w-16 h-16 mx-auto mb-4 opacity-50" />
                        <p>Nenhum produto disponível no momento.</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-storefront::layouts.public>
