<x-core::layouts.auth-split title="Cadastre-se - Illuminar">
    @php
        $stepWithError = 1;
        if ($errors->has(['cpf', 'phone', 'birth_date'])) {
            $stepWithError = 2;
        } elseif ($errors->has(['password', 'password_confirmation'])) {
            $stepWithError = 3;
        }
    @endphp
    <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800/90 shadow-lg shadow-amber-500/5 p-6 sm:p-8"
         x-data="{
             step: {{ $stepWithError }},
             maxStep: 3,
             stepError: '',
             validateStep() {
                 const form = this.$refs.registerForm;
                 if (!form) return true;
                 this.stepError = '';
                 if (this.step === 1) {
                     const fn = form.querySelector('#first_name');
                     const ln = form.querySelector('#last_name');
                     const em = form.querySelector('#email');
                     if (!fn || !fn.value.trim()) { this.stepError = 'Preencha o nome.'; fn?.focus(); return false; }
                     if (!ln || !ln.value.trim()) { this.stepError = 'Preencha o sobrenome.'; ln?.focus(); return false; }
                     if (!em || !em.value.trim()) { this.stepError = 'Preencha o e-mail.'; em?.focus(); return false; }
                     if (!/^[^@]+@[^@]+\.\S+$/.test(em.value.trim())) { this.stepError = 'Informe um e-mail válido.'; em?.focus(); return false; }
                     return true;
                 }
                 if (this.step === 2) {
                     const cpf = form.querySelector('#cpf');
                     const phone = form.querySelector('#phone');
                     const bd = form.querySelector('#birth_date');
                     const cpfDigits = (cpf?.value || '').replace(/\D/g, '');
                     const phoneDigits = (phone?.value || '').replace(/\D/g, '');
                     if (cpfDigits.length !== 11) { this.stepError = 'Preencha o CPF com 11 dígitos.'; cpf?.focus(); return false; }
                     if (phoneDigits.length < 10) { this.stepError = 'Preencha o telefone com DDD e número.'; phone?.focus(); return false; }
                     if (!bd?.value) { this.stepError = 'Preencha a data de nascimento.'; bd?.focus(); return false; }
                     return true;
                 }
                 return true;
             },
             goNext() {
                 if (!this.validateStep()) return;
                 this.step++;
             }
         }">
        <div class="mb-6">
            <h1 class="font-display text-2xl font-bold text-gray-900 dark:text-white">Criar conta</h1>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Preencha os dados para se cadastrar e comprar na Illuminar.</p>
            {{-- Indicador de passos --}}
            <div class="mt-4 flex items-center gap-2">
                @foreach ([1 => 'Dados pessoais', 2 => 'Documento e contato', 3 => 'Senha de acesso'] as $s => $label)
                    <div class="flex items-center gap-1.5">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full text-sm font-medium transition-colors"
                              :class="step >= {{ $s }} ? 'bg-amber-500 text-gray-900' : 'bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-400'"
                              x-text="{{ $s }}"></span>
                        @if ($s < 3)
                            <span class="hidden sm:block w-6 h-0.5 rounded bg-gray-200 dark:bg-gray-600" :class="{ 'bg-amber-500 dark:bg-amber-400': step > {{ $s }} }"></span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        @include('user::auth.partials.recaptcha')
        <form method="POST" action="{{ route('register') }}" data-recaptcha-action="register" id="register-form" x-ref="registerForm"
              @submit="
                  const form = $refs.registerForm;
                  if (step !== maxStep) { $event.preventDefault(); goNext(); return; }
                  stepError = '';
                  const pw = form?.querySelector('#password');
                  const pw2 = form?.querySelector('#password_confirmation');
                  if (pw && pw.value.length < 8) { $event.preventDefault(); stepError = 'A senha deve ter no mínimo 8 caracteres.'; pw.focus(); return; }
                  if (pw && pw2 && pw.value !== pw2.value) { $event.preventDefault(); stepError = 'As senhas não conferem.'; pw2.focus(); return; }
              ">
            @csrf
            @include('user::auth.partials.recaptcha-input')

            {{-- Passo 1: Nome, Sobrenome, E-mail --}}
            <div x-show="step === 1" x-cloak class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus
                               class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sobrenome</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required
                               class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('email') border-red-500 @enderror"
                           placeholder="seu@email.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Passo 2: CPF, Telefone, Data de nascimento --}}
            <div x-show="step === 2" x-cloak class="space-y-4" style="display: none;">
                <div>
                    <label for="cpf" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CPF</label>
                    <input type="text" id="cpf" name="cpf" value="{{ old('cpf') }}" required x-mask="'999.999.999-99'" maxlength="14"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('cpf') border-red-500 @enderror"
                           placeholder="000.000.000-00">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Necessário para emissão de nota fiscal e processamento de pagamento.</p>
                    @error('cpf')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required x-mask="'(99) 99999-9999'"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('phone') border-red-500 @enderror"
                           placeholder="(00) 00000-0000">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de nascimento</label>
                    <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('birth_date') border-red-500 @enderror">
                    @error('birth_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Passo 3: Senha e newsletter --}}
            <div x-show="step === 3" x-cloak class="space-y-4" style="display: none;">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Senha</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500 @error('password') border-red-500 @enderror"
                           placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar senha</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                           class="mt-1 block w-full rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700/50 px-3 py-2.5 text-gray-900 dark:text-white focus:ring-2 focus:ring-amber-500"
                           placeholder="Repita a senha">
                </div>
                <label class="inline-flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <input type="checkbox" name="newsletter" value="1" {{ old('newsletter') ? 'checked' : '' }}
                           class="rounded border-gray-300 text-amber-500 focus:ring-amber-500">
                    Quero receber ofertas e novidades por e-mail
                </label>
            </div>

            {{-- Mensagem de erro da etapa (campos obrigatórios não preenchidos) --}}
            <div x-show="stepError" x-cloak
                 class="mt-4 rounded-xl bg-red-500/10 dark:bg-red-400/10 border border-red-500/20 dark:border-red-400/20 px-4 py-3 text-sm text-red-700 dark:text-red-300 flex items-center gap-2">
                <x-icon name="circle-exclamation" style="solid" class="w-5 h-5 shrink-0" />
                <span x-text="stepError"></span>
            </div>

            {{-- Botões de navegação --}}
            <div class="mt-6 flex gap-3">
                <template x-if="step > 1">
                    <button type="button"
                            @click="stepError = ''; step--"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 rounded-xl border-2 border-gray-300 dark:border-gray-600 px-4 py-3 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <x-icon name="arrow-left" style="solid" class="w-5 h-5" />
                        Voltar
                    </button>
                </template>
                <template x-if="step < maxStep">
                    <button type="button"
                            @click="goNext()"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 font-medium text-gray-900 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 transition-all">
                        Próximo
                        <x-icon name="arrow-right" style="solid" class="w-5 h-5" />
                    </button>
                </template>
                <template x-if="step === maxStep">
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-4 py-3 font-medium text-gray-900 shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 transition-all">
                        <x-icon name="user-plus" style="solid" class="w-5 h-5" />
                        Criar conta
                    </button>
                </template>
            </div>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600 dark:text-gray-400">
            Já tem conta? <a href="{{ route('login') }}" class="font-medium text-amber-600 dark:text-amber-400 hover:underline">Entrar</a>
        </p>
    </div>
</x-core::layouts.auth-split>
