<x-storefront::layouts.public>
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12"
         x-data="{
             success: false,
             orderNumber: '',
             loading: false,
             error: ''
         }">
        <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white mb-8">Checkout</h1>

        <div x-show="success"
             x-cloak
             class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 p-8 text-center">
            <x-icon name="circle-check" style="solid" class="w-16 h-16 mx-auto mb-4 text-green-600 dark:text-green-400" />
            <h2 class="font-display text-xl font-semibold text-green-800 dark:text-green-300 mb-2">Pedido Realizado com Sucesso!</h2>
            <p class="text-green-700 dark:text-green-400 mb-2">Número do pedido: <strong x-text="orderNumber"></strong></p>
            <a href="{{ route('storefront.index') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                <x-icon name="house" style="solid" class="w-4 h-4" />
                Voltar ao Início
            </a>
        </div>

        <div x-show="!success"
             x-cloak>
            <div x-show="$parent.cart.length === 0"
                 x-cloak
                 class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-12 text-center">
                <p class="text-gray-600 dark:text-gray-400 mb-4">Seu carrinho está vazio.</p>
                <a href="{{ route('storefront.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                    Continuar Comprando
                </a>
            </div>

            <div x-show="$parent.cart.length > 0"
                 x-cloak
                 class="space-y-8">
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                    <h2 class="font-display text-lg font-semibold text-gray-900 dark:text-white mb-4">Resumo do Pedido</h2>
                    <ul class="space-y-3 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="item in $parent.cart" :key="item.product_id">
                            <li class="flex justify-between py-2">
                                <span class="text-gray-700 dark:text-gray-300" x-text="item.name + ' x ' + item.quantity"></span>
                                <span class="font-medium text-gray-900 dark:text-white" x-text="$parent.formatMoney(item.subtotal)"></span>
                            </li>
                        </template>
                    </ul>
                    <p class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 text-lg font-bold text-gray-900 dark:text-white">
                        Total: <span x-text="$parent.formatMoney($parent.getCartTotal())"></span>
                    </p>
                </div>

                <form @submit.prevent="
                    loading = true;
                    error = '';
                    window.dispatchEvent(new CustomEvent('start-loading'));
                    fetch('{{ route('storefront.checkout.process') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            items: $parent.cart.map(i => ({ product_id: i.product_id, quantity: i.quantity })),
                            payment_method: document.querySelector('[name=payment_method]:checked').value
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        window.dispatchEvent(new CustomEvent('stop-loading'));
                        loading = false;
                        if (data.success) {
                            $parent.clearCart();
                            orderNumber = data.order_number;
                            success = true;
                        } else {
                            error = data.message || 'Erro ao processar pedido';
                        }
                    })
                    .catch(err => {
                        window.dispatchEvent(new CustomEvent('stop-loading'));
                        loading = false;
                        error = 'Erro ao processar pedido. Tente novamente.';
                    });
                "
                      class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                    <h2 class="font-display text-lg font-semibold text-gray-900 dark:text-white mb-4">Forma de Pagamento</h2>

                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <input type="radio" name="payment_method" value="pix" class="text-primary" checked>
                            <span class="text-gray-700 dark:text-gray-300">PIX</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <input type="radio" name="payment_method" value="credit_card" class="text-primary">
                            <span class="text-gray-700 dark:text-gray-300">Cartão de Crédito</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <input type="radio" name="payment_method" value="debit_card" class="text-primary">
                            <span class="text-gray-700 dark:text-gray-300">Cartão de Débito</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <input type="radio" name="payment_method" value="boleto" class="text-primary">
                            <span class="text-gray-700 dark:text-gray-300">Boleto</span>
                        </label>
                    </div>

                    <p x-show="error"
                       x-cloak
                       x-text="error"
                       class="mt-4 text-sm text-red-600 dark:text-red-400"></p>

                    <button type="submit"
                            :disabled="loading"
                            class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-medium text-white hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed">
                        <x-icon name="credit-card" style="solid" class="w-5 h-5" />
                        <span x-text="loading ? 'Processando...' : 'Finalizar Compra'"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-storefront::layouts.public>
