<x-storefront::layouts.public>
<x-slot name="title">Termos e Condições de Uso</x-slot>
<x-slot name="description">Termos e Condições de Uso da Illuminar. Leia com atenção antes de utilizar nossos serviços.</x-slot>
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Termos e Condições de Uso</span>
    </nav>

    <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="file-contract" style="duotone" class="w-7 h-7" />
        </span>
        Termos e Condições de Uso
    </h1>
    <p class="text-gray-600 dark:text-gray-400 mb-2">Por favor, leia estes termos com atenção antes de utilizar nossos serviços.</p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mb-10">Última atualização: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

    {{-- Índice rápido --}}
    <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-5 mb-10 shadow-sm">
        <p class="text-sm font-medium text-gray-900 dark:text-white mb-3">Índice</p>
        <ol class="grid grid-cols-1 sm:grid-cols-2 gap-1.5 text-sm text-amber-600 dark:text-amber-400">
            @foreach(['Objeto e Aceitação', 'Cadastro e Conta', 'Produtos e Preços', 'Pedidos e Pagamento', 'Entrega', 'Cancelamentos e Devoluções', 'Propriedade Intelectual', 'Responsabilidades', 'Privacidade', 'Disposições Gerais'] as $i => $item)
            <li><a href="#clausula-{{ $i+1 }}" class="hover:underline">{{ $i+1 }}. {{ $item }}</a></li>
            @endforeach
        </ol>
    </div>

    <div class="space-y-8">

        <section id="clausula-1" class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">1</span>
                Objeto e Aceitação dos Termos
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Os presentes Termos e Condições de Uso ("Termos") regulam o acesso e a utilização da plataforma de comércio eletrônico <strong class="text-gray-900 dark:text-white">Illuminar</strong> ("Plataforma"), de responsabilidade da Illuminar — Materiais Elétricos e Iluminação ("Illuminar", "nós").</p>
                <p>Ao acessar ou utilizar nossos serviços — incluindo navegação, cadastro, compra de produtos ou qualquer interação com a Plataforma — você ("Usuário", "você") declara que <strong class="text-gray-900 dark:text-white">leu, compreendeu e concorda integralmente</strong> com estes Termos.</p>
                <p>Se você não concordar com quaisquer disposições destes Termos, não utilize nossa Plataforma.</p>
                <p>Estes Termos podem ser alterados a qualquer momento. As alterações entram em vigor após a publicação na Plataforma com a data de atualização.</p>
            </div>
        </section>

        <section id="clausula-2" class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">2</span>
                Cadastro e Conta de Usuário
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Para realizar compras, é necessário criar uma conta na Plataforma. O usuário deve:</p>
                <ul class="list-disc list-inside space-y-1 pl-2">
                    <li>Ser maior de 18 anos ou emancipado legalmente, ou ter autorização dos responsáveis legais</li>
                    <li>Fornecer informações verdadeiras, precisas, atuais e completas durante o cadastro</li>
                    <li>Manter as informações cadastrais sempre atualizadas</li>
                    <li>Manter em sigilo sua senha de acesso, sendo responsável por toda atividade realizada com suas credenciais</li>
                    <li>Notificar imediatamente a Illuminar sobre qualquer uso não autorizado de sua conta</li>
                </ul>
                <p>A Illuminar reserva-se o direito de recusar, suspender ou cancelar cadastros que violem estes Termos, apresentem informações falsas ou sejam utilizados de forma fraudulenta.</p>
                <p>Cada usuário pode possuir apenas um cadastro. É proibida a criação de múltiplas contas para obter vantagens indevidas.</p>
            </div>
        </section>

        <section id="clausula-3" class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">3</span>
                Produtos, Preços e Disponibilidade
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>As informações sobre produtos (descrição, especificações, imagens e preços) são apresentadas com a maior precisão possível, mas podem conter erros tipográficos ou inconsistências.</p>
                <p>A Illuminar reserva-se o direito de:</p>
                <ul class="list-disc list-inside space-y-1 pl-2">
                    <li>Alterar preços a qualquer momento, sem aviso prévio, antes da confirmação do pedido</li>
                    <li>Limitar quantidades por cliente ou por pedido</li>
                    <li>Descontinuar produtos sem aviso prévio</li>
                    <li>Cancelar pedidos em caso de erro manifesto de preço (preço com erro evidente de digitação)</li>
                </ul>
                <p>Preços exibidos incluem impostos aplicáveis. O frete é calculado à parte e exibido antes da conclusão do pedido. Promoções são válidas enquanto durarem os estoques ou pelo período indicado.</p>
            </div>
        </section>

        <section id="clausula-4" class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">4</span>
                Pedidos e Pagamento
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>A conclusão do pedido e a confirmação do pagamento constituem o aceite do contrato de compra e venda entre o Usuário e a Illuminar.</p>
                <p>O pedido somente é confirmado após a aprovação do pagamento. Pedidos aguardando pagamento por boleto são cancelados automaticamente após 3 dias sem confirmação de pagamento.</p>
                <p>Formas de pagamento aceitas: PIX, cartão de crédito, cartão de débito e boleto bancário. Todas as transações são processadas por gateways de pagamento certificados com criptografia SSL.</p>
                <p>Em caso de suspeita de fraude, a Illuminar pode solicitar documentação adicional e, se necessário, cancelar o pedido com reembolso integral.</p>
            </div>
        </section>

        <section id="clausula-5" class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">5</span>
                Entrega
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Os prazos de entrega são estimativas e contam a partir da confirmação do pagamento. A Illuminar não se responsabiliza por atrasos causados por transportadoras, greves, desastres naturais, eventos de força maior ou informações incorretas fornecidas pelo Usuário.</p>
                <p>O Usuário é responsável por fornecer um endereço de entrega correto e completo. A Illuminar não se responsabiliza por entregas não realizadas por culpa do destinatário (endereço errado, ausência no local, recusa de recebimento injustificada).</p>
                <p>Ao receber o produto, o Usuário deve verificar a integridade da embalagem. Em caso de avaria visível, o recebimento deve ser recusado.</p>
            </div>
        </section>

        <section id="clausula-6" class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">6</span>
                Cancelamentos, Devoluções e Reembolsos
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>O Usuário pode cancelar o pedido gratuitamente enquanto o status for "Aguardando Pagamento" ou "Pagamento Confirmado" (antes do despacho). Após o despacho, aplica-se a política de devoluções.</p>
                <p>O direito de arrependimento (CDC, Art. 49) assegura ao consumidor a possibilidade de desistir da compra em até <strong class="text-gray-900 dark:text-white">7 dias corridos</strong> após o recebimento, sem necessidade de justificativa. Para mais detalhes, consulte nossa <a href="{{ route('storefront.page.devolucoes-reembolsos') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Política de Devoluções e Reembolsos</a>.</p>
            </div>
        </section>

        <section id="clausula-7" class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">7</span>
                Propriedade Intelectual
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Todo o conteúdo da Plataforma — incluindo, mas não se limitando a, textos, imagens, logotipos, marcas, layout, código-fonte, design e software — é de propriedade exclusiva da Illuminar e/ou de seus parceiros, estando protegido pelas leis de propriedade intelectual aplicáveis (Lei 9.279/96 e Lei 9.610/98).</p>
                <p>É estritamente proibida a reprodução, distribuição, modificação, transmissão, exibição pública ou uso comercial do conteúdo sem autorização expressa e por escrito da Illuminar.</p>
                <p>A plataforma foi desenvolvida por <strong class="text-gray-900 dark:text-white">Reinan Rodrigues, CEO da Vertex Solutions LTDA</strong>. O código e a arquitetura do sistema são propriedade intelectual da Vertex Solutions LTDA, protegidos pela Lei 9.609/98.</p>
            </div>
        </section>

        <section id="clausula-8" class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">8</span>
                Limitação de Responsabilidade
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>A Illuminar não se responsabiliza por:</p>
                <ul class="list-disc list-inside space-y-1 pl-2">
                    <li>Danos decorrentes do uso inadequado dos produtos pelo consumidor</li>
                    <li>Falhas de terceiros (transportadoras, operadoras de pagamento, provedores de internet)</li>
                    <li>Indisponibilidade temporária da Plataforma por manutenção ou eventos de força maior</li>
                    <li>Prejuízos indiretos, lucros cessantes ou danos morais não previstos pela legislação consumerista brasileira</li>
                </ul>
                <p>A responsabilidade da Illuminar limita-se ao valor do produto adquirido, exceto nos casos previstos no Código de Defesa do Consumidor.</p>
            </div>
        </section>

        <section id="clausula-9" class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 text-sm font-bold">9</span>
                Privacidade e Proteção de Dados
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                O tratamento dos seus dados pessoais é regido pela nossa <a href="{{ route('storefront.page.politica-privacidade') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Política de Privacidade</a>, em conformidade com a Lei Geral de Proteção de Dados (LGPD — Lei 13.709/2018). Ao utilizar nossa Plataforma, você também concorda com nossa Política de Privacidade.
            </p>
        </section>

        <section id="clausula-10" class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6 sm:p-8">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500 text-gray-900 text-sm font-bold">10</span>
                Disposições Gerais e Foro
            </h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Estes Termos são regidos pela legislação da República Federativa do Brasil, em especial pelo Código de Defesa do Consumidor (Lei 8.078/90), pelo Marco Civil da Internet (Lei 12.965/2014) e pela LGPD (Lei 13.709/2018).</p>
                <p>Fica eleito o foro da comarca do domicílio do Usuário para dirimir quaisquer controvérsias oriundas destes Termos, conforme previsto no Art. 101, inciso I do CDC, sem prejuízo de qualquer outro foro privilegiado por lei.</p>
                <p>Caso qualquer disposição destes Termos seja considerada inválida ou inaplicável, as demais disposições permanecerão em pleno vigor e efeito.</p>
                <p>A omissão ou tolerância da Illuminar em exigir o cumprimento de qualquer disposição destes Termos não constituirá novação ou renúncia de direito.</p>
            </div>
        </section>

    </div>

    <p class="mt-10 text-sm text-gray-500 dark:text-gray-400">
        © {{ date('Y') }} Illuminar — Todos os direitos reservados. Plataforma desenvolvida por <strong class="text-gray-600 dark:text-gray-300">Reinan Rodrigues, CEO da Vertex Solutions LTDA</strong>. Esta plataforma e seus termos foram elaborados em conformidade com a legislação brasileira vigente.
    </p>

</div>
</x-storefront::layouts.public>
