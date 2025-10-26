@props([
    'href' => '/dashboard',
    'icon' => 'dashboard-line',
    'title' => 'dashboard',
])
<li >
    <a href="{{ $href }}" wire:current.exact='active' wire:key='{{ md5($href) }}'>
        <i class="ri-{{ $icon }} me-2 ri-lg" ></i>
        <span>{{ Str::title($title) }}</span>
    </a>
</li>
