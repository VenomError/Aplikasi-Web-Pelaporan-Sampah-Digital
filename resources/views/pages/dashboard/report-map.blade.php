<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use App\Enum\ReportStatus;

new #[Title('Map Penjemputan')] class extends Component {
    public $reports = [];

    public function mount()
    {
        $baseLat = -5.1477;
        $baseLng = 119.4327;

        // Buat 10 data acak sekitar Makassar
        for ($i = 1; $i <= 10; $i++) {
            $status = ReportStatus::random();

            $this->reports[] = [
                'id' => $i,
                'title' => "Laporan #$i",
                'status' => $status->name,
                'color' => $status->color(),
                'latitude' => $baseLat + mt_rand(-50, 50) / 1000,
                'longitude' => $baseLng + mt_rand(-50, 50) / 1000,
                'address' => "Jl. Contoh No. $i, Makassar",
                'member_name' => "Member $i",
                'operator_name' => 'Operator ' . chr(64 + $i), // A, B, C, ...
            ];
        }
    }
};
?>

<div>
    <x-dashboard.page-title title="Map Penjemputan">
        <x-dashboard.page-title-item title="Map Penjemputan" />
    </x-dashboard.page-title>

    <div x-data="mapComponent({ reports: $wire.reports })" x-init="init()" class="position-relative border rounded shadow-sm"
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
