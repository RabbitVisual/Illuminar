<x-storefront::layouts.public>
<x-slot name="title">Meus Pedidos</x-slot>
<x-slot name="description">Acompanhe seus pedidos, rastreie entregas e acesse seu histórico de compras na Illuminar.</x-slot>
<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <a href="{{ route('storefront.page.atendimento') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Atendimento</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Meus Pedidos</span>
    </nav>

    <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="box-open" style="duotone" class="w-7 h-7" />
        </span>
        Meus Pedidos
    </h1>
    <p class="text-gray-600 dark:text-gray-400 text-lg mb-10">
        Acompanhe seus pedidos e rastreie o status das entregas em tempo real.
    </p>

    {{-- Conteúdo condicionado por autenticação --}}
    @auth
        {{-- Usuário logado mas não no painel (redirecionamento manual caso controller não redirecione) --}}
        <div class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-8 text-center">
            <x-icon name="arrow-right" style="duotone" class="w-12 h-12 mx-auto mb-4 text-amber-500" />
            <h2 class="font-display text-lg font-bold text-gray-900 dark:text-white mb-2">Redirecionando...</h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">Você será redirecionado para o seu painel de pedidos.</p>
            <a href="{{ route('customer.orders.index') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3 text-base font-medium text-gray-900 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30 transition-all duration-300">
                <x-icon name="boxes-stacked" style="duotone" class="w-5 h-5" />
                Ver Meus Pedidos
            </a>
        </div>
    @else
        {{-- Usuário não autenticado --}}
        <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-8 sm:p-10 text-center shadow-sm">
            <x-icon name="lock" style="duotone" class="w-14 h-14 mx-auto mb-5 text-gray-400 dark:text-gray-500" />
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-3">Faça login para acessar seus pedidos</h2>
            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto mb-8 leading-relaxed">
                Para consultar seus pedidos, rastrear entregas e acessar seu histórico de compras, você precisa estar logado na sua conta Illuminar.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3 text-base font-medium text-gray-900 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30 hover:scale-[1.02] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    <x-icon name="right-to-bracket" style="solid" class="w-5 h-5" />
                    Entrar na minha conta
                </a>
                <a href="{{ route('register') }}"
                   class="inline-flex items-center gap-2 rounded-xl border-2 border-amber-500/60 dark:border-amber-400/60 px-6 py-3 text-base font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500/50 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                    <x-icon name="user-plus" style="solid" class="w-5 h-5" />
                    Criar conta grátis
                </a>
            </div>
        </div>

        {{-- Informações sobre pedidos --}}
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-4 text-center shadow-sm">
                <x-icon name="magnifying-glass" style="duotone" class="w-7 h-7 mx-auto mb-2 text-amber-500" />
                <p class="text-sm font-medium text-gray-900 dark:text-white">Rastreamento em tempo real</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Saiba exatamente onde está seu pedido</p>
            </div>
            <div class="rounded-xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-4 text-center shadow-sm">
                <x-icon name="clock-rotate-left" style="duotone" class="w-7 h-7 mx-auto mb-2 text-amber-500" />
                <p class="text-sm font-medium text-gray-900 dark:text-white">Histórico completo</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Acesse todas as compras anteriores</p>
            </div>
            <div class="rounded-xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-4 text-center shadow-sm">
                <x-icon name="arrow-rotate-left" style="duotone" class="w-7 h-7 mx-auto mb-2 text-amber-500" />
                <p class="text-sm font-medium text-gray-900 dark:text-white">Solicitar devoluções</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Trocas e devoluções simplificadas</p>
            </div>
        </div>

        <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            Precisa de ajuda com um pedido? <a href="{{ route('storefront.page.fale-conosco') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Entre em contato conosco →</a>
        </p>
    @endauth

</div>
</x-storefront::layouts.public>
