<x-storefront::layouts.public>
<x-slot name="title">Dúvidas Frequentes</x-slot>
<x-slot name="description">Encontre respostas para as principais dúvidas sobre compras, entrega, pagamento, troca e garantia na Illuminar.</x-slot>
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Dúvidas Frequentes</span>
    </nav>

    <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="circle-question" style="duotone" class="w-7 h-7" />
        </span>
        Dúvidas Frequentes
    </h1>
    <p class="text-gray-600 dark:text-gray-400 text-lg mb-10">Encontre respostas rápidas para as principais perguntas dos nossos clientes.</p>

    {{-- FAQ Accordion --}}
    <div x-data="{ open: null }" class="space-y-3">

        {{-- Seção: Compra --}}
        <h2 class="font-display text-sm font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400 pt-4 pb-1 flex items-center gap-2">
            <x-icon name="cart-shopping" style="duotone" class="w-4 h-4" />
            Compras e Cadastro
        </h2>
        @foreach([
            ['id' => 'q1', 'q' => 'Preciso me cadastrar para comprar?', 'a' => 'Sim, é necessário criar uma conta para finalizar a compra. O cadastro é gratuito e rápido. Com uma conta você também pode acompanhar seus pedidos, salvar endereços e consultar o histórico de compras.'],
            ['id' => 'q2', 'q' => 'Como faço meu cadastro?', 'a' => 'Clique em "Entrar" no menu superior e depois em "Criar conta". Preencha seus dados (nome, e-mail e senha) e confirme seu cadastro pelo e-mail que enviaremos. Simples e seguro.'],
            ['id' => 'q3', 'q' => 'Posso comprar como pessoa jurídica (CNPJ)?', 'a' => 'Sim! Atendemos empresas com CNPJ com emissão de nota fiscal eletrônica. Para pedidos maiores, condições especiais e atendimento dedicado, acesse nossa área de Atendimento Corporativo.'],
            ['id' => 'q4', 'q' => 'Os preços do site são os mesmos da loja física?', 'a' => 'Os preços podem variar entre o site e a loja física. Promoções exclusivas podem estar disponíveis somente em um dos canais. Verifique sempre o preço no momento da compra.'],
        ] as $faq)
        <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 overflow-hidden">
            <button type="button"
                    @click="open = open === '{{ $faq['id'] }}' ? null : '{{ $faq['id'] }}'"
                    class="flex w-full items-center justify-between gap-4 bg-white dark:bg-gray-800/60 px-6 py-4 text-left transition-colors hover:bg-amber-500/5 dark:hover:bg-amber-400/5 focus:outline-none focus:bg-amber-500/5 dark:focus:bg-amber-400/5"
                    :aria-expanded="open === '{{ $faq['id'] }}'">
                <span class="font-medium text-gray-900 dark:text-white">{{ $faq['q'] }}</span>
                <x-icon name="chevron-down" style="solid" class="w-4 h-4 text-amber-500 shrink-0 transition-transform duration-300" x-bind:class="{ 'rotate-180': open === '{{ $faq['id'] }}' }" />
            </button>
            <div x-show="open === '{{ $faq['id'] }}'"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="border-t border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 px-6 py-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $faq['a'] }}</p>
            </div>
        </div>
        @endforeach

        {{-- Seção: Pagamento --}}
        <h2 class="font-display text-sm font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400 pt-6 pb-1 flex items-center gap-2">
            <x-icon name="credit-card" style="duotone" class="w-4 h-4" />
            Pagamento
        </h2>
        @foreach([
            ['id' => 'q5', 'q' => 'Quais formas de pagamento são aceitas?', 'a' => 'Aceitamos PIX (aprovação instantânea), cartão de crédito (até 12x dependendo do valor), cartão de débito e boleto bancário (compensação em até 2 dias úteis após o pagamento).'],
            ['id' => 'q6', 'q' => 'O pagamento por PIX é mais rápido?', 'a' => 'Sim! Pedidos pagos via PIX têm aprovação instantânea e são priorizados no processamento, sendo enviados mais rapidamente do que pedidos pagos por boleto.'],
            ['id' => 'q7', 'q' => 'Meu pagamento foi confirmado. Em quanto tempo o pedido é processado?', 'a' => 'Pedidos com pagamento confirmado são processados em até 1 dia útil. Após a confirmação, você receberá um e-mail com as informações de envio e código de rastreamento.'],
            ['id' => 'q8', 'q' => 'Posso parcelar no cartão de crédito?', 'a' => 'Sim, oferecemos parcelamento no cartão de crédito. As condições de parcelamento (número de parcelas e taxas) são exibidas durante o checkout conforme o valor do pedido.'],
        ] as $faq)
        <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 overflow-hidden">
            <button type="button"
                    @click="open = open === '{{ $faq['id'] }}' ? null : '{{ $faq['id'] }}'"
                    class="flex w-full items-center justify-between gap-4 bg-white dark:bg-gray-800/60 px-6 py-4 text-left transition-colors hover:bg-amber-500/5 dark:hover:bg-amber-400/5 focus:outline-none"
                    :aria-expanded="open === '{{ $faq['id'] }}'">
                <span class="font-medium text-gray-900 dark:text-white">{{ $faq['q'] }}</span>
                <x-icon name="chevron-down" style="solid" class="w-4 h-4 text-amber-500 shrink-0 transition-transform duration-300" x-bind:class="{ 'rotate-180': open === '{{ $faq['id'] }}' }" />
            </button>
            <div x-show="open === '{{ $faq['id'] }}'"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="border-t border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 px-6 py-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $faq['a'] }}</p>
            </div>
        </div>
        @endforeach

        {{-- Seção: Entrega --}}
        <h2 class="font-display text-sm font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400 pt-6 pb-1 flex items-center gap-2">
            <x-icon name="truck-fast" style="duotone" class="w-4 h-4" />
            Entrega e Frete
        </h2>
        @foreach([
            ['id' => 'q9', 'q' => 'Vocês entregam em todo o Brasil?', 'a' => 'Sim! Entregamos em todo o território nacional via transportadoras parceiras. O prazo e o valor do frete são calculados automaticamente no carrinho conforme o seu CEP.'],
            ['id' => 'q10', 'q' => 'Como rastrear meu pedido?', 'a' => 'Após o envio, você receberá um e-mail com o código de rastreamento. Também é possível acompanhar pelo painel "Meus Pedidos" na sua conta. O rastreamento é atualizado em tempo real pela transportadora.'],
            ['id' => 'q11', 'q' => 'Qual o prazo de entrega?', 'a' => 'O prazo varia conforme a sua localização e a disponibilidade do produto. Em geral, regiões Sul e Sudeste recebem em 3 a 5 dias úteis; Norte, Nordeste e Centro-Oeste entre 5 e 10 dias úteis após a confirmação do pagamento.'],
            ['id' => 'q12', 'q' => 'O que faço se meu pedido chegar com avaria ou produto errado?', 'a' => 'Caso o pedido chegue com avaria visível, não assine o recebimento e recuse a entrega. Se a avaria for interna, fotografe o produto e entre em contato conosco em até 48 horas pelo Fale Conosco. Resolveremos com máxima prioridade.'],
        ] as $faq)
        <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 overflow-hidden">
            <button type="button"
                    @click="open = open === '{{ $faq['id'] }}' ? null : '{{ $faq['id'] }}'"
                    class="flex w-full items-center justify-between gap-4 bg-white dark:bg-gray-800/60 px-6 py-4 text-left transition-colors hover:bg-amber-500/5 dark:hover:bg-amber-400/5 focus:outline-none"
                    :aria-expanded="open === '{{ $faq['id'] }}'">
                <span class="font-medium text-gray-900 dark:text-white">{{ $faq['q'] }}</span>
                <x-icon name="chevron-down" style="solid" class="w-4 h-4 text-amber-500 shrink-0 transition-transform duration-300" x-bind:class="{ 'rotate-180': open === '{{ $faq['id'] }}' }" />
            </button>
            <div x-show="open === '{{ $faq['id'] }}'"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="border-t border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 px-6 py-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $faq['a'] }}</p>
            </div>
        </div>
        @endforeach

        {{-- Seção: Trocas e Garantias --}}
        <h2 class="font-display text-sm font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400 pt-6 pb-1 flex items-center gap-2">
            <x-icon name="shield-check" style="duotone" class="w-4 h-4" />
            Trocas, Devoluções e Garantias
        </h2>
        @foreach([
            ['id' => 'q13', 'q' => 'Posso trocar ou devolver um produto?', 'a' => 'Sim. Você tem 7 dias corridos após o recebimento para exercer o direito de arrependimento (CDC). Para produtos com defeito ou vício, o prazo é de 30 dias para bens não duráveis e 90 dias para bens duráveis. Acesse "Minhas Devoluções" para solicitar.'],
            ['id' => 'q14', 'q' => 'O produto precisa estar na embalagem original para devolução?', 'a' => 'Para exercer o direito de arrependimento, o produto deve estar em perfeito estado, sem sinais de uso, com embalagem original, manual e todos os acessórios. Produtos com defeito serão analisados individualmente.'],
            ['id' => 'q15', 'q' => 'Como funciona a garantia dos produtos?', 'a' => 'Todos os produtos possuem garantia legal (90 dias para bens duráveis pelo CDC) mais a garantia do fabricante, que pode ser de 1 a 5 anos dependendo do produto. Consulte a embalagem ou a ficha do produto para saber o prazo específico.'],
            ['id' => 'q16', 'q' => 'Em quanto tempo recebo o reembolso após a devolução?', 'a' => 'Após recebermos e inspecionarmos o produto, processamos o reembolso em até 5 dias úteis. O prazo para o estorno depende da sua forma de pagamento: PIX é imediato, cartão de crédito pode levar até 2 faturas, boleto é creditado em conta em até 2 dias úteis.'],
        ] as $faq)
        <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 overflow-hidden">
            <button type="button"
                    @click="open = open === '{{ $faq['id'] }}' ? null : '{{ $faq['id'] }}'"
                    class="flex w-full items-center justify-between gap-4 bg-white dark:bg-gray-800/60 px-6 py-4 text-left transition-colors hover:bg-amber-500/5 dark:hover:bg-amber-400/5 focus:outline-none"
                    :aria-expanded="open === '{{ $faq['id'] }}'">
                <span class="font-medium text-gray-900 dark:text-white">{{ $faq['q'] }}</span>
                <x-icon name="chevron-down" style="solid" class="w-4 h-4 text-amber-500 shrink-0 transition-transform duration-300" x-bind:class="{ 'rotate-180': open === '{{ $faq['id'] }}' }" />
            </button>
            <div x-show="open === '{{ $faq['id'] }}'"
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-1"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="border-t border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 px-6 py-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $faq['a'] }}</p>
            </div>
        </div>
        @endforeach

    </div>

    {{-- Ainda com dúvidas --}}
    <div class="mt-12 rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6 sm:p-8 text-center">
        <x-icon name="headset" style="duotone" class="w-10 h-10 mx-auto mb-3 text-amber-500" />
        <h2 class="font-display text-lg font-bold text-gray-900 dark:text-white mb-2">Ainda tem dúvidas?</h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-5">Nossa equipe de atendimento está pronta para ajudá-lo.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('storefront.page.fale-conosco') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-2.5 text-sm font-medium text-gray-900 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30 transition-all duration-300">
                <x-icon name="envelope" style="duotone" class="w-4 h-4" />
                Fale Conosco
            </a>
            <a href="{{ route('storefront.page.compre-por-telefone') }}"
               class="inline-flex items-center gap-2 rounded-xl border-2 border-amber-500/60 dark:border-amber-400/60 px-5 py-2.5 text-sm font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 transition-all duration-300">
                <x-icon name="phone" style="duotone" class="w-4 h-4" />
                Ligue para nós
            </a>
        </div>
    </div>

</div>
</x-storefront::layouts.public>
