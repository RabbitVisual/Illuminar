<x-core::layouts.master heading="Papéis e permissões">
    <div class="space-y-6">
        <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white">Papéis do sistema</h2>

        @if (session('success'))
            <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success dark:bg-success/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Papel</th>
                        <th scope="col" class="px-4 py-3">Usuários</th>
                        <th scope="col" class="px-4 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $role->name }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $role->users_count }} usuário(s)</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('role.edit', $role) }}"
                                       class="inline-flex items-center gap-2 rounded-lg border border-primary-600 px-3 py-1.5 text-sm font-medium text-primary-700 hover:bg-primary-700 hover:text-white dark:text-primary-300 dark:hover:bg-primary-600">
                                        <x-icon name="key" style="solid" class="w-4 h-4" />
                                        Editar permissões
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Nenhum papel cadastrado. Execute o seeder RolesAndPermissionsSeeder.
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-core::layouts.master>
