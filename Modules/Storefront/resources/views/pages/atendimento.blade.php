<x-storefront::layouts.public>
<x-slot name="title">Atendimento ao Cliente</x-slot>
<x-slot name="description">Central de atendimento Illuminar. Encontre todas as formas de suporte, contato e autoatendimento.</x-slot>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Atendimento</span>
    </nav>

    {{-- Título --}}
    <div class="mb-10">
        <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
            <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                <x-icon name="headset" style="duotone" class="w-7 h-7" />
            </span>
            Central de Atendimento
        </h1>
        <p class="text-gray-600 dark:text-gray-400 text-lg max-w-2xl">
            Estamos aqui para ajudar! Escolha a forma de atendimento que melhor atende sua necessidade.
        </p>
    </div>

    {{-- Cards de atendimento --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-14">
        <a href="{{ route('storefront.page.fale-conosco') }}"
           class="group storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform duration-300">
                <x-icon name="envelope" style="duotone" class="w-7 h-7" />
            </div>
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-2">Fale Conosco</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Envie sua mensagem e nossa equipe responderá em até 24 horas úteis.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-amber-600 dark:text-amber-400">
                Enviar mensagem <x-icon name="arrow-right" style="solid" class="w-3 h-3" />
            </span>
        </a>

        <a href="{{ route('storefront.page.compre-por-telefone') }}"
           class="group storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform duration-300">
                <x-icon name="phone" style="duotone" class="w-7 h-7" />
            </div>
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-2">Compre por Telefone</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Prefere comprar por telefone? Nossos consultores estão prontos para atendê-lo.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-amber-600 dark:text-amber-400">
                Ver números <x-icon name="arrow-right" style="solid" class="w-3 h-3" />
            </span>
        </a>

        <a href="{{ route('storefront.page.atendimento-corporativo') }}"
           class="group storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform duration-300">
                <x-icon name="building" style="duotone" class="w-7 h-7" />
            </div>
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-2">Atendimento Corporativo</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Atendimento exclusivo para empresas com CNPJ, orçamentos e condições especiais.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-amber-600 dark:text-amber-400">
                Saiba mais <x-icon name="arrow-right" style="solid" class="w-3 h-3" />
            </span>
        </a>

        <a href="{{ route('storefront.page.meus-pedidos') }}"
           class="group storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform duration-300">
                <x-icon name="box-open" style="duotone" class="w-7 h-7" />
            </div>
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-2">Meus Pedidos</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Acompanhe seus pedidos, rastreie entregas e acesse histórico de compras.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-amber-600 dark:text-amber-400">
                Ver pedidos <x-icon name="arrow-right" style="solid" class="w-3 h-3" />
            </span>
        </a>

        <a href="{{ route('storefront.page.minhas-devolucoes') }}"
           class="group storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform duration-300">
                <x-icon name="arrow-rotate-left" style="duotone" class="w-7 h-7" />
            </div>
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-2">Minhas Devoluções</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Solicite a devolução ou troca de um produto de forma rápida e sem complicações.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-amber-600 dark:text-amber-400">
                Solicitar <x-icon name="arrow-right" style="solid" class="w-3 h-3" />
            </span>
        </a>

        <a href="{{ route('storefront.page.duvidas-frequentes') }}"
           class="group storefront-card-hover rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm hover:border-amber-500/20 dark:hover:border-amber-400/20 transition-colors">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 transition-transform duration-300">
                <x-icon name="circle-question" style="duotone" class="w-7 h-7" />
            </div>
            <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-2">Dúvidas Frequentes</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">Encontre respostas rápidas para as principais dúvidas dos nossos clientes.</p>
            <span class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-amber-600 dark:text-amber-400">
                Ver FAQ <x-icon name="arrow-right" style="solid" class="w-3 h-3" />
            </span>
        </a>
    </div>

    {{-- Informações de contato --}}
    <div class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6 sm:p-8">
        <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
            <x-icon name="clock" style="duotone" class="w-5 h-5 text-amber-500" />
            Horário de Atendimento
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white mb-1">Segunda a Sexta</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">08h às 18h</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white mb-1">Sábados</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">08h às 13h</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-900 dark:text-white mb-1">Domingos e Feriados</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Fechado</p>
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-4">
            <a href="tel:0000000000" class="inline-flex items-center gap-2 text-sm font-medium text-amber-700 dark:text-amber-300 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                <x-icon name="phone" style="duotone" class="w-4 h-4" />
                (00) 0000-0000
            </a>
            <a href="mailto:contato@illuminar.com.br" class="inline-flex items-center gap-2 text-sm font-medium text-amber-700 dark:text-amber-300 hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                <x-icon name="envelope" style="duotone" class="w-4 h-4" />
                contato@illuminar.com.br
            </a>
        </div>
    </div>

</div>
</x-storefront::layouts.public>
