<x-core::layouts.master heading="Módulo Core">
    <div class="space-y-8">
        <div>
            <h2 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Illuminar</h2>
            <p class="mt-1 text-gray-600 dark:text-gray-400">Sistema corporativo modular — E-commerce e PDV. Esta é a página de validação do Módulo Core.</p>
        </div>

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm max-w-2xl">
            <h3 class="font-display text-lg font-semibold text-gray-900 dark:text-white mb-4">Validação de componentes</h3>
            <ul class="space-y-3 text-gray-700 dark:text-gray-300">
                <li class="flex items-center gap-3">
                    <x-icon name="check" style="solid" class="text-success shrink-0" />
                    <span>Layout mestre com sidebar e topbar</span>
                </li>
                <li class="flex items-center gap-3">
                    <x-icon name="check" style="solid" class="text-success shrink-0" />
                    <span>Dark mode (toggle na sidebar ou topbar)</span>
                </li>
                <li class="flex items-center gap-3">
                    <x-icon name="check" style="solid" class="text-success shrink-0" />
                    <span>Componente <code class="px-1.5 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-sm">&lt;x-icon&gt;</code> (Font Awesome Pro)</span>
                </li>
                <li class="flex items-center gap-3">
                    <x-icon name="check" style="solid" class="text-success shrink-0" />
                    <span>Tipografia Inter (UI) e Poppins (títulos)</span>
                </li>
            </ul>

            <div class="mt-6 pt-6 border-t border-border dark:border-border space-y-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">Testar loading overlay (ação &gt; 3s):</p>
                <button type="button"
                        @click="window.dispatchEvent(new CustomEvent('start-loading', { detail: { message: 'Processando...', icon: 'lightbulb' } })); setTimeout(() => window.dispatchEvent(new CustomEvent('stop-loading')), 3500)"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary dark:bg-primary text-white font-medium hover:opacity-90 transition-opacity">
                    <x-icon name="spinner" style="solid" class="fa-spin" />
                    Disparar loading (3,5s)
                </button>
            </div>

            <div class="mt-6 pt-6 border-t border-border dark:border-border space-y-2" x-data="{ cpf: '' }">
                <label for="test-cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Máscara CPF (x-mask):</label>
                <input type="text"
                       id="test-cpf"
                       x-mask="'cpf'"
                       x-model="cpf"
                       placeholder="000.000.000-00"
                       class="w-full max-w-xs rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
        </div>
    </div>
</x-core::layouts.master>
