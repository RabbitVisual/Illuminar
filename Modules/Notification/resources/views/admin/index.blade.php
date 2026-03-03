<x-core::layouts.master heading="E-mails Automáticos">
    <div class="max-w-4xl space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 px-4 py-3 text-sm text-green-700 dark:text-green-300 flex items-center gap-2">
                <x-icon name="circle-check" style="solid" class="w-5 h-5 shrink-0" />
                {{ session('success') }}
            </div>
        @endif

        <p class="text-sm text-gray-600 dark:text-gray-400">
            Gerencie os templates de e-mail enviados automaticamente quando um pagamento é aprovado ou quando um pedido é enviado. Use as variáveis mágicas no assunto e no corpo para personalizar as mensagens.
        </p>

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Template</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Assunto</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase text-gray-600 dark:text-gray-400">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($templates as $template)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    @if ($template->mailable_class === 'payment_approved')
                                        Pagamento aprovado
                                    @elseif ($template->mailable_class === 'order_shipped')
                                        Pedido enviado
                                    @else
                                        {{ $template->mailable_class }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 max-w-xs truncate" title="{{ $template->subject }}">
                                    {{ Str::limit($template->subject, 50) }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($template->is_active)
                                        <span class="rounded-full bg-green-100 dark:bg-green-900/30 px-2 py-0.5 text-xs font-medium text-green-700 dark:text-green-300">Ativo</span>
                                    @else
                                        <span class="rounded-full bg-gray-100 dark:bg-gray-700 px-2 py-0.5 text-xs font-medium text-gray-600 dark:text-gray-400">Inativo</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.notification.templates.edit', $template) }}"
                                       class="inline-flex items-center gap-1.5 rounded-lg border border-border dark:border-border px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                        <x-icon name="pen" style="solid" class="w-4 h-4" />
                                        Editar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    Nenhum template cadastrado. Execute o seeder: <code class="text-xs bg-gray-100 dark:bg-gray-800 px-1 rounded">php artisan db:seed --class=Modules\\Notification\\Database\\Seeders\\NotificationTemplateSeeder</code>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-core::layouts.master>
