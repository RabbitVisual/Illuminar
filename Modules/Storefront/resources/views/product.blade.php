<x-storefront::layouts.public>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-10 lg:py-12">
        {{-- Breadcrumb --}}
        <nav class="mb-6 text-xs sm:text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2 flex-wrap">
            <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 font-medium">Início</a>
            <span>/</span>
            @if($product->category)
                <a href="{{ route('storefront.catalog', ['category' => $product->category->slug]) }}"
                   class="hover:text-amber-600 dark:hover:text-amber-400 font-medium">
                    {{ $product->category->name }}
                </a>
                <span>/</span>
            @endif
            <span class="text-gray-600 dark:text-gray-300 truncate max-w-[60%] sm:max-w-xs" title="{{ $product->name }}">
                {{ $product->name }}
            </span>
        </nav>

        @php
            $gallery = $product->images->pluck('path')->map(fn ($path) => asset('storage/' . $path))->all();
            $cover = $product->image_path ? asset('storage/' . $product->image_path) : null;
            if ($cover) {
                array_unshift($gallery, $cover);
                $gallery = array_values(array_unique($gallery));
            }
            if (empty($gallery)) {
                $gallery = [];
            }
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10"
             x-data="{
                images: @js($gallery),
                currentIndex: 0,
                get currentImage() {
                    return this.images.length ? this.images[this.currentIndex] : null;
                }
             }">
            {{-- Galeria / Imagem principal --}}
            <div class="lg:col-span-6 xl:col-span-7">
                <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-900/70 p-4 sm:p-5 storefront-card-hover shadow-sm">
                    <div class="relative overflow-hidden rounded-xl bg-linear-to-br from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900 aspect-square group">
                        <template x-if="currentImage">
                            <img :src="currentImage"
                                 alt="{{ $product->name }}"
                                 class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110" />
                        </template>
                        @if(! $product->image_path && $product->images->isEmpty())
                            <div class="flex h-full w-full items-center justify-center">
                                <x-icon name="lightbulb" style="duotone" class="w-40 h-40 sm:w-52 sm:h-52 text-gray-400 dark:text-gray-500 group-hover:text-amber-500/70 transition-colors duration-300" />
                            </div>
                        @endif
                        @if($product->category)
                            <span class="absolute top-4 left-4 rounded-full bg-amber-500/95 dark:bg-amber-400/95 px-3 py-1 text-xs font-semibold text-gray-900 shadow-sm">
                                {{ $product->category->name }}
                            </span>
                        @endif
                        @if($product->brand)
                            <span class="absolute top-4 right-4">
                                <x-core::brand-logo :brand="$product->brand" size="sm" />
                            </span>
                        @endif
                    </div>
                    {{-- Miniaturas --}}
                    @if(!empty($gallery))
                        <div class="mt-4 flex gap-3 overflow-x-auto pb-1">
                            <template x-for="(img, idx) in images" :key="idx">
                                <button type="button"
                                        @click="currentIndex = idx"
                                        class="relative h-16 w-16 rounded-lg border-2 overflow-hidden flex-shrink-0"
                                        :class="idx === currentIndex ? 'border-amber-500' : 'border-gray-200 dark:border-gray-700'">
                                    <img :src="img"
                                         alt="Miniatura do produto"
                                         class="h-full w-full object-cover" />
                                </button>
                            </template>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Caixa de compra / informações principais --}}
            <div class="lg:col-span-6 xl:col-span-5">
                <div class="space-y-5">
                    <div>
                        @if($product->brand)
                            <div class="flex items-center gap-2 mb-1">
                                <x-core::brand-logo :brand="$product->brand" size="sm" />
                                <p class="text-xs font-semibold tracking-wide text-amber-600 dark:text-amber-400 uppercase">
                                    {{ $product->brand->name }}
                                </p>
                            </div>
                        @endif
                        <h1 class="font-display text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white leading-tight">
                            {{ $product->name }}
                        </h1>
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
                            @if ($product->sku)
                                <span class="inline-flex items-center gap-1 rounded-full border border-gray-200 dark:border-gray-700 px-2.5 py-1 bg-white/70 dark:bg-gray-900/70">
                                    <x-icon name="barcode" style="solid" class="w-3 h-3" />
                                    SKU: {{ $product->sku }}
                                </span>
                            @endif
                            @if ($product->barcode)
                                <span class="inline-flex items-center gap-1 rounded-full border border-gray-200 dark:border-gray-700 px-2.5 py-1 bg-white/70 dark:bg-gray-900/70">
                                    <x-icon name="qrcode" style="solid" class="w-3 h-3" />
                                    Código de barras: {{ $product->barcode }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-900/70 p-5 shadow-sm storefront-card-hover"
                         x-data="{
                             product: @js([
                                 'id' => $product->id,
                                 'name' => $product->name,
                                 'sku' => $product->sku,
                                 'price' => $product->price,
                                 'stock' => $product->stock,
                             ])
                         }">
                        <div class="flex items-end justify-between gap-4 mb-4">
                            <div>
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                    Preço
                                </p>
                                <p class="mt-1 text-3xl font-bold text-amber-600 dark:text-amber-400">
                                    {{ $product->price_formatted }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">
                                    Valor à vista. Consulte condições de pagamento no checkout.
                                </p>
                            </div>
                            <div class="text-right">
                                @if ($product->stock > 0)
                                    <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase">
                                        <x-icon name="circle-check" style="solid" class="w-3.5 h-3.5 inline-block mr-1" />
                                        Em estoque
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $product->stock }} unidade(s) disponível(is)
                                    </p>
                                @else
                                    <p class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase">
                                        <x-icon name="triangle-exclamation" style="solid" class="w-3.5 h-3.5 inline-block mr-1" />
                                        Indisponível
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-4 space-y-3">
                            <button type="button"
                                    @click="$dispatch('illuminar-add-to-cart', product)"
                                    :disabled="product.stock < 1"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-linear-to-r from-amber-500 to-amber-600 px-6 py-3 text-base font-medium text-gray-900 hover:from-amber-400 hover:to-amber-500 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                <x-icon name="cart-plus" style="solid" class="w-5 h-5" />
                                Adicionar ao Carrinho
                            </button>
                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                Você poderá calcular o frete e escolher a forma de pagamento na tela de carrinho e checkout.
                            </p>
                            @if ($product->stock < 1)
                                <p class="text-sm text-red-600 dark:text-red-400">
                                    Produto indisponível no momento. Fale com nossa equipe para previsão de reposição.
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Resumo rápido / Benefícios da loja --}}
                    <div class="rounded-2xl border border-gray-200/70 dark:border-gray-800 bg-gray-50/90 dark:bg-gray-900/70 p-4 text-xs text-gray-600 dark:text-gray-400 space-y-2">
                        <div class="flex items-center gap-2">
                            <x-icon name="shield-check" style="duotone" class="w-4 h-4 text-amber-500 shrink-0" />
                            <p>Produto com nota fiscal e garantia de fábrica.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-icon name="truck-fast" style="duotone" class="w-4 h-4 text-amber-500 shrink-0" />
                            <p>Envio rápido para todo o Brasil conforme opções de frete disponíveis.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-icon name="headset" style="duotone" class="w-4 h-4 text-amber-500 shrink-0" />
                            <p>Atendimento especializado para ajudar na escolha da melhor solução de iluminação.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Conteúdo detalhado --}}
        <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">
            <div class="lg:col-span-2">
                <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-900/70 p-6 shadow-sm storefront-card-hover">
                    <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white mb-3">
                        Descrição detalhada
                    </h2>
                    @if ($product->description)
                        <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                            {{ $product->description }}
                        </p>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Este produto ainda não possui uma descrição detalhada cadastrada. Entre em contato com nossa equipe para mais informações sobre aplicações, ambientes indicados e combinações de iluminação.
                        </p>
                    @endif
                </div>
            </div>
            <div class="lg:col-span-1">
                <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-900/70 p-6 shadow-sm storefront-card-hover">
                    <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white mb-3">
                        Especificações técnicas
                    </h2>
                    <ul class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
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
                                <span>Temperatura de cor: {{ $product->color_temperature_k }} K</span>
                            </li>
                        @endif
                        @if ($product->lumens)
                            <li class="flex items-center gap-2">
                                <x-icon name="sun" style="solid" class="w-4 h-4 text-amber-500 shrink-0" />
                                <span>Lúmens: {{ $product->lumens }} lm</span>
                            </li>
                        @endif
                        @if (!$product->voltage && !$product->power_watts && !$product->color_temperature_k && !$product->lumens)
                            <li class="text-sm text-gray-500 dark:text-gray-500">
                                Sem especificações técnicas cadastradas.
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- Produtos relacionados --}}
        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
            <section class="mt-12 md:mt-14">
                <div class="flex items-center justify-between gap-3 mb-5">
                    <h2 class="font-display text-xl md:text-2xl font-semibold text-gray-900 dark:text-white flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                            <x-icon name="sparkles" style="duotone" class="w-4 h-4" />
                        </span>
                        Produtos relacionados
                    </h2>
                    <a href="{{ route('storefront.catalog', ['category' => optional($product->category)->slug]) }}"
                       class="text-xs font-medium text-amber-600 dark:text-amber-400 hover:underline">
                        Ver mais produtos desta categoria
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <article class="group storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-900/70 overflow-hidden shadow-sm">
                            <a href="{{ route('storefront.product', $related->slug) }}" class="block">
                                <div class="aspect-square bg-linear-to-br from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900 flex items-center justify-center relative overflow-hidden">
                                    <x-icon name="lightbulb" style="duotone" class="w-16 h-16 text-gray-400 dark:text-gray-500 group-hover:text-amber-500/70 transition-colors duration-300" />
                                    @if($related->category)
                                        <span class="absolute top-3 left-3 rounded-full bg-amber-500/95 dark:bg-amber-400/95 px-2.5 py-1 text-[11px] font-semibold text-gray-900 shadow-sm">
                                            {{ $related->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <h3 class="font-display text-sm font-semibold text-gray-900 dark:text-white truncate" title="{{ $related->name }}">
                                    <a href="{{ route('storefront.product', $related->slug) }}">
                                        {{ $related->name }}
                                    </a>
                                </h3>
                                @if($related->brand)
                                    <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $related->brand->name }}
                                    </p>
                                @endif
                                <p class="mt-2 text-sm font-bold text-amber-600 dark:text-amber-400">
                                    {{ $related->price_formatted }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-storefront::layouts.public>
