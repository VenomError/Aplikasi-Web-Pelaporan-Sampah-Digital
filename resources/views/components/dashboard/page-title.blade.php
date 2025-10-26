@props(['title' => 'Dashboard'])

<div class="page-header">
    <div class="add-item d-flex">
        <div class="page-title">
            <h4>{{ Str::upper($title )}}</h4>
            <ul class="breadcrumb">
                <x-dashboard.page-title-item title="Dashboard" :href="route('dashboard')" />
                {{ $slot }}
            </ul>
        </div>
    </div>
    <ul class="table-top-head">
       {{ $action ?? '' }}
    </ul>
    <div class="page-btn">
        {{ $button ?? '' }}
    </div>
</div>
