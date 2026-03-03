<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="storefrontCart()"
      :class="{ 'dark': darkMode }"
      x-init="loadCartFromStorage(); $watch('darkMode', val => {
          localStorage.setItem('theme', val ? 'dark' : 'light');
          document.documentElement.classList.toggle('dark', val);
      })"
      @illuminar-add-to-cart.window="addToCart($event.detail)">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ $title ?? config('app.name', 'Illuminar') }}</title>

    <meta name="description" content="{{ $description ?? 'Materiais elétricos e iluminação' }}">
    <meta name="keywords" content="{{ $keywords ?? 'iluminação, lâmpadas, materiais elétricos' }}">
    <meta name="author" content="{{ $author ?? '' }}">

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen">
    <x-loading-overlay />

    {{-- Header Público --}}
    <header class="sticky top-0 z-40 border-b border-gray-200 dark:border-gray-700 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-4">
                <a href="{{ route('storefront.index') }}" class="font-display font-bold text-xl text-primary dark:text-primary shrink-0">
                    Illuminar
                </a>

                <nav class="flex items-center gap-4">
                    <a href="{{ route('storefront.index') }}"
                       class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-primary dark:hover:text-primary transition-colors">
                        Início
                    </a>

                    <button type="button"
                            @click="darkMode = !darkMode"
                            class="p-2 rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"
                            aria-label="Alternar tema">
                        <x-icon name="sun-bright" style="duotone" class="block dark:hidden w-5 h-5" />
                        <x-icon name="moon" style="duotone" class="hidden dark:block w-5 h-5" />
                    </button>

                    <a href="{{ route('storefront.cart') }}"
                       class="relative inline-flex items-center gap-2 rounded-lg px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <x-icon name="cart-shopping" style="duotone" class="w-5 h-5" />
                        <span x-show="cart.length > 0"
                              x-cloak
                              x-transition
                              class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-primary text-xs font-bold text-white"
                              x-text="cart.length"></span>
                    </a>

                    @auth
                        <a href="{{ route('admin.index') }}"
                           class="inline-flex items-center gap-2 rounded-lg bg-primary px-4 py-2 text-sm font-medium text-white hover:opacity-90 transition-opacity">
                            <x-icon name="user" style="duotone" class="w-4 h-4" />
                            Minha Conta
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 rounded-lg border border-primary px-4 py-2 text-sm font-medium text-primary hover:bg-primary hover:text-white transition-colors">
                            Entrar
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <script>
        function storefrontCart() {
            return {
                cart: [],
                CART_KEY: 'illuminar_cart',
                darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),

                loadCartFromStorage() {
                    try {
                        const stored = localStorage.getItem(this.CART_KEY);
                        this.cart = stored ? JSON.parse(stored) : [];
                    } catch (e) {
                        this.cart = [];
                    }
                },

                saveCartToStorage() {
                    localStorage.setItem(this.CART_KEY, JSON.stringify(this.cart));
                },

                addToCart(product) {
                    const existing = this.cart.find(item => item.product_id === product.id);
                    if (existing) {
                        const newQty = existing.quantity + 1;
                        if (product.stock !== undefined && newQty > product.stock) return;
                        existing.quantity = newQty;
                        existing.subtotal = existing.price * newQty;
                    } else {
                        if (product.stock !== undefined && product.stock < 1) return;
                        this.cart.push({
                            product_id: product.id,
                            name: product.name,
                            sku: product.sku,
                            price: product.price,
                            quantity: 1,
                            subtotal: product.price,
                            stock: product.stock ?? 999
                        });
                    }
                    this.saveCartToStorage();
                },

                removeFromCart(productId) {
                    this.cart = this.cart.filter(item => item.product_id !== productId);
                    this.saveCartToStorage();
                },

                updateQty(productId, qty) {
                    const item = this.cart.find(i => i.product_id === productId);
                    if (!item) return;
                    const numQty = parseInt(qty, 10) || 1;
                    const maxQty = item.stock !== undefined ? Math.min(numQty, item.stock) : numQty;
                    item.quantity = Math.max(1, maxQty);
                    item.subtotal = item.price * item.quantity;
                    this.saveCartToStorage();
                },

                getCartTotal() {
                    return this.cart.reduce((sum, item) => sum + item.subtotal, 0);
                },

                formatMoney(cents) {
                    const val = (cents / 100).toFixed(2).replace('.', ',');
                    return 'R$ ' + val.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                },

                clearCart() {
                    this.cart = [];
                    this.saveCartToStorage();
                }
            };
        }
    </script>
</body>
</html>
