@props([
    'loadingText' => 'Loading...',
    'action' => 'submit()',
    'color' => 'primary'
])
<button
    class="btn btn-{{ $color }}"
    wire:click='{{ $action }}'
    wire:target='{{ $action }}'
    wire:loading.attr='disabled'
>
    <span class="mx-2" wire:loading.remove wire:target='{{ $action }}'>{{ $slot }}</span>
    <x-spinner addClass="me-2" wire:loading wire:target='{{ $action }}' />
    <span wire:loading wire:target='{{ $action }}'>{{ $loadingText }}</span>
</button>
