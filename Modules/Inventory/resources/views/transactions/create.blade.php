<x-core::layouts.master heading="Nova movimentação">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('inventory.transactions.index') }}" class="hover:text-primary transition-colors">Kardex</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Nova movimentação</span>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700" x-data='{ transactionType: @js(old('type', 'in')), unitCost: @js(old('unit_cost', '')) }'>
            <form method="POST" action="{{ route('inventory.transactions.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produto</label>
                        <select id="product_id"
                                name="product_id"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('product_id') border-red-500 @enderror">
                            <option value="">Selecione o produto...</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->sku }}) - Estoque: {{ $product->stock ?? 0 }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                            Tipo de movimentação
                            <span data-tooltip-target="tooltip-type" class="cursor-help">
                                <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-gray-400" />
                            </span>
                        </label>
                        <div id="tooltip-type" role="tooltip" class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Entrada: adiciona ao estoque. Saída: remove do estoque (venda, avaria, etc.).
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <select id="type"
                                name="type"
                                required
                                x-model="transactionType"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('type') border-red-500 @enderror">
                            <option value="in" {{ old('type', 'in') == 'in' ? 'selected' : '' }}>Entrada</option>
                            <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Saída</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fornecedor <span class="text-gray-500">(opcional, para entradas)</span></label>
                        <select id="supplier_id"
                                name="supplier_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('supplier_id') border-red-500 @enderror">
                            <option value="">Nenhum</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantidade</label>
                        <input type="number"
                               id="quantity"
                               name="quantity"
                               value="{{ old('quantity') }}"
                               required
                               min="1"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('quantity') border-red-500 @enderror"
                               placeholder="Ex: 10">
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-show="transactionType === 'in'">
                        <label for="unit_cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Custo unitário <span class="text-gray-500">(para entradas)</span></label>
                        <input type="text"
                               id="unit_cost"
                               name="unit_cost"
                               x-mask="'money'"
                               x-model="unitCost"
                               placeholder="R$ 0,00"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('unit_cost') border-red-500 @enderror">
                        @error('unit_cost')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                        <input type="text"
                               id="description"
                               name="description"
                               value="{{ old('description') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 @error('description') border-red-500 @enderror"
                               placeholder="Ex: Nota Fiscal 123, Avaria, Devolução">
                        @error('description')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <x-icon name="check" style="solid" class="w-4 h-4" />
                        Registrar
                    </button>
                    <a href="{{ route('inventory.transactions.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
