@extends('storepanel::layouts.pos')

@section('content')
<div x-data="posSystem()" x-init="init()" class="flex-1 flex flex-col min-h-0">
    {{-- Toast --}}
    <div x-show="toast.show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-4 right-4 z-50 max-w-sm rounded-lg px-4 py-3 shadow-lg"
         :class="toast.type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'"
         x-cloak>
        <p x-text="toast.message"></p>
    </div>

    <div class="flex-1 grid grid-cols-1 lg:grid-cols-5 gap-4 p-4 min-h-0 overflow-hidden">
        {{-- Coluna Esquerda: Carrinho (60%) --}}
        <div class="lg:col-span-3 flex flex-col min-h-0 rounded-xl border border-border dark:border-border bg-white dark:bg-surface shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-border dark:border-border bg-gray-50 dark:bg-gray-800/50">
                <h2 class="font-display font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="cart-shopping" style="duotone" class="w-5 h-5" />
                    Carrinho
                </h2>
            </div>
            <div class="flex-1 overflow-auto">
                <table class="min-w-full divide-y divide-border dark:divide-border" x-show="cart.length > 0">
                    <thead class="bg-gray-50 dark:bg-gray-800/50 sticky top-0">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-400">Produto</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 dark:text-gray-400 w-28">Qtd</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-400">Preço</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-600 dark:text-gray-400">Subtotal</th>
                            <th class="px-4 py-2 w-12"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border dark:divide-border bg-white dark:bg-surface">
                        <template x-for="(item, index) in cart" :key="item.product_id + '-' + index">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30">
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900 dark:text-white" x-text="item.name"></span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400" x-text="item.sku"></span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-1">
                                        <button type="button"
                                                @click="updateQuantity(index, item.quantity - 1)"
                                                class="rounded-lg p-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300">
                                            <x-icon name="minus" style="solid" class="w-4 h-4" />
                                        </button>
                                        <span class="w-10 text-center font-medium" x-text="item.quantity"></span>
                                        <button type="button"
                                                @click="updateQuantity(index, item.quantity + 1)"
                                                class="rounded-lg p-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300">
                                            <x-icon name="plus" style="solid" class="w-4 h-4" />
                                        </button>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-right text-sm text-gray-600 dark:text-gray-400" x-text="formatMoney(item.price / 100)"></td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900 dark:text-white" x-text="formatMoney(item.subtotal / 100)"></td>
                                <td class="px-4 py-3">
                                    <button type="button"
                                            @click="removeFromCart(index)"
                                            class="rounded-lg p-2 text-danger hover:bg-danger/10"
                                            aria-label="Remover">
                                        <x-icon name="trash" style="solid" class="w-4 h-4" />
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <div x-show="cart.length === 0" class="flex flex-col items-center justify-center h-64 text-gray-500 dark:text-gray-400">
                    <x-icon name="cart-shopping" style="duotone" class="w-16 h-16 mb-4 opacity-50" />
                    <p class="font-display text-lg">Carrinho vazio</p>
                    <p class="text-sm mt-1">Digite o código de barras ou SKU e pressione Enter</p>
                </div>
            </div>
        </div>

        {{-- Coluna Direita: Comandos (40%) --}}
        <div class="lg:col-span-2 flex flex-col gap-4 min-h-0">
            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-4 shadow-sm">
                <label for="search-input" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar produto (código de barras ou SKU)</label>
                <input type="text"
                       id="search-input"
                       x-ref="searchInput"
                       x-model="searchTerm"
                       @keydown.enter.prevent="search()"
                       placeholder="Passe o código ou digite e pressione Enter"
                       autofocus
                       class="block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-4 py-3 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent text-lg">
            </div>

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-4 shadow-sm flex-1 flex flex-col gap-4">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Subtotal</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white" x-text="formatMoney(cartTotal / 100)"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total</p>
                    <p class="text-3xl font-bold text-primary dark:text-primary" x-text="formatMoney(cartTotal / 100)"></p>
                </div>

                <div>
                    <label for="payment-method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Forma de pagamento</label>
                    <select id="payment-method"
                            x-model="paymentMethod"
                            class="block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-4 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="pix">PIX</option>
                        <option value="credit_card">Cartão de Crédito</option>
                        <option value="debit_card">Cartão de Débito</option>
                        <option value="cash">Dinheiro</option>
                    </select>
                </div>

                <div x-show="paymentMethod === 'cash'" x-cloak>
                    <label for="amount-received" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Valor recebido</label>
                    <input type="text"
                           id="amount-received"
                           x-mask="'money'"
                           x-model="amountReceived"
                           placeholder="R$ 0,00"
                           class="block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-4 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p x-show="paymentMethod === 'cash' && parseAmountReceived() > 0 && parseAmountReceived() >= cartTotal/100" class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                        Troco: <span x-text="formatMoney(Math.max(0, parseAmountReceived() - cartTotal/100))"></span>
                    </p>
                </div>

                <button type="button"
                        @click="checkout()"
                        :disabled="cart.length === 0 || loading"
                        class="mt-auto w-full py-4 rounded-xl bg-green-600 hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed text-white font-display font-bold text-xl flex items-center justify-center gap-2 transition-colors">
                    <x-icon name="check" style="solid" class="w-6 h-6" />
                    Finalizar Venda (F2)
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('posSystem', () => ({
        cart: [],
        searchTerm: '',
        paymentMethod: 'pix',
        amountReceived: '',
        loading: false,
        toast: { show: false, message: '', type: 'error' },
        keydownHandler: null,

        get cartTotal() {
            return this.cart.reduce((sum, item) => sum + item.subtotal, 0);
        },

        init() {
            this.$nextTick(() => this.$refs.searchInput?.focus());

            this.keydownHandler = (e) => {
                if (e.key === 'F2') {
                    e.preventDefault();
                    this.checkout();
                } else if (e.key === 'F4') {
                    e.preventDefault();
                    this.cancelSale();
                }
            };
            document.addEventListener('keydown', this.keydownHandler);
        },

        formatMoney(value) {
            if (value == null || isNaN(value)) return 'R$ 0,00';
            return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
        },

        parseAmountReceived() {
            const val = this.amountReceived || (document.getElementById('amount-received')?.value || '');
            if (!val) return 0;
            const cleaned = String(val).replace(/[^\d,]/g, '').replace(',', '.');
            return parseFloat(cleaned) || 0;
        },

        showToast(message, type = 'error') {
            this.toast = { show: true, message, type };
            setTimeout(() => { this.toast.show = false; }, 3000);
        },

        search() {
            const term = this.searchTerm?.trim();
            if (!term) return;

            const url = `{{ route('pdv.search') }}?term=${encodeURIComponent(term)}`;
            fetch(url, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => {
                    if (res.ok) return res.json();
                    if (res.status === 404) throw new Error('Produto não encontrado');
                    throw new Error('Erro ao buscar produto');
                })
                .then(product => {
                    this.addToCart(product);
                    this.searchTerm = '';
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                })
                .catch(err => {
                    this.showToast(err.message || 'Produto não encontrado', 'error');
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                });
        },

        addToCart(product) {
            const existing = this.cart.find(item => item.product_id === product.id);
            if (existing) {
                existing.quantity += 1;
                existing.subtotal = existing.price * existing.quantity;
            } else {
                this.cart.push({
                    product_id: product.id,
                    name: product.name,
                    sku: product.sku,
                    price: product.price,
                    quantity: 1,
                    subtotal: product.price
                });
            }
        },

        removeFromCart(index) {
            this.cart.splice(index, 1);
            this.$nextTick(() => this.$refs.searchInput?.focus());
        },

        updateQuantity(index, qty) {
            if (qty <= 0) {
                this.removeFromCart(index);
                return;
            }
            this.cart[index].quantity = qty;
            this.cart[index].subtotal = this.cart[index].price * qty;
        },

        cancelSale() {
            this.cart = [];
            this.searchTerm = '';
            this.amountReceived = '';
            this.showToast('Venda cancelada', 'success');
            this.$nextTick(() => this.$refs.searchInput?.focus());
        },

        async checkout() {
            if (this.cart.length === 0) {
                this.showToast('Adicione itens ao carrinho', 'error');
                return;
            }

            if (this.paymentMethod === 'cash') {
                const received = this.parseAmountReceived();
                if (received < this.cartTotal / 100) {
                    this.showToast('Valor recebido insuficiente', 'error');
                    return;
                }
            }

            this.loading = true;
            window.dispatchEvent(new CustomEvent('start-loading', { detail: { message: 'Finalizando venda...', icon: 'receipt' } }));

            const payload = {
                items: this.cart.map(item => ({ product_id: item.product_id, quantity: item.quantity })),
                payment_method: this.paymentMethod,
                _token: document.querySelector('meta[name="csrf-token"]')?.content
            };
            if (this.paymentMethod === 'cash') {
                payload.amount_received = this.amountReceived || '';
            }

            try {
                const res = await fetch('{{ route('pdv.checkout') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': payload._token,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(payload)
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    this.showToast(`Venda concluída! Pedido ${data.order_number}`, 'success');
                    this.cart = [];
                    this.searchTerm = '';
                    this.amountReceived = '';
                    this.$nextTick(() => this.$refs.searchInput?.focus());
                } else {
                    this.showToast(data.error || 'Erro ao finalizar venda', 'error');
                }
            } catch (err) {
                this.showToast('Erro de conexão. Tente novamente.', 'error');
            } finally {
                this.loading = false;
                window.dispatchEvent(new CustomEvent('stop-loading'));
            }
        }
    }));
});
</script>
@endsection
