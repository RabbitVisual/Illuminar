@props([
    'brand' => null,
    'size' => 'md', // xs | sm | md | lg
    'showName' => false,
    'class' => '',
])

@php
    $sizes = [
        'xs' => 'h-5',
        'sm' => 'h-6',
        'md' => 'h-8',
        'lg' => 'h-10',
    ];

    $wrapperSizes = [
        'xs' => 'h-6 w-6',
        'sm' => 'h-7 w-7',
        'md' => 'h-9 w-9',
        'lg' => 'h-11 w-11',
    ];

    $sizeKey = $sizes[$size] ?? $sizes['md'];
    $wrapperSize = $wrapperSizes[$size] ?? $wrapperSizes['md'];

    $name = $brand?->name ?? 'Marca';

    $logoUrl = null;
    if ($brand && $brand->logo) {
        $raw = trim($brand->logo);
        $isAbsolute = preg_match('/^https?:\/\//i', $raw) === 1;
        $logoUrl = $isAbsolute ? $raw : asset($raw);
    }

    $initials = '';
    if ($brand && $brand->name) {
        $parts = preg_split('/\s+/', trim($brand->name));
        $initials = mb_strtoupper(mb_substr($parts[0] ?? '', 0, 1) . mb_substr($parts[1] ?? '', 0, 1));
    }

    $wrapperClass = implode(' ', [
        'inline-flex items-center gap-2',
        $class,
    ]);
@endphp

<span class="{{ $wrapperClass }}">
    <span class="flex items-center justify-center rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 overflow-hidden {{ $wrapperSize }}">
        @if ($logoUrl)
            <img src="{{ $logoUrl }}"
                 alt="Logo {{ $name }}"
                 loading="lazy"
                 class="h-full w-full object-contain" />
        @else
            <span class="flex h-full w-full items-center justify-center text-xs font-semibold text-amber-700 dark:text-amber-300 bg-amber-500/10 dark:bg-amber-400/15">
                {{ $initials ?: 'BR' }}
            </span>
        @endif
    </span>

    @if ($showName)
        <span class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 truncate max-w-32">
            {{ $name }}
        </span>
    @endif
</span>

