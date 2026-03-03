@props(['title' => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
      }"
      :class="{ 'dark': darkMode }"
      x-init="$watch('darkMode', val => {
          localStorage.setItem('theme', val ? 'dark' : 'light');
          document.documentElement.classList.toggle('dark', val);
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
<body class="font-sans antialiased min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col lg:flex-row">
    <x-loading-overlay />

    {{-- Theme toggle: apenas um ícone por vez (x-show evita sol e lua simultâneos) --}}
    <button type="button"
            @click="darkMode = !darkMode"
            class="fixed top-4 right-4 z-30 p-2 rounded-lg bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors shadow-sm"
            aria-label="Alternar tema">
        <span x-show="!darkMode" x-cloak><x-icon name="sun-bright" style="duotone" class="w-5 h-5" /></span>
        <span x-show="darkMode" x-cloak><x-icon name="moon" style="duotone" class="w-5 h-5" /></span>
    </button>

    {{-- Coluna esquerda: branding --}}
    <div class="relative hidden lg:flex lg:w-1/2 min-h-screen flex-col items-center justify-center px-8 py-12 overflow-hidden">
        <div class="fixed inset-0 -z-10 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(251,191,36,0.12),transparent)] dark:bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(251,191,36,0.18),transparent)] pointer-events-none"></div>
        <div class="absolute top-1/4 left-1/4 w-64 h-64 storefront-hero-light-orb animate-light-glow rounded-full pointer-events-none opacity-60"></div>
        <div class="absolute bottom-1/4 right-1/4 w-48 h-48 storefront-hero-light-orb animate-light-glow rounded-full pointer-events-none opacity-40" style="animation-delay: 1s;"></div>
        <a href="{{ route('storefront.index') }}" class="mb-10 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 rounded-lg">
            <x-core::logo height="h-12" class="w-auto" />
        </a>
        <div class="relative text-center max-w-md">
            <div class="inline-flex items-center gap-2 rounded-full bg-amber-500/15 dark:bg-amber-400/15 border border-amber-500/20 dark:border-amber-400/20 px-4 py-2 text-sm font-medium text-amber-700 dark:text-amber-300 mb-6 shadow-sm">
                <x-icon name="bolt" style="duotone" class="w-4 h-4" />
                Iluminação e Materiais Elétricos
            </div>
            <h2 class="font-display text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-3">
                Ilumine seus <span class="text-amber-600 dark:text-amber-400">Ambientes</span>
            </h2>
            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                Materiais elétricos e iluminação de qualidade para sua casa ou empresa.
            </p>
            <div class="mt-8 flex justify-center gap-4 opacity-80">
                <x-icon name="lightbulb" style="duotone" class="w-12 h-12 text-amber-500 dark:text-amber-400" />
                <x-icon name="bolt" style="duotone" class="w-10 h-10 text-amber-500 dark:text-amber-400" />
            </div>
        </div>
    </div>

    {{-- Coluna direita: formulário --}}
    <div class="flex-1 flex flex-col items-center justify-center px-4 sm:px-6 py-12 lg:py-0 w-full">
        {{-- Logo em mobile (clicável) --}}
        <a href="{{ route('storefront.index') }}" class="lg:hidden mb-8 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 rounded-lg">
            <x-core::logo height="h-10" class="w-auto" />
        </a>
        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
        <p class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('storefront.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Voltar para o início</a>
        </p>
    </div>
</body>
</html>
