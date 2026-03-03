<x-core::layouts.master heading="Editar Método de Entrega">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('shipping.methods.index') }}" class="hover:text-primary transition-colors">Métodos de Entrega</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">{{ $method->name }}</span>
        </div>

        @php
            $coverageData = $method->coverage_data ?? [];
            $coverageCities = old('coverage_cities', is_array($coverageData) ? implode(', ', $coverageData) : '');
            $coverageStates = old('coverage_states', is_array($coverageData) ? implode(', ', $coverageData) : '');
            $coverageZipRanges = old('coverage_zip_ranges', is_array($coverageData) ? implode(', ', $coverageData) : '');
        @endphp

        <form method="POST" action="{{ route('shipping.methods.update', $method) }}" id="shipping-form"
              x-data="{
                  coverageType: '{{ old('coverage_type', $method->coverage_type) }}',
                  methodType: '{{ old('type', $method->type) }}'
              }"
              x-init="$watch('coverageType', val => coverageType = val); $watch('methodType', val => methodType = val)">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm space-y-6">
                <h3 class="font-display font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="truck-fast" style="duotone" class="w-5 h-5" />
                    Dados do Método
                </h3>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $method->name) }}" required
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
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
                            <option value="{{ $key }}" {{ $method->type === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div x-data='{ basePrice: @js(old("base_price", $method->base_price_formatted)) }'>
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
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('base_price')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="delivery_time_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Prazo de Entrega (dias úteis)</label>
                    <input type="number" id="delivery_time_days" name="delivery_time_days" value="{{ old('delivery_time_days', $method->delivery_time_days) }}" min="1" max="90" required
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
                            <option value="{{ $key }}" {{ $method->coverage_type === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div x-show="coverageType === 'cities'" x-cloak>
                    <label for="coverage_cities" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cidades (separadas por vírgula)</label>
                    <textarea id="coverage_cities" name="coverage_cities" rows="4"
                              class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">{{ $coverageCities }}</textarea>
                </div>

                <div x-show="coverageType === 'state'" x-cloak>
                    <label for="coverage_states" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estados (UF, separados por vírgula)</label>
                    <input type="text" id="coverage_states" name="coverage_states" value="{{ $coverageStates }}"
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div x-show="coverageType === 'zip_codes'" x-cloak>
                    <label for="coverage_zip_ranges" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Faixas de CEP (separadas por vírgula)</label>
                    <input type="text" id="coverage_zip_ranges" name="coverage_zip_ranges" value="{{ $coverageZipRanges }}"
                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent">
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $method->is_active) ? 'checked' : '' }}
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
