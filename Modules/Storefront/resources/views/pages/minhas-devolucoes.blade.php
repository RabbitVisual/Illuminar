<x-storefront::layouts.public>
<x-slot name="title">Minhas Devoluções</x-slot>
<x-slot name="description">Solicite a devolução ou troca de produtos Illuminar de forma simples e rápida.</x-slot>
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <a href="{{ route('storefront.page.atendimento') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Atendimento</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Minhas Devoluções</span>
    </nav>

    <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="arrow-rotate-left" style="duotone" class="w-7 h-7" />
        </span>
        Minhas Devoluções
    </h1>
    <p class="text-gray-600 dark:text-gray-400 text-lg mb-10 leading-relaxed">
        Precisa trocar ou devolver um produto? Tornamos o processo simples e sem complicações. Confira abaixo como solicitar.
    </p>

    {{-- Prazo destaque --}}
    <div class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-5 mb-10 flex items-start gap-4">
        <x-icon name="calendar-check" style="duotone" class="w-8 h-8 text-amber-500 shrink-0 mt-0.5" />
        <div>
            <p class="font-semibold text-gray-900 dark:text-white">Direito de arrependimento: 7 dias corridos</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                De acordo com o Código de Defesa do Consumidor (Art. 49 da Lei 8.078/90), você tem <strong>7 dias corridos</strong> a partir do recebimento do produto para solicitar a devolução por arrependimento, sem necessidade de justificativa.
            </p>
        </div>
    </div>

    {{-- Como solicitar --}}
    <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
        <x-icon name="list-check" style="duotone" class="w-5 h-5 text-amber-500" />
        Como solicitar devolução ou troca
    </h2>
    <div class="space-y-4 mb-10">
        @foreach([
            ['num' => '1', 'title' => 'Acesse sua conta', 'desc' => 'Faça login na sua conta Illuminar e acesse a seção "Meus Pedidos". Localize o pedido que contém o produto que deseja devolver ou trocar.'],
            ['num' => '2', 'title' => 'Selecione o produto e o motivo', 'desc' => 'Clique em "Solicitar Devolução/Troca" no pedido desejado, selecione o produto e informe o motivo (arrependimento, produto com defeito, produto errado, etc.).'],
            ['num' => '3', 'title' => 'Aguarde a aprovação', 'desc' => 'Nossa equipe analisará sua solicitação em até 2 dias úteis e enviará instruções de coleta ou orientação para entrega do produto por e-mail.'],
            ['num' => '4', 'title' => 'Embalagem e envio', 'desc' => 'Embale o produto adequadamente com todos os acessórios, manuais e nota fiscal. Siga as instruções recebidas por e-mail para envio ou coleta.'],
            ['num' => '5', 'title' => 'Reembolso ou troca', 'desc' => 'Após recebermos e inspecionarmos o produto, processaremos o reembolso ou enviaremos o produto substituto em até 5 dias úteis.'],
        ] as $step)
        <div class="flex items-start gap-4 rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-5 shadow-sm">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-500 text-sm font-bold text-gray-900">{{ $step['num'] }}</span>
            <div>
                <p class="font-medium text-gray-900 dark:text-white">{{ $step['title'] }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5 leading-relaxed">{{ $step['desc'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- CTA login ou painel --}}
    @auth
    <div class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6 flex flex-col sm:flex-row items-center gap-4">
        <div class="flex-1">
            <p class="font-semibold text-gray-900 dark:text-white">Pronto para solicitar?</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Acesse seus pedidos e inicie o processo de devolução ou troca agora mesmo.</p>
        </div>
        <a href="{{ route('customer.orders.index') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-2.5 text-sm font-medium text-gray-900 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30 transition-all duration-300 shrink-0">
            <x-icon name="boxes-stacked" style="duotone" class="w-4 h-4" />
            Ir para Meus Pedidos
        </a>
    </div>
    @else
    <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 text-center shadow-sm">
        <p class="text-gray-700 dark:text-gray-300 mb-4">Faça login para acessar seus pedidos e solicitar devoluções.</p>
        <a href="{{ route('login') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-2.5 text-sm font-medium text-gray-900 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30 transition-all duration-300">
            <x-icon name="right-to-bracket" style="solid" class="w-4 h-4" />
            Entrar na minha conta
        </a>
    </div>
    @endauth

    <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">
        Dúvidas sobre devoluções? <a href="{{ route('storefront.page.devolucoes-reembolsos') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Leia nossa política de devoluções e reembolsos →</a>
    </p>

</div>
</x-storefront::layouts.public>
