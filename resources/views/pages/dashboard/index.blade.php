<?php
use App\Enum\ReportStatus;
use App\Models\Report;
use Carbon\Carbon;
use Livewire\Volt\Component;

new class extends Component {
    public $date;
    public function mount()
    {
        if (!$this->date) {
            $this->date = now()->format('Y-m-d');
        }
    }

    #[Computed]
    public function reportCountByStatus(?ReportStatus $status = null): int
    {
        $query = Report::query();
        $query->when($status, fn($q) => $q->whereStatus($status));
        $query->when($this->date, fn($q) => $q->whereDate('created_at', Carbon::parse($this->date)));
        return $query->count();
    }
};
?>

<div class="">
    <div class="welcome d-lg-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center welcome-text">
            <h3 class="d-flex align-items-center me-2">
                <img
                    class="me-2"
                    src="assets/img/icons/hi.svg"
                    alt="img"
                >
                Halo {{ auth()->user()->name }}
            </h3>
            <h6>Welcome to Admin Dashboard !</h6>
        </div>
        <div class="d-flex align-items-center">
            <div class="position-relative daterange-wraper me-2">
                <input
                    class="form-control"
                    type="date"
                    wire:model.live="date"
                />
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <x-widget.dash-count
            class="col-lg-6"
            title="Total Laporan"
            :count="$this->reportCountByStatus()"
            color="success"
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
</div>
<script>
    function setPosition(position) {
        let lat = position.coords.latitude;
        let long = position.coords.longitude;
        let accuracy = position.coords.accuracy; // meter
    }

    function errorPosition(error) {
        console.error(error);
    }
    const options = {
        enableHighAccuracy: true,
        timeout: 10000,
        maximumAge: 0
    };
    document.addEventListener('DOMContentLoaded', () => {
        navigator.geolocation.watchPosition(setPosition, errorPosition, options);
    })
</script>
