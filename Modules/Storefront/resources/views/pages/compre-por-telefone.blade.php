<x-storefront::layouts.public>
<x-slot name="title">Compre por Telefone</x-slot>
<x-slot name="description">Compre produtos Illuminar por telefone. Atendimento personalizado com consultores especializados em iluminação.</x-slot>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <a href="{{ route('storefront.page.atendimento') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Atendimento</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Compre por Telefone</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
        <div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                    <x-icon name="phone" style="duotone" class="w-7 h-7" />
                </span>
                Compre por Telefone
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg mb-8 leading-relaxed">
                Prefere comprar pelo telefone? Nossa equipe de consultores especializados está pronta para ajudá-lo a encontrar os produtos ideais e finalizar seu pedido com toda segurança e praticidade.
            </p>

            {{-- Números de telefone --}}
            <div class="space-y-4 mb-10">
                <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-5 flex items-center gap-4 shadow-sm">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                        <x-icon name="phone" style="duotone" class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Central de Vendas</p>
                        <a href="tel:0000000000" class="text-xl font-bold text-amber-600 dark:text-amber-400 hover:underline">(00) 0000-0000</a>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Seg–Sex: 08h às 18h | Sáb: 08h às 13h</p>
                    </div>
                </div>
                <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-5 flex items-center gap-4 shadow-sm">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-green-500/10 dark:bg-green-400/10 text-green-600 dark:text-green-400">
                        <x-icon name="whatsapp" style="brands" class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">WhatsApp Comercial</p>
                        <a href="https://wa.me/5500000000000" target="_blank" rel="noopener noreferrer" class="text-xl font-bold text-green-600 dark:text-green-400 hover:underline">(00) 00000-0000</a>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Atendimento por mensagem</p>
                    </div>
                </div>
            </div>

            {{-- Como funciona --}}
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-5 flex items-center gap-2">
                <x-icon name="list-check" style="duotone" class="w-5 h-5 text-amber-500" />
                Como funciona
            </h2>
            <ol class="space-y-4">
                <li class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-500 text-sm font-bold text-gray-900">1</span>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Ligue ou envie mensagem</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Entre em contato pelos números acima em nosso horário de atendimento.</p>
                    </div>
                </li>
                <li class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-500 text-sm font-bold text-gray-900">2</span>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Informe os produtos desejados</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Diga o código, nome do produto ou descreva o que precisa. Nossa equipe ajudará a identificar o item correto.</p>
                    </div>
                </li>
                <li class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-500 text-sm font-bold text-gray-900">3</span>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Receba seu orçamento</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">O consultor preparará um orçamento detalhado com preços e condições.</p>
                    </div>
                </li>
                <li class="flex items-start gap-4">
                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-500 text-sm font-bold text-gray-900">4</span>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Finalize seu pedido</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Escolha a forma de pagamento e confirme o endereço de entrega. Simples assim!</p>
                    </div>
                </li>
            </ol>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6 sm:p-8">
                <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="shield-check" style="duotone" class="w-5 h-5 text-amber-500" />
                    Vantagens de comprar por telefone
                </h2>
                <ul class="space-y-3">
                    @foreach([
                        ['icon' => 'user-tie', 'text' => 'Atendimento personalizado com consultores especializados em iluminação'],
                        ['icon' => 'lightbulb', 'text' => 'Indicação técnica do produto mais adequado para sua necessidade'],
                        ['icon' => 'tag', 'text' => 'Possibilidade de condições especiais para pedidos de maior volume'],
                        ['icon' => 'clock', 'text' => 'Agilidade no processo de compra sem precisar navegar pelo site'],
                        ['icon' => 'shield-check', 'text' => 'Segurança total no processamento do seu pedido e pagamento'],
                    ] as $item)
                    <li class="flex items-start gap-3">
                        <x-icon name="{{ $item['icon'] }}" style="duotone" class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" />
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $item['text'] }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm">
                <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="credit-card" style="duotone" class="w-5 h-5 text-amber-500" />
                    Formas de pagamento aceitas
                </h2>
                <div class="flex flex-wrap gap-2">
                    @foreach(['PIX', 'Cartão de Crédito', 'Cartão de Débito', 'Boleto Bancário'] as $metodo)
                    <span class="inline-flex items-center rounded-lg bg-gray-100 dark:bg-gray-700 px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-300">
                        {{ $metodo }}
                    </span>
                    @endforeach
                </div>
                <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">
                    <a href="{{ route('storefront.page.formas-pagamento-entrega') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Ver detalhes sobre pagamento e entrega →</a>
                </p>
            </div>
        </div>
    </div>

</div>
</x-storefront::layouts.public>
