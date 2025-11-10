<?php
use App\Models\Incentive;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

new class extends Component {
    use WithPagination;
    public $search = '';

    #[Computed]
    public function incentives()
    {
        $query = Incentive::query();
        $query->orderBy('name');
        $query->when($this->search, function ($q) {
            $q->search(['name'], $this->search);
        });

        return $query->paginate(5);
    }

    public function toggleStatus(Incentive $incentive)
    {
        $incentive->is_active = !$incentive->is_active;
        $incentive->save();
        $incentive->refresh();
        if($incentive->is_active){
            flash("incentive Activated");
        }
    }
};
?>
<div>
    <x-dashboard.page-title title="List insentif">
        <x-dashboard.page-title-item title="insentif" />
    </x-dashboard.page-title>
    <x-table :search="$search" col="5" :paginate="$this->incentives()">
        <x-slot:head>
            <tr class="text-center">
                <th>Insentif</th>
                <th>Status</th>
                <th>Point Required</th>
                <th>Total Redeemed</th>
                <th>Action</th>
            </tr>
        </x-slot:head>
        <x-slot:body>
            @forelse ($this->incentives as $incentive)
                <tr>
                    <td>
                        <div class="productimgname">
                            <a class="product-img stock-img" href="javascript:void(0);">
                                <img src="{{ $incentive->image }}" alt="{{ $incentive->name }}">
                            </a>
                            <a href="javascript:void(0);">{{ Str::title($incentive->name) }}</a>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-switch form-check-lg m-0">
                            <input
                                class="form-check-input"
                                id="switch-lg"
                                type="checkbox"
                                role="switch"
                                wire:change='toggleStatus({{ $incentive->id }})'
                                @checked($incentive->is_active)
                            />
                        </div>
                    </td>

                    <td class="text-center">{{ Number::format($incentive->points_required, locale: 'id_ID') }}</td>
                    <td class="text-center">{{ $incentive->redemtions_count }}</td>
                    <td>
                        <div class="hstack fs-15 justify-content-center gap-2">
                            <x-button.icon-action
                                type="a"
                                href="/"
                                icon="ri ri-eye-line"
                                color="info"
                            />
                            <x-button.icon-action
                                type="button"
                                wire:click="confirmDelete({{ $incentive->id }})"
                                target="confirmDelete({{ $incentive->id }})"
                                icon="ri ri-delete-bin-line"
                                color="danger"
                            />
                        </div>
                    </td>
                </tr>
            @empty
                <x-table.empty-state col="5" />
            @endforelse
        </x-slot:body>
    </x-table>
</div>
