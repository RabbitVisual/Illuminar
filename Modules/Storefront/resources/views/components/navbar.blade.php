{{-- Navbar público - consome darkMode e cart do escopo pai (storefrontCart) --}}
<header class="sticky top-0 z-40 border-b border-gray-200/80 dark:border-gray-700/80 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md shadow-sm animate-fade-in-up"
        x-data="{ scrolled: false, mobileOpen: false }"
        x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)">
    <div class="absolute inset-0 bg-gradient-to-r from-amber-500/5 via-transparent to-amber-500/5 dark:from-amber-400/10 dark:via-transparent dark:to-amber-400/10 pointer-events-none"></div>
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-4">
            <a href="{{ route('storefront.index') }}" class="shrink-0 flex items-center group">
                <x-core::logo height="h-10" class="w-auto transition-transform duration-300 group-hover:scale-105" />
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden lg:flex items-center gap-1 sm:gap-2">
                <a href="{{ route('storefront.index') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 transition-all duration-300">
                    Início
                </a>
                <a href="{{ route('storefront.catalog') }}"
                   class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 transition-all duration-300">
                    Catálogo
                </a>

                <button type="button"
                        @click="darkMode = !darkMode"
                        class="p-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:text-amber-600 dark:hover:text-amber-400 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500/50"
                        aria-label="Alternar tema">
                    <span x-show="!darkMode" x-cloak><x-icon name="sun-bright" style="duotone" class="w-5 h-5" /></span>
                    <span x-show="darkMode" x-cloak><x-icon name="moon" style="duotone" class="w-5 h-5" /></span>
                </button>

                <a href="{{ route('storefront.cart') }}"
                   class="relative inline-flex items-center gap-2 rounded-lg px-3 py-2.5 text-gray-700 dark:text-gray-300 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:text-amber-600 dark:hover:text-amber-400 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500/50">
                    <x-icon name="cart-shopping" style="duotone" class="w-5 h-5" />
                    <span x-show="cart.length > 0"
                          x-cloak
                          x-transition:enter="transition ease-out duration-300"
                          x-transition:enter-start="opacity-0 scale-75"
                          x-transition:enter-end="opacity-100 scale-100"
                          class="absolute -top-0.5 -right-0.5 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-amber-500 dark:bg-amber-400 text-xs font-bold text-gray-900 shadow-lg shadow-amber-500/30"
                          :class="{ 'animate-cart-pop': cart.length > 0 }"
                          x-text="cart.length"></span>
                </a>

                @auth
                    <a href="@role('Customer'){{ route('customer.index') }}@else{{ Route::has('admin.index') ? route('admin.index') : route('storefront.index') }}@endrole"
                       class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 dark:from-amber-500 dark:to-amber-600 px-4 py-2 text-sm font-medium text-gray-900 hover:from-amber-400 hover:to-amber-500 dark:hover:from-amber-400 dark:hover:to-amber-500 transition-all duration-300 shadow-md shadow-amber-500/25">
                        <x-icon name="user" style="duotone" class="w-4 h-4" />
                        Minha Conta
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center gap-2 rounded-lg border-2 border-amber-500 dark:border-amber-400 px-4 py-2 text-sm font-medium text-amber-600 dark:text-amber-400 hover:bg-amber-500 hover:text-gray-900 dark:hover:bg-amber-400 dark:hover:text-gray-900 transition-all duration-300">
                        Entrar
                    </a>
                @endauth
            </nav>

            {{-- Mobile: right actions (cart + hamburger) --}}
            <div class="flex lg:hidden items-center gap-1">
                <a href="{{ route('storefront.cart') }}"
                   class="relative p-2.5 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 transition-all duration-300">
                    <x-icon name="cart-shopping" style="duotone" class="w-5 h-5" />
                    <span x-show="cart.length > 0"
                          x-cloak
                          class="absolute top-1 right-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-amber-500 dark:bg-amber-400 text-[10px] font-bold text-gray-900"
                          x-text="cart.length"></span>
                </a>
                <button type="button"
                        @click="mobileOpen = !mobileOpen"
                        class="p-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500/50"
                        aria-label="Abrir menu"
                        :aria-expanded="mobileOpen">
                    <x-icon name="bars" style="solid" class="w-6 h-6" />
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div x-show="mobileOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.self="mobileOpen = false"
         class="fixed inset-x-0 top-16 z-30 lg:hidden">
        <div class="border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-lg">
            <nav class="mx-auto max-w-7xl px-4 py-4 space-y-1">
                <a href="{{ route('storefront.index') }}"
                   @click="mobileOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:text-amber-600 dark:hover:text-amber-400 transition-all duration-300">
                    <x-icon name="house" style="duotone" class="w-5 h-5" />
                    Início
                </a>
                <a href="{{ route('storefront.catalog') }}"
                   @click="mobileOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:text-amber-600 dark:hover:text-amber-400 transition-all duration-300">
                    <x-icon name="tags" style="duotone" class="w-5 h-5" />
                    Catálogo
                </a>
                <a href="{{ route('storefront.cart') }}"
                   @click="mobileOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 hover:text-amber-600 dark:hover:text-amber-400 transition-all duration-300">
                    <x-icon name="cart-shopping" style="duotone" class="w-5 h-5" />
                    Carrinho
                    <span x-show="cart.length > 0" x-cloak class="ml-auto rounded-full bg-amber-500 dark:bg-amber-400 px-2 py-0.5 text-xs font-bold text-gray-900" x-text="cart.length"></span>
                </a>
                <div class="flex items-center gap-3 px-4 py-3">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Tema</span>
                    <button type="button"
                            @click="darkMode = !darkMode"
                            class="p-2.5 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-amber-500/10 dark:hover:bg-amber-400/10 transition-all duration-300"
                            aria-label="Alternar tema">
                        <span x-show="!darkMode" x-cloak><x-icon name="sun-bright" style="duotone" class="w-5 h-5" /></span>
                        <span x-show="darkMode" x-cloak><x-icon name="moon" style="duotone" class="w-5 h-5" /></span>
                    </button>
                </div>
                @auth
                    <a href="@role('Customer'){{ route('customer.index') }}@else{{ Route::has('admin.index') ? route('admin.index') : route('storefront.index') }}@endrole"
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg bg-amber-500/10 dark:bg-amber-400/10 text-amber-700 dark:text-amber-300 font-medium">
                        <x-icon name="user" style="duotone" class="w-5 h-5" />
                        Minha Conta
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       @click="mobileOpen = false"
                       class="flex items-center gap-3 px-4 py-3 rounded-lg border-2 border-amber-500 dark:border-amber-400 text-amber-600 dark:text-amber-400 font-medium">
                        <x-icon name="right-to-bracket" style="solid" class="w-5 h-5" />
                        Entrar
                    </a>
                @endauth
            </nav>
        </div>
    </div>
</header>
