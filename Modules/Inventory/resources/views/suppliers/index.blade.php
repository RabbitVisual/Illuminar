<x-core::layouts.master heading="Fornecedores">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white">Listagem de fornecedores</h2>
            <a href="{{ route('inventory.suppliers.create') }}"
               class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                <x-icon name="plus" style="solid" class="w-4 h-4" />
                Novo fornecedor
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success dark:bg-success/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Nome</th>
                        <th scope="col" class="px-4 py-3">CNPJ</th>
                        <th scope="col" class="px-4 py-3">E-mail</th>
                        <th scope="col" class="px-4 py-3">Telefone</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $supplier)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $supplier->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ preg_match('/^\d{14}$/', $supplier->cnpj) ? preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $supplier->cnpj) : $supplier->cnpj }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $supplier->email ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    @if ($supplier->phone)
                                        {{ strlen($supplier->phone) === 11 ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $supplier->phone) : (strlen($supplier->phone) === 10 ? preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $supplier->phone) : $supplier->phone) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $supplier->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $supplier->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('inventory.suppliers.edit', $supplier) }}"
                                           class="rounded-lg p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                           aria-label="Editar">
                                            <x-icon name="pen" style="solid" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('inventory.suppliers.destroy', $supplier) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente excluir este fornecedor?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="rounded-lg p-2 text-danger hover:bg-danger/10 transition-colors"
                                                    aria-label="Excluir">
                                                <x-icon name="trash" style="solid" class="w-4 h-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Nenhum fornecedor cadastrado.
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
            @if ($suppliers->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
