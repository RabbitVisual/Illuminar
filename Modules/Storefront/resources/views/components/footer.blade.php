{{-- Footer público - e-commerce iluminação --}}
<footer class="relative border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 mt-auto overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-b from-amber-500/5 via-transparent to-transparent dark:from-amber-400/5 pointer-events-none"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10 lg:gap-8">

            {{-- Coluna 1: Logo + Descrição + Badges + Redes --}}
            <div class="sm:col-span-2">
                <a href="{{ route('storefront.index') }}" class="inline-block mb-5">
                    <x-core::logo height="h-11" class="w-auto" />
                </a>
                <p class="text-sm text-gray-600 dark:text-gray-400 max-w-sm leading-relaxed mb-5">
                    Materiais elétricos e iluminação de qualidade para sua casa ou empresa. Iluminando o Brasil com eficiência, variedade e atendimento especializado.
                </p>
                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500/10 dark:bg-amber-400/10 px-3 py-1.5 text-xs font-medium text-amber-700 dark:text-amber-300">
                        <x-icon name="bolt" style="duotone" class="w-3.5 h-3.5" />
                        Energia & Iluminação
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500/10 dark:bg-amber-400/10 px-3 py-1.5 text-xs font-medium text-amber-700 dark:text-amber-300">
                        <x-icon name="truck-fast" style="duotone" class="w-3.5 h-3.5" />
                        Entrega em todo Brasil
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500/10 dark:bg-amber-400/10 px-3 py-1.5 text-xs font-medium text-amber-700 dark:text-amber-300">
                        <x-icon name="shield-check" style="duotone" class="w-3.5 h-3.5" />
                        Compra segura
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-lg bg-amber-500/10 dark:bg-amber-400/10 px-3 py-1.5 text-xs font-medium text-amber-700 dark:text-amber-300">
                        <x-icon name="file-invoice" style="duotone" class="w-3.5 h-3.5" />
                        Nota fiscal
                    </span>
                </div>
                {{-- Redes sociais --}}
                <div class="flex gap-2">
                    <a href="#" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:text-amber-600 dark:hover:text-amber-400 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/50" aria-label="Facebook">
                        <x-icon name="facebook" style="brands" class="w-5 h-5" />
                    </a>
                    <a href="#" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:text-amber-600 dark:hover:text-amber-400 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/50" aria-label="Instagram">
                        <x-icon name="instagram" style="brands" class="w-5 h-5" />
                    </a>
                    <a href="#" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:text-amber-600 dark:hover:text-amber-400 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/50" aria-label="WhatsApp">
                        <x-icon name="whatsapp" style="brands" class="w-5 h-5" />
                    </a>
                </div>
            </div>

            {{-- Coluna 2: Atendimento --}}
            <div>
                <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="headset" style="duotone" class="w-4 h-4 text-amber-500" />
                    Atendimento
                </h3>
                <ul class="space-y-2.5">
                    @foreach([
                        ['route' => 'storefront.page.atendimento', 'label' => 'Central de Atendimento'],
                        ['route' => 'storefront.page.fale-conosco', 'label' => 'Fale Conosco'],
                        ['route' => 'storefront.page.compre-por-telefone', 'label' => 'Compre por Telefone'],
                        ['route' => 'storefront.page.atendimento-corporativo', 'label' => 'Atendimento Corporativo'],
                        ['route' => 'storefront.page.meus-pedidos', 'label' => 'Meus Pedidos'],
                        ['route' => 'storefront.page.minhas-devolucoes', 'label' => 'Minhas Devoluções'],
                    ] as $link)
                    <li>
                        <a href="{{ route($link['route']) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors focus:outline-none focus:underline focus:decoration-amber-500">
                            {{ $link['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Coluna 3: Ajuda & Info --}}
            <div>
                <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="circle-question" style="duotone" class="w-4 h-4 text-amber-500" />
                    Ajuda & Info
                </h3>
                <ul class="space-y-2.5">
                    @foreach([
                        ['route' => 'storefront.page.duvidas-frequentes', 'label' => 'Dúvidas Frequentes'],
                        ['route' => 'storefront.page.devolucoes-reembolsos', 'label' => 'Devoluções e Reembolsos'],
                        ['route' => 'storefront.page.formas-pagamento-entrega', 'label' => 'Formas de Pagamento'],
                        ['route' => 'storefront.page.garantias', 'label' => 'Garantias'],
                        ['route' => 'storefront.index', 'label' => 'Início'],
                        ['route' => 'storefront.catalog', 'label' => 'Catálogo'],
                        ['route' => 'storefront.cart', 'label' => 'Carrinho'],
                    ] as $link)
                    <li>
                        <a href="{{ route($link['route']) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors focus:outline-none focus:underline focus:decoration-amber-500">
                            {{ $link['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Coluna 4: Legal + Contato --}}
            <div>
                <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="scale-balanced" style="duotone" class="w-4 h-4 text-amber-500" />
                    Legal
                </h3>
                <ul class="space-y-2.5 mb-8">
                    @foreach([
                        ['route' => 'storefront.page.politica-privacidade', 'label' => 'Política de Privacidade'],
                        ['route' => 'storefront.page.termos-condicoes', 'label' => 'Termos de Uso'],
                        ['route' => 'storefront.page.garantias', 'label' => 'Política de Garantias'],
                        ['route' => 'storefront.page.devolucoes-reembolsos', 'label' => 'Política de Devoluções'],
                    ] as $link)
                    <li>
                        <a href="{{ route($link['route']) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-amber-600 dark:hover:text-amber-400 transition-colors focus:outline-none focus:underline focus:decoration-amber-500">
                            {{ $link['label'] }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <h3 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="address-book" style="duotone" class="w-4 h-4 text-amber-500" />
                    Contato
                </h3>
                <ul class="space-y-2.5 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex items-center gap-2">
                        <x-icon name="envelope" style="duotone" class="w-4 h-4 text-amber-500 shrink-0" />
                        <a href="mailto:contato@illuminar.com.br" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors break-all">contato@illuminar.com.br</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <x-icon name="phone" style="duotone" class="w-4 h-4 text-amber-500 shrink-0" />
                        <a href="tel:0000000000" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">(00) 0000-0000</a>
                    </li>
                    <li class="flex items-center gap-2">
                        <x-icon name="clock" style="duotone" class="w-4 h-4 text-amber-500 shrink-0" />
                        <span class="text-xs">Seg–Sex 08h–18h | Sáb 08h–13h</span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- Rodapé inferior --}}
        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-sm text-gray-500 dark:text-gray-500 text-center sm:text-left">
                © {{ date('Y') }} Illuminar. Todos os direitos reservados. Plataforma protegida pela Lei 9.609/98.
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-500 text-center sm:text-right">
                Desenvolvido por <strong class="text-amber-600 dark:text-amber-400">Reinan Rodrigues</strong>, CEO da <strong class="text-amber-600 dark:text-amber-400">Vertex Solutions LTDA</strong>
            </p>
        </div>
    </div>
</footer>
