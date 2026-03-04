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

            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 space-y-4">
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Assunto do e-mail</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject', $emailTemplate->subject) }}" required
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    @error('subject')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Corpo do e-mail (Markdown e variáveis permitidos)</label>
                    <textarea id="body" name="body" rows="12" required
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 font-mono text-sm">{{ old('body', $emailTemplate->body) }}</textarea>
                    @error('body')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $emailTemplate->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    Template ativo (e-mails serão enviados)
                </label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    Salvar template
                </button>
                <a href="{{ route('admin.notification.templates.index') }}"
                   class="rounded-lg border border-gray-300 px-6 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:border-gray-600">
                    Voltar
                </a>
            </div>
        </form>
    </div>
</x-core::layouts.master>
