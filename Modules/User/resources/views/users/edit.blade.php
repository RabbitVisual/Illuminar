<x-core::layouts.master heading="Editar usuário">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('user.index') }}" class="hover:text-primary transition-colors">Usuários</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Editar</span>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <form method="POST" action="{{ route('user.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                            <input type="text"
                                   id="first_name"
                                   name="first_name"
                                   value="{{ old('first_name', $user->first_name) }}"
                                   required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('first_name') border-red-500 @enderror"
                                   placeholder="Nome">
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sobrenome</label>
                            <input type="text"
                                   id="last_name"
                                   name="last_name"
                                   value="{{ old('last_name', $user->last_name) }}"
                                   required
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('last_name') border-red-500 @enderror"
                                   placeholder="Sobrenome">
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('email') border-red-500 @enderror"
                               placeholder="email@exemplo.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nova senha <span class="text-gray-500">(deixe em branco para manter)</span></label>
                        <input type="password"
                               id="password"
                               name="password"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('password') border-red-500 @enderror"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar nova senha</label>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               placeholder="••••••••">
                    </div>

                    @php
                        $cpfValue = old('cpf', $user->cpf ?? $user->document ?? '');
                        $cpfFormatted = strlen($cpfValue) === 11 ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpfValue) : $cpfValue;
                        $phoneValue = old('phone', $user->phone ?? '');
                        $phoneFormatted = strlen($phoneValue) === 11 ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $phoneValue) : (strlen($phoneValue) === 10 ? preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $phoneValue) : $phoneValue);
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ cpf: '{{ $cpfFormatted }}', phone: '{{ $phoneFormatted }}' }">
                        <div>
                            <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CPF</label>
                            <input type="text"
                                   id="cpf"
                                   name="cpf"
                                   x-mask="'cpf'"
                                   x-model="cpf"
                                   placeholder="000.000.000-00"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('cpf') border-red-500 @enderror">
                            @error('cpf')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone</label>
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   x-mask="'phone'"
                                   x-model="phone"
                                   placeholder="(00) 00000-0000"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Papel</label>
                        <select id="role_id"
                                name="role_id"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('role_id') border-red-500 @enderror">
                            <option value="">Selecione...</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->roles->first()?->id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <x-icon name="check" style="solid" class="w-4 h-4" />
                        Atualizar
                    </button>
                    <a href="{{ route('user.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
