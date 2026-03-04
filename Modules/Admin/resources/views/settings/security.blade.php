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

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 space-y-6">
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
                           class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    Habilitar reCAPTCHA v3 em login, cadastro e esqueci senha
                </label>
                <div>
                    <label for="recaptcha_v3_site_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site Key (pública)</label>
                    <input type="text" id="recaptcha_v3_site_key" name="recaptcha_v3_site_key" value="{{ old('recaptcha_v3_site_key', $recaptchaSiteKey) }}"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           placeholder="6Lc...">
                </div>
                <div>
                    <label for="recaptcha_v3_secret_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                        Secret Key
                        <span data-tooltip-target="tooltip-secret-key" class="cursor-help">
                            <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                        </span>
                    </label>
                    <div id="tooltip-secret-key" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Chave privada do reCAPTCHA. Mantenha em sigilo e preencha apenas para alterar.
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <input type="password" id="recaptcha_v3_secret_key" name="recaptcha_v3_secret_key"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                           placeholder="Deixe em branco para manter a atual">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Não exibimos a chave atual por segurança. Preencha apenas para alterar.</p>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 space-y-6 mt-6">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="shield-halved" style="duotone" class="w-5 h-5" />
                    Autenticação em duas etapas (2FA)
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Quando habilitado, o sistema poderá exigir um segundo fator de autenticação (implementação futura).
                </p>
                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="checkbox" name="two_factor_enabled" value="1" {{ $twoFactorEnabled ? 'checked' : '' }}
                           class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    Habilitar 2FA (preparação para uso futuro)
                </label>
            </div>

            <div class="mt-6">
                <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    Salvar configurações
                </button>
            </div>
        </form>
    </div>
</x-core::layouts.master>
