@props(['src'=>''])

<img  {{ $attributes->merge([
    'src' => asset($src),
    'alt' => 'img'
]) }} />
