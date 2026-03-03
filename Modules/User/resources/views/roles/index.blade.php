<x-core::layouts.master heading="Papéis e permissões">
    <div class="space-y-6">
        <h2 class="font-display text-xl font-semibold text-gray-900 dark:text-white">Papéis do sistema</h2>

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
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Papel</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Usuários</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-600 dark:text-gray-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border dark:divide-border bg-white dark:bg-surface">
                        @forelse ($roles as $role)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $role->name }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $role->users_count }} usuário(s)</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('role.edit', $role) }}"
                                       class="inline-flex items-center gap-2 rounded-lg px-3 py-1.5 text-sm font-medium text-primary hover:bg-primary/10 transition-colors">
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
    </div>
</x-core::layouts.master>
