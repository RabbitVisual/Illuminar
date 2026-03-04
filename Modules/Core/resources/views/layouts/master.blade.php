<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          sidebarOpen: false
      }"
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => {
          localStorage.setItem('theme', val ? 'dark' : 'light');
          if (val) {
              document.documentElement.classList.add('dark');
          } else {
              document.documentElement.classList.remove('dark');
          }
      })">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ $title ?? config('app.name', 'Illuminar') }}</title>

    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
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
<body class="font-sans antialiased bg-background text-gray-900 dark:bg-background dark:text-gray-100 min-h-screen">
    <x-loading-overlay />

    {{-- Navbar principal (Flowbite) --}}
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start gap-3">
                    <button type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600"
                            aria-controls="sidebar"
                            aria-expanded="false"
                            @click="sidebarOpen = !sidebarOpen">
                        <span class="sr-only">Abrir menu lateral</span>
                        <x-icon name="bars" style="solid" class="w-6 h-6" />
                    </button>
                    <a href="@role('Customer'){{ route('customer.index') }}@else{{ Route::has('admin.index') ? route('admin.index') : url('/core') }}@endrole"
                       class="flex items-center gap-2">
                        <x-core::logo height="h-8" class="w-auto max-w-[140px]" />
                    </a>
                    <span class="hidden md:inline-flex items-center text-sm font-medium text-gray-500 dark:text-gray-400">
                        <x-icon name="angle-right" style="solid" class="w-4 h-4 mr-1" />
                        <span>{{ $heading ?? 'Painel' }}</span>
                    </span>
                </div>
                <div class="flex items-center gap-3">
                    @hasanyrole('SuperAdmin|Owner|Manager|Cashier')
                        @if (Route::has('storefront.index'))
                            <a href="{{ route('storefront.index') }}"
                               target="_blank"
                               class="hidden md:inline-flex items-center gap-2 rounded-lg border border-primary-600 text-primary-700 dark:text-primary-300 px-4 py-2 text-sm font-medium hover:bg-primary-700 hover:text-white focus:ring-4 focus:ring-primary-300 dark:hover:bg-primary-600 dark:focus:ring-primary-800">
                                <x-icon name="store" style="duotone" class="w-5 h-5" />
                                <span>Ver Loja</span>
                            </a>
                        @endif
                        @if (Route::has('pdv.index'))
                            <a href="{{ route('pdv.index') }}"
                               target="_blank"
                               class="hidden md:inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800">
                                <x-icon name="cash-register" style="duotone" class="w-5 h-5" />
                                <span>Abrir PDV</span>
                            </a>
                        @endif
                    @endhasanyrole

                    {{-- Toggle de tema (navbar) --}}
                    <button type="button"
                            @click="darkMode = !darkMode"
                            data-tooltip-target="tooltip-theme-toggle"
                            class="inline-flex items-center justify-center w-9 h-9 text-gray-500 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700"
                            aria-label="Alternar tema claro/escuro">
                        <span x-show="!darkMode" x-cloak>
                            <x-icon name="sun-bright" style="duotone" class="w-5 h-5 text-yellow-400" />
                        </span>
                        <span x-show="darkMode" x-cloak>
                            <x-icon name="moon" style="duotone" class="w-5 h-5 text-slate-200" />
                        </span>
                    </button>
                    <div id="tooltip-theme-toggle"
                         role="tooltip"
                         class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Alternar entre modo claro e escuro
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    {{-- Dropdown de usuário --}}
                    @auth
                        @php
                            $authUser = auth()->user();
                        @endphp
                        <button type="button"
                                class="flex items-center text-sm bg-gray-100 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 dark:bg-gray-700"
                                id="user-menu-button"
                                aria-expanded="false"
                                data-dropdown-toggle="user-dropdown"
                                data-tooltip-target="tooltip-user-menu">
                            <span class="sr-only">Abrir menu do usuário</span>
                            <div class="flex items-center gap-2 px-2 py-1.5">
                                @if (! empty($authUser?->photo))
                                    <img src="{{ $authUser->photo_url }}"
                                         alt="{{ $authUser->name ?? $authUser->full_name ?? $authUser->email }}"
                                         class="h-8 w-8 rounded-full object-cover border border-primary-500/70 shadow-sm">
                                @else
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-600 text-white font-semibold">
                                        {{ strtoupper(substr($authUser->name ?? ($authUser->full_name ?? 'U'), 0, 2)) }}
                                    </div>
                                @endif
                                <span class="hidden sm:block text-gray-800 dark:text-gray-100 max-w-[140px] truncate">
                                    {{ $authUser->name ?? $authUser->full_name ?? $authUser->email }}
                                </span>
                                <x-icon name="angle-down" style="solid" class="hidden sm:block w-3 h-3 text-gray-500 dark:text-gray-400" />
                            </div>
                        </button>
                        <div id="tooltip-user-menu"
                             role="tooltip"
                             class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Ver opções da sua conta
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                             id="user-dropdown">
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-sm font-medium text-gray-500 truncate dark:text-gray-400">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                            <ul class="py-2" aria-labelledby="user-menu-button">
                                @php
                                    $profileUrl = null;
                                    $user = auth()->user();

                                    if (Route::has('customer.profile') && $user?->hasRole('Customer')) {
                                        $profileUrl = route('customer.profile');
                                    } elseif (Route::has('admin.profile')) {
                                        $profileUrl = route('admin.profile');
                                    } elseif (Route::has('pdv.profile')) {
                                        $profileUrl = route('pdv.profile');
                                    }
                                @endphp
                                @if ($profileUrl)
                                    <li>
                                        <a href="{{ $profileUrl }}"
                                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600">
                                            Meu perfil
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30">
                                            Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-16 min-h-screen bg-background dark:bg-background">
        {{-- Overlay mobile --}}
        <div x-show="sidebarOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-30 bg-black/50 sm:hidden"
             aria-hidden="true"></div>

        {{-- Sidebar (Flowbite) --}}
        <aside id="sidebar"
               class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
               :class="{ 'translate-x-0': sidebarOpen }"
               aria-label="Menu lateral">
            <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
                <ul class="space-y-1 font-medium">
                    @hasanyrole('SuperAdmin|Owner|Manager|Cashier')
                        @if (Route::has('admin.index'))
                            <li>
                                <a href="{{ route('admin.index') }}"
                                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group">
                                    <x-icon name="chart-pie" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="ml-3">Dashboard</span>
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ url('/core') }}"
                               class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group">
                                <x-icon name="house" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                <span class="ml-3">Início</span>
                            </a>
                        </li>

                        {{-- Usuários --}}
                        @if (Route::has('user.index') || Route::has('role.index'))
                            <li>
                                <button type="button"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        aria-controls="sidebar-users"
                                        data-collapse-toggle="sidebar-users">
                                    <x-icon name="users" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Usuários</span>
                                    <x-icon name="angle-down" style="solid" class="w-3 h-3 text-gray-500 dark:text-gray-400" />
                                </button>
                                <ul id="sidebar-users" class="hidden py-2 space-y-1">
                                    @if (Route::has('user.index'))
                                        <li>
                                            <a href="{{ route('user.index') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Usuários
                                            </a>
                                        </li>
                                    @endif
                                    @if (Route::has('role.index'))
                                        <li>
                                            <a href="{{ route('role.index') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Papéis
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Catálogo --}}
                        @if (Route::has('catalog.products.index') || Route::has('catalog.categories.index') || Route::has('catalog.brands.index'))
                            <li>
                                <button type="button"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        aria-controls="sidebar-catalog"
                                        data-collapse-toggle="sidebar-catalog">
                                    <x-icon name="box-open" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Catálogo</span>
                                    <x-icon name="angle-down" style="solid" class="w-3 h-3 text-gray-500 dark:text-gray-400" />
                                </button>
                                <ul id="sidebar-catalog" class="hidden py-2 space-y-1">
                                    @if (Route::has('catalog.products.index'))
                                        <li>
                                            <a href="{{ route('catalog.products.index') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Produtos
                                            </a>
                                        </li>
                                    @endif
                                    @if (Route::has('catalog.categories.index'))
                                        <li>
                                            <a href="{{ route('catalog.categories.index') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Categorias
                                            </a>
                                        </li>
                                    @endif
                                    @if (Route::has('catalog.brands.index'))
                                        <li>
                                            <a href="{{ route('catalog.brands.index') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Marcas
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Estoque --}}
                        @if (Route::has('inventory.transactions.index') || Route::has('inventory.transactions.create') || Route::has('inventory.suppliers.index'))
                            <li>
                                <button type="button"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        aria-controls="sidebar-inventory"
                                        data-collapse-toggle="sidebar-inventory">
                                    <x-icon name="warehouse" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Estoque</span>
                                    <x-icon name="angle-down" style="solid" class="w-3 h-3 text-gray-500 dark:text-gray-400" />
                                </button>
                                <ul id="sidebar-inventory" class="hidden py-2 space-y-1">
                                    @if (Route::has('inventory.transactions.index'))
                                        <li>
                                            <a href="{{ route('inventory.transactions.index') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Kardex (Histórico)
                                            </a>
                                        </li>
                                    @endif
                                    @if (Route::has('inventory.transactions.create'))
                                        <li>
                                            <a href="{{ route('inventory.transactions.create') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Nova Movimentação
                                            </a>
                                        </li>
                                    @endif
                                    @if (Route::has('inventory.suppliers.index'))
                                        <li>
                                            <a href="{{ route('inventory.suppliers.index') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Fornecedores
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Vendas --}}
                        @if (Route::has('sales.orders.index'))
                            <li>
                                <button type="button"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        aria-controls="sidebar-sales"
                                        data-collapse-toggle="sidebar-sales">
                                    <x-icon name="receipt" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Vendas</span>
                                    <x-icon name="angle-down" style="solid" class="w-3 h-3 text-gray-500 dark:text-gray-400" />
                                </button>
                                <ul id="sidebar-sales" class="hidden py-2 space-y-1">
                                    <li>
                                        <a href="{{ route('sales.orders.index') }}"
                                           class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                            Todos os Pedidos
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        {{-- Entregas --}}
                        @if (Route::has('shipping.methods.index') || Route::has('shipping.admin.shipments.index'))
                            <li>
                                <button type="button"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                        aria-controls="sidebar-shipping"
                                        data-collapse-toggle="sidebar-shipping">
                                    <x-icon name="truck-fast" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Entregas</span>
                                    <x-icon name="angle-down" style="solid" class="w-3 h-3 text-gray-500 dark:text-gray-400" />
                                </button>
                                <ul id="sidebar-shipping" class="hidden py-2 space-y-1">
                                    @if (Route::has('shipping.methods.index'))
                                        <li>
                                            <a href="{{ route('shipping.methods.index') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Métodos de Entrega
                                            </a>
                                        </li>
                                    @endif
                                    @if (Route::has('shipping.admin.shipments.index'))
                                        <li>
                                            <a href="{{ route('shipping.admin.shipments.index') }}"
                                               class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                Entregas e Rastreio
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        {{-- Configurações --}}
                        @hasrole('SuperAdmin|Owner')
                            @if (Route::has('payment.admin.gateways.index') || Route::has('shipping.methods.index') || Route::has('admin.security-requests.index') || Route::has('admin.settings.security') || Route::has('admin.notification.templates.index'))
                                <li>
                                    <button type="button"
                                            class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                                            aria-controls="sidebar-settings"
                                            data-collapse-toggle="sidebar-settings">
                                        <x-icon name="gear" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                        <span class="flex-1 ml-3 text-left whitespace-nowrap">Configurações</span>
                                        <x-icon name="angle-down" style="solid" class="w-3 h-3 text-gray-500 dark:text-gray-400" />
                                    </button>
                                    <ul id="sidebar-settings" class="hidden py-2 space-y-1">
                                        @if (Route::has('shipping.methods.index'))
                                            <li>
                                                <a href="{{ route('shipping.methods.index') }}"
                                                   class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Métodos de Entrega
                                                </a>
                                            </li>
                                        @endif
                                        @if (Route::has('payment.admin.gateways.index'))
                                            <li>
                                                <a href="{{ route('payment.admin.gateways.index') }}"
                                                   class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Gateways de Pagamento
                                                </a>
                                            </li>
                                        @endif
                                        @if (Route::has('admin.security-requests.index'))
                                            <li>
                                                <a href="{{ route('admin.security-requests.index') }}"
                                                   class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Solicitações de Conta
                                                </a>
                                            </li>
                                        @endif
                                        @if (Route::has('admin.settings.security'))
                                            <li>
                                                <a href="{{ route('admin.settings.security') }}"
                                                   class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    Segurança
                                                </a>
                                            </li>
                                        @endif
                                        @if (Route::has('admin.notification.templates.index'))
                                            <li>
                                                <a href="{{ route('admin.notification.templates.index') }}"
                                                   class="flex items-center w-full p-2 pl-11 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                                    E-mails Automáticos
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endhasrole
                    @endhasanyrole

                    {{-- Menu do cliente --}}
                    @role('Customer')
                        @if (Route::has('customer.index'))
                            <li>
                                <a href="{{ route('customer.index') }}"
                                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group">
                                    <x-icon name="user" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="ml-3">Meu Painel</span>
                                </a>
                            </li>
                        @endif
                        @if (Route::has('customer.orders.index'))
                            <li>
                                <a href="{{ route('customer.orders.index') }}"
                                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group">
                                    <x-icon name="boxes-stacked" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="ml-3">Meus Pedidos</span>
                                </a>
                            </li>
                        @endif
                        @if (Route::has('customer.profile'))
                            <li>
                                <a href="{{ route('customer.profile') }}"
                                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group">
                                    <x-icon name="id-card" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="ml-3">Meu Perfil</span>
                                </a>
                            </li>
                        @endif
                        @if (Route::has('storefront.index'))
                            <li>
                                <a href="{{ route('storefront.index') }}"
                                   class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 group">
                                    <x-icon name="store" style="duotone" class="w-5 h-5 text-gray-500 group-hover:text-primary-600 dark:text-gray-400 dark:group-hover:text-primary-400" />
                                    <span class="ml-3">Ir para a Loja</span>
                                </a>
                            </li>
                        @endif
                    @endrole
                </ul>

                {{-- Ações no rodapé da sidebar --}}
                <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <button type="button"
                            @click="darkMode = !darkMode"
                            class="flex items-center w-full p-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700"
                            data-tooltip-target="tooltip-theme-sidebar">
                        <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-gray-100 dark:bg-gray-700">
                            <span x-show="!darkMode" x-cloak>
                                <x-icon name="sun-bright" style="duotone" class="w-4 h-4 text-yellow-400" />
                            </span>
                            <span x-show="darkMode" x-cloak>
                                <x-icon name="moon" style="duotone" class="w-4 h-4 text-slate-200" />
                            </span>
                        </span>
                        <span x-text="darkMode ? 'Tema claro' : 'Tema escuro'">Tema</span>
                    </button>
                    <div id="tooltip-theme-sidebar"
                         role="tooltip"
                         class="absolute z-50 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Altere rapidamente o tema da interface
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit"
                                    class="flex items-center w-full p-2 text-sm text-red-600 rounded-lg hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30">
                                <span class="flex items-center justify-center w-8 h-8 mr-3 rounded-lg bg-red-100 dark:bg-red-900/40">
                                    <x-icon name="right-from-bracket" style="solid" class="w-4 h-4" />
                                </span>
                                <span>Sair</span>
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </aside>

        {{-- Conteúdo principal --}}
        <div class="flex flex-col flex-1 min-h-screen bg-gray-50 dark:bg-surface sm:ml-64">
            <main class="flex-1 px-4 py-6 lg:px-8">
                <header class="mb-6">
                    <h1 class="text-xl font-semibold font-display text-gray-900 dark:text-white">
                        {{ $heading ?? 'Painel' }}
                    </h1>
                </header>
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
