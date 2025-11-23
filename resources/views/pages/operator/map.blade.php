<?php
use App\Enum\ReportStatus;
use App\Models\Report;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;

new #[Title('Map Penjemputan')] class extends Component {
    public $baseQuery;
    public $reports;
    #[Url('date')]
    public $date;
    public $filter = [];

    public $status = ReportStatus::PENDING;

    public function mount()
    {
        if (!$this->date) {
            $this->date = now()->format('Y-m-d');
        }
    }

    public function render(): mixed
    {
        $this->reports = $this->reports();
        return parent::render();
    }
    public function reports()
    {
        $operator = auth()->user()->owner;

        $query = $operator->reports();
        if ($this->filter) {
            $query->where($this->filter);
        }
        $query->when($this->status, fn($q) => $q->whereStatus($this->status));
        $query->when($this->date, fn($q) => $q->whereDate('created_at', Carbon::parse($this->date)));

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
        $operator = auth()->user()->owner;

        $query = $operator->reports();
        if ($this->filter) {
            $query->where($this->filter);
        }
        if ($this->date) {
            $query->whereDate('created_at', Carbon::parse($this->date));
        }
        $query->where('status', $status);
        return $query->count();
    }
};
?>

<div>
    <x-dashboard.page-title title="Map Penjemputan">
        <x-dashboard.page-title-item title="Map Penjemputan" />
        <x-slot:action>
            <input
                class="form-control me-3"
                type="date"
                wire:model.live="date"
            />
            <select class="form-select" wire:model.live="status">
                <option disabled>select status</option>
                @foreach (ReportStatus::cases() as $status)
                    <option value="{{ $status->value }}">{{ $status->value }}</option>
                @endforeach
            </select>
        </x-slot:action>
    </x-dashboard.page-title>
    <div class="row justify-content-center">
        <x-widget.dash-count
            class="col-lg-6"
            title="Total Laporan"
            :count="count($this->reports)"
            color="primary"
            icon="ri-file-list-fill"
        />
        <x-widget.dash-count
            class="col-lg-6"
            :title="ReportStatus::COMPLETED->value"
            :count="$this->reportCountByStatus(ReportStatus::COMPLETED)"
            :color="ReportStatus::COMPLETED->color()"
            :icon="ReportStatus::COMPLETED->icon()"
        />
        @foreach (ReportStatus::cases() as $status)
            @if ($status != ReportStatus::COMPLETED)
                <x-widget.dash-count
                    :title="$status->value"
                    :count="$this->reportCountByStatus($status)"
                    :color="$status->color()"
                    :icon="$status->icon()"
                />
            @endif
        @endforeach
    </div>
    <div
        class="position-relative rounded border shadow-sm"
        style="height: 500px;"
        wire:ignore
        x-data="{
            map: null,
            reportMarkers: [],
            userMarker: null,
            selected: null,
            reports: $wire.entangle('reports').live,
        
            init() {
                if (!this.map) {
        
                    // 🔥 INIT MAP
                    this.map = L.map(this.$refs.maparea).setView([-5.1477, 119.4327], 13);
        
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(this.map);
        
                    this.startTracking();
                }
        
                // load marker awal
                this.updateMarkers();
        
                // update setelah reports berubah
                this.$watch('reports', () => {
                    this.updateMarkers();
                });
            },
        
            updateMarkers() {
                this.reportMarkers.forEach(m => this.map.removeLayer(m));
                this.reportMarkers = [];
        
                this.reports.forEach(rep => {
                    const popupHtml = `
                                    <b>${rep.title}</b><br>
                                    <small>${rep.address}</small><br><br>
                                    <br><br>
                                    <a 
                                        href='https://www.google.com/maps/dir/?api=1&destination=${rep.latitude},${rep.longitude}'
                                        target='_blank'
                                        style='font-size:14px; text-decoration:none;'
                                    >
                                        🧭 Arahkan di Google Maps
                                    </a>
                                `;
        
                    const marker = L.marker([rep.latitude, rep.longitude]).addTo(this.map);
                    marker.bindPopup(popupHtml);
                    marker.on('click', () => this.selected = rep);
                    this.reportMarkers.push(marker);
                });
            },
        
            startTracking() {
                if (!navigator.geolocation) {
                    alert('Browser tidak mendukung geolokasi');
                    return;
                }
        
                navigator.geolocation.watchPosition(
                    pos => {
                        const lat = pos.coords.latitude;
                        const lon = pos.coords.longitude;
                        const acc = pos.coords.accuracy;
        
                        // 🔹 Marker user
                        if (!this.userMarker) {
                            this.userMarker = L.marker([lat, lon]).addTo(this.map);
                        } else {
                            this.userMarker.setLatLng([lat, lon]);
                        }
        
                        if (!this.userCircle) {
                            this.userCircle = L.circle([lat, lon], {
                                radius: acc,
                                color: 'blue',
                                fillColor: '#3f8bfd',
                                fillOpacity: 0.2
                            }).addTo(this.map);
                        } else {
                            this.userCircle.setLatLng([lat, lon]);
                            this.userCircle.setRadius(acc);
                        }
        
                        this.map.setView([lat, lon], this.map.getZoom());
                    },
                    err => console.error(err), { enableHighAccuracy: true }
                );
        
            }
        }"
    >
        <!-- 🔥 INI YANG WAJIB ADA -->
        <div
            class="w-100 h-100"
            id="map"
            x-ref="maparea"
        ></div>
    </div>

</div>
