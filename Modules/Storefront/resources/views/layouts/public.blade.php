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
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen overflow-x-hidden flex flex-col">
    <x-loading-overlay />

    <x-storefront::navbar />

    <main class="flex-1">
        {{ $slot }}
    </main>

    <x-storefront::footer />

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

                saveCartFromStorage() {
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
                    this.saveCartFromStorage();
                },

                removeFromCart(productId) {
                    this.cart = this.cart.filter(item => item.product_id !== productId);
                    this.saveCartFromStorage();
                },

                updateQty(productId, qty) {
                    const item = this.cart.find(i => i.product_id === productId);
                    if (!item) return;
                    const numQty = parseInt(qty, 10) || 1;
                    const maxQty = item.stock !== undefined ? Math.min(numQty, item.stock) : numQty;
                    item.quantity = Math.max(1, maxQty);
                    item.subtotal = item.price * item.quantity;
                    this.saveCartFromStorage();
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
                    this.saveCartFromStorage();
                }
            };
        }
    </script>
</body>
</html>
