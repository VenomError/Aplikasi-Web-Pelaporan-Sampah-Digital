 @props([
     'type' => 'button',
     'icon' => 'ri-edit-box-line',
     'color' => 'warning',
     'target' => null,
     'size' => 'sm',
 ])
 <{{ $type }} class="btn btn-icon btn-{{ $size }} btn-{{ $color }}" {{ $attributes->merge() }}
     wire:loading.attr='disabled' wire:target='{{ $target }}'>
     <i class="{{ $icon }}" wire:loading.remove wire:target='{{ $target }}'></i>
     <x-spinner style="width: 0.65rem; height: 0.65rem;" wire:loading wire:target='{{ $target }}' />
     </{{ $type }}>
