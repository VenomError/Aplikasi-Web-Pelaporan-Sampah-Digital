<?php
use App\Enum\ReportStatus;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search = '';
    public $date;
    public $status = ReportStatus::PENDING;

    public function mount()
    {
        if (!$this->date) {
            $this->date = now()->format('Y-m-d');
        }
    }

    #[Computed]
    public function reports()
    {
        $operator = auth()->user()->owner;

        $query = $operator->reports();
        $query->when($this->status, fn($q) => $q->whereStatus($this->status));
        $query->when($this->date, fn($q) => $q->whereDate('created_at', Carbon::parse($this->date)));
        $query->when($this->search, function ($q) {
            $q->search(['title', 'description', 'address'], $this->search);
        });
        $query->orderBy('created_at', 'desc');
        return $query->paginate();
    }

    #[Computed]
    public function reportCountByStatus(?ReportStatus $status = null): int
    {
        $operator = auth()->user()->owner;

        $query = $operator->reports();
        $query->when($status, fn($q) => $q->whereStatus($status));
        $query->when($this->date, fn($q) => $q->whereDate('created_at', Carbon::parse($this->date)));
        return $query->count();
    }
};
?>
<div>
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

    <x-table
        :search="$search"
        col="7"
        :paginate="$this->reports()"
    >
        <x-slot:header>
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
        </x-slot:header>
        <x-slot:head>
            <tr class="text-center">
                <th>ID</th>
                <th>Image</th>
                <th>Address</th>
                <th>Member</th>
                <th>Report At</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </x-slot:head>
        <x-slot:body>
            @forelse ($this->reports() as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td class="text-center">
                        <div class="">
                            <a class="product-img stock-img" href="javascript:void(0);">
                                <img
                                    src="{{ $report->image }}"
                                    alt="{{ $report->title }}"
                                    style="height: 50px;"
                                >
                            </a>
                        </div>
                    </td>
                    <td>{{ $report->address }}</td>
                    <td>{{ $report->member->account->name }}</td>
                    <td>{{ $report->created_at->format('D d-m-y H:i') }}</td>
                    <td>
                        <button class="btn btn-sm btn-{{ $report->status->color() }}">{{ $report->status }}</button>
                    </td>
                    <td>
                        <div class="hstack fs-15 justify-content-center gap-2">
                            <a
                                class="btn btn-icon btn-sm btn-info"
                                href="https://www.google.com/maps/dir/?api=1&destination={{ $report->latitude }},{{ $report->longitude }}"
                                target='_blank'
                            >
                                <i class="ri ri-map-pin-line"></i>
                            </a>

                        </div>
                    </td>
                </tr>
            @empty
                <x-table.empty-state col="7" />
            @endforelse
        </x-slot:body>
    </x-table>
</div>
