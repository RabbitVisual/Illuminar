<x-core::layouts.master heading="Início">
    <div class="max-w-3xl space-y-8">
        <div>
            <h2 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Bem-vindo ao Illuminar</h2>
            <p class="mt-1 text-gray-600 dark:text-gray-400">Sistema corporativo de E-commerce e PDV. Use os atalhos abaixo para acessar as áreas do sistema.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @hasanyrole('SuperAdmin|Owner|Manager|Cashier')
                @if (Route::has('admin.index'))
                    <a href="{{ route('admin.index') }}"
                       class="flex flex-col gap-3 rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-md transition-all">
                        <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
                            <x-icon name="chart-pie" style="duotone" class="w-6 h-6" />
                        </span>
                        <div>
                            <h3 class="font-display font-semibold text-gray-900 dark:text-white">Dashboard</h3>
                            <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">Gráficos, pedidos e relatórios</p>
                        </div>
                    </a>
                @endif
            @endhasanyrole

            @hasanyrole('SuperAdmin|Owner|Manager|Cashier')
                @if (Route::has('pdv.index'))
                    <a href="{{ route('pdv.index') }}"
                       class="flex flex-col gap-3 rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-md transition-all">
                        <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
                            <x-icon name="cash-register" style="duotone" class="w-6 h-6" />
                        </span>
                        <div>
                            <h3 class="font-display font-semibold text-gray-900 dark:text-white">Abrir PDV</h3>
                            <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">Ponto de venda presencial</p>
                        </div>
                    </a>
                @endif
            @endhasanyrole

            @if (Route::has('storefront.index'))
                <a href="{{ route('storefront.index') }}"
                   target="_blank"
                   rel="noopener"
                   class="flex flex-col gap-3 rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm hover:border-primary/50 dark:hover:border-primary/50 hover:shadow-md transition-all">
                    <span class="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10 dark:bg-primary/20 text-primary">
                        <x-icon name="store" style="duotone" class="w-6 h-6" />
                    </span>
                    <div>
                        <h3 class="font-display font-semibold text-gray-900 dark:text-white">Ver Loja</h3>
                        <p class="mt-0.5 text-sm text-gray-600 dark:text-gray-400">Abrir vitrine em nova aba</p>
                    </div>
                </a>
            @endif
        </div>
    </div>
</x-core::layouts.master>
