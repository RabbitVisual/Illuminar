<x-storefront::layouts.public>
<x-slot name="title">Garantias</x-slot>
<x-slot name="description">Política de garantias da Illuminar. Conheça seus direitos, prazos e como acionar a garantia dos seus produtos.</x-slot>
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Garantias</span>
    </nav>

    <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="shield-check" style="duotone" class="w-7 h-7" />
        </span>
        Política de Garantias
    </h1>
    <p class="text-gray-600 dark:text-gray-400 text-lg mb-4 leading-relaxed">
        Trabalhamos com produtos de qualidade e respeitamos todos os seus direitos como consumidor. Conheça nossas garantias e como acioná-las.
    </p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mb-10">Última atualização: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

    <div class="space-y-8">

        {{-- Garantia legal --}}
        <section class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6 sm:p-8">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <x-icon name="scale-balanced" style="duotone" class="w-6 h-6 text-amber-500" />
                Garantia Legal (Código de Defesa do Consumidor)
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                A garantia legal é obrigatória por lei (CDC, Arts. 26 e 27) e assegura que, em caso de defeito ou vício do produto, o consumidor tem o direito de:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="rounded-xl bg-white dark:bg-gray-800/60 border border-gray-200/60 dark:border-gray-700/60 p-4">
                    <p class="font-semibold text-gray-900 dark:text-white mb-2 text-sm">Produtos Não Duráveis</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Prazo para reclamar: <strong class="text-amber-600 dark:text-amber-400">30 dias</strong> a partir do recebimento</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ex: consumíveis, produtos perecíveis</p>
                </div>
                <div class="rounded-xl bg-white dark:bg-gray-800/60 border border-gray-200/60 dark:border-gray-700/60 p-4">
                    <p class="font-semibold text-gray-900 dark:text-white mb-2 text-sm">Produtos Duráveis</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">Prazo para reclamar: <strong class="text-amber-600 dark:text-amber-400">90 dias</strong> a partir do recebimento</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Ex: luminárias, materiais elétricos, lâmpadas LED</p>
                </div>
            </div>
            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                Em caso de vício constatado, a Illuminar tem <strong class="text-gray-900 dark:text-white">30 dias</strong> para sanar o defeito. Não solucionado no prazo, o consumidor pode exigir: substituição do produto, abatimento no preço ou reembolso integral.
            </p>
        </section>

        {{-- Garantia do fabricante --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <x-icon name="industry" style="duotone" class="w-5 h-5 text-amber-500" />
                Garantia do Fabricante
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                Além da garantia legal, os fabricantes dos produtos vendidos na Illuminar oferecem garantia estendida. O prazo varia por produto e marca. As principais categorias têm os seguintes prazos médios:
            </p>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-2 pr-4 font-medium text-gray-700 dark:text-gray-300">Categoria</th>
                            <th class="text-left py-2 pr-4 font-medium text-gray-700 dark:text-gray-300">Garantia do Fabricante</th>
                            <th class="text-left py-2 font-medium text-gray-700 dark:text-gray-300">Observação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700/50">
                        @foreach([
                            ['Lâmpadas LED', '1 a 2 anos', 'Consulte a embalagem'],
                            ['Luminárias e Arandelas', '1 a 3 anos', 'Depende da marca e linha'],
                            ['Materiais Elétricos', '1 a 5 anos', 'Varia por fabricante'],
                            ['Disjuntores e Quadros', '1 a 5 anos', 'Algumas marcas oferecem vitalício'],
                            ['Fios e Cabos', '1 ano', 'Garantia contra defeito de fabricação'],
                        ] as $g)
                        <tr>
                            <td class="py-2.5 pr-4 text-gray-900 dark:text-white font-medium">{{ $g[0] }}</td>
                            <td class="py-2.5 pr-4 text-amber-600 dark:text-amber-400 font-medium">{{ $g[1] }}</td>
                            <td class="py-2.5 text-gray-500 dark:text-gray-400 text-xs">{{ $g[2] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="mt-4 text-xs text-gray-500 dark:text-gray-400">Para verificar a garantia específica de um produto, consulte a embalagem, manual do fabricante ou a ficha técnica na página do produto.</p>
        </section>

        {{-- Como acionar --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <x-icon name="wrench" style="duotone" class="w-5 h-5 text-amber-500" />
                Como Acionar a Garantia
            </h2>
            <div class="space-y-4">
                @foreach([
                    ['n' => '1', 'title' => 'Identifique o problema', 'desc' => 'Verifique se o defeito está dentro do prazo de garantia e não foi causado por mau uso, instalação incorreta ou acidente.'],
                    ['n' => '2', 'title' => 'Reúna os documentos', 'desc' => 'Separe a nota fiscal de compra, fotos ou vídeos que comprovem o defeito e a embalagem original (se possível).'],
                    ['n' => '3', 'title' => 'Entre em contato conosco', 'desc' => 'Acesse Minhas Devoluções (se autenticado) ou utilize o Fale Conosco informando o número do pedido e descrevendo o problema.'],
                    ['n' => '4', 'title' => 'Aguarde a análise', 'desc' => 'Nossa equipe técnica analisará o caso em até 2 dias úteis. Para garantia do fabricante, poderemos encaminhar diretamente à assistência técnica autorizada.'],
                    ['n' => '5', 'title' => 'Resolução', 'desc' => 'Conforme a análise: reparo, substituição por produto idêntico, ou reembolso. Comunicaremos o resultado por e-mail.'],
                ] as $step)
                <div class="flex items-start gap-4">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-amber-500 text-sm font-bold text-gray-900">{{ $step['n'] }}</span>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $step['title'] }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5 leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- O que não é coberto --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4">O que não é coberto pela garantia</h2>
            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                @foreach([
                    'Defeitos causados por instalação incorreta por parte do consumidor ou de terceiros não autorizados',
                    'Danos causados por acidentes, quedas, umidade excessiva, tensão elétrica inadequada ou agentes externos',
                    'Desgaste natural do produto pelo uso normal ao longo do tempo',
                    'Produtos com número de série adulterado ou removido',
                    'Danos causados por uso inadequado, contrário às especificações técnicas do produto',
                    'Produtos reparados por assistência técnica não autorizada pelo fabricante',
                ] as $exc)
                <li class="flex items-start gap-2">
                    <x-icon name="xmark" style="solid" class="w-4 h-4 text-red-500 shrink-0 mt-0.5" />
                    {{ $exc }}
                </li>
                @endforeach
            </ul>
        </section>

    </div>

    <div class="mt-10 rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-5 flex flex-col sm:flex-row items-center gap-4">
        <x-icon name="headset" style="duotone" class="w-8 h-8 text-amber-500 shrink-0" />
        <div class="flex-1">
            <p class="font-semibold text-gray-900 dark:text-white">Dúvidas sobre a garantia do seu produto?</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Nossa equipe está pronta para orientá-lo.</p>
        </div>
        <a href="{{ route('storefront.page.fale-conosco') }}"
           class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-5 py-2.5 text-sm font-medium text-gray-900 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30 transition-all duration-300 shrink-0">
            <x-icon name="envelope" style="duotone" class="w-4 h-4" />
            Fale Conosco
        </a>
    </div>

    <p class="mt-8 text-sm text-gray-500 dark:text-gray-400">
        Esta política está em conformidade com a Lei 8.078/1990 (Código de Defesa do Consumidor). © {{ date('Y') }} Illuminar — Desenvolvido por Reinan Rodrigues, CEO da Vertex Solutions LTDA.
    </p>

</div>
</x-storefront::layouts.public>
