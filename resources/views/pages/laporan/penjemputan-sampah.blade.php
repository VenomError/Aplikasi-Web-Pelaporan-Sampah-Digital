<?php
use App\Models\Report;
use App\Models\Incentive;
use App\Enum\ReportStatus;
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Repository\IncentiveRepository;

new class extends Component {
    use WithPagination;
    public $search = '';

    public $selectedReport;

    #[Computed]
    public function reports()
    {
        $query = Report::query();
        $query->orderBy('created_at', 'desc');
        $query->when($this->search, function ($q) {
            $q->search(['title', 'description', 'address'], $this->search);
        });

        return $query->paginate(5);
    }

    public function confirmDelete(Report $report)
    {
        // handle delete
        $this->dispatch('show:modal', id: 'modalDeleteReport');
        $this->selectedReport = $report;
    }
    public function setToEdit(Report $report)
    {
        $this->dispatch('show:modal', id: 'modalEditReport');
        $this->selectedReport = $report;
    }

    public function deleteConfirmed()
    {
        // delete
        $this->dispatch('hide:modal', id: 'modalDeleteReport');
        $this->reset('selectedReport');
    }
    #[On('hide:modal')]
    public function onHideModal($id)
    {
        if ($id == 'modalDeleteReport') {
            $this->render();
        }
    }
    public function export() {}
    #[Computed]
    public function reportCountByStatus(ReportStatus $status): int
    {
        $query = Report::latest();
        $query->where('status', $status);
        return $query->count();
    }
};
?>
<div>
    <x-dashboard.page-title title="Laporan Penjemputan Sampah">
        <x-dashboard.page-title-item title="Penjemputan Sampah" />
    </x-dashboard.page-title>
    <div class="row justify-content-center">
        <x-widget.dash-count class="col-lg-6" title="Total Laporan" :count="$this->reports()->total()" color="success"
            icon="ri-file-list-fill" />
        <x-widget.dash-count class="col-lg-6" :title="ReportStatus::COMPLETED->value" :count="$this->reportCountByStatus(ReportStatus::COMPLETED)" :color="ReportStatus::COMPLETED->color()" :icon="ReportStatus::COMPLETED->icon()" />
        @foreach (ReportStatus::cases() as $status)
            @if ($status != ReportStatus::COMPLETED)
                <x-widget.dash-count :title="$status->value" :count="$this->reportCountByStatus($status)" :color="$status->color()" :icon="$status->icon()" />
            @endif
        @endforeach
    </div>
    <x-table :search="$search" col="5" :paginate="$this->reports()">
        <x-slot:header>
            <x-button.submit action="export()" color="primary" loadingText="Exporting...">Export</x-button.submit>
        </x-slot:header>
        <x-slot:head>
            <tr class="text-center">
                <th>ID</th>
                <th>Image</th>
                <th>Address</th>
                <th>Member</th>
                <th>Operator</th>
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
                                <img src="{{ $report->image }}" alt="{{ $report->title }}">
                            </a>
                        </div>
                    </td>
                    <td>{{ $report->address }}</td>
                    <td>{{ $report->member->account->name }}</td>
                    <td>{{ $report->operator?->account?->name ?? 'Belum Ada' }}</td>
                    <td>
                        <button class="btn btn-sm btn-{{ $report->status->color() }}">{{ $report->status }}</button>
                    </td>
                    <td>
                        <div class="hstack fs-15 justify-content-center gap-2">
                            <x-button.icon-action type="a" href="/" icon="ri ri-eye-line" color="info" />
                            <x-button.icon-action type="button" wire:click="setToEdit({{ $report->id }})"
                                target="setToEdit({{ $report->id }})" icon="ri ri-pencil-line" color="warning" />
                            <x-button.icon-action type="button" wire:click="confirmDelete({{ $report->id }})"
                                target="confirmDelete({{ $report->id }})" icon="ri ri-delete-bin-line"
                                color="danger" />
                        </div>
                    </td>
                </tr>
            @empty
                <x-table.empty-state col="5" />
            @endforelse
        </x-slot:body>
    </x-table>

    {{-- MODAL --}}
    <x-modal-delete id="modalDeleteReport" confirmAction="deleteConfirmed()" />
</div>
