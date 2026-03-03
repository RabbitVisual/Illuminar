<x-storefront::layouts.public>
<x-slot name="title">Fale Conosco</x-slot>
<x-slot name="description">Entre em contato com a Illuminar. Tire suas dúvidas, faça sugestões ou resolva problemas.</x-slot>
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-14">

    {{-- Breadcrumb --}}
    <nav class="mb-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Início</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <a href="{{ route('storefront.page.atendimento') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Atendimento</a>
        <x-icon name="chevron-right" style="solid" class="w-3 h-3" />
        <span class="text-gray-900 dark:text-white font-medium">Fale Conosco</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
        {{-- Formulário --}}
        <div class="lg:col-span-2">
            <h1 class="font-display text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3 flex items-center gap-4">
                <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
                    <x-icon name="envelope" style="duotone" class="w-7 h-7" />
                </span>
                Fale Conosco
            </h1>
            <p class="text-gray-600 dark:text-gray-400 text-lg mb-8">
                Preencha o formulário abaixo e nossa equipe retornará em até <strong>24 horas úteis</strong>.
            </p>

            <form action="mailto:contato@illuminar.com.br" method="get" enctype="text/plain"
                  class="space-y-6 rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 sm:p-8 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="nome" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nome completo <span class="text-red-500">*</span></label>
                        <input type="text" id="nome" name="nome" required placeholder="Seu nome"
                               class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-colors">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">E-mail <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" required placeholder="seu@email.com"
                               class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-colors">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="telefone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Telefone / WhatsApp</label>
                        <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000"
                               class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-colors">
                    </div>
                    <div>
                        <label for="assunto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Assunto <span class="text-red-500">*</span></label>
                        <select id="assunto" name="assunto" required
                                class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-colors">
                            <option value="">Selecione um assunto</option>
                            <option value="duvida">Dúvida sobre produto</option>
                            <option value="pedido">Informações sobre pedido</option>
                            <option value="troca">Troca ou devolução</option>
                            <option value="garantia">Garantia de produto</option>
                            <option value="pagamento">Formas de pagamento</option>
                            <option value="corporativo">Atendimento corporativo</option>
                            <option value="sugestao">Sugestão</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="pedido" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Número do pedido (opcional)</label>
                    <input type="text" id="pedido" name="pedido" placeholder="Ex: ILL-2026-00001"
                           class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-colors">
                </div>

                <div>
                    <label for="mensagem" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Mensagem <span class="text-red-500">*</span></label>
                    <textarea id="mensagem" name="mensagem" rows="5" required placeholder="Descreva sua dúvida ou solicitação com o máximo de detalhes possível..."
                              class="w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-colors resize-none"></textarea>
                </div>

                <div class="flex items-start gap-3">
                    <input type="checkbox" id="lgpd" name="lgpd" required
                           class="mt-0.5 h-4 w-4 rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                    <label for="lgpd" class="text-sm text-gray-600 dark:text-gray-400">
                        Concordo com a <a href="{{ route('storefront.page.politica-privacidade') }}" class="text-amber-600 dark:text-amber-400 hover:underline">Política de Privacidade</a> e autorizo o uso dos meus dados para retorno de contato. <span class="text-red-500">*</span>
                    </label>
                </div>

                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3 text-base font-medium text-gray-900 shadow-md shadow-amber-500/20 hover:shadow-amber-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <x-icon name="paper-plane" style="solid" class="w-5 h-5" />
                    Enviar Mensagem
                </button>
            </form>
        </div>

        {{-- Informações laterais --}}
        <div class="space-y-6">
            <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm">
                <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="clock" style="duotone" class="w-5 h-5 text-amber-500" />
                    Horário de Atendimento
                </h2>
                <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                    <li class="flex justify-between">
                        <span>Segunda a Sexta</span>
                        <span class="font-medium text-gray-900 dark:text-white">08h – 18h</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Sábado</span>
                        <span class="font-medium text-gray-900 dark:text-white">08h – 13h</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Domingos e Feriados</span>
                        <span class="font-medium text-gray-900 dark:text-white">Fechado</span>
                    </li>
                </ul>
            </div>

            <div class="rounded-2xl border border-gray-200/80 dark:border-gray-700/80 bg-white dark:bg-gray-800/60 p-6 shadow-sm">
                <h2 class="font-display font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-icon name="address-card" style="duotone" class="w-5 h-5 text-amber-500" />
                    Outros Canais
                </h2>
                <ul class="space-y-4">
                    <li>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Telefone</p>
                        <a href="tel:0000000000" class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:underline">(00) 0000-0000</a>
                    </li>
                    <li>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">E-mail</p>
                        <a href="mailto:contato@illuminar.com.br" class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:underline break-all">contato@illuminar.com.br</a>
                    </li>
                    <li>
                        <p class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">WhatsApp</p>
                        <a href="https://wa.me/5500000000000" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-amber-600 dark:text-amber-400 hover:underline">(00) 00000-0000</a>
                    </li>
                </ul>
            </div>

            <div class="rounded-2xl border border-amber-500/20 dark:border-amber-400/20 bg-amber-500/5 dark:bg-amber-400/5 p-6">
                <x-icon name="circle-info" style="duotone" class="w-6 h-6 text-amber-500 mb-3" />
                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                    Tem um pedido em andamento? Acesse <a href="{{ route('storefront.page.meus-pedidos') }}" class="font-medium text-amber-600 dark:text-amber-400 hover:underline">Meus Pedidos</a> para acompanhar em tempo real.
                </p>
            </div>
        </div>
    </div>

</div>
</x-storefront::layouts.public>
