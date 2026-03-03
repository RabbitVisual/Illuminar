<x-core::layouts.auth title="Login Illuminar">
    <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-lg">
        <div class="mb-6 text-center">
            <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Illuminar</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Entre com suas credenciais</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="email"
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-danger @enderror"
                           placeholder="seu@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Senha</label>
                    <input type="password"
                           id="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-transparent @error('password') border-danger @enderror"
                           placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox"
                           id="remember"
                           name="remember"
                           class="rounded border-border dark:border-border text-primary focus:ring-primary">
                    <label for="remember" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Lembrar-me</label>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 font-medium text-white hover:opacity-90 transition-opacity focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-surface">
                    <x-icon name="right-to-bracket" style="solid" class="w-5 h-5" />
                    Entrar
                </button>
            </div>
        </form>
    </div>
</x-core::layouts.auth>
