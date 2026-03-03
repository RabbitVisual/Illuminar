<x-storefront::layouts.public>
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white mb-8">Carrinho de Compras</h1>

        <div x-show="cart.length === 0"
             x-cloak
             class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-12 text-center">
            <x-icon name="cart-shopping" style="duotone" class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-500" />
            <p class="text-gray-600 dark:text-gray-400 mb-4">Seu carrinho está vazio.</p>
            <a href="{{ route('storefront.index') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-2 text-sm font-medium text-gray-900 hover:from-amber-400 hover:to-amber-500 transition-all duration-300">
                <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                Continuar Comprando
            </a>
        </div>

        <div x-show="cart.length > 0"
             x-cloak
             class="space-y-6">
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Produto</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Qtd</th>
                                <th class="px-4 py-3 text-right text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Subtotal</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700" x-ref="cartBody">
                            <template x-for="(item, index) in cart" :key="item.product_id">
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="px-4 py-3">
                                        <span class="font-medium text-gray-900 dark:text-white" x-text="item.name"></span>
                                        <span class="block text-sm text-gray-500 dark:text-gray-400" x-text="'SKU: ' + (item.sku || '-')"></span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <button type="button"
                                                    @click="updateQty(item.product_id, item.quantity - 1)"
                                                    class="rounded border border-gray-300 dark:border-gray-600 px-2 py-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <x-icon name="minus" style="solid" class="w-3 h-3" />
                                            </button>
                                            <input type="number"
                                                   :value="item.quantity"
                                                   min="1"
                                                   @input="updateQty(item.product_id, $event.target.value)"
                                                   class="w-16 rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-2 py-1 text-center text-gray-900 dark:text-white">
                                            <button type="button"
                                                    @click="updateQty(item.product_id, item.quantity + 1)"
                                                    class="rounded border border-gray-300 dark:border-gray-600 px-2 py-1 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                                <x-icon name="plus" style="solid" class="w-3 h-3" />
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right font-medium text-gray-900 dark:text-white">
                                        <span x-text="formatMoney(item.subtotal)"></span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button type="button"
                                                @click="removeFromCart(item.product_id)"
                                                class="rounded p-1 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                            <x-icon name="trash" style="solid" class="w-4 h-4" />
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="{{ route('storefront.index') }}"
                   class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                    <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                    Continuar Comprando
                </a>
                <div class="flex items-center gap-4">
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">
                        Total: <span x-text="formatMoney(getCartTotal())"></span>
                    </span>
                    <a href="{{ route('storefront.checkout') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3 text-sm font-medium text-gray-900 hover:from-amber-400 hover:to-amber-500 transition-all duration-300">
                        <x-icon name="credit-card" style="solid" class="w-4 h-4" />
                        Finalizar Compra
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-storefront::layouts.public>
