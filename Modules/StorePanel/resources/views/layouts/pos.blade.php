<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
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

    <title>PDV - {{ config('app.name', 'Illuminar') }}</title>

    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-gray-900 dark:bg-background dark:text-gray-100 h-screen overflow-hidden">
    <x-loading-overlay />

    <div class="h-screen flex flex-col">
        <header class="flex items-center justify-between px-4 py-3 border-b border-gray-200 bg-white/95 backdrop-blur dark:bg-gray-900/95 dark:border-gray-800">
            <div class="flex items-center gap-3">
                <a href="{{ Route::has('admin.index') ? route('admin.index') : url('/core') }}" class="flex items-center gap-2">
                    <x-core::logo height="h-7" class="w-auto max-w-[120px]" />
                </a>
                <div class="hidden sm:flex flex-col">
                    <span class="text-xs uppercase tracking-wide text-gray-400 dark:text-gray-500">Ponto de Venda</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-gray-100">PDV Rápido</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <div class="hidden sm:flex items-center gap-2 pr-2 border-r border-gray-200 dark:border-gray-700">
                        <img src="{{ auth()->user()->photo_url }}?v={{ auth()->user()->updated_at?->timestamp ?? time() }}"
                             alt="{{ auth()->user()->full_name }}"
                             class="h-8 w-8 rounded-full object-cover border border-primary-500/70 shadow-sm bg-primary-600">
                        <span class="text-xs font-medium text-gray-700 dark:text-gray-200 max-w-[120px] truncate">
                            {{ auth()->user()->full_name ?? auth()->user()->email }}
                        </span>
                    </div>
                    @if (Route::has('pdv.profile'))
                        <a href="{{ route('pdv.profile') }}"
                           class="hidden sm:inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                            <x-icon name="id-card" style="duotone" class="w-4 h-4" />
                            <span>Meu perfil</span>
                        </a>
                    @endif
                    <a href="{{ Route::has('admin.index') ? route('admin.index') : url('/core') }}"
                       class="inline-flex items-center gap-2 rounded-lg border border-gray-200 px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                        <x-icon name="gauge-high" style="duotone" class="w-4 h-4" />
                        <span>Painel</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-700">
                            <x-icon name="right-from-bracket" style="solid" class="w-4 h-4" />
                            <span>Sair</span>
                        </button>
                    </form>
                @endauth
            </div>
        </header>
        <div class="flex-1 flex flex-col min-h-0">
            @yield('content')
        </div>
    </div>
</body>
</html>
