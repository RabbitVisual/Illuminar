<x-core::layouts.master heading="Gateways de Pagamento">
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ Route::has('admin.index') ? route('admin.index') : url('/core') }}" class="hover:text-primary transition-colors">Dashboard</a>
                <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Gateways de Pagamento</span>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 px-4 py-3 text-sm text-green-700 dark:text-green-300 flex items-center gap-2">
                <x-icon name="circle-check" style="solid" class="w-5 h-5 shrink-0" />
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="rounded-xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 px-4 py-3 text-sm text-red-700 dark:text-red-300 flex items-center gap-2">
                <x-icon name="circle-exclamation" style="solid" class="w-5 h-5 shrink-0" />
                {{ session('error') }}
            </div>
        @endif

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <x-icon name="credit-card" style="duotone" class="w-5 h-5" />
                Provedores Configurados
            </h2>

            <div class="space-y-4">
                @forelse ($gateways as $gateway)
                    <div class="flex items-center justify-between gap-4 rounded-lg border border-border dark:border-border p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                                <x-icon name="credit-card" style="duotone" class="w-6 h-6" />
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $gateway->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $gateway->provider_label }} · {{ $gateway->environment_label }}
                                    @if ($gateway->is_active)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-green-100 dark:bg-green-900/30 px-2 py-0.5 text-xs font-medium text-green-700 dark:text-green-300 ml-2">
                                            <x-icon name="circle-check" style="solid" class="w-3 h-3" /> Ativo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-700 px-2 py-0.5 text-xs font-medium text-gray-600 dark:text-gray-400 ml-2">Inativo</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('payment.admin.gateways.edit', $gateway) }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-primary px-4 py-2 text-sm font-medium text-primary hover:bg-primary hover:text-white transition-colors">
                            <x-icon name="pen" style="solid" class="w-4 h-4" />
                            Configurar
                        </a>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 py-8 text-center">Nenhum gateway configurado. Adicione um provedor abaixo.</p>
                @endforelse
            </div>

            <div class="mt-6 pt-6 border-t border-border dark:border-border">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-3">Adicionar Provedor</h3>
                <form method="POST" action="{{ route('payment.admin.gateways.store') }}" class="flex flex-wrap items-end gap-4">
                    @csrf
                    <div>
                        <label for="provider" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Provedor</label>
                        <select id="provider" name="provider" required
                                class="rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                            @foreach ($providers as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="environment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ambiente</label>
                        <select id="environment" name="environment" required
                                class="rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="sandbox">Sandbox (Testes)</option>
                            <option value="production">Produção</option>
                        </select>
                    </div>
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                        <x-icon name="plus" style="solid" class="w-4 h-4" />
                        Adicionar
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-core::layouts.master>
