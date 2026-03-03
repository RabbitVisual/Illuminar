<x-core::layouts.auth-split title="Recuperar senha por CPF - Illuminar">
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/90 shadow-lg shadow-amber-500/5 p-6 sm:p-8">
        <div class="mb-6">
            <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Recuperar senha</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Informe CPF e data de nascimento. Enviaremos um link para o e-mail cadastrado.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-xl bg-emerald-500/10 dark:bg-emerald-400/10 border border-emerald-500/20 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        @include('user::auth.partials.recaptcha')
        <form method="POST" action="{{ route('password.email.cpf') }}" data-recaptcha-action="forgot_password_cpf">
            @csrf
            @include('user::auth.partials.recaptcha-input')
            <div class="space-y-4">
                <div>
                    <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CPF</label>
                    <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" required autofocus x-mask="'999.999.999-99'" maxlength="14"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('cpf') border-red-500 @enderror"
                           placeholder="000.000.000-00">
                    @error('cpf')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de nascimento</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('birth_date') border-red-500 @enderror">
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 font-medium text-gray-900 shadow-lg shadow-amber-500/20">
                    <x-icon name="key" style="solid" class="w-5 h-5" />
                    Enviar link de recuperação
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('password.request') }}" class="font-medium text-amber-600 dark:text-amber-400 hover:underline">Recuperar por e-mail</a>
        </p>
        <p class="mt-2 text-center text-sm text-gray-500">
            <a href="{{ route('login') }}" class="font-medium text-amber-600 dark:text-amber-400 hover:underline">Voltar ao login</a>
        </p>
    </div>
</x-core::layouts.auth-split>
