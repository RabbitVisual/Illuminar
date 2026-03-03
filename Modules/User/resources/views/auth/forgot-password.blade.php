<x-core::layouts.auth-split title="Esqueci a senha - Illuminar">
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/90 shadow-lg shadow-amber-500/5 p-6 sm:p-8">
        <div class="mb-6">
            <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Recuperar senha</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Informe seu e-mail e enviaremos um link para redefinir sua senha.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-xl bg-emerald-500/10 dark:bg-emerald-400/10 border border-emerald-500/20 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        @include('user::auth.partials.recaptcha')
        <form method="POST" action="{{ route('password.email') }}" data-recaptcha-action="forgot_password">
            @csrf
            @include('user::auth.partials.recaptcha-input')
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                       class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('email') border-red-500 @enderror"
                       placeholder="seu@email.com">
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
            <div class="mt-6">
                <button type="submit" class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 font-medium text-gray-900 shadow-lg shadow-amber-500/20">
                    <x-icon name="envelope" style="solid" class="w-5 h-5" />
                    Enviar link de recuperação
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
            Lembrou a senha? <a href="{{ route('login') }}" class="font-medium text-amber-600 dark:text-amber-400 hover:underline">Voltar ao login</a>
        </p>
        <p class="mt-2 text-center text-sm text-gray-500">
            Recuperar por <a href="{{ route('password.request.cpf') }}" class="font-medium text-amber-600 dark:text-amber-400 hover:underline">CPF e data de nascimento</a>
        </p>
    </div>
</x-core::layouts.auth-split>
