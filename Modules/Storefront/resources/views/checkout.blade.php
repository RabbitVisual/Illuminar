<x-storefront::layouts.public>
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12"
         x-data="{
             success: false,
             orderNumber: '',
             loading: false,
             error: '',
             zipCode: '',
             city: '',
             state: '',
             shippingRates: [],
             selectedShipping: null,
             shippingLoading: false,
             shippingError: ''
         }">
        <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white mb-3">Checkout</h1>
        <ol class="flex items-center gap-3 text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-8">
            <li class="flex items-center gap-2">
                <span class="flex h-6 w-6 items-center justify-center rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    1
                </span>
                <span>Carrinho</span>
            </li>
            <x-icon name="chevron-right" style="solid" class="w-3.5 h-3.5" />
            <li class="flex items-center gap-2">
                <span class="flex h-6 w-6 items-center justify-center rounded-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    2
                </span>
                <span>Entrega</span>
            </li>
            <x-icon name="chevron-right" style="solid" class="w-3.5 h-3.5" />
            <li class="flex items-center gap-2">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-amber-500 text-gray-900 font-semibold">
                    3
                </span>
                <span class="font-medium text-gray-900 dark:text-white">Pagamento</span>
            </li>
        </ol>

        <div x-show="success"
             x-cloak
             class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 p-8 text-center">
            <x-icon name="circle-check" style="solid" class="w-16 h-16 mx-auto mb-4 text-green-600 dark:text-green-400" />
            <h2 class="font-display text-xl font-semibold text-green-800 dark:text-green-300 mb-2">Pedido Realizado com Sucesso!</h2>
            <p class="text-green-700 dark:text-green-400 mb-2">
                Número do pedido: <strong x-text="orderNumber"></strong>
            </p>
            <p class="text-sm text-green-700 dark:text-green-400 mb-4 max-w-xl mx-auto">
                A confirmação do pagamento pode levar alguns instantes, dependendo da forma escolhida
                (cartão, PIX ou boleto). Você pode acompanhar o status em <strong>Meus Pedidos</strong>
                dentro do seu painel.
            </p>
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
                {{-- Endereço e Frete --}}
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6">
                    <h2 class="font-display text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <x-icon name="truck-fast" style="duotone" class="w-5 h-5" />
                        Calcular Frete
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Informe seu CEP para ver as opções de entrega disponíveis.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="zip_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">CEP</label>
                            <input type="text" id="zip_code" x-model="zipCode" x-mask="'cep'"
                                   placeholder="00000-000"
                                   class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-gray-900 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cidade</label>
                            <input type="text" id="city" x-model="city" placeholder="Sua cidade"
                                   class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-gray-900 dark:text-gray-100">
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado (UF)</label>
                            <input type="text" id="state" x-model="state" placeholder="BA" maxlength="2"
                                   class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-gray-900 dark:text-gray-100 uppercase">
                        </div>
                    </div>
                    <button type="button"
                            @click="
                                shippingLoading = true;
                                shippingError = '';
                                shippingRates = [];
                                selectedShipping = null;
                                fetch('{{ route('storefront.calculate-shipping') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        zip_code: zipCode.replace(/\D/g, ''),
                                        city: city,
                                        state: state.toUpperCase(),
                                        cart_total: $parent.getCartTotal()
                                    })
                                })
                                .then(r => r.json())
                                .then(data => {
                                    shippingLoading = false;
                                    if (data.success) {
                                        shippingRates = data.rates || [];
                                        shippingError = data.message || '';
                                        if (shippingRates.length > 0) selectedShipping = shippingRates[0];
                                    } else {
                                        shippingError = data.message || 'Erro ao calcular frete';
                                    }
                                })
                                .catch(() => {
                                    shippingLoading = false;
                                    shippingError = 'Erro ao calcular frete. Tente novamente.';
                                });
                            "
                            :disabled="shippingLoading || !zipCode || !city || !state"
                            class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-amber-400 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span x-show="!shippingLoading">Calcular Frete</span>
                        <span x-show="shippingLoading" x-cloak>Calculando...</span>
                    </button>

                    <p x-show="shippingError" x-cloak x-text="shippingError"
                       class="mt-4 text-sm text-red-600 dark:text-red-400"></p>

                    <div x-show="shippingRates.length > 0" x-cloak class="mt-6 space-y-2">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Selecione a opção de entrega:</p>
                        <template x-for="rate in shippingRates" :key="rate.id">
                            <label class="flex items-center justify-between gap-4 p-3 rounded-lg border cursor-pointer transition-colors"
                                   :class="selectedShipping && selectedShipping.id === rate.id ? 'border-amber-500 bg-amber-500/5 dark:bg-amber-400/5' : 'border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="shipping_option" :value="rate.id"
                                           :checked="selectedShipping && selectedShipping.id === rate.id"
                                           @change="selectedShipping = rate"
                                           class="text-amber-500">
                                    <div>
                                        <span class="font-medium text-gray-900 dark:text-white" x-text="rate.name"></span>
                                        <span class="block text-xs text-gray-500 dark:text-gray-400" x-text="'Entrega em até ' + rate.delivery_time_days + ' dias úteis'"></span>
                                    </div>
                                </div>
                                <span class="font-semibold text-gray-900 dark:text-white" x-text="rate.price_formatted"></span>
                            </label>
                        </template>
                    </div>
                </div>

                {{-- Resumo do Pedido + Cupom --}}
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 space-y-4"
                     x-data="{
                         couponCode: '',
                         appliedCoupon: null,
                         couponDiscount: 0,
                     }">
                    <h2 class="font-display text-lg font-semibold text-gray-900 dark:text-white mb-2">Resumo do Pedido</h2>
                    <ul class="space-y-3 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="item in $parent.cart" :key="item.product_id">
                            <li class="flex justify-between py-2">
                                <span class="text-gray-700 dark:text-gray-300" x-text="item.name + ' x ' + item.quantity"></span>
                                <span class="font-medium text-gray-900 dark:text-white" x-text="$parent.formatMoney(item.subtotal)"></span>
                            </li>
                        </template>
                    </ul>

                    <div class="pt-3 space-y-3">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div class="flex-1">
                                <label for="coupon_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Cupom de desconto
                                </label>
                                <input id="coupon_code"
                                       type="text"
                                       x-model="couponCode"
                                       placeholder="Digite seu cupom (ex: BEMVINDO10)"
                                       class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 uppercase">
                            </div>
                            <div class="sm:pt-6">
                                <button type="button"
                                        @click="
                                            appliedCoupon = couponCode.trim().toUpperCase() || null;
                                            // Cálculo aproximado apenas para exibição (validação real é feita no servidor)
                                            couponDiscount = 0;
                                        "
                                        class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-amber-400 transition-colors">
                                    <x-icon name="percent" style="solid" class="w-4 h-4" />
                                    Aplicar cupom
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            O desconto será validado e aplicado definitivamente ao finalizar a compra.
                        </p>
                    </div>

                    <div class="mt-2 space-y-1 text-sm text-gray-700 dark:text-gray-300">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-medium" x-text="$parent.formatMoney($parent.getCartTotal())"></span>
                        </div>
                        <div x-show="selectedShipping" x-cloak class="flex justify-between">
                            <span>Frete (<span x-text="selectedShipping ? selectedShipping.name : ''"></span>)</span>
                            <span class="font-medium" x-text="selectedShipping ? selectedShipping.price_formatted : ''"></span>
                        </div>
                        <div x-show="appliedCoupon" x-cloak class="flex justify-between text-emerald-600 dark:text-emerald-400">
                            <span x-text="'Cupom ' + appliedCoupon"></span>
                            <span class="font-medium" x-text="couponDiscount ? '- ' + $parent.formatMoney(couponDiscount) : '- R$ 0,00'"></span>
                        </div>
                    </div>

                    <p class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700 text-lg font-bold text-gray-900 dark:text-white">
                        Total estimado:
                        <span
                            x-text="$parent.formatMoney($parent.getCartTotal() + (selectedShipping ? selectedShipping.price : 0) - couponDiscount)">
                        </span>
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
                        const couponField = document.querySelector('#coupon_code');

                        body: JSON.stringify({
                            items: $parent.cart.map(i => ({ product_id: i.product_id, quantity: i.quantity })),
                            payment_method: document.querySelector('[name=payment_method]:checked').value,
                            shipping_method_id: selectedShipping ? selectedShipping.id : null,
                            shipping_amount: selectedShipping ? selectedShipping.price : 0,
                            coupon_code: couponField ? couponField.value.toUpperCase() : null,
                        })
                    })
                    .then(r => r.json())
                    .then(data => {
                        window.dispatchEvent(new CustomEvent('stop-loading'));
                        loading = false;
                        if (data.success) {
                            if (data.payment_url) {
                                // Mantém o carrinho até o retorno do provedor de pagamento
                                window.location.href = data.payment_url;
                                return;
                            }

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
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <input type="radio" name="payment_method" value="cash" class="text-primary">
                            <span class="text-gray-700 dark:text-gray-300">Pagamento na loja / Dinheiro (modo demo)</span>
                        </label>
                    </div>

                    <p x-show="shippingRates.length === 0 && zipCode && city && state && !shippingLoading"
                       x-cloak
                       class="mt-4 text-sm text-amber-600 dark:text-amber-400">
                        Infelizmente não entregamos nesta região no momento. Verifique o CEP e tente novamente ou entre em contato.
                    </p>

                    <p x-show="error"
                       x-cloak
                       x-text="error"
                       class="mt-4 text-sm text-red-600 dark:text-red-400"></p>

                    <button type="submit"
                            :disabled="loading || (shippingRates.length > 0 && !selectedShipping)"
                            class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-6 py-3 text-base font-medium text-white hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed">
                        <x-icon name="credit-card" style="solid" class="w-5 h-5" />
                        <span x-text="loading ? 'Processando...' : 'Finalizar Compra'"></span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-storefront::layouts.public>
