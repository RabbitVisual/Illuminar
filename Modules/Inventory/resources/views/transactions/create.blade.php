<x-core::layouts.master heading="Nova movimentação">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('inventory.transactions.index') }}" class="hover:text-primary transition-colors">Kardex</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Nova movimentação</span>
        </div>

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm" x-data='{ transactionType: @js(old('type', 'in')), unitCost: @js(old('unit_cost', '')) }'>
            <form method="POST" action="{{ route('inventory.transactions.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Produto</label>
                        <select id="product_id"
                                name="product_id"
                                required
                                class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('product_id') border-danger @enderror">
                            <option value="">Selecione o produto...</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->sku }}) - Estoque: {{ $product->stock ?? 0 }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de movimentação</label>
                        <select id="type"
                                name="type"
                                required
                                x-model="transactionType"
                                class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('type') border-danger @enderror">
                            <option value="in" {{ old('type', 'in') == 'in' ? 'selected' : '' }}>Entrada</option>
                            <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Saída</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="supplier_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fornecedor <span class="text-gray-500">(opcional, para entradas)</span></label>
                        <select id="supplier_id"
                                name="supplier_id"
                                class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('supplier_id') border-danger @enderror">
                            <option value="">Nenhum</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
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
                               class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('quantity') border-danger @enderror"
                               placeholder="Ex: 10">
                        @error('quantity')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
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
                               class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('unit_cost') border-danger @enderror">
                        @error('unit_cost')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descrição</label>
                        <input type="text"
                               id="description"
                               name="description"
                               value="{{ old('description') }}"
                               class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('description') border-danger @enderror"
                               placeholder="Ex: Nota Fiscal 123, Avaria, Devolução">
                        @error('description')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 font-medium text-white hover:opacity-90 transition-opacity">
                        <x-icon name="check" style="solid" class="w-4 h-4" />
                        Registrar
                    </button>
                    <a href="{{ route('inventory.transactions.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
