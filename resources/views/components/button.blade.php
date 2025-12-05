@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => null,
    'outline' => false,
    'block' => false,
    'icon' => null,
    'iconPosition' => 'left',
    'class' => '',
])

@php
    $baseClass = 'btn';
    $variantClass = $outline ? "btn-outline-{$variant}" : "btn-{$variant}";
    $sizeClass = $size ? "btn-{$size}" : '';
    $blockClass = $block ? 'w-100' : '';
    $buttonClass = trim("{$baseClass} {$variantClass} {$sizeClass} {$blockClass} {$class}");
@endphp

<button
    type="{{ $type }}"
    class="{{ $buttonClass }}"
    {{ $attributes->except(['class', 'type', 'variant', 'size', 'outline', 'block', 'icon', 'iconPosition']) }}
>
    @if($icon && $iconPosition === 'left')
        <i class="{{ $icon }}"></i>
    @endif

    {{ $slot }}

    @if($icon && $iconPosition === 'right')
        <i class="{{ $icon }}"></i>
    @endif
</button>

