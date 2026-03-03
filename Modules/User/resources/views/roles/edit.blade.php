<x-core::layouts.master heading="Editar permissões">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('role.index') }}" class="hover:text-primary transition-colors">Papéis</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">{{ $role->name }}</span>
        </div>

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
            <form method="POST" action="{{ route('role.update', $role) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <h3 class="font-display text-lg font-semibold text-gray-900 dark:text-white">Permissões do papel {{ $role->name }}</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Marque as permissões que este papel deve possuir.</p>
                </div>

                @if ($permissions->isEmpty())
                    <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma permissão cadastrada no sistema. Crie permissões via Spatie ou seeders.</p>
                @else
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @foreach ($permissions as $permission)
                            <label class="flex items-center gap-3 rounded-lg px-3 py-2 hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer">
                                <input type="checkbox"
                                       name="permissions[]"
                                       value="{{ $permission->name }}"
                                       {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}
                                       class="rounded border-border dark:border-border text-primary focus:ring-primary">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 font-medium text-white hover:opacity-90 transition-opacity">
                        <x-icon name="check" style="solid" class="w-4 h-4" />
                        Salvar permissões
                    </button>
                    <a href="{{ route('role.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
