@props(['title' => ''])
<li class="submenu-open" >
    <h6 class="submenu-hdr">{{ Str::title($title) }}</h6>
    {{ $slot }}
</li>
