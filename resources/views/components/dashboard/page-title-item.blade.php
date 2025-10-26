@props([
    'title' => 'dashboard',
    'href' => null,
    'isActive' => false,
])
@if ($isActive || !$href)
    <li class="breadcrumb-item active">{{ Str::title($title) }}</li>
@else
    <li class="breadcrumb-item">
        <a href="{{ $href }}">{{ Str::title($title) }}</a>
    </li>
@endif
