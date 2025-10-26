@props([
    'label' => null,
    'placeholder' => null,
])

@php
    $model = $attributes->wire('model')->value();
@endphp

<div class="mb-3">
    <label class="form-label" for="{{ $model }}">{{ Str::title($label) }}</label>

    <input
        {{ $attributes->merge([
            'class' => 'form-control',
            'type' => 'text',
            'placeholder' => 'Input ' . Str::title($label),
            'id' => $model,
        ]) }}
    >
    {{ $slot }}
    @error($model)
        <small class="text-danger  d-block">{{ $message }}</small>
    @enderror
</div>
