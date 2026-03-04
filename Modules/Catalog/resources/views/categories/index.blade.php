<x-core::layouts.master heading="Categorias">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white">Listagem de categorias</h2>
            <a href="{{ route('catalog.categories.create') }}"
               class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                <x-icon name="plus" style="solid" class="w-4 h-4" />
                Nova categoria
            </a>
        </div>

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Nome</th>
                        <th scope="col" class="px-4 py-3">Categoria pai</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                        <th scope="col" class="px-4 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $category->name }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $category->parent?->name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' }}">
                                        {{ $category->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('catalog.categories.edit', $category) }}"
                                           class="rounded-lg p-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                                           aria-label="Editar">
                                            <x-icon name="pen" style="solid" class="w-4 h-4" />
                                        </a>
                                        <form action="{{ route('catalog.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente excluir esta categoria?');">
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
                                <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Nenhuma categoria cadastrada.
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
            @if ($categories->hasPages())
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
