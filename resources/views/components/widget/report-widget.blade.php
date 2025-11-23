@use('App\Enum\ReportStatus')

@props([
    'all' => 0,
    'pending' => 0,
    'processing' => 0,
    'completed' => 0,
    'rejected' => 0,
    'cancelled' => 0,
])

<div class="row justify-content-center">

    {{-- Total laporan --}}
    <x-widget.dash-count
        class="col-lg-6"
        title="Total Laporan"
        :count="count($this->reports())"
        color="primary"
        icon="ri-file-list-fill"
    />

    {{-- Loop all statuses --}}
    @foreach (ReportStatus::cases() as $status)
        <x-widget.dash-count
            class="col-lg-6"
            :title="$status->value"
            :count="${ strtolower($status->value) }"
            :color="$status->color()"
            :icon="$status->icon()"
        />
    @endforeach

</div>
