<x-core::layouts.master heading="Editar permissões">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('role.index') }}" class="hover:text-primary transition-colors">Papéis</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">{{ $role->name }}</span>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
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
                                       class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                            </label>
                        @endforeach
                    </div>
                @endif

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                        <x-icon name="check" style="solid" class="w-4 h-4" />
                        Salvar permissões
                    </button>
                    <a href="{{ route('role.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
