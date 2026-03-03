@props([
    'name',
    'style' => 'duotone',
    'class' => '',
    'bordered' => false,
    'pulled' => null,
    'size' => null,
])

@php
    $styleMap = [
        'duotone' => 'fa-duotone',
        'solid'   => 'fa-solid',
        'regular' => 'fa-regular',
        'light'   => 'fa-light',
        'brands'  => 'fa-brands',
    ];

    $faStyle = $styleMap[$style] ?? $styleMap['duotone'];

    $classes = [
        $faStyle,
        "fa-{$name}",
        $bordered ? 'fa-border' : '',
        $pulled ? "fa-pull-{$pulled}" : '',
        $size ? "fa-{$size}" : '',
        $class,
    ];

    $finalClass = implode(' ', array_filter($classes));
@endphp

<i {{ $attributes->merge(['class' => $finalClass]) }} aria-hidden="true"></i>
