@props([
    'type' => 'border',
    'color' => 'primary',
    'size' => 'sm',
])

@php
    $baseClass = $type === 'grow' ? 'spinner-grow' : 'spinner-border';
    $sizeClass = $size ? "{$baseClass}-{$size}" : '';
@endphp

<div {{ $attributes->merge() }} class="{{ $baseClass }}  {{ $sizeClass }}" role="status">
    <span class="visually-hidden">Loading...</span>
</div>
