<?php
use App\Models\Report;
use App\Enum\ReportStatus;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

new #[Title('Map Penjemputan')] class extends Component {
    public $baseQuery;
    public $filter = [];

    public function render(): mixed
    {
        return parent::render();
    }
    #[Computed]
    public function reports()
    {
        $query = Report::latest();
        if ($this->filter) {
            $query->where($this->filter);
        }
        return $query
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'title' => $report->title,
                    'status' => $report->status->name,
                    'color' => $report->status->color(),
                    'latitude' => $report->latitude,
                    'longitude' => $report->longitude,
                    'address' => $report->address,
                    'member_name' => $report->member?->account?->name ?? 'Tidak Ada',
                    'operator_name' => $report->operator?->account?->name ?? 'Tidak Ada',
                ];
            })
            ->toArray();
    }
    #[Computed]
    public function reportCountByStatus(ReportStatus $status): int
    {
        $query = Report::latest();
        if ($this->filter) {
            $query->where($this->filter);
        }
        $query->where('status', $status);
        return $query->count();
    }
};
?>

<div>
    <x-dashboard.page-title title="Map Penjemputan">
        <x-dashboard.page-title-item title="Map Penjemputan" />
    </x-dashboard.page-title>
    <div class="row justify-content-center">
        <x-widget.dash-count class="col-lg-6" title="Total Laporan" :count="count($this->reports())" color="primary"
            icon="ri-file-list-fill" />
        <x-widget.dash-count class="col-lg-6" :title="ReportStatus::COMPLETED->value" :count="$this->reportCountByStatus(ReportStatus::COMPLETED)" :color="ReportStatus::COMPLETED->color()" :icon="ReportStatus::COMPLETED->icon()" />
        @foreach (ReportStatus::cases() as $status)
            @if ($status != ReportStatus::COMPLETED)
                <x-widget.dash-count :title="$status->value" :count="$this->reportCountByStatus($status)" :color="$status->color()" :icon="$status->icon()" />
            @endif
        @endforeach
    </div>
    <div x-data="mapComponent({ reports: @js($this->reports()) })" x-init="init()" class="position-relative border rounded shadow-sm"
        style="height: 500px;">
        <div id="map" class="position-absolute top-0 start-0 w-100 h-100"></div>

        <!-- Info Box -->
        <div x-show="selected" x-transition class="position-absolute top-0 start-50 translate-middle-x mt-3"
            style="min-width: 340px; z-index: 1000;">

            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="card-title mb-1" x-text="selected.title"></h5>
                            <small class="text-muted" x-text="selected.address"></small>
                        </div>
                        <span class="badge fs-6" :class="'bg-' + selected.color" x-text="selected.status"></span>
                    </div>

                    <hr class="my-2">

                    <div class="mb-2">
                        <i class="ri-user-fill"></i>
                        <span>Member: </span>
                        <a href="#" class="fw-semibold text-decoration-underline text-info"
                            x-text="selected.member_name"
                            @click.prevent="alert('Lihat profil member: ' + selected.member_name)">
                        </a>
                    </div>

                    <div class="mb-3">
                        <i class="ri-customer-service-fill"></i>
                        <span>Operator: </span>
                        <a href="#" class="fw-semibold text-decoration-underline text-info"
                            x-text="selected.operator_name"
                            @click.prevent="alert('Lihat profil operator: ' + selected.operator_name)">
                        </a>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-danger flex-grow-1" @click="selected = null">
                            Tutup
                        </button>
                        <button class="btn btn-sm btn-primary flex-grow-1"
                            @click="alert('Detail laporan: ' + selected.title)">
                            Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('mapComponent', (data) => ({
                map: null,
                reports: data.reports || [],
                selected: null,

                init() {
                    if (typeof L === 'undefined') {
                        console.error('Leaflet belum dimuat!');
                        return;
                    }

                    this.map = L.map('map').setView([-5.1477, 119.4327], 13);

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(this.map);

                    // Tambahkan marker
                    this.reports.forEach(rep => {
                        const marker = L.marker([rep.latitude, rep.longitude]).addTo(this.map);
                        marker.on('click', () => this.selected = rep);
                    });
                },
            }));
        });
    </script>
</div>
