<x-core::layouts.master heading="Editar fornecedor">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('inventory.suppliers.index') }}" class="hover:text-primary transition-colors">Fornecedores</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Editar</span>
        </div>

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
            <form method="POST" action="{{ route('inventory.suppliers.update', $supplier) }}">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name', $supplier->name) }}"
                               required
                               class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-danger @enderror"
                               placeholder="Razão social">
                        @error('name')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    @php
                        $cnpjFormatted = old('cnpj');
                        if ($cnpjFormatted === null && preg_match('/^\d{14}$/', $supplier->cnpj ?? '')) {
                            $cnpjFormatted = preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $supplier->cnpj);
                        }
                        $cnpjFormatted = $cnpjFormatted ?? '';
                        $phoneFormatted = old('phone');
                        if ($phoneFormatted === null && $supplier->phone) {
                            $phoneFormatted = strlen($supplier->phone) === 11 ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $supplier->phone) : (strlen($supplier->phone) === 10 ? preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $supplier->phone) : $supplier->phone);
                        }
                        $phoneFormatted = $phoneFormatted ?? '';
                    @endphp
                    <div x-data='{ cnpj: @js($cnpjFormatted) }'>
                        <label for="cnpj" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CNPJ</label>
                        <input type="text"
                               id="cnpj"
                               name="cnpj"
                               x-mask="'cnpj'"
                               x-model="cnpj"
                               placeholder="00.000.000/0000-00"
                               required
                               class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('cnpj') border-danger @enderror">
                        @error('cnpj')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email', $supplier->email) }}"
                               class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-danger @enderror"
                               placeholder="contato@fornecedor.com">
                        @error('email')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data='{ phone: @js($phoneFormatted) }'>
                        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone</label>
                        <input type="text"
                               id="phone"
                               name="phone"
                               x-mask="'phone'"
                               x-model="phone"
                               placeholder="(00) 00000-0000"
                               class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-danger @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Endereço</label>
                        <textarea id="address"
                                  name="address"
                                  rows="3"
                                  class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('address') border-danger @enderror"
                                  placeholder="Endereço completo">{{ old('address', $supplier->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox"
                               id="is_active"
                               name="is_active"
                               value="1"
                               {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}
                               class="rounded border-border dark:border-border text-primary focus:ring-primary">
                        <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">Ativo</label>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 font-medium text-white hover:opacity-90 transition-opacity">
                        <x-icon name="check" style="solid" class="w-4 h-4" />
                        Atualizar
                    </button>
                    <a href="{{ route('inventory.suppliers.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
