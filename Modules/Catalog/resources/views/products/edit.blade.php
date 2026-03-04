<x-core::layouts.master heading="Editar produto">
    <div class="max-w-4xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('catalog.products.index') }}" class="hover:text-primary transition-colors">Produtos</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Editar</span>
        </div>

        <form method="POST" action="{{ route('catalog.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Informações Básicas --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
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
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('name') border-red-500 @enderror"
                                       placeholder="Nome do produto">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
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
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('sku') border-red-500 @enderror"
                                           placeholder="Ex: LAMP-LED-001">
                                    @error('sku')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="barcode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código de barras</label>
                                    <input type="text"
                                           id="barcode"
                                           name="barcode"
                                           value="{{ old('barcode', $product->barcode) }}"
                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('barcode') border-red-500 @enderror"
                                           placeholder="7891234567890">
                                    @error('barcode')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Categoria</label>
                                    <select id="category_id"
                                            name="category_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('category_id') border-red-500 @enderror">
                                        <option value="">Selecione...</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="brand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
                                    <select id="brand_id"
                                            name="brand_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('brand_id') border-red-500 @enderror">
                                        <option value="">Selecione...</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                                <textarea id="description"
                                          name="description"
                                          rows="3"
                                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('description') border-red-500 @enderror"
                                          placeholder="Descrição do produto">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Foto principal do produto
                                </label>
                                @if($product->image_path)
                                    <div class="mb-3">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Imagem atual:</p>
                                        <img src="{{ asset('storage/'.$product->image_path) }}"
                                             alt="Imagem atual do produto"
                                             class="h-24 w-24 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                    </div>
                                @endif
                                <input type="file"
                                       id="image"
                                       name="image"
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('image') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Envie uma nova imagem para substituir a atual. Formatos JPG ou PNG, até 2MB.
                                </p>
                                @error('image')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gallery" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Galeria de imagens (opcional)
                                </label>
                                @if($product->images && $product->images->isNotEmpty())
                                    <div class="mb-3 grid grid-cols-3 sm:grid-cols-4 gap-3">
                                        @foreach($product->images as $image)
                                            <label class="group relative block">
                                                <input type="checkbox"
                                                       name="remove_images[]"
                                                       value="{{ $image->id }}"
                                                       class="absolute top-1.5 left-1.5 h-4 w-4 text-red-600 bg-white/90 border-gray-300 rounded focus:ring-red-500">
                                                <img src="{{ asset('storage/'.$image->path) }}"
                                                     alt="Imagem da galeria"
                                                     class="h-20 w-full object-cover rounded-lg border border-gray-200 dark:border-gray-700 group-hover:opacity-80">
                                            </label>
                                        @endforeach
                                    </div>
                                @endif
                                <input type="file"
                                       id="gallery"
                                       name="gallery[]"
                                       accept="image/*"
                                       multiple
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white @error('gallery.*') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    Adicione novas fotos ou marque as existentes acima para remover. Formatos JPG ou PNG, até 2MB por imagem.
                                </p>
                                @error('gallery.*')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Ficha Técnica (Iluminação) --}}
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <x-icon name="lightbulb" style="duotone" class="w-5 h-5" />
                            Ficha Técnica (Iluminação)
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="voltage" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Voltagem</label>
                                <select id="voltage"
                                        name="voltage"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('voltage') border-red-500 @enderror">
                                    <option value="">Selecione...</option>
                                    <option value="Bivolt" {{ old('voltage', $product->voltage) == 'Bivolt' ? 'selected' : '' }}>Bivolt</option>
                                    <option value="110V" {{ old('voltage', $product->voltage) == '110V' ? 'selected' : '' }}>110V</option>
                                    <option value="220V" {{ old('voltage', $product->voltage) == '220V' ? 'selected' : '' }}>220V</option>
                                    <option value="12V" {{ old('voltage', $product->voltage) == '12V' ? 'selected' : '' }}>12V</option>
                                </select>
                                @error('voltage')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
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
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('power_watts') border-red-500 @enderror"
                                       placeholder="Ex: 9.5">
                                @error('power_watts')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="lumens" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lúmens (lm)</label>
                                <input type="number"
                                       id="lumens"
                                       name="lumens"
                                       value="{{ old('lumens', $product->lumens) }}"
                                       min="0"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('lumens') border-red-500 @enderror"
                                       placeholder="Ex: 800">
                                @error('lumens')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="color_temperature_k" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Temperatura de cor (K)</label>
                                <select id="color_temperature_k"
                                        name="color_temperature_k"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('color_temperature_k') border-red-500 @enderror">
                                    <option value="">Selecione...</option>
                                    <option value="2700" {{ old('color_temperature_k', $product->color_temperature_k) == '2700' ? 'selected' : '' }}>2700K (Quente)</option>
                                    <option value="3000" {{ old('color_temperature_k', $product->color_temperature_k) == '3000' ? 'selected' : '' }}>3000K</option>
                                    <option value="4000" {{ old('color_temperature_k', $product->color_temperature_k) == '4000' ? 'selected' : '' }}>4000K (Neutro)</option>
                                    <option value="5000" {{ old('color_temperature_k', $product->color_temperature_k) == '5000' ? 'selected' : '' }}>5000K</option>
                                    <option value="6000" {{ old('color_temperature_k', $product->color_temperature_k) == '6000' ? 'selected' : '' }}>6000K (Frio)</option>
                                    <option value="6500" {{ old('color_temperature_k', $product->color_temperature_k) == '6500' ? 'selected' : '' }}>6500K</option>
                                </select>
                                @error('color_temperature_k')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Preços (sidebar) --}}
                <div class="space-y-6">
                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
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
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('cost_price') border-red-500 @enderror">
                                @error('cost_price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
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
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('price') border-red-500 @enderror">
                                @error('price')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <input type="checkbox"
                                   id="is_active"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Produto ativo</label>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            <x-icon name="check" style="solid" class="w-4 h-4" />
                            Atualizar
                        </button>
                        <a href="{{ route('catalog.products.index') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-lg rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-core::layouts.master>
