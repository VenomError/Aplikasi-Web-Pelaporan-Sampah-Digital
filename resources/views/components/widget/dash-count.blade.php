@props([
    'color' => 'primary',
    'count' => 0,
    'title' => '',
    'icon' => '',
    'class' => 'col-xl-3 col-sm-6 col-12',
])
<div class=" {{ $class }} d-flex" {{ $attributes->merge() }}>
    <div class="dash-count bg-{{ $color }}">
        <div class="dash-counts ">
            <h4>{{ $count }}</h4>
            <h5>{{ $title }}</h5>
        </div>
        <div class="dash-imgs">
            <i class="{{ $icon }}"></i>
        </div>
    </div>
</div>
