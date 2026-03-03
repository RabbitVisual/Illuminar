<x-storefront::layouts.public>
<x-slot name="title">Devoluções e Reembolsos</x-slot>
<x-slot name="description">Política de devoluções e reembolsos da Illuminar. Conheça seus direitos e como proceder para trocas e estornos.</x-slot>
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Devoluções e Reembolsos</span>
    </nav>

    <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="arrows-rotate" style="duotone" class="w-7 h-7" />
        </span>
        Devoluções e Reembolsos
    </h1>
    <p class="text-gray-600 dark:text-gray-400 text-lg mb-4 leading-relaxed">
        A Illuminar preza pela satisfação dos seus clientes. Conhecemos e respeitamos seus direitos como consumidor, conforme o Código de Defesa do Consumidor (Lei 8.078/90).
    </p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mb-10">Última atualização: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

    <div class="space-y-8">

        {{-- 1. Direito de arrependimento --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">1</span>
                Direito de Arrependimento (CDC, Art. 49)
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>O consumidor que realizar compra fora do estabelecimento comercial (pela internet) tem o direito de desistir da compra em até <strong class="text-gray-900 dark:text-white">7 (sete) dias corridos</strong> contados a partir do recebimento do produto, sem necessidade de justificativa.</p>
                <p>Para exercer esse direito:</p>
                <ul class="list-disc list-inside space-y-1 pl-2">
                    <li>O produto deve estar sem sinais de uso, em perfeitas condições</li>
                    <li>Deve estar na embalagem original, com todos os acessórios e manual</li>
                    <li>A nota fiscal original deve acompanhar o produto</li>
                    <li>Solicite a devolução via <a href="{{ route('storefront.page.minhas-devolucoes') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Minhas Devoluções</a> ou pelo <a href="{{ route('storefront.page.fale-conosco') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Fale Conosco</a></li>
                </ul>
            </div>
        </section>

        {{-- 2. Produto com defeito --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">2</span>
                Produto com Defeito ou Vício
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Caso o produto apresente defeito ou vício, você tem direito à:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-3">
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="font-semibold text-gray-900 dark:text-white mb-1 text-sm">Produtos Não Duráveis</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Prazo de reclamação: <strong>30 dias</strong> após o recebimento</p>
                    </div>
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                        <p class="font-semibold text-gray-900 dark:text-white mb-1 text-sm">Produtos Duráveis</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">Prazo de reclamação: <strong>90 dias</strong> após o recebimento</p>
                    </div>
                </div>
                <p class="mt-3">Em caso de defeito confirmado, o consumidor pode optar por: reparo do produto, substituição por produto idêntico, abatimento proporcional do preço ou restituição imediata da quantia paga.</p>
                <p>Entre em contato pelo <a href="{{ route('storefront.page.fale-conosco') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Fale Conosco</a> informando fotos ou vídeos que comprovem o defeito.</p>
            </div>
        </section>

        {{-- 3. Produto errado ou avariado --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">3</span>
                Produto Errado ou Avariado na Entrega
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Se você receber um produto diferente do pedido ou com avaria visível:</p>
                <ul class="list-disc list-inside space-y-1 pl-2">
                    <li><strong class="text-gray-900 dark:text-white">Avaria visível no momento da entrega:</strong> não assine o recebimento e recuse o produto</li>
                    <li><strong class="text-gray-900 dark:text-white">Avaria interna ou produto errado:</strong> fotografe e entre em contato em até 48 horas pelo Fale Conosco</li>
                    <li>A Illuminar arcará com todos os custos de coleta e reenvio nesses casos</li>
                </ul>
            </div>
        </section>

        {{-- 4. Processo de reembolso --}}
        <section class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6 sm:p-8">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500 text-gray-900 text-sm font-bold">4</span>
                Prazos de Reembolso
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">Após recebermos, inspecionarmos e aprovarmos a devolução, processamos o reembolso em até <strong class="text-gray-900 dark:text-white">5 dias úteis</strong>. O prazo para o crédito em sua conta depende da forma de pagamento:</p>
            <div class="space-y-3">
                @foreach([
                    ['icon' => 'mobile-screen', 'metodo' => 'PIX', 'prazo' => 'Imediato após o processamento'],
                    ['icon' => 'credit-card', 'metodo' => 'Cartão de Crédito', 'prazo' => 'Até 2 faturas subsequentes (prazo da operadora)'],
                    ['icon' => 'credit-card', 'metodo' => 'Cartão de Débito', 'prazo' => 'Até 10 dias úteis (prazo da operadora)'],
                    ['icon' => 'file-lines', 'metodo' => 'Boleto Bancário', 'prazo' => 'Transferência em até 2 dias úteis após aprovação'],
                ] as $r)
                <div class="flex items-center gap-3 text-sm">
                    <x-icon name="{{ $r['icon'] }}" style="duotone" class="w-5 h-5 text-amber-500 shrink-0" />
                    <span class="font-medium text-gray-900 dark:text-white w-36 shrink-0">{{ $r['metodo'] }}</span>
                    <span class="text-gray-600 dark:text-gray-400">{{ $r['prazo'] }}</span>
                </div>
                @endforeach
            </div>
        </section>

        {{-- 5. Exceções --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">5</span>
                Situações não cobertas pela política de devolução
            </h2>
            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                @foreach([
                    'Produto com sinais evidentes de uso, mau uso ou instalação incorreta',
                    'Produto fora do prazo de solicitação de devolução',
                    'Defeito causado por acidente, queda, umidade ou agente externo',
                    'Produto adquirido por pessoa jurídica para revenda',
                    'Produtos sob encomenda especial sem previsão de estoque regular',
                ] as $exc)
                <li class="flex items-start gap-2">
                    <x-icon name="xmark" style="solid" class="w-4 h-4 text-red-500 shrink-0 mt-0.5" />
                    {{ $exc }}
                </li>
                @endforeach
            </ul>
        </section>

    </div>

    <p class="mt-10 text-sm text-gray-500 dark:text-gray-400">
        Esta política está em conformidade com a Lei 8.078/1990 (Código de Defesa do Consumidor), a Lei 12.965/2014 (Marco Civil da Internet) e demais legislações brasileiras aplicáveis. © {{ date('Y') }} Illuminar — Desenvolvido por Reinan Rodrigues, CEO da Vertex Solutions LTDA.
    </p>

</div>
</x-storefront::layouts.public>
