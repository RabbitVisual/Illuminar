<x-core::layouts.master heading="Editar produto">
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('catalog.products.index') }}" class="hover:text-primary transition-colors">Produtos</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Editar</span>
        </div>

        <form method="POST" action="{{ route('catalog.products.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Informações Básicas --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
                        <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="circle-info" style="duotone" class="w-5 h-5" />
                            Informações Básicas
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $product->name) }}"
                                       required
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-danger @enderror"
                                       placeholder="Nome do produto">
                                @error('name')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="sku" class="block text-sm font-medium text-gray-700 dark:text-gray-300">SKU</label>
                                    <input type="text"
                                           id="sku"
                                           name="sku"
                                           value="{{ old('sku', $product->sku) }}"
                                           required
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('sku') border-danger @enderror"
                                           placeholder="Ex: LAMP-LED-001">
                                    @error('sku')
                                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="barcode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código de barras</label>
                                    <input type="text"
                                           id="barcode"
                                           name="barcode"
                                           value="{{ old('barcode', $product->barcode) }}"
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('barcode') border-danger @enderror"
                                           placeholder="7891234567890">
                                    @error('barcode')
                                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoria</label>
                                    <select id="category_id"
                                            name="category_id"
                                            class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('category_id') border-danger @enderror">
                                        <option value="">Selecione...</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                                    <select id="brand_id"
                                            name="brand_id"
                                            class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('brand_id') border-danger @enderror">
                                        <option value="">Selecione...</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                                <textarea id="description"
                                          name="description"
                                          rows="3"
                                          class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-danger @enderror"
                                          placeholder="Descrição do produto">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Ficha Técnica (Iluminação) --}}
                    <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
                        <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="lightbulb" style="duotone" class="w-5 h-5" />
                            Ficha Técnica (Iluminação)
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="voltage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Voltagem</label>
                                <select id="voltage"
                                        name="voltage"
                                        class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('voltage') border-danger @enderror">
                                    <option value="">Selecione...</option>
                                    <option value="Bivolt" {{ old('voltage', $product->voltage) == 'Bivolt' ? 'selected' : '' }}>Bivolt</option>
                                    <option value="110V" {{ old('voltage', $product->voltage) == '110V' ? 'selected' : '' }}>110V</option>
                                    <option value="220V" {{ old('voltage', $product->voltage) == '220V' ? 'selected' : '' }}>220V</option>
                                    <option value="12V" {{ old('voltage', $product->voltage) == '12V' ? 'selected' : '' }}>12V</option>
                                </select>
                                @error('voltage')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="power_watts" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Potência (W)</label>
                                <input type="number"
                                       id="power_watts"
                                       name="power_watts"
                                       value="{{ old('power_watts', $product->power_watts) }}"
                                       step="0.01"
                                       min="0"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('power_watts') border-danger @enderror"
                                       placeholder="Ex: 9.5">
                                @error('power_watts')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="lumens" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lúmens (lm)</label>
                                <input type="number"
                                       id="lumens"
                                       name="lumens"
                                       value="{{ old('lumens', $product->lumens) }}"
                                       min="0"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('lumens') border-danger @enderror"
                                       placeholder="Ex: 800">
                                @error('lumens')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="color_temperature_k" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Temperatura de cor (K)</label>
                                <select id="color_temperature_k"
                                        name="color_temperature_k"
                                        class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('color_temperature_k') border-danger @enderror">
                                    <option value="">Selecione...</option>
                                    <option value="2700" {{ old('color_temperature_k', $product->color_temperature_k) == '2700' ? 'selected' : '' }}>2700K (Quente)</option>
                                    <option value="3000" {{ old('color_temperature_k', $product->color_temperature_k) == '3000' ? 'selected' : '' }}>3000K</option>
                                    <option value="4000" {{ old('color_temperature_k', $product->color_temperature_k) == '4000' ? 'selected' : '' }}>4000K (Neutro)</option>
                                    <option value="5000" {{ old('color_temperature_k', $product->color_temperature_k) == '5000' ? 'selected' : '' }}>5000K</option>
                                    <option value="6000" {{ old('color_temperature_k', $product->color_temperature_k) == '6000' ? 'selected' : '' }}>6000K (Frio)</option>
                                    <option value="6500" {{ old('color_temperature_k', $product->color_temperature_k) == '6500' ? 'selected' : '' }}>6500K</option>
                                </select>
                                @error('color_temperature_k')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Preços (sidebar) --}}
                <div class="space-y-6">
                    <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
                        <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="money-bill" style="duotone" class="w-5 h-5" />
                            Preços
                        </h3>
                        @php
                            $costPriceFormatted = old('cost_price', $product->cost_price_formatted);
                            $priceFormatted = old('price', $product->price_formatted);
                        @endphp
                        <div class="space-y-4" x-data='{ costPrice: @js($costPriceFormatted), price: @js($priceFormatted) }'>
                            <div>
                                <label for="cost_price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preço de custo</label>
                                <input type="text"
                                       id="cost_price"
                                       name="cost_price"
                                       x-mask="'money'"
                                       x-model="costPrice"
                                       placeholder="R$ 0,00"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('cost_price') border-danger @enderror">
                                @error('cost_price')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preço de venda</label>
                                <input type="text"
                                       id="price"
                                       name="price"
                                       x-mask="'money'"
                                       x-model="price"
                                       placeholder="R$ 0,00"
                                       required
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('price') border-danger @enderror">
                                @error('price')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
                        <div class="flex items-center gap-2">
                            <input type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                   class="rounded border-border dark:border-border text-primary focus:ring-primary">
                            <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Produto ativo</label>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2 font-medium text-white hover:opacity-90 transition-opacity">
                            <x-icon name="check" style="solid" class="w-4 h-4" />
                            Atualizar
                        </button>
                        <a href="{{ route('catalog.products.index') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-core::layouts.master>
