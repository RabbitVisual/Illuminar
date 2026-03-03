<x-storefront::layouts.public>
<x-slot name="title">Formas de Pagamento e Entrega</x-slot>
<x-slot name="description">Conheça todas as formas de pagamento e opções de entrega disponíveis na Illuminar para todo o Brasil.</x-slot>
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Formas de Pagamento e Entrega</span>
    </nav>

    <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="credit-card" style="duotone" class="w-7 h-7" />
        </span>
        Pagamento e Entrega
    </h1>
    <p class="text-gray-600 dark:text-gray-400 text-lg mb-10">Oferecemos diversas opções de pagamento seguras e entregamos em todo o Brasil.</p>

    {{-- Pagamento --}}
    <section class="mb-12">
        <h2 class="font-display text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                <x-icon name="money-bill" style="duotone" class="w-5 h-5" />
            </span>
            Formas de Pagamento
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

            <div class="storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-500/10 text-green-600 dark:text-green-400">
                        <x-icon name="mobile-screen" style="duotone" class="w-5 h-5" />
                    </div>
                    <h3 class="font-display font-semibold text-gray-900 dark:text-white">PIX</h3>
                    <span class="ml-auto rounded-full bg-green-500/10 px-2 py-0.5 text-xs font-medium text-green-700 dark:text-green-400">Recomendado</span>
                </div>
                <ul class="space-y-1.5 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-green-500 shrink-0" /> Aprovação instantânea</li>
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-green-500 shrink-0" /> Sem taxa adicional</li>
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-green-500 shrink-0" /> Pedido processado imediatamente</li>
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-green-500 shrink-0" /> Disponível 24h, 7 dias por semana</li>
                </ul>
            </div>

            <div class="storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                        <x-icon name="credit-card" style="duotone" class="w-5 h-5" />
                    </div>
                    <h3 class="font-display font-semibold text-gray-900 dark:text-white">Cartão de Crédito</h3>
                </div>
                <ul class="space-y-1.5 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-amber-500 shrink-0" /> Parcelamento em até 12x*</li>
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-amber-500 shrink-0" /> Visa, Mastercard, Elo, Amex</li>
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-amber-500 shrink-0" /> Ambiente seguro com criptografia</li>
                    <li class="flex items-start gap-2"><x-icon name="circle-info" style="solid" class="w-3.5 h-3.5 text-gray-400 shrink-0 mt-0.5" /> <span class="text-xs text-gray-500 dark:text-gray-400">*Juros aplicados em parcelas acima de 3x. Consulte as condições no checkout.</span></li>
                </ul>
            </div>

            <div class="storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                        <x-icon name="credit-card" style="duotone" class="w-5 h-5" />
                    </div>
                    <h3 class="font-display font-semibold text-gray-900 dark:text-white">Cartão de Débito</h3>
                </div>
                <ul class="space-y-1.5 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-amber-500 shrink-0" /> Débito à vista</li>
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-amber-500 shrink-0" /> Aprovação imediata</li>
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-amber-500 shrink-0" /> Visa, Mastercard, Elo</li>
                </ul>
            </div>

            <div class="storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                        <x-icon name="file-lines" style="duotone" class="w-5 h-5" />
                    </div>
                    <h3 class="font-display font-semibold text-gray-900 dark:text-white">Boleto Bancário</h3>
                </div>
                <ul class="space-y-1.5 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-amber-500 shrink-0" /> Pagamento à vista</li>
                    <li class="flex items-center gap-2"><x-icon name="clock" style="solid" class="w-3.5 h-3.5 text-gray-400 shrink-0" /> Compensação em 1-2 dias úteis</li>
                    <li class="flex items-center gap-2"><x-icon name="check" style="solid" class="w-3.5 h-3.5 text-amber-500 shrink-0" /> Validade de 3 dias corridos</li>
                </ul>
            </div>

        </div>

        <div class="mt-6 rounded-xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-4 flex items-start gap-3">
            <x-icon name="lock" style="duotone" class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" />
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <strong class="text-gray-900 dark:text-white">Segurança garantida.</strong> Todas as transações são processadas com criptografia SSL de 256 bits. Seus dados financeiros nunca são armazenados em nossos servidores.
            </p>
        </div>
    </section>

    {{-- Entrega --}}
    <section class="mb-12">
        <h2 class="font-display text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                <x-icon name="truck-fast" style="duotone" class="w-5 h-5" />
            </span>
            Entrega e Frete
        </h2>

        <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm mb-6">
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                Entregamos em todo o Brasil por meio de transportadoras parceiras. O valor e o prazo do frete são calculados automaticamente no carrinho ao informar o seu CEP, antes de finalizar a compra.
            </p>

            <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4">Prazos estimados por região</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-2 pr-4 font-medium text-gray-700 dark:text-gray-300">Região</th>
                            <th class="text-left py-2 pr-4 font-medium text-gray-700 dark:text-gray-300">Prazo (dias úteis)</th>
                            <th class="text-left py-2 font-medium text-gray-700 dark:text-gray-300">Observação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @foreach([
                            ['Sul e Sudeste', '3 a 5 dias úteis', 'Capitais em até 3 dias'],
                            ['Centro-Oeste', '5 a 7 dias úteis', 'Capitais em até 5 dias'],
                            ['Nordeste', '5 a 8 dias úteis', 'Varia por estado'],
                            ['Norte', '7 a 12 dias úteis', 'Área remota pode variar'],
                        ] as $r)
                        <tr>
                            <td class="py-2.5 pr-4 text-gray-900 dark:text-white font-medium">{{ $r[0] }}</td>
                            <td class="py-2.5 pr-4 text-gray-600 dark:text-gray-400">{{ $r[1] }}</td>
                            <td class="py-2.5 text-gray-500 dark:text-gray-400 text-xs">{{ $r[2] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">* Os prazos acima são estimativas e contam a partir da confirmação do pagamento. Podem variar em períodos de alta demanda (Black Friday, Natal, etc.).</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach([
                ['icon' => 'magnifying-glass', 'title' => 'Rastreamento', 'desc' => 'Acompanhe seu pedido em tempo real pelo link enviado por e-mail após o despacho.'],
                ['icon' => 'box', 'title' => 'Embalagem', 'desc' => 'Embalamos os produtos com cuidado para garantir que cheguem em perfeito estado.'],
                ['icon' => 'shield-check', 'title' => 'Seguro de Entrega', 'desc' => 'Todos os pedidos possuem seguro de transporte incluído no valor do frete.'],
            ] as $c)
            <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-5 shadow-sm text-center">
                <x-icon name="{{ $c['icon'] }}" style="duotone" class="w-8 h-8 mx-auto mb-3 text-amber-500" />
                <p class="font-medium text-gray-900 dark:text-white mb-1">{{ $c['title'] }}</p>
                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $c['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
        Dúvidas sobre pagamento ou entrega? <a href="{{ route('storefront.page.fale-conosco') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Fale conosco →</a>
    </p>

</div>
</x-storefront::layouts.public>
