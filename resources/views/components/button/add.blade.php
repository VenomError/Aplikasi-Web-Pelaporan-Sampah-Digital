@props(['type' => 'a', 'title' => 'Add'])
<div class="page-btn">
    <{{ $type }} class="btn btn-primary " {{ $attributes->merge() }}>
        <i class="ri-add-large-line me-2"  ></i>
        {{ Str::title($title) }}
    </{{ $type }}>
</div>
