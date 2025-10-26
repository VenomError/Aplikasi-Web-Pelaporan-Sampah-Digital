@props([
    'label' => null,
    'placeholder' => null,
    'rows' => 3,
])

@php
    $model = $attributes->wire('model')->value();
@endphp

<div class="mb-3">
    <label class="form-label" for="{{ $model }}">{{ Str::title($label) }}</label>

    <textarea
        {{ $attributes->merge([
            'class' => 'form-control',
            'placeholder' => $placeholder ?? 'Input ' . Str::title($label),
            'id' => $model,
            'rows' => $rows,
        ]) }}
    ></textarea>

    @error($model)
        <small class="text-danger mx-1">{{ $message }}</small>
    @enderror
</div>
