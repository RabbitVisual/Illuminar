<x-core::layouts.auth-split title="Redefinir senha - Illuminar">
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/90 shadow-lg shadow-amber-500/5 p-6 sm:p-8">
        <div class="mb-6">
            <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Nova senha</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Defina uma nova senha para sua conta.</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', $email) }}"
                           required
                           autofocus
                           autocomplete="email"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:focus:ring-amber-400 @error('email') border-red-500 @enderror"
                           placeholder="seu@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nova senha</label>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           autocomplete="new-password"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:focus:ring-amber-400 @error('password') border-red-500 @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar senha</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:focus:ring-amber-400"
                           placeholder="••••••••">
                </div>
            </div>
            <div class="mt-6">
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 dark:from-amber-500 dark:to-amber-600 px-4 py-3 font-medium text-gray-900 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-300">
                    <x-icon name="key" style="solid" class="w-5 h-5" />
                    Redefinir senha
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-500">
            <a href="{{ route('login') }}" class="font-medium text-amber-600 dark:text-amber-400 hover:underline">Voltar ao login</a>
        </p>
    </div>
</x-core::layouts.auth-split>
