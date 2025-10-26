@props([
    'href' => '/dashboard',
    'title' => 'dashboard'
])
 <li>
     <a href="{{ $href }}" wire:current.strict='active' wire:key='{{ md5($href) }}'>
         {{ Str::title($title) }}
     </a>
 </li>
