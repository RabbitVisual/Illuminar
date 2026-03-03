@props([
    'class' => '',
    'height' => 'h-10',
])

@php
    $logoClass = trim("brightness-0 dark:brightness-100 object-contain {$height} {$class} " . ($attributes->get('class') ?? ''));
@endphp

<img src="{{ asset('img/illuminar/logo.png') }}"
     alt="Illuminar - Materiais Elétricos e Iluminação"
     {{ $attributes->except('class')->merge(['class' => $logoClass]) }} />
