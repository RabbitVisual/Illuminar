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

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <div x-show="sidebarOpen"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-30 bg-black/50 lg:hidden"
             aria-hidden="true"></div>
        <aside class="fixed inset-y-0 left-0 z-40 w-64 flex flex-col bg-white dark:bg-surface border-r border-border dark:border-border transform -translate-x-full lg:translate-x-0 lg:static transition-transform duration-200 ease-out"
               :class="{ 'translate-x-0': sidebarOpen }">
            <div class="flex h-16 items-center justify-between gap-2 border-b border-border dark:border-border px-4 lg:px-6">
                <a href="{{ url('/core') }}" class="flex items-center gap-2 font-display font-bold text-lg text-primary dark:text-primary">
                    <x-icon name="lightbulb" style="duotone" class="text-2xl" />
                    <span>Illuminar</span>
                </a>
                <button type="button"
                        @click="sidebarOpen = false"
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400">
                    <x-icon name="xmark" style="solid" />
                </button>
            </div>
            <nav class="flex-1 overflow-y-auto p-4 space-y-1">
                <a href="{{ url('/core') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-colors">
                    <x-icon name="house" style="duotone" />
                    <span>Início</span>
                </a>
                @if (Route::has('user.index'))
                    <a href="{{ route('user.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-colors">
                        <x-icon name="users" style="duotone" />
                        <span>Usuários</span>
                    </a>
                @endif
                @if (Route::has('role.index'))
                    <a href="{{ route('role.index') }}"
                       class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-colors">
                        <x-icon name="key" style="duotone" />
                        <span>Papéis</span>
                    </a>
                @endif
                @if (Route::has('catalog.products.index'))
                    <div class="pt-2 mt-2 border-t border-border dark:border-border">
                        <p class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                            <x-icon name="box-open" style="duotone" class="w-4 h-4" />
                            Catálogo
                        </p>
                        <a href="{{ route('catalog.products.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-colors">
                            <x-icon name="box-open" style="duotone" />
                            <span>Produtos</span>
                        </a>
                        <a href="{{ route('catalog.categories.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-colors">
                            <x-icon name="tags" style="duotone" />
                            <span>Categorias</span>
                        </a>
                        <a href="{{ route('catalog.brands.index') }}"
                           class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-colors">
                            <x-icon name="copyright" style="duotone" />
                            <span>Marcas</span>
                        </a>
                    </div>
                @endif
            </nav>
            <div class="border-t border-border dark:border-border p-4 space-y-1">
                <button type="button"
                        @click="darkMode = !darkMode"
                        class="flex items-center gap-3 w-full px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                        aria-label="Alternar tema">
                    <x-icon name="sun-bright" style="duotone" class="block dark:hidden w-5" />
                    <x-icon name="moon" style="duotone" class="hidden dark:block w-5" />
                    <span x-text="darkMode ? 'Claro' : 'Escuro'">Tema</span>
                </button>
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-3 w-full px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-danger transition-colors">
                            <x-icon name="right-from-bracket" style="solid" class="w-5" />
                            <span>Sair</span>
                        </button>
                    </form>
                @endauth
            </div>
        </aside>

        {{-- Main content area --}}
        <div class="flex flex-1 flex-col min-w-0">
            {{-- Topbar --}}
            <header class="sticky top-0 z-30 flex h-16 items-center gap-4 border-b border-border dark:border-border bg-white dark:bg-surface px-4 lg:px-8">
                <button type="button"
                        @click="sidebarOpen = true"
                        class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400"
                        aria-label="Abrir menu">
                    <x-icon name="bars" style="solid" class="w-6 h-6" />
                </button>
                <div class="flex-1">
                    <h1 class="font-display font-semibold text-gray-900 dark:text-white truncate">
                        {{ $heading ?? 'Painel' }}
                    </h1>
                </div>
                <button type="button"
                        @click="darkMode = !darkMode"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 lg:hidden"
                        aria-label="Alternar tema">
                    <x-icon name="sun-bright" style="duotone" class="block dark:hidden w-5 h-5" />
                    <x-icon name="moon" style="duotone" class="hidden dark:block w-5 h-5" />
                </button>
            </header>

            {{-- Page content --}}
            <main class="flex-1 p-4 lg:p-8 overflow-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
