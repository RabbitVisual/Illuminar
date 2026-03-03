<x-storefront::layouts.public>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            {{-- Imagem --}}
            <div class="aspect-square rounded-xl bg-gradient-to-br from-gray-100 to-amber-500/5 dark:from-gray-800 dark:to-amber-500/10 flex items-center justify-center overflow-hidden group">
                <x-icon name="lightbulb" style="duotone" class="w-48 h-48 text-gray-400 dark:text-gray-500 group-hover:text-amber-500/60 transition-colors duration-300" />
            </div>

            {{-- Detalhes --}}
            <div>
                <h1 class="font-display text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                    {{ $product->name }}
                </h1>
                @if ($product->sku)
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">SKU: {{ $product->sku }}</p>
                @endif
                <p class="mt-4 text-2xl font-bold text-amber-600 dark:text-amber-400">
                    {{ $product->price_formatted }}
                </p>

                @if ($product->description)
                    <div class="mt-6">
                        <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-2">Descrição</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $product->description }}</p>
                    </div>
                @endif

                {{-- Especificações Técnicas --}}
                <div class="mt-6">
                    <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-3">Especificações Técnicas</h3>
                    <ul class="space-y-2 text-gray-600 dark:text-gray-400">
                        @if ($product->voltage)
                            <li class="flex items-center gap-2">
                                <x-icon name="bolt" style="solid" class="w-4 h-4 text-amber-500 shrink-0" />
                                <span>Voltagem: {{ $product->voltage }}</span>
                            </li>
                        @endif
                        @if ($product->power_watts)
                            <li class="flex items-center gap-2">
                                <x-icon name="gauge-high" style="solid" class="w-4 h-4 text-amber-500 shrink-0" />
                                <span>Potência: {{ $product->power_watts }} W</span>
                            </li>
                        @endif
                        @if ($product->color_temperature_k)
                            <li class="flex items-center gap-2">
                                <x-icon name="palette" style="solid" class="w-4 h-4 text-amber-500 shrink-0" />
                                <span>Temperatura de Cor: {{ $product->color_temperature_k }} K</span>
                            </li>
                        @endif
                        @if ($product->lumens)
                            <li class="flex items-center gap-2">
                                <x-icon name="sun" style="solid" class="w-4 h-4 text-amber-500 shrink-0" />
                                <span>Lúmens: {{ $product->lumens }} lm</span>
                            </li>
                        @endif
                        @if (!$product->voltage && !$product->power_watts && !$product->color_temperature_k && !$product->lumens)
                            <li class="text-gray-500 dark:text-gray-500">Sem especificações técnicas cadastradas.</li>
                        @endif
                    </ul>
                </div>

                <div class="mt-8"
                     x-data="{
                         product: @js([
                             'id' => $product->id,
                             'name' => $product->name,
                             'sku' => $product->sku,
                             'price' => $product->price,
                             'stock' => $product->stock,
                         ])
                     }">
                    <button type="button"
                            @click="$dispatch('illuminar-add-to-cart', product)"
                            :disabled="product.stock < 1"
                            class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3 text-base font-medium text-gray-900 hover:from-amber-400 hover:to-amber-500 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                        <x-icon name="cart-plus" style="solid" class="w-5 h-5" />
                        Adicionar ao Carrinho
                    </button>
                    @if ($product->stock < 1)
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">Produto indisponível no momento.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-storefront::layouts.public>
