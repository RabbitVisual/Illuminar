<x-storefront::layouts.public>
<x-slot name="title">Atendimento Corporativo</x-slot>
<x-slot name="description">Soluções de iluminação para empresas. Orçamentos especiais, atendimento B2B e condições exclusivas para CNPJ.</x-slot>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <a href="{{ route('storefront.page.atendimento') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Atendimento</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Atendimento Corporativo</span>
    </nav>

    {{-- Hero corporativo --}}
    <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden border border-amber-500/20 dark:border-amber-400/25 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm shadow-lg shadow-amber-500/5 p-8 md:p-12 mb-12">
        <div class="storefront-hero-glow absolute inset-0 pointer-events-none"></div>
        <div class="absolute top-6 right-10 opacity-15 dark:opacity-20 pointer-events-none">
            <x-icon name="building" style="duotone" class="w-28 h-28 text-amber-500 animate-float" />
        </div>
        <div class="relative max-w-2xl">
            <div class="inline-flex items-center gap-2 rounded-full bg-amber-500/15 dark:bg-amber-400/15 border border-amber-500/20 dark:border-amber-400/20 px-4 py-1.5 text-sm font-medium text-amber-700 dark:text-amber-300 mb-4">
                <x-icon name="bolt" style="duotone" class="w-4 h-4" />
                Soluções para Empresas
            </div>
            <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Atendimento Corporativo</h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                Oferecemos condições exclusivas para empresas, construtoras, administradoras de condomínios, escritórios de projetos e profissionais da área elétrica. Tenha acesso a orçamentos personalizados, prazos especiais e uma equipe dedicada ao seu negócio.
            </p>
            <a href="{{ route('storefront.page.fale-conosco') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3 text-base font-medium text-gray-900 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30 hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                <x-icon name="envelope" style="duotone" class="w-5 h-5" />
                Solicitar Atendimento B2B
            </a>
        </div>
    </div>

    {{-- Vantagens --}}
    <h2 class="font-display text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="star" style="duotone" class="w-5 h-5" />
        </span>
        Vantagens para sua empresa
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-12">
        @foreach([
            ['icon' => 'file-invoice', 'title' => 'Nota Fiscal Eletrônica', 'desc' => 'Emissão de NF-e para pessoa jurídica em todas as compras, facilitando a gestão contábil e fiscal da sua empresa.'],
            ['icon' => 'percent', 'title' => 'Condições Especiais', 'desc' => 'Descontos progressivos conforme o volume de compras. Quanto mais você compra, mais economiza.'],
            ['icon' => 'users', 'title' => 'Gerente de Contas', 'desc' => 'Um consultor exclusivo dedicado ao seu negócio para agilizar pedidos e garantir o melhor atendimento.'],
            ['icon' => 'truck-fast', 'title' => 'Entrega Programada', 'desc' => 'Planeje suas entregas com antecedência e garanta que os materiais cheguem no prazo certo para sua obra ou projeto.'],
            ['icon' => 'boxes-stacked', 'title' => 'Orçamentos em Massa', 'desc' => 'Envie sua lista de materiais e receba um orçamento completo e personalizado em poucas horas.'],
            ['icon' => 'file-contract', 'title' => 'Contratos de Fornecimento', 'desc' => 'Estabeleça contratos de fornecimento contínuo com preços fixos e prioridade no estoque.'],
        ] as $card)
        <div class="storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400 mb-4">
                <x-icon name="{{ $card['icon'] }}" style="duotone" class="w-6 h-6" />
            </div>
            <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-2">{{ $card['title'] }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $card['desc'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Segmentos atendidos --}}
    <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm mb-10">
        <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <x-icon name="industry" style="duotone" class="w-5 h-5 text-amber-500" />
            Segmentos que atendemos
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach([
                'Construtoras', 'Incorporadoras', 'Escritórios de Arquitetura', 'Escritórios de Engenharia',
                'Administradoras de Condomínios', 'Hotéis e Pousadas', 'Estabelecimentos Comerciais',
                'Escolas e Faculdades', 'Hospitais e Clínicas', 'Indústrias', 'Prefeituras e Órgãos Públicos', 'Outros'
            ] as $segmento)
            <div class="flex items-center gap-2 rounded-lg bg-gray-50 dark:bg-gray-700/50 px-3 py-2">
                <x-icon name="check" style="solid" class="w-3.5 h-3.5 text-amber-500 shrink-0" />
                <span class="text-sm text-gray-700 dark:text-gray-300">{{ $segmento }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA contato --}}
    <div class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6 sm:p-8 flex flex-col sm:flex-row items-center gap-6">
        <div class="flex-1">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-2">Pronto para começar?</h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                Entre em contato agora mesmo e nosso time comercial preparará uma proposta exclusiva para sua empresa. Processo rápido, sem burocracia.
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 shrink-0">
            <a href="tel:0000000000" class="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-amber-500 dark:border-amber-400 px-5 py-2.5 text-sm font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 transition-all duration-300">
                <x-icon name="phone" style="duotone" class="w-4 h-4" />
                Ligar Agora
            </a>
            <a href="{{ route('storefront.page.fale-conosco') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-2.5 text-sm font-medium text-gray-900 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30 transition-all duration-300">
                <x-icon name="envelope" style="duotone" class="w-4 h-4" />
                Solicitar Orçamento
            </a>
        </div>
    </div>

</div>
</x-storefront::layouts.public>
