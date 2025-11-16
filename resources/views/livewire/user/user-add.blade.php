<?php
use App\Enum\UserRole;
use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Livewire\Forms\Account\AddAccountForm;

new class extends Component {
    use WithFileUploads;
    public UserRole $role;
    public AddAccountForm $form;

    #[On('hide:modal')]
    public function onHideModal($id)
    {
        if ($id == 'modalAddAccount') {
            $this->form->reset();
            $this->form->resetErrorBag();
        }
    }

    public function submit()
    {
        if ($this->form->add($this->role)) {
            $this->dispatch('hide:modal', id: 'modalAddAccount');
            $this->dispatch('refresh');
        }
    }
};
?>
<div>
    <div class="row">
        <div class="col-12">
            @if ($form->avatar && method_exists($form->avatar, 'temporaryUrl'))
                <div class="d-flex justify-content-center">
                    <img class="avatar avatar-xxl img-fluid rounded-circle" src="{{ $form->avatar->temporaryUrl() }}"
                        alt="">
                </div>
            @endif
            <x-input type="text" label="Full Name" wire:model='form.name' />
            <x-input type="email" label="Email Address" wire:model='form.email' />
            <x-input type="password" label="Password" wire:model='form.password' />
            <x-input type="file" label="Avatar" wire:model='form.avatar'>
                <div wire:loading wire:target="form.avatar">Uploading...</div>
            </x-input>

            @if ($role == UserRole::MEMBER)
                <x-input type="tel" label="Phone Number" wire:model='form.phone' />
                <x-input-textarea label="Address" wire:model='form.address' />
            @endif

            <div class="d-flex float-end">
                <x-button.submit action="submit()">Add Account</x-button.submit>
            </div>
        </div>
    </div>
</div>