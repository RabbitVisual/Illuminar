@props([
    'product',
    'aspect' => 'square', // square | 4/3 | 16/9
    'class' => '',
])

@php
    $aspectClass = match ($aspect) {
        '4/3', '4-3' => 'aspect-[4/3]',
        '16/9', '16-9' => 'aspect-[16/9]',
        default => 'aspect-square',
    };

    $baseWrapperClasses = implode(' ', [
        $aspectClass,
        'relative overflow-hidden bg-linear-to-br from-gray-100 to-gray-50 dark:from-gray-800 dark:to-gray-900',
        'flex items-center justify-center',
        $class,
    ]);

    $imagePath = $product->image_path ?? null;

    if (! $imagePath && method_exists($product, 'images')) {
        $firstImage = $product->images->first();
        if ($firstImage && ! empty($firstImage->path)) {
            $imagePath = $firstImage->path;
        }
    }

    if ($imagePath) {
        // Se o caminho já parece ser uma URL completa, usa direto; caso contrário, assume storage público.
        $isAbsoluteUrl = preg_match('/^https?:\/\//i', $imagePath) === 1;
        $src = $isAbsoluteUrl ? $imagePath : asset('storage/' . ltrim($imagePath, '/'));
    }
@endphp

<div class="{{ $baseWrapperClasses }}">
    @if (! empty($imagePath ?? null))
        <img src="{{ $src }}"
             alt="{{ $product->name }}"
             loading="lazy"
             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105" />
    @else
        <div class="flex h-2/3 w-2/3 items-center justify-center rounded-2xl bg-amber-500/10 dark:bg-amber-400/10 text-amber-600 dark:text-amber-400">
            <x-icon name="lightbulb" style="duotone" class="w-1/2 h-1/2" />
        </div>
    @endif
</div>

