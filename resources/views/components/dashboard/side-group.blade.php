@props([
    'href' => '/dashboard',
    'icon' => 'box',
    'title' => 'dashboard'
])
<li class="submenu" wire:key='{{ md5($href) }}'>
    <a href="{{ $href }}" wire:current='active'>
        <i class="ri-{{ $icon }} ri-lg me-2"></i>
        <span>{{ Str::title($title) }}</span>
        <span class="menu-arrow"></span>
    </a>
    <ul>
       {{ $slot }}
    </ul>
</li>
