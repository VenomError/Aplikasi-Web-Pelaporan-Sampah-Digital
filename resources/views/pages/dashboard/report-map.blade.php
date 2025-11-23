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
    #[Url('date')]
    public $date;
    public $filter = [];

    public function mount()
    {
        if (!$this->date) {
            $this->date = now()->format('Y-m-d');
        }
    }

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
        if ($this->date) {
            $query->whereDate('created_at', Carbon::parse($this->date));
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
            <input class="form-control" wire:model.live="date" type="date" />
        </x-slot:action>
    </x-dashboard.page-title>
    <div class="row justify-content-center">
        <x-widget.dash-count class="col-lg-6" title="Total Laporan" :count="count($this->reports())" color="primary"
            icon="ri-file-list-fill" />
        <x-widget.dash-count class="col-lg-6" :title="ReportStatus::COMPLETED->value"
            :count="$this->reportCountByStatus(ReportStatus::COMPLETED)" :color="ReportStatus::COMPLETED->color()"
            :icon="ReportStatus::COMPLETED->icon()" />
        @foreach (ReportStatus::cases() as $status)
            @if ($status != ReportStatus::COMPLETED)
                <x-widget.dash-count :title="$status->value" :count="$this->reportCountByStatus($status)"
                    :color="$status->color()" :icon="$status->icon()" />
            @endif
        @endforeach
    </div>
    <div x-data="mapComponent({ reports: @js($this->reports()) })" x-init="init()"
        class="position-relative border rounded shadow-sm" style="height: 500px;">
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

                userMarker: null,
                userCircle: null,
                watchId: null,

                init() {
                    if (typeof L === 'undefined') {
                        console.error('Leaflet belum dimuat!');
                        return;
                    }

                    // Inisialisasi Map
                    this.map = L.map('map').setView([-5.1477, 119.4327], 13);

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(this.map);

                    // Tambahkan marker laporan
                    this.reports.forEach(rep => {
                        const marker = L.marker([rep.latitude, rep.longitude]).addTo(this.map);
                        marker.on('click', () => this.selected = rep);
                    });

                    // Jalankan tracking lokasi realtime
                    this.trackCurrentLocation();
                },

                trackCurrentLocation() {
                    if (!navigator.geolocation) {
                        alert("Browser tidak mendukung geolokasi.");
                        return;
                    }

                    this.watchId = navigator.geolocation.watchPosition(
                        (pos) => {
                            const lat = pos.coords.latitude;
                            const lon = pos.coords.longitude;
                            const acc = pos.coords.accuracy; // meter

                            // Buat / update marker user
                            if (!this.userMarker) {
                                this.userMarker = L.marker([lat, lon], {
                                    icon: L.icon({
                                        iconUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-icon.png",
                                        iconSize: [25, 41],
                                        iconAnchor: [12, 41],
                                        popupAnchor: [1, -34]
                                    })
                                }).addTo(this.map);
                            } else {
                                this.userMarker.setLatLng([lat, lon]);
                            }

                            // Buat / update circle radius akurasi
                            if (!this.userCircle) {
                                this.userCircle = L.circle([lat, lon], {
                                    radius: acc,
                                    color: "blue",
                                    fillColor: "#3f8bfd",
                                    fillOpacity: 0.2
                                }).addTo(this.map);
                            } else {
                                this.userCircle.setLatLng([lat, lon]);
                                this.userCircle.setRadius(acc);
                            }

                            // Auto-center setiap update (jika mau)
                            this.map.setView([lat, lon], 15);
                        },
                        (err) => {
                            console.error(err);
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 15000,
                            maximumAge: 0
                        }
                    );
                }
            }));
        });
    </script>

</div>