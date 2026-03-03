<x-storefront::layouts.public>
<x-slot name="title">Política de Privacidade</x-slot>
<x-slot name="description">Política de Privacidade da Illuminar. Saiba como coletamos, usamos e protegemos seus dados pessoais conforme a LGPD.</x-slot>
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Política de Privacidade</span>
    </nav>

    <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="shield-halved" style="duotone" class="w-7 h-7" />
        </span>
        Política de Privacidade
    </h1>
    <p class="text-gray-600 dark:text-gray-400 mb-2">Em conformidade com a <strong>Lei Geral de Proteção de Dados (LGPD — Lei 13.709/2018)</strong>.</p>
    <p class="text-xs text-gray-500 dark:text-gray-400 mb-10">Última atualização: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>

    <div class="space-y-8">

        {{-- 1. Controlador dos dados --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4">1. Identificação do Controlador</h2>
            <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                <p><strong class="text-gray-900 dark:text-white">Nome fantasia:</strong> Illuminar — Materiais Elétricos e Iluminação</p>
                <p><strong class="text-gray-900 dark:text-white">Responsável pelo desenvolvimento:</strong> Reinan Rodrigues, CEO da Vertex Solutions LTDA</p>
                <p><strong class="text-gray-900 dark:text-white">E-mail para assuntos de privacidade:</strong> <a href="mailto:privacidade@illuminar.com.br" class="text-amber-600 dark:text-amber-400 hover:underline">privacidade@illuminar.com.br</a></p>
            </div>
        </section>

        {{-- 2. Dados coletados --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4">2. Dados Coletados</h2>
            <div class="space-y-4 text-sm text-gray-600 dark:text-gray-400">
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white mb-2">2.1 Dados fornecidos diretamente por você:</p>
                    <ul class="list-disc list-inside space-y-1 pl-2">
                        <li>Nome completo, CPF ou CNPJ</li>
                        <li>Endereço de e-mail e senha de acesso</li>
                        <li>Endereço completo (para entrega e faturamento)</li>
                        <li>Número de telefone / WhatsApp</li>
                        <li>Dados de pagamento (processados de forma criptografada)</li>
                    </ul>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white mb-2">2.2 Dados coletados automaticamente:</p>
                    <ul class="list-disc list-inside space-y-1 pl-2">
                        <li>Endereço IP e dados de localização aproximada</li>
                        <li>Tipo de navegador e sistema operacional</li>
                        <li>Páginas visitadas e produtos visualizados</li>
                        <li>Data e hora de acesso</li>
                        <li>Cookies e tecnologias similares de rastreamento</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- 3. Finalidades --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4">3. Finalidades do Tratamento</h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                <p>Utilizamos seus dados para as seguintes finalidades, todas com base legal na LGPD:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                    @foreach([
                        ['base' => 'Contrato', 'desc' => 'Processar e entregar pedidos, emitir notas fiscais e gerenciar sua conta'],
                        ['base' => 'Contrato', 'desc' => 'Comunicar sobre o status do pedido, entrega e confirmação de pagamento'],
                        ['base' => 'Legítimo interesse', 'desc' => 'Prevenir fraudes e garantir a segurança das transações'],
                        ['base' => 'Legítimo interesse', 'desc' => 'Melhorar a experiência de navegação e personalizar o atendimento'],
                        ['base' => 'Consentimento', 'desc' => 'Enviar comunicações de marketing, promoções e novidades (opt-in)'],
                        ['base' => 'Obrigação legal', 'desc' => 'Cumprir obrigações fiscais, tributárias e regulatórias'],
                    ] as $f)
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-3">
                        <span class="inline-block rounded-md bg-amber-500/10 px-2 py-0.5 text-xs font-medium text-amber-700 dark:text-amber-300 mb-2">{{ $f['base'] }}</span>
                        <p class="text-xs leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- 4. Compartilhamento --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4">4. Compartilhamento de Dados</h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Compartilhamos seus dados apenas quando estritamente necessário, com:</p>
                <ul class="list-disc list-inside space-y-1 pl-2">
                    <li><strong class="text-gray-900 dark:text-white">Transportadoras:</strong> nome, endereço e telefone para efetuar a entrega</li>
                    <li><strong class="text-gray-900 dark:text-white">Gateways de pagamento:</strong> dados necessários para processamento seguro (nenhuma informação de cartão é armazenada pela Illuminar)</li>
                    <li><strong class="text-gray-900 dark:text-white">Autoridades públicas:</strong> quando exigido por lei, ordem judicial ou regulação fiscal</li>
                </ul>
                <p class="mt-2">Não vendemos, alugamos ou cedemos seus dados pessoais a terceiros para fins comerciais.</p>
            </div>
        </section>

        {{-- 5. Direitos do titular --}}
        <section class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6 sm:p-8">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <x-icon name="user-shield" style="duotone" class="w-5 h-5 text-amber-500" />
                5. Seus Direitos como Titular (LGPD, Art. 18)
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach([
                    ['icon' => 'eye', 'right' => 'Acesso', 'desc' => 'Solicitar a confirmação e acesso aos dados que possuímos sobre você'],
                    ['icon' => 'pen', 'right' => 'Correção', 'desc' => 'Solicitar a correção de dados incompletos, inexatos ou desatualizados'],
                    ['icon' => 'trash', 'right' => 'Exclusão', 'desc' => 'Solicitar a anonimização, bloqueio ou exclusão dos seus dados'],
                    ['icon' => 'ban', 'right' => 'Revogação', 'desc' => 'Revogar o consentimento dado para tratamento dos seus dados'],
                    ['icon' => 'file-export', 'right' => 'Portabilidade', 'desc' => 'Solicitar a portabilidade dos dados a outro fornecedor de serviço'],
                    ['icon' => 'circle-info', 'right' => 'Informação', 'desc' => 'Ser informado sobre as entidades com as quais os dados foram compartilhados'],
                ] as $r)
                <div class="flex items-start gap-3 rounded-xl bg-white dark:bg-gray-800/60 p-3 border border-gray-200/50 dark:border-gray-700/50">
                    <x-icon name="{{ $r['icon'] }}" style="duotone" class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" />
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $r['right'] }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-0.5">{{ $r['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">Para exercer seus direitos, entre em contato via <a href="mailto:privacidade@illuminar.com.br" class="text-amber-600 dark:text-amber-400 hover:underline">privacidade@illuminar.com.br</a> ou pelo <a href="{{ route('storefront.page.fale-conosco') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Fale Conosco</a>. Responderemos em até 15 dias corridos.</p>
        </section>

        {{-- 6. Cookies --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4">6. Cookies</h2>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Utilizamos cookies para proporcionar melhor experiência de navegação. Os tipos de cookies utilizados são:</p>
                <ul class="list-disc list-inside space-y-1 pl-2">
                    <li><strong class="text-gray-900 dark:text-white">Essenciais:</strong> necessários para o funcionamento básico do site (sessão, carrinho, autenticação)</li>
                    <li><strong class="text-gray-900 dark:text-white">Preferências:</strong> armazenam suas escolhas (tema claro/escuro, idioma)</li>
                    <li><strong class="text-gray-900 dark:text-white">Analíticos:</strong> coletam dados anônimos de navegação para melhorias no site</li>
                </ul>
                <p>Você pode gerenciar ou desabilitar cookies nas configurações do seu navegador. A desativação de cookies essenciais pode comprometer o funcionamento do site.</p>
            </div>
        </section>

        {{-- 7. Segurança --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4">7. Segurança dos Dados</h2>
            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                <p>Implementamos medidas técnicas e organizacionais para proteger seus dados:</p>
                <ul class="list-disc list-inside space-y-1 pl-2">
                    <li>Criptografia SSL/TLS para transmissão de dados</li>
                    <li>Senhas armazenadas com hash bcrypt (nunca em texto simples)</li>
                    <li>Acesso restrito aos dados apenas por pessoal autorizado</li>
                    <li>Monitoramento de acessos e tentativas de fraude</li>
                    <li>Backups regulares com proteção contra perda de dados</li>
                </ul>
                <p class="mt-2">Em caso de incidente de segurança que possa afetar seus dados, notificaremos a ANPD e os titulares afetados nos prazos previstos pela LGPD.</p>
            </div>
        </section>

        {{-- 8. Retenção --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4">8. Retenção de Dados</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                Mantemos seus dados pelo tempo necessário para cumprir as finalidades descritas nesta política e as obrigações legais aplicáveis. Dados de transações são mantidos por <strong class="text-gray-900 dark:text-white">5 anos</strong> para fins fiscais (Código Tributário Nacional). Dados de conta podem ser excluídos a pedido, observadas as obrigações legais de retenção.
            </p>
        </section>

        {{-- 9. Alterações --}}
        <section class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
            <h2 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-4">9. Alterações nesta Política</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                Podemos atualizar esta Política de Privacidade periodicamente. A data de "Última atualização" no topo desta página indica quando a revisão mais recente foi feita. Alterações significativas serão comunicadas por e-mail ou notificação no site. O uso continuado dos nossos serviços após as alterações constitui aceite da nova política.
            </p>
        </section>

    </div>

    <p class="mt-10 text-sm text-gray-500 dark:text-gray-400">
        Esta Política de Privacidade foi elaborada em conformidade com a Lei 13.709/2018 (LGPD), a Lei 12.965/2014 (Marco Civil da Internet) e demais legislações brasileiras aplicáveis. © {{ date('Y') }} Illuminar — Desenvolvido por Reinan Rodrigues, CEO da Vertex Solutions LTDA.
    </p>

</div>
</x-storefront::layouts.public>
