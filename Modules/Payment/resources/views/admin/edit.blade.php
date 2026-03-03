<x-core::layouts.master heading="Configurar Gateway">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('payment.admin.gateways.index') }}" class="hover:text-primary transition-colors">Gateways</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">{{ $gateway->name }}</span>
        </div>

        <form method="POST" action="{{ route('payment.admin.gateways.update', $gateway) }}" id="gateway-form">
            @csrf

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm space-y-6">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="key" style="duotone" class="w-5 h-5" />
                    Credenciais
                </h3>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome de exibição</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $gateway->name) }}" required
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-danger @enderror"
                           placeholder="Ex: Mercado Pago Produção">
                    @error('name')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="public_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Chave Pública (Public Key)</label>
                    <input type="text" id="public_key" name="public_key" value="{{ old('public_key', $gateway->credentials['public_key'] ?? '') }}"
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('public_key') border-danger @enderror"
                           placeholder="Cole a chave pública aqui">
                    @error('public_key')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Chave Secreta (Secret Key)</label>
                    <input type="password" id="secret_key" name="secret_key" value="{{ old('secret_key', $gateway->credentials['secret_key'] ?? '') }}"
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('secret_key') border-danger @enderror"
                           placeholder="Cole a chave secreta aqui (deixe em branco para manter)">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Deixe em branco para não alterar a chave atual.</p>
                    @error('secret_key')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="webhook_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL do Webhook (opcional)</label>
                    <input type="url" id="webhook_url" name="webhook_url" value="{{ old('webhook_url', $gateway->credentials['webhook_url'] ?? '') }}"
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('webhook_url') border-danger @enderror"
                           placeholder="https://sualoja.com/webhook/pagamento">
                    @error('webhook_url')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <p class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Formas de pagamento atendidas</p>
                    @php
                        $supported = old('supported_methods', $gateway->credentials['supported_methods'] ?? []);
                        if (! is_array($supported)) {
                            $supported = [];
                        }
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach (\Modules\Payment\Models\PaymentGateway::supportedPaymentMethods() as $method)
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                <input type="checkbox"
                                       name="supported_methods[]"
                                       value="{{ $method }}"
                                       {{ in_array($method, $supported, true) ? 'checked' : '' }}
                                       class="rounded border-border text-primary focus:ring-primary">
                                <span>
                                    @switch($method)
                                        @case('pix') PIX @break
                                        @case('credit_card') Cartão de Crédito @break
                                        @case('debit_card') Cartão de Débito @break
                                        @case('boleto') Boleto Bancário @break
                                        @default {{ ucfirst(str_replace('_', ' ', $method)) }}
                                    @endswitch
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Marque apenas as formas efetivamente configuradas neste provedor (conforme painel do gateway).
                    </p>
                    @error('supported_methods')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="environment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ambiente</label>
                    <select id="environment" name="environment" required
                            class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="sandbox" {{ old('environment', $gateway->environment) === 'sandbox' ? 'selected' : '' }}>Sandbox (Testes)</option>
                        <option value="production" {{ old('environment', $gateway->environment) === 'production' ? 'selected' : '' }}>Produção</option>
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $gateway->is_active) ? 'checked' : '' }}
                           class="rounded border-border text-primary focus:ring-primary">
                    <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Gateway ativo (disponível para clientes)</label>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                    <x-icon name="floppy-disk" style="solid" class="w-4 h-4" />
                    Salvar
                </button>
                <a href="{{ route('payment.admin.gateways.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('gateway-form').addEventListener('submit', function() {
            window.dispatchEvent(new CustomEvent('start-loading', { detail: { message: 'Salvando configurações...' } }));
        });
    </script>
</x-core::layouts.master>
