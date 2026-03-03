<x-core::layouts.master heading="Configurações de Segurança">
    <div class="max-w-2xl space-y-6">
        @if (session('success'))
            <div class="rounded-xl bg-green-500/10 dark:bg-green-400/10 border border-green-500/20 px-4 py-3 text-sm text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.settings.security.update') }}">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm space-y-6">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="robot" style="duotone" class="w-5 h-5" />
                    reCAPTCHA v3
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Proteja login, cadastro e recuperação de senha contra bots. Obtenha as chaves em
                    <a href="https://www.google.com/recaptcha/admin" target="_blank" rel="noopener" class="text-primary hover:underline">Google reCAPTCHA</a>.
                </p>
                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="recaptcha_enabled" value="1" {{ $recaptchaEnabled ? 'checked' : '' }}
                           class="rounded border-border text-primary focus:ring-primary">
                    Habilitar reCAPTCHA v3 em login, cadastro e esqueci senha
                </label>
                <div>
                    <label for="recaptcha_v3_site_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site Key (pública)</label>
                    <input type="text" id="recaptcha_v3_site_key" name="recaptcha_v3_site_key" value="{{ old('recaptcha_v3_site_key', $recaptchaSiteKey) }}"
                           class="block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary"
                           placeholder="6Lc...">
                </div>
                <div>
                    <label for="recaptcha_v3_secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Secret Key</label>
                    <input type="password" id="recaptcha_v3_secret_key" name="recaptcha_v3_secret_key"
                           class="block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary"
                           placeholder="Deixe em branco para manter a atual">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Não exibimos a chave atual por segurança. Preencha apenas para alterar.</p>
                </div>
            </div>

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm space-y-6 mt-6">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="shield-halved" style="duotone" class="w-5 h-5" />
                    Autenticação em duas etapas (2FA)
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Quando habilitado, o sistema poderá exigir um segundo fator de autenticação (implementação futura).
                </p>
                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="two_factor_enabled" value="1" {{ $twoFactorEnabled ? 'checked' : '' }}
                           class="rounded border-border text-primary focus:ring-primary">
                    Habilitar 2FA (preparação para uso futuro)
                </label>
            </div>

            <div class="mt-6">
                <button type="submit" class="rounded-lg bg-primary px-6 py-2.5 font-medium text-white hover:opacity-90 focus:ring-2 focus:ring-primary focus:ring-offset-2">
                    Salvar configurações
                </button>
            </div>
        </form>
    </div>
</x-core::layouts.master>
