<x-core::layouts.master heading="Solicitações de Conta">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Pedidos de recuperação de senha (e-mail ou CPF) e cadastros de novos clientes.
            </p>
            <form method="GET" action="{{ route('admin.security-requests.index') }}" class="flex flex-wrap gap-2">
                <select name="type" class="rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary">
                    <option value="">Todos os tipos</option>
                    <option value="password_reset_email" {{ request('type') === 'password_reset_email' ? 'selected' : '' }}>Recuperação (e-mail)</option>
                    <option value="password_reset_cpf" {{ request('type') === 'password_reset_cpf' ? 'selected' : '' }}>Recuperação (CPF)</option>
                    <option value="registration" {{ request('type') === 'registration' ? 'selected' : '' }}>Cadastro</option>
                </select>
                <select name="status" class="rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary">
                    <option value="">Todos os status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendente</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Concluído</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expirado</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Falhou</option>
                </select>
                <button type="submit" class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:opacity-90">
                    Filtrar
                </button>
            </form>
        </div>

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800/80">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-400">Data</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-400">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-400">E-mail / CPF</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-400">IP</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-gray-400">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($requests as $req)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30">
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
            </div>
            @if ($requests->hasPages())
                <div class="px-4 py-3 border-t border-border dark:border-border">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</x-core::layouts.master>
