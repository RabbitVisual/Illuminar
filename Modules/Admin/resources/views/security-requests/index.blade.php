<x-core::layouts.master heading="Solicitações de Conta">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Pedidos de recuperação de senha (e-mail ou CPF) e cadastros de novos clientes.
            </p>
            <form method="GET" action="{{ route('admin.security-requests.index') }}" class="flex flex-wrap gap-2">
                <select name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="">Todos os tipos</option>
                    <option value="password_reset_email" {{ request('type') === 'password_reset_email' ? 'selected' : '' }}>Recuperação (e-mail)</option>
                    <option value="password_reset_cpf" {{ request('type') === 'password_reset_cpf' ? 'selected' : '' }}>Recuperação (CPF)</option>
                    <option value="registration" {{ request('type') === 'registration' ? 'selected' : '' }}>Cadastro</option>
                </select>
                <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="">Todos os status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluído</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expirado</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Falhou</option>
                </select>
                <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    Filtrar
                </button>
            </form>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3">Data</th>
                        <th scope="col" class="px-4 py-3">Tipo</th>
                        <th scope="col" class="px-4 py-3">E-mail / CPF</th>
                        <th scope="col" class="px-4 py-3">IP</th>
                        <th scope="col" class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $req)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                    {{ $req->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ \Modules\Core\Models\SecurityRequest::typeLabel($req->type) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    @if ($req->email)
                                        {{ $req->email }}
                                    @elseif ($req->cpf)
                                        {{ $req->masked_cpf }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $req->ip_address ?? '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium
                                        @if ($req->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                        @elseif ($req->status === 'failed') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                        @elseif ($req->status === 'expired') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                        @endif">
                                        {{ \Modules\Core\Models\SecurityRequest::statusLabel($req->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Nenhuma solicitação encontrada.
                                </td>
                            </tr>
                        @endforelse
                </tbody>
            </table>
            @if ($requests->hasPages())
                <div class="px-4 py-3 border-t border-border dark:border-border">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
