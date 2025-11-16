<?php
use App\Models\Incentive;
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Reactive;
use App\Livewire\Forms\Incentive\EditIncentiveForm;

new class extends Component {
    use WithFileUploads;
    public EditIncentiveForm $form;

    #[Reactive]
    public ?Incentive $incentive;

    #[On('show:modal')]
    public function onShowModal($id)
    {
        if($id == 'modalEditIncentive'){
            $this->form->setIncentive($this->incentive);
        }
    }

    public function submit()
    {
        if ($this->form->submit()) {
            $this->dispatch('hide:modal', id: 'modalEditIncentive');
        }
    }
};
?>
<div>
    <form wire:submit.prevent='submit()'>
        <div class="row">
            <div class="col-12">
                @if ($form?->image && method_exists($form?->image, 'temporaryUrl'))
                    <div class="d-flex justify-content-center">
                        <img class="avatar avatar-xxl img-fluid rounded-circle" src="{{ $form?->image->temporaryUrl() }}"
                            alt="">
                    </div>
                @endif
                <x-input type="text" label="Incentive Name" wire:model='form.name' />
                <x-input type="number" label="Points Required" wire:model='form.points_required' />
                <x-input type="file" label="New Image" wire:model='form.image' accept="image/*">
                    <div wire:loading wire:target="form.image">Uploading...</div>
                </x-input>
                <x-input-textarea label="Description" wire:model='form.description' />
                <div class="form-check form-check-lg form-switch form-check-reverse mb-3">
                    <input class="form-check-input " type="checkbox" role="switch" id="switch-lg"
                        wire:model.live='form.is_active'>
                    <label class="form-check-label me-2" for="switch-lg">
                        <span
                            class="badge rounded-1 bg-{{ $form->is_active ? 'success' : 'danger' }}">{{ $form->is_active ? 'active' : 'inactive' }}</span>
                    </label>
                </div>
                <div class="d-flex float-end">
                    <x-button.submit action="submit()">Edit Incentive</x-button.submit>
                </div>
            </div>
        </div>
    </form>
</div>