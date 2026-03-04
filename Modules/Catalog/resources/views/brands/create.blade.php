<x-core::layouts.master heading="Nova marca">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('catalog.brands.index') }}" class="hover:text-primary transition-colors">Marcas</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Nova</span>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <form method="POST" action="{{ route('catalog.brands.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') border-red-500 @enderror"
                               placeholder="Ex: Philips, Osram">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                            Logo (URL)
                            <span data-tooltip-target="tooltip-logo" class="cursor-help">
                                <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                            </span>
                        </label>
                        <div id="tooltip-logo" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            URL da imagem do logo da marca (ex: https://exemplo.com/logo.png).
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <input type="text"
                               id="logo"
                               name="logo"
                               value="{{ old('logo') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('logo') border-red-500 @enderror"
                               placeholder="https://...">
                        @error('logo')
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
                    <a href="{{ route('catalog.brands.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
