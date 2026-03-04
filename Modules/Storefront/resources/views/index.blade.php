<x-storefront::layouts.public>
    <div class="relative min-h-screen">
        {{-- Background sutil para toda a página --}}
        <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(251,191,36,0.08),transparent)] dark:bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(251,191,36,0.12),transparent)] pointer-events-none"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Hero: iluminação e eletricidade --}}
            <section class="relative overflow-hidden rounded-2xl sm:rounded-3xl mt-6 mb-20 md:mb-28 border border-amber-500/20 dark:border-amber-400/25 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm shadow-xl shadow-amber-500/5 dark:shadow-amber-400/5">
                <div class="storefront-hero-glow absolute inset-0 pointer-events-none"></div>
                {{-- Orbes de luz animados --}}
                <div class="absolute top-1/4 left-1/4 w-64 h-64 storefront-hero-light-orb animate-light-glow rounded-full pointer-events-none"></div>
                <div class="absolute bottom-1/4 right-1/4 w-48 h-48 storefront-hero-light-orb animate-light-glow rounded-full pointer-events-none" style="animation-delay: 1s;"></div>
                <div class="absolute top-8 right-12 opacity-25 dark:opacity-35 pointer-events-none">
                    <x-icon name="lightbulb" style="duotone" class="w-28 h-28 sm:w-32 sm:h-32 text-amber-500 animate-float animate-bulb-glow" />
                </div>
                <div class="absolute bottom-12 left-8 opacity-20 dark:opacity-30 pointer-events-none">
                    <x-icon name="bolt" style="duotone" class="w-20 h-20 sm:w-24 sm:h-24 text-amber-500 animate-float-delayed" />
                </div>
                <div class="absolute top-1/2 right-20 opacity-10 dark:opacity-15 pointer-events-none">
                    <x-icon name="plug" style="duotone" class="w-16 h-16 text-amber-500 animate-float-delayed-2" />
                </div>

                <div class="relative px-6 py-18 sm:py-20 md:py-24 lg:py-28 text-center">
                    <div class="inline-flex items-center gap-2 rounded-full bg-amber-500/15 dark:bg-amber-400/15 border border-amber-500/20 dark:border-amber-400/20 px-4 py-2 text-sm font-medium text-amber-700 dark:text-amber-300 mb-6 animate-fade-in-up shadow-sm">
                        <x-icon name="bolt" style="duotone" class="w-4 h-4" />
                        Iluminação e Materiais Elétricos
                    </div>
                    <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-gray-900 dark:text-white mb-4 animate-fade-in-up tracking-tight" style="animation-delay: 0.08s">
                        Ilumine seus <span class="text-amber-600 dark:text-amber-400 bg-clip-text">Ambientes</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-10 animate-fade-in-up leading-relaxed" style="animation-delay: 0.15s">
                        Materiais elétricos e iluminação de qualidade para sua casa ou empresa. Variedade, preços competitivos e atendimento especializado.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 animate-fade-in-up" style="animation-delay: 0.25s">
                        <a href="{{ route('storefront.catalog') }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-linear-to-r from-amber-500 to-amber-600 dark:from-amber-500 dark:to-amber-600 px-6 py-3.5 text-base font-medium text-gray-900 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            <x-icon name="lightbulb" style="duotone" class="w-5 h-5" />
                            Ver Produtos
                        </a>
                        <a href="#categorias"
                           class="inline-flex items-center gap-2 rounded-xl border-2 border-amber-500/60 dark:border-amber-400/60 px-6 py-3.5 text-base font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            <x-icon name="tags" style="duotone" class="w-5 h-5" />
                            Explorar Catálogo
                        </a>
                    </div>
                </div>
            </section>

            {{-- Diferenciais --}}
            <section class="mb-20 md:mb-28">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
                    @foreach([
                        ['icon' => 'truck-fast', 'title' => 'Entrega Rápida', 'desc' => 'Entregas em todo o Brasil com prazo garantido e rastreamento.', 'delay' => '0.1s'],
                        ['icon' => 'shield-check', 'title' => 'Qualidade Garantida', 'desc' => 'Produtos de marcas reconhecidas com garantia e nota fiscal.', 'delay' => '0.2s'],
                        ['icon' => 'headset', 'title' => 'Atendimento Especializado', 'desc' => 'Equipe pronta para orientar na escolha ideal de iluminação.', 'delay' => '0.3s'],
                        ['icon' => 'tag', 'title' => 'Preços Competitivos', 'desc' => 'Melhores condições do mercado para você e sua empresa.', 'delay' => '0.4s'],
                    ] as $card)
                    <div class="storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm animate-fade-in-up hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors"
                         style="animation-delay: {{ $card['delay'] }}">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/15 text-amber-600 dark:text-amber-400 mb-4 group-hover:animate-electric-pulse">
                            <x-icon name="{{ $card['icon'] }}" style="duotone" class="w-7 h-7" />
                        </div>
                        <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-2">{{ $card['title'] }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $card['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- Categorias --}}
            @if(isset($categories) && $categories->isNotEmpty())
            <section id="categorias" class="mb-20 md:mb-28 scroll-mt-24">
                <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                        <x-icon name="lightbulb" style="duotone" class="w-5 h-5" />
                    </span>
                    Categorias
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    @foreach ($categories as $index => $category)
                        <a href="{{ route('storefront.catalog', ['category' => $category->slug]) }}"
                           class="group storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-5 text-center shadow-sm animate-fade-in-up hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors"
                           style="animation-delay: {{ 0.05 * $index }}s">
                            <div class="flex h-12 w-12 mx-auto mb-3 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-700 group-hover:bg-amber-500/15 dark:group-hover:bg-amber-400/20 text-gray-600 dark:text-gray-400 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-all duration-300">
                                <x-icon name="lightbulb" style="duotone" class="w-6 h-6" />
                            </div>
                            <span class="font-medium text-gray-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors block truncate" title="{{ $category->name }}">{{ $category->name }}</span>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $category->products_count }} produto(s)</p>
                        </a>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Produtos em Destaque --}}
            <section id="produtos" class="mb-20 md:mb-28 scroll-mt-24">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                    <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                            <x-icon name="sparkles" style="duotone" class="w-5 h-5" />
                        </span>
                        Produtos em Destaque
                    </h2>
                    @if(request('category'))
                        <a href="{{ route('storefront.index') }}"
                           class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:underline focus:outline-none focus:underline">
                            Limpar filtro
                        </a>
                    @endif
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse ($products as $index => $product)
                        <article class="group storefront-card-hover storefront-product-glow rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 overflow-hidden shadow-sm animate-fade-in-up hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors"
                                 style="animation-delay: {{ 0.05 * min($index, 8) }}s">
                            <div class="relative">
                                <x-core::product-image :product="$product" aspect="square" class="group" />
                                @if($product->category)
                                    <span class="absolute top-3 left-3 rounded-full bg-amber-500/95 dark:bg-amber-400/95 px-2.5 py-1 text-xs font-medium text-gray-900 shadow-sm">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                            </div>
                            <div class="p-4 sm:p-5">
                                <div class="flex items-center justify-between gap-2 mb-1">
                                    <h3 class="font-display font-semibold text-gray-900 dark:text-white truncate" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h3>
                                    @if($product->brand)
                                        <x-core::brand-logo :brand="$product->brand" size="xs" />
                                    @endif
                                </div>
                                <p class="mt-2 text-lg font-bold text-amber-600 dark:text-amber-400">
                                    {{ $product->price_formatted }}
                                </p>
                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('storefront.product', $product->slug) }}"
                                       class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:border-amber-500/50 dark:hover:border-amber-400/50 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500/50">
                                        <x-icon name="eye" style="solid" class="w-4 h-4" />
                                        Ver
                                    </a>
                                    <button type="button"
                                            @click="$dispatch('illuminar-add-to-cart', {{ json_encode(['id' => $product->id, 'name' => $product->name, 'sku' => $product->sku, 'price' => $product->price, 'stock' => $product->stock ?? 999]) }})"
                                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-lg bg-linear-to-r from-amber-500 to-amber-600 dark:from-amber-500 dark:to-amber-600 px-3 py-2.5 text-sm font-medium text-gray-900 hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                        <x-icon name="cart-plus" style="solid" class="w-4 h-4" />
                                        Carrinho
                                    </button>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full storefront-card-hover rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/60 p-12 text-center">
                            <x-icon name="box-open" style="duotone" class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-500" />
                            <p class="text-gray-600 dark:text-gray-400">Nenhum produto disponível no momento.</p>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Volte em breve para conferir nossas novidades.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            {{-- Por que a Illuminar --}}
            <section class="mb-20 md:mb-28">
                <div class="relative storefront-card-hover rounded-2xl sm:rounded-3xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-8 md:p-12 shadow-sm overflow-hidden">
                    <div class="absolute top-0 right-0 w-72 h-72 bg-amber-500/5 dark:bg-amber-400/10 rounded-full -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-amber-500/5 dark:bg-amber-400/10 rounded-full translate-y-1/2 -translate-x-1/2 pointer-events-none"></div>
                    <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-900 dark:text-white text-center mb-10 flex items-center justify-center gap-3 relative">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                            <x-icon name="lightbulb" style="duotone" class="w-5 h-5" />
                        </span>
                        Por que escolher a Illuminar?
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                        <div class="text-center group">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/15 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform duration-300">
                                <x-icon name="calendar-check" style="duotone" class="w-8 h-8" />
                            </div>
                            <p class="font-display text-3xl font-bold text-amber-600 dark:text-amber-400">+10</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Anos iluminando o Brasil</p>
                        </div>
                        <div class="text-center group">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/15 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform duration-300">
                                <x-icon name="users" style="duotone" class="w-8 h-8" />
                            </div>
                            <p class="font-display text-3xl font-bold text-amber-600 dark:text-amber-400">+5.000</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Clientes satisfeitos</p>
                        </div>
                        <div class="text-center group">
                            <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/15 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform duration-300">
                                <x-icon name="boxes-stacked" style="duotone" class="w-8 h-8" />
                            </div>
                            <p class="font-display text-3xl font-bold text-amber-600 dark:text-amber-400">+2.000</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Produtos no catálogo</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Newsletter / Captação de Leads --}}
            <section class="mb-20 md:mb-28">
                <div class="storefront-card-hover rounded-2xl sm:rounded-3xl border border-gray-200/80 dark:border-gray-700/80 bg-gray-50/90 dark:bg-gray-900/70 px-6 py-8 md:px-10 md:py-10 shadow-sm">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 lg:gap-10">
                        <div class="max-w-xl">
                            <div class="inline-flex items-center gap-2 rounded-full bg-amber-500/10 dark:bg-amber-400/10 px-3 py-1 text-xs font-medium text-amber-700 dark:text-amber-300 mb-3">
                                <x-icon name="envelope-open-text" style="duotone" class="w-4 h-4" />
                                Newsletter Illuminar
                            </div>
                            <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-2">
                                Receba ofertas e novidades em primeira mão
                            </h2>
                            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">
                                Fique por dentro de lançamentos, promoções exclusivas e dicas de iluminação para valorizar cada ambiente da sua casa ou empresa.
                            </p>
                        </div>
                        <div class="w-full max-w-md">
                            <form class="mt-2 space-y-3" onsubmit="return false;">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label for="newsletter-name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Nome
                                        </label>
                                        <input id="newsletter-name" type="text" autocomplete="name"
                                               class="block w-full rounded-lg border border-gray-300 bg-white/90 text-sm text-gray-900 focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-800/80 dark:border-gray-600 dark:text-white dark:placeholder-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                               placeholder="Como podemos te chamar?">
                                    </div>
                                    <div>
                                        <label for="newsletter-email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            E-mail
                                        </label>
                                        <input id="newsletter-email" type="email" autocomplete="email"
                                               class="block w-full rounded-lg border border-gray-300 bg-white/90 text-sm text-gray-900 focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-800/80 dark:border-gray-600 dark:text-white dark:placeholder-gray-500 dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                               placeholder="seuemail@exemplo.com">
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <button type="submit"
                                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-2.5 text-sm font-medium text-gray-900 shadow-sm hover:shadow-lg hover:shadow-amber-500/25 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                        <x-icon name="paper-plane" style="solid" class="w-4 h-4" />
                                        Quero receber novidades
                                    </button>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-500 max-w-xs">
                                        Prometemos enviar apenas conteúdos relevantes. Você pode se descadastrar quando quiser.
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            {{-- CTA Final --}}
            <section class="mb-20 md:mb-24">
                <div class="relative rounded-2xl sm:rounded-3xl bg-linear-to-r from-amber-500 via-amber-600 to-amber-500 dark:from-amber-500 dark:via-amber-600 dark:to-amber-500 p-8 md:p-12 text-center text-gray-900 overflow-hidden shadow-xl shadow-amber-500/20 dark:shadow-amber-400/10">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_50%,rgba(255,255,255,0.2),transparent_50%)] pointer-events-none"></div>
                    <div class="absolute top-4 left-1/4 opacity-20 pointer-events-none">
                        <x-icon name="lightbulb" style="duotone" class="w-16 h-16 text-white animate-float" />
                    </div>
                    <div class="absolute bottom-4 right-1/4 opacity-20 pointer-events-none">
                        <x-icon name="bolt" style="duotone" class="w-14 h-14 text-white animate-float-delayed" />
                    </div>
                    <div class="relative">
                        <h2 class="font-display text-2xl md:text-3xl font-bold mb-4 flex items-center justify-center gap-3 flex-wrap">
                            <x-icon name="magnifying-glass" style="duotone" class="w-8 h-8" />
                            Encontre a iluminação ideal
                        </h2>
                        <p class="text-gray-900/90 max-w-xl mx-auto mb-6 text-lg">
                            Navegue pelo nosso catálogo e descubra lâmpadas, luminárias e materiais elétricos para todos os ambientes.
                        </p>
                        <a href="{{ route('storefront.catalog') }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-white px-6 py-3.5 text-base font-medium text-amber-600 hover:bg-gray-100 transition-all duration-300 shadow-lg hover:scale-[1.02] active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-amber-500">
                            <x-icon name="magnifying-glass" style="solid" class="w-5 h-5" />
                            Ver Catálogo Completo
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-storefront::layouts.public>
