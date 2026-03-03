<x-storefront::layouts.public>
    {{-- Background sutil alinhado à home --}}
    <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_80%_50%_at_50%_-10%,rgba(251,191,36,0.06),transparent)] dark:bg-[radial-gradient(ellipse_80%_50%_at_50%_-10%,rgba(251,191,36,0.08),transparent)] pointer-events-none"></div>

    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        {{-- Breadcrumb --}}
        <nav class="mb-6 text-sm text-gray-500 dark:text-gray-400" aria-label="Breadcrumb">
            <ol class="flex items-center gap-2">
                <li>
                    <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
                </li>
                <li>
                    <x-icon name="chevron-right" style="solid" class="w-3.5 h-3.5 inline-block text-gray-400 dark:text-gray-500" />
                </li>
                <li class="font-medium text-gray-900 dark:text-white" aria-current="page">Carrinho</li>
            </ol>
        </nav>

        <div class="mb-8">
            <h1 class="font-display text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">Carrinho de Compras</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Revise seus itens e prossiga para o checkout com segurança.</p>
        </div>

        {{-- Carrinho vazio --}}
        <div x-show="cart.length === 0"
             x-cloak
             class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/90 shadow-sm overflow-hidden">
            <div class="px-6 py-16 sm:py-20 text-center">
                <div class="inline-flex h-20 w-20 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/15 text-amber-600 dark:text-amber-400 mb-6">
                    <x-icon name="cart-shopping" style="duotone" class="w-10 h-10" />
                </div>
                <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white mb-2">Seu carrinho está vazio</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-sm mx-auto mb-8">
                    Adicione produtos do catálogo para ver os itens aqui. Você pode alterar quantidades e remover itens a qualquer momento.
                </p>
                <a href="{{ route('storefront.catalog') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 dark:from-amber-500 dark:to-amber-600 px-6 py-3.5 text-base font-medium text-gray-900 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    <x-icon name="magnifying-glass" style="solid" class="w-5 h-5" />
                    Ver catálogo
                </a>
            </div>
        </div>

        {{-- Carrinho com itens --}}
        <div x-show="cart.length > 0"
             x-cloak
             class="space-y-6 lg:space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 items-start">
                {{-- Lista de itens --}}
                <div class="lg:col-span-3">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-display text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-icon name="box-open" style="duotone" class="w-5 h-5 text-amber-500 dark:text-amber-400" />
                            Seus itens
                            <span class="inline-flex items-center justify-center min-w-[1.5rem] h-6 px-2 rounded-full bg-amber-500/15 dark:bg-amber-400/15 text-amber-700 dark:text-amber-300 text-sm font-medium"
                                  x-text="cart.length"></span>
                        </h2>
                    </div>

                    {{-- Mobile: cards por item --}}
                    <div class="lg:hidden space-y-4">
                        <template x-for="(item, index) in cart" :key="item.product_id">
                            <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden p-4">
                                <div class="flex gap-4">
                                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/15 text-amber-600 dark:text-amber-400">
                                        <x-icon name="lightbulb" style="duotone" class="w-7 h-7" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white truncate" x-text="item.name"></p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400" x-text="'SKU: ' + (item.sku || '-')"></p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Unit. <span x-text="formatMoney(item.price)"></span></p>
                                    </div>
                                    <button type="button"
                                            @click="removeFromCart(item.product_id)"
                                            class="shrink-0 inline-flex h-9 w-9 items-center justify-center rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20"
                                            aria-label="Remover item">
                                        <x-icon name="trash" style="solid" class="w-4 h-4" />
                                    </button>
                                </div>
                                <div class="mt-4 flex items-center justify-between gap-4">
                                    <div class="inline-flex items-center gap-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 p-1">
                                        <button type="button"
                                                @click="updateQty(item.product_id, Math.max(1, item.quantity - 1))"
                                                class="flex h-9 w-9 items-center justify-center rounded-md text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                aria-label="Diminuir quantidade">
                                            <x-icon name="minus" style="solid" class="w-4 h-4" />
                                        </button>
                                        <input type="number"
                                               :value="item.quantity"
                                               min="1"
                                               @input="updateQty(item.product_id, $event.target.value)"
                                               class="h-9 w-14 rounded border-0 bg-transparent text-center text-sm font-medium text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:ring-inset"
                                               aria-label="Quantidade">
                                        <button type="button"
                                                @click="updateQty(item.product_id, item.quantity + 1)"
                                                class="flex h-9 w-9 items-center justify-center rounded-md text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600"
                                                aria-label="Aumentar quantidade">
                                            <x-icon name="plus" style="solid" class="w-4 h-4" />
                                        </button>
                                    </div>
                                    <span class="font-semibold text-gray-900 dark:text-white" x-text="formatMoney(item.subtotal)"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Desktop: tabela --}}
                    <div class="hidden lg:block rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" role="table" aria-label="Itens do carrinho">
                                <thead class="bg-gray-50 dark:bg-gray-800/80">
                                    <tr>
                                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Produto</th>
                                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Preço unit.</th>
                                        <th scope="col" class="px-4 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Quantidade</th>
                                        <th scope="col" class="px-4 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">Subtotal</th>
                                        <th scope="col" class="px-4 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400 w-14">
                                            <span class="sr-only">Remover</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800" x-ref="cartBody">
                                    <template x-for="(item, index) in cart" :key="item.product_id">
                                        <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-700/30 transition-colors">
                                            <td class="px-4 py-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/15 text-amber-600 dark:text-amber-400">
                                                        <x-icon name="lightbulb" style="duotone" class="w-6 h-6" />
                                                    </div>
                                                    <div class="min-w-0">
                                                        <span class="font-medium text-gray-900 dark:text-white block truncate" x-text="item.name"></span>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400" x-text="'SKU: ' + (item.sku || '-')"></span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                                <span x-text="formatMoney(item.price)"></span>
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="inline-flex items-center gap-1 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 p-1">
                                                    <button type="button"
                                                            @click="updateQty(item.product_id, Math.max(1, item.quantity - 1))"
                                                            class="flex h-8 w-8 items-center justify-center rounded-md text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1 dark:focus:ring-offset-gray-800"
                                                            aria-label="Diminuir quantidade">
                                                        <x-icon name="minus" style="solid" class="w-3.5 h-3.5" />
                                                    </button>
                                                    <input type="number"
                                                           :value="item.quantity"
                                                           min="1"
                                                           @input="updateQty(item.product_id, $event.target.value)"
                                                           class="h-8 w-12 rounded border-0 bg-transparent text-center text-sm font-medium text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 focus:ring-inset dark:focus:ring-amber-400"
                                                           aria-label="Quantidade">
                                                    <button type="button"
                                                            @click="updateQty(item.product_id, item.quantity + 1)"
                                                            class="flex h-8 w-8 items-center justify-center rounded-md text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-gray-900 dark:hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-1 dark:focus:ring-offset-gray-800"
                                                            aria-label="Aumentar quantidade">
                                                        <x-icon name="plus" style="solid" class="w-3.5 h-3.5" />
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <span class="font-semibold text-gray-900 dark:text-white" x-text="formatMoney(item.subtotal)"></span>
                                            </td>
                                            <td class="px-4 py-4 text-right">
                                                <button type="button"
                                                        @click="removeFromCart(item.product_id)"
                                                        class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 dark:focus:ring-offset-gray-800"
                                                        aria-label="Remover item do carrinho"
                                                        title="Remover">
                                                    <x-icon name="trash" style="solid" class="w-4 h-4" />
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <a href="{{ route('storefront.catalog') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                            <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                            Continuar comprando
                        </a>
                        <span class="text-gray-300 dark:text-gray-600">|</span>
                        <button type="button"
                                @click="clearCart()"
                                class="inline-flex items-center gap-2 text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                            <x-icon name="trash" style="solid" class="w-4 h-4" />
                            Esvaziar carrinho
                        </button>
                    </div>
                </div>

                {{-- Resumo (sticky em desktop) --}}
                <aside class="lg:col-span-2 lg:sticky lg:top-24">
                    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="font-display text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-icon name="receipt" style="duotone" class="w-5 h-5 text-amber-500 dark:text-amber-400" />
                                Resumo do pedido
                            </h2>
                        </div>
                        <div class="px-6 py-5 space-y-4">
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal (<span x-text="cart.length"></span> <span x-text="cart.length === 1 ? 'item' : 'itens'"></span>)</span>
                                <span class="font-semibold text-gray-900 dark:text-white text-lg" x-text="formatMoney(getCartTotal())"></span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                                O frete e as opções de pagamento (PIX, cartão, boleto) serão calculados na próxima etapa, de acordo com seu endereço de entrega.
                            </p>
                            <div class="pt-2 space-y-3">
                                <a href="{{ route('storefront.checkout') }}"
                                   class="flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 dark:from-amber-500 dark:to-amber-600 px-6 py-3.5 text-base font-medium text-gray-900 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 hover:scale-[1.01] active:scale-[0.99] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                    <x-icon name="credit-card" style="solid" class="w-5 h-5" />
                                    Ir para o checkout
                                </a>
                                <a href="{{ route('storefront.catalog') }}"
                                   class="flex w-full items-center justify-center gap-2 rounded-xl border-2 border-gray-200 dark:border-gray-600 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:border-amber-500/50 dark:hover:border-amber-400/50 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                                    <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                                    Continuar comprando
                                </a>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/80 border-t border-gray-200 dark:border-gray-700 space-y-3">
                            <div class="flex items-start gap-3 text-xs text-gray-600 dark:text-gray-400">
                                <x-icon name="shield-check" style="duotone" class="w-4 h-4 text-emerald-500 dark:text-emerald-400 shrink-0 mt-0.5" />
                                <span>Pagamento seguro com Stripe, Mercado Pago e Pagar.me. Seus dados estão protegidos.</span>
                            </div>
                            <div class="flex items-start gap-3 text-xs text-gray-600 dark:text-gray-400">
                                <x-icon name="truck-fast" style="duotone" class="w-4 h-4 text-amber-500 dark:text-amber-400 shrink-0 mt-0.5" />
                                <span>Frete calculado no checkout conforme sua região. Entrega em todo o Brasil.</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-storefront::layouts.public>
