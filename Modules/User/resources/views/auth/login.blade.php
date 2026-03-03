<x-core::layouts.auth-split title="Login - Illuminar">
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/90 shadow-lg shadow-amber-500/5 p-6 sm:p-8"
         x-data="{ tab: 'email' }">
        <div class="mb-6">
            <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Entrar</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Use seu e-mail ou CPF para acessar sua conta.</p>
        </div>

        {{-- Abas E-mail / CPF --}}
        <div class="flex rounded-lg border border-gray-200 dark:border-gray-600 p-1 mb-6 bg-gray-50 dark:bg-gray-700/50">
            <button type="button"
                    @click="tab = 'email'"
                    :class="tab === 'email' ? 'bg-white dark:bg-gray-800 text-amber-600 dark:text-amber-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'"
                    class="flex-1 flex items-center justify-center gap-2 rounded-md py-2.5 text-sm font-medium transition-colors">
                <x-icon name="envelope" style="solid" class="w-4 h-4" />
                E-mail
            </button>
            <button type="button"
                    @click="tab = 'cpf'"
                    :class="tab === 'cpf' ? 'bg-white dark:bg-gray-800 text-amber-600 dark:text-amber-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white'"
                    class="flex-1 flex items-center justify-center gap-2 rounded-md py-2.5 text-sm font-medium transition-colors">
                <x-icon name="id-card" style="solid" class="w-4 h-4" />
                CPF
            </button>
        </div>

        @include('user::auth.partials.recaptcha')
        <form method="POST" action="{{ route('login') }}" id="login-form" data-recaptcha-action="login">
            @csrf
            @include('user::auth.partials.recaptcha-input')
            <input type="hidden" name="login_type" x-model="tab">

            {{-- Aba E-mail --}}
            <div x-show="tab === 'email'" x-cloak class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           autocomplete="email"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:focus:ring-amber-400 @error('email') border-red-500 @enderror"
                           placeholder="seu@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Aba CPF --}}
            <div x-show="tab === 'cpf'" x-cloak class="space-y-4" style="display: none;">
                <div>
                    <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CPF</label>
                    <input type="text"
                           id="cpf"
                           name="cpf"
                           value="{{ old('cpf') }}"
                           x-mask="'999.999.999-99'"
                           maxlength="14"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:focus:ring-amber-400 @error('cpf') border-red-500 @enderror"
                           placeholder="000.000.000-00">
                    @error('cpf')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Senha (comum às duas abas) --}}
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Senha</label>
                <input type="password"
                       id="password"
                       name="password"
                       autocomplete="current-password"
                       class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-amber-500 focus:border-transparent dark:focus:ring-amber-400 @error('password') border-red-500 @enderror"
                       placeholder="••••••••">
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-4 flex items-center justify-between">
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <input type="checkbox"
                           name="remember"
                           class="rounded border-gray-300 dark:border-gray-600 text-amber-500 focus:ring-amber-500 dark:focus:ring-amber-400">
                    Lembrar-me
                </label>
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:underline">
                    Esqueceu a senha?
                </a>
            </div>

            <div class="mt-6">
                <button type="submit"
                        class="w-full flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 dark:from-amber-500 dark:to-amber-600 px-4 py-3 font-medium text-gray-900 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-300">
                    <x-icon name="right-to-bracket" style="solid" class="w-5 h-5" />
                    Entrar
                </button>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
            Ainda não tem conta?
            <a href="{{ route('register') }}" class="font-medium text-amber-600 dark:text-amber-400 hover:underline">Cadastre-se</a>
        </p>
    </div>
</x-core::layouts.auth-split>
