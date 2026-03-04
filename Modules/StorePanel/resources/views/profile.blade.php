<x-core::layouts.master heading="Meu Perfil (PDV)">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('admin.index') }}" class="hover:text-primary transition-colors">Dashboard</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <a href="{{ route('pdv.index') }}" class="hover:text-primary transition-colors">PDV</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Meu Perfil</span>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success dark:bg-success/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('pdv.profile.update') }}"
                  x-data="{ loading: false }"
                  x-on:submit="loading = true; window.dispatchEvent(new CustomEvent('start-loading'))">
                @csrf

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <img src="{{ $user->photo_url }}"
                                 alt="{{ $user->full_name ?? $user->email }}"
                                 class="h-20 w-20 rounded-full object-cover border-2 border-primary-500 shadow-sm">
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $user->full_name ?? $user->email }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Operador identificado em todo o PDV e relatórios internos.
                            </p>
                            <label class="inline-flex items-center gap-2 mt-1 cursor-pointer text-xs sm:text-sm font-medium text-primary-700 dark:text-primary-300">
                                <x-icon name="camera" style="duotone" class="w-4 h-4" />
                                <span>Alterar foto</span>
                                <input type="file"
                                       name="photo"
                                       accept="image/jpeg,image/png,image/webp"
                                       class="hidden">
                            </label>
                            @error('photo')
                                <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-border dark:border-border pt-4 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                            <input type="text"
                                   id="first_name"
                                   name="first_name"
                                   value="{{ old('first_name', $user->first_name) }}"
                                   required
                                   class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('first_name') border-danger @enderror"
                                   placeholder="Nome">
                            @error('first_name')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sobrenome</label>
                            <input type="text"
                                   id="last_name"
                                   name="last_name"
                                   value="{{ old('last_name', $user->last_name) }}"
                                   required
                                   class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('last_name') border-danger @enderror"
                                   placeholder="Sobrenome">
                            @error('last_name')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                        <input type="email"
                               id="email"
                               value="{{ $user->email }}"
                               disabled
                               class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-gray-100 dark:bg-gray-800 px-3 py-2 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">O e-mail não pode ser alterado por aqui.</p>
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone</label>
                        <input type="text"
                               id="phone"
                               name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               x-mask="'phone'"
                               class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-danger @enderror"
                               placeholder="(00) 00000-0000">
                        @error('phone')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-border dark:border-border">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Alterar senha</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Deixe em branco para manter a senha atual.</p>
                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nova senha</label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('password') border-danger @enderror"
                                       placeholder="••••••••">
                                @error('password')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar nova senha</label>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 font-medium text-white hover:opacity-90 transition-opacity">
                        <x-icon name="check" style="solid" class="w-4 h-4" />
                        Salvar alterações
                    </button>
                    <a href="{{ route('pdv.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                        Voltar ao PDV
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>

