<x-core::layouts.master heading="Meu Perfil">
    <div class="max-w-2xl space-y-6">
        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
            <a href="{{ route('customer.index') }}" class="hover:text-primary transition-colors">Meu Painel</a>
            <x-icon name="chevron-right" style="solid" class="w-4 h-4" />
            <span class="text-gray-900 dark:text-white">Meu Perfil</span>
        </div>

        @if (session('success'))
            <div class="rounded-lg border border-success/30 bg-success/10 px-4 py-3 text-sm text-success dark:bg-success/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="rounded-xl border border-border dark:border-border bg-white dark:bg-surface p-6 shadow-sm">
            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('customer.profile.update') }}"
                  x-data="{ loading: false }"
                  x-on:submit="loading = true; window.dispatchEvent(new CustomEvent('start-loading'))">
                @csrf

                <div class="space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <img src="{{ $user->photo_url }}"
                                 alt="{{ $user->full_name ?? $user->email }}"
                                 class="h-20 w-20 rounded-full object-cover border-2 border-primary-500 shadow-sm">
                        </div>
                        <div class="space-y-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $user->full_name ?? $user->email }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Foto de perfil usada em todo o painel e PDV.
                            </p>
                            <label class="inline-flex items-center gap-2 mt-1 cursor-pointer text-xs sm:text-sm font-medium text-primary-700 dark:text-primary-300">
                                <x-icon name="camera" style="duotone" class="w-4 h-4" />
                                <span>Alterar foto</span>
                                <input type="file"
                                       name="photo"
                                       accept="image/jpeg,image/png,image/webp"
                                       class="hidden">
                            </label>
                            @error('photo')
                                <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-border dark:border-border pt-4 space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                            <input type="text"
                                   id="first_name"
                                   name="first_name"
                                   value="{{ old('first_name', $user->first_name) }}"
                                   required
                                   class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('first_name') border-danger @enderror"
                                   placeholder="Nome">
                            @error('first_name')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sobrenome</label>
                            <input type="text"
                                   id="last_name"
                                   name="last_name"
                                   value="{{ old('last_name', $user->last_name) }}"
                                   required
                                   class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('last_name') border-danger @enderror"
                                   placeholder="Sobrenome">
                            @error('last_name')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                            <input type="email"
                                   id="email"
                                   value="{{ $user->email }}"
                                   disabled
                                   class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-gray-100 dark:bg-gray-800 px-3 py-2 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">O e-mail não pode ser alterado.</p>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone</label>
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone', $user->phone) }}"
                                   x-mask="'phone'"
                                   class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-danger @enderror"
                                   placeholder="(00) 00000-0000">
                            @error('phone')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="phone_secondary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefone secundário</label>
                            <input type="text"
                                   id="phone_secondary"
                                   name="phone_secondary"
                                   value="{{ old('phone_secondary', $user->phone_secondary) }}"
                                   x-mask="'phone'"
                                   class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('phone_secondary') border-danger @enderror"
                                   placeholder="(00) 00000-0000">
                            @error('phone_secondary')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data de nascimento</label>
                            <input type="date"
                                   id="birth_date"
                                   name="birth_date"
                                   value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('birth_date') border-danger @enderror">
                            @error('birth_date')
                                <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-4 border-t border-border dark:border-border" x-data="{ document_type: '{{ old('document_type', $user->document_type) }}' }">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Documento</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="document_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                                <select id="document_type"
                                        name="document_type"
                                        x-model="document_type"
                                        class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('document_type') border-danger @enderror">
                                    <option value="cpf" {{ old('document_type', $user->document_type) === 'cpf' ? 'selected' : '' }}>CPF</option>
                                    <option value="cnpj" {{ old('document_type', $user->document_type) === 'cnpj' ? 'selected' : '' }}>CNPJ</option>
                                </select>
                                @error('document_type')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="document" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CPF / CNPJ</label>
                                <input type="text"
                                       id="document"
                                       name="document"
                                       value="{{ old('document', $user->document_formatted ?? $user->document) }}"
                                       x-mask="document_type === 'cnpj' ? '99.999.999/9999-99' : '999.999.999-99'"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('document') border-danger @enderror"
                                       :placeholder="document_type === 'cnpj' ? '00.000.000/0001-00' : '000.000.000-00'">
                                @error('document')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4" x-show="document_type === 'cnpj'" x-cloak style="display: none;">
                            <div class="sm:col-span-2">
                                <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Razão social</label>
                                <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $user->company_name) }}"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('company_name') border-danger @enderror" placeholder="Nome da empresa">
                                @error('company_name')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="trade_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome fantasia</label>
                                <input type="text" id="trade_name" name="trade_name" value="{{ old('trade_name', $user->trade_name) }}"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('trade_name') border-danger @enderror">
                                @error('trade_name')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="state_registration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Inscrição estadual</label>
                                <input type="text" id="state_registration" name="state_registration" value="{{ old('state_registration', $user->state_registration) }}"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('state_registration') border-danger @enderror">
                                @error('state_registration')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="municipal_registration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Inscrição municipal</label>
                                <input type="text" id="municipal_registration" name="municipal_registration" value="{{ old('municipal_registration', $user->municipal_registration) }}"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('municipal_registration') border-danger @enderror">
                                @error('municipal_registration')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-border dark:border-border">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Endereço</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">CEP</label>
                                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                                           x-mask="'99999-999'"
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('postal_code') border-danger @enderror" placeholder="00000-000">
                                    @error('postal_code')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="street" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Logradouro</label>
                                    <input type="text" id="street" name="street" value="{{ old('street', $user->street) }}"
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('street') border-danger @enderror" placeholder="Rua, avenida">
                                    @error('street')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                <div>
                                    <label for="number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número</label>
                                    <input type="text" id="number" name="number" value="{{ old('number', $user->number) }}"
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('number') border-danger @enderror">
                                    @error('number')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="complement" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Complemento</label>
                                    <input type="text" id="complement" name="complement" value="{{ old('complement', $user->complement) }}"
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('complement') border-danger @enderror">
                                    @error('complement')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="neighborhood" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bairro</label>
                                    <input type="text" id="neighborhood" name="neighborhood" value="{{ old('neighborhood', $user->neighborhood) }}"
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('neighborhood') border-danger @enderror">
                                    @error('neighborhood')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cidade</label>
                                    <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}"
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary @error('city') border-danger @enderror">
                                    @error('city')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado (UF)</label>
                                    <input type="text" id="state" name="state" value="{{ old('state', $user->state) }}" maxlength="2"
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary uppercase @error('state') border-danger @enderror" placeholder="SP">
                                    @error('state')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">País</label>
                                    <input type="text" id="country" name="country" value="{{ old('country', $user->country ?? 'BR') }}" maxlength="2"
                                           class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary uppercase @error('country') border-danger @enderror" placeholder="BR">
                                    @error('country')<p class="mt-1 text-sm text-danger">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-border dark:border-border">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Preferências</h3>
                        <div class="flex flex-wrap gap-4">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="newsletter" value="1" {{ old('newsletter', $user->newsletter) ? 'checked' : '' }}
                                       class="rounded border-border dark:border-border text-primary focus:ring-primary">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Receber newsletter</span>
                            </label>
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="accepts_marketing" value="1" {{ old('accepts_marketing', $user->accepts_marketing) ? 'checked' : '' }}
                                       class="rounded border-border dark:border-border text-primary focus:ring-primary">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Aceitar marketing</span>
                            </label>
                            <div>
                                <label for="preferred_contact" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Preferência de contato</label>
                                <select id="preferred_contact" name="preferred_contact"
                                        class="mt-1 rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary text-sm">
                                    <option value="email" {{ old('preferred_contact', $user->preferred_contact) === 'email' ? 'selected' : '' }}>E-mail</option>
                                    <option value="phone" {{ old('preferred_contact', $user->preferred_contact) === 'phone' ? 'selected' : '' }}>Telefone</option>
                                    <option value="whatsapp" {{ old('preferred_contact', $user->preferred_contact) === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-border dark:border-border">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Alterar senha</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Deixe em branco para manter a senha atual.</p>
                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nova senha</label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent @error('password') border-danger @enderror"
                                       placeholder="••••••••">
                                @error('password')
                                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar nova senha</label>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="mt-1 block w-full rounded-lg border border-border dark:border-border bg-white dark:bg-surface px-3 py-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary focus:border-transparent"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 font-medium text-white hover:opacity-90 transition-opacity">
                        <x-icon name="check" style="solid" class="w-4 h-4" />
                        Salvar alterações
                    </button>
                    <a href="{{ route('customer.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-border dark:border-border px-4 py-2 font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <x-icon name="arrow-left" style="solid" class="w-4 h-4" />
                        Voltar
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-core::layouts.master>
