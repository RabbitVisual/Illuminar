<x-core::layouts.master heading="Novo fornecedor">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('inventory.suppliers.index') }}" class="hover:text-primary transition-colors">Fornecedores</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Novo</span>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <form method="POST" action="{{ route('inventory.suppliers.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') border-red-500 @enderror"
                               placeholder="Razão social">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ cnpj: @js(old('cnpj', '')) }">
                        <label for="cnpj" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CNPJ</label>
                        <input type="text"
                               id="cnpj"
                               name="cnpj"
                               x-mask="'cnpj'"
                               x-model="cnpj"
                               placeholder="00.000.000/0000-00"
                               required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('cnpj') border-red-500 @enderror">
                        @error('cnpj')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('email') border-red-500 @enderror"
                               placeholder="contato@fornecedor.com">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ phone: @js(old('phone', '')) }">
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone</label>
                        <input type="text"
                               id="phone"
                               name="phone"
                               x-mask="'phone'"
                               x-model="phone"
                               placeholder="(00) 00000-0000"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Endereço</label>
                        <textarea id="address"
                                  name="address"
                                  rows="3"
                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('address') border-red-500 @enderror"
                                  placeholder="Endereço completo">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox"
                               id="is_active"
                               name="is_active"
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">Ativo</label>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <x-icon name="check" style="solid" class="w-4 h-4" />
                        Salvar
                    </button>
                    <a href="{{ route('inventory.suppliers.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
