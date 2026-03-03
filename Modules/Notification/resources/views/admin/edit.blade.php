<x-core::layouts.master heading="Editar template de e-mail">
    <div class="max-w-3xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('admin.notification.templates.index') }}" class="hover:text-primary transition-colors">E-mails Automáticos</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">
                @if ($emailTemplate->mailable_class === 'payment_approved')
                    Pagamento aprovado
                @elseif ($emailTemplate->mailable_class === 'order_shipped')
                    Pedido enviado
                @else
                    {{ $emailTemplate->mailable_class }}
                @endif
            </span>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/20 px-4 py-3 text-sm text-green-700 dark:text-green-300 flex items-center gap-2">
                <x-icon name="circle-check" style="solid" class="w-5 h-5 shrink-0" />
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20 px-4 py-3 text-sm text-amber-800 dark:text-amber-200">
            <p class="font-medium mb-1">Variáveis mágicas (use no assunto e no corpo):</p>
            <ul class="list-disc list-inside space-y-0.5 text-amber-700 dark:text-amber-300">
                @foreach ($placeholders as $key => $label)
                    <li><code class="bg-amber-100 dark:bg-amber-900/40 px-1 rounded">{!! '{' . $key . '}' !!}</code> — {{ $label }}</li>
                @endforeach
            </ul>
        </div>

        <form method="POST" action="{{ route('admin.notification.templates.update', $emailTemplate) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm space-y-4">
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assunto do e-mail</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject', $emailTemplate->subject) }}" required
                           class="block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Corpo do e-mail (Markdown e variáveis permitidos)</label>
                    <textarea id="body" name="body" rows="12" required
                              class="block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary font-mono text-sm">{{ old('body', $emailTemplate->body) }}</textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $emailTemplate->is_active) ? 'checked' : '' }}
                           class="rounded border-border text-primary focus:ring-primary">
                    Template ativo (e-mails serão enviados)
                </label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="rounded-lg bg-primary px-6 py-2.5 font-medium text-white hover:opacity-90 focus:ring-2 focus:ring-primary focus:ring-offset-2">
                    Salvar template
                </button>
                <a href="{{ route('admin.notification.templates.index') }}"
                   class="rounded-lg border border-border dark:border-border px-6 py-2.5 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</x-core::layouts.master>
