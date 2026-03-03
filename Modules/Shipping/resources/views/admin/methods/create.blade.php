<x-core::layouts.master heading="Novo Método de Entrega">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('shipping.methods.index') }}" class="hover:text-primary transition-colors">Métodos de Entrega</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Novo</span>
        </div>

        <form method="POST" action="{{ route('shipping.methods.store') }}" id="shipping-form"
              x-data="{
                  coverageType: '{{ old('coverage_type', 'national') }}',
                  methodType: '{{ old('type', 'correios') }}'
              }"
              x-init="$watch('coverageType', val => coverageType = val); $watch('methodType', val => methodType = val)">
            @csrf

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm space-y-6">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="truck-fast" style="duotone" class="w-5 h-5" />
                    Dados do Método
                </h3>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent"
                           placeholder="Ex: SEDEX, Motoboy Local">
                    @error('name')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo</label>
                    <select id="type" name="type" required
                            x-model="methodType"
                            class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                        @foreach (\Modules\Shipping\Models\ShippingMethod::types() as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div x-data='{ basePrice: @js(old("base_price", "R$ 0,00")) }'>
                    <label for="base_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Preço Base (R$) <span class="text-danger">*</span>
                        <template x-if="methodType === 'motoboy'">
                            <span class="text-amber-600 dark:text-amber-400 text-xs">Obrigatório para Motoboy</span>
                        </template>
                    </label>
                    <input type="text" id="base_price" name="base_price"
                           x-mask="'money'"
                           x-model="basePrice"
                           required
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent"
                           placeholder="R$ 0,00">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">O frete nunca é gratuito por padrão. Informe o valor mínimo.</p>
                    @error('base_price')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="delivery_time_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prazo de Entrega (dias úteis)</label>
                    <input type="number" id="delivery_time_days" name="delivery_time_days" value="{{ old('delivery_time_days', 5) }}" min="1" max="90" required
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('delivery_time_days')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="coverage_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Cobertura</label>
                    <select id="coverage_type" name="coverage_type" required
                            x-model="coverageType"
                            class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                        @foreach (\Modules\Shipping\Models\ShippingMethod::coverageTypes() as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div x-show="coverageType === 'cities'" x-cloak>
                    <label for="coverage_cities" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cidades (separadas por vírgula)</label>
                    <textarea id="coverage_cities" name="coverage_cities" rows="4"
                              class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent"
                              placeholder="Feira de Santana, Salvador, Camaçari, Lauro de Freitas">{{ old('coverage_cities') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Digite os nomes das cidades onde este método está disponível.</p>
                </div>

                <div x-show="coverageType === 'state'" x-cloak>
                    <label for="coverage_states" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estados (UF, separados por vírgula)</label>
                    <input type="text" id="coverage_states" name="coverage_states" value="{{ old('coverage_states') }}"
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent"
                           placeholder="BA, SP, RJ">
                </div>

                <div x-show="coverageType === 'zip_codes'" x-cloak>
                    <label for="coverage_zip_ranges" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Faixas de CEP (separadas por vírgula)</label>
                    <input type="text" id="coverage_zip_ranges" name="coverage_zip_ranges" value="{{ old('coverage_zip_ranges') }}"
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent"
                           placeholder="40000-40999, 41000-41999">
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                           class="rounded border-border text-primary focus:ring-primary">
                    <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Método ativo</label>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-4">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-primary px-6 py-2.5 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                    <x-icon name="floppy-disk" style="solid" class="w-4 h-4" />
                    Salvar
                </button>
                <a href="{{ route('shipping.methods.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-core::layouts.master>
