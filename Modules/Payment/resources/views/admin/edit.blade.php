<x-core::layouts.master heading="Configurar Gateway">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('payment.admin.gateways.index') }}" class="hover:text-primary transition-colors">Gateways</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">{{ $gateway->name }}</span>
        </div>

        <form method="POST" action="{{ route('payment.admin.gateways.update', $gateway) }}" id="gateway-form">
            @csrf

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 space-y-6">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="key" style="duotone" class="w-5 h-5" />
                    Credenciais
                </h3>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome de exibição</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $gateway->name) }}" required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') border-red-500 @enderror"
                           placeholder="Ex: Mercado Pago Produção">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="public_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Chave Pública (Public Key)</label>
                    <input type="text" id="public_key" name="public_key" value="{{ old('public_key', $gateway->credentials['public_key'] ?? '') }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('public_key') border-red-500 @enderror"
                           placeholder="Cole a chave pública aqui">
                    @error('public_key')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                        Chave Secreta (Secret Key)
                        <span data-tooltip-target="tooltip-secret-key" class="cursor-help">
                            <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                        </span>
                    </label>
                    <div id="tooltip-secret-key" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Chave privada do gateway. Mantenha em sigilo. Deixe em branco para não alterar.
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <input type="password" id="secret_key" name="secret_key" value="{{ old('secret_key', $gateway->credentials['secret_key'] ?? '') }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('secret_key') border-red-500 @enderror"
                           placeholder="Cole a chave secreta aqui (deixe em branco para manter)">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Deixe em branco para não alterar a chave atual.</p>
                    @error('secret_key')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="webhook_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                        URL do Webhook (opcional)
                        <span data-tooltip-target="tooltip-webhook" class="cursor-help">
                            <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                        </span>
                    </label>
                    <div id="tooltip-webhook" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        URL configurada no painel do provedor para receber notificações de pagamento.
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <input type="url" id="webhook_url" name="webhook_url" value="{{ old('webhook_url', $gateway->credentials['webhook_url'] ?? '') }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('webhook_url') border-red-500 @enderror"
                           placeholder="https://sualoja.com/webhook/pagamento">
                    @error('webhook_url')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
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
                                       class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
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
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="environment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ambiente</label>
                    <select id="environment" name="environment" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <option value="sandbox" {{ old('environment', $gateway->environment) === 'sandbox' ? 'selected' : '' }}>Sandbox (Testes)</option>
                        <option value="production" {{ old('environment', $gateway->environment) === 'production' ? 'selected' : '' }}>Produção</option>
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $gateway->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Gateway ativo (disponível para clientes)</label>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <button type="submit"
                        class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    <x-icon name="floppy-disk" style="solid" class="w-4 h-4" />
                    Salvar
                </button>
                <a href="{{ route('payment.admin.gateways.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
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
