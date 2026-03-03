<x-core::layouts.master heading="Fornecedores">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white">Listagem de fornecedores</h2>
            <a href="{{ route('inventory.suppliers.create') }}"
               class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                <x-icon name="plus" style="solid" class="w-4 h-4" />
                Novo fornecedor
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success dark:bg-success/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-xl border border-border dark:border-border bg-white dark:bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border dark:divide-border">
                    <thead class="bg-gray-50 dark:bg-gray-800/50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Nome</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">CNPJ</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">E-mail</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Telefone</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Status</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border dark:divide-border bg-white dark:bg-surface">
                        @forelse ($suppliers as $supplier)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
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
            </div>
            @if ($suppliers->hasPages())
                <div class="border-t border-border dark:border-border px-4 py-3">
                    {{ $suppliers->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
