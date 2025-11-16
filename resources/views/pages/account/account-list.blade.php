<?php
use App\Models\User;
use App\Enum\UserRole;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;
use App\Repository\UserRepository;
use Illuminate\Container\Attributes\Cache;

new class extends Component {
    use WithPagination;
    #[Cache]
    public $search = '';
    public UserRole $role;

    // delete handle
    public User $selectedUser;

    public function mount(UserRole $role)
    {
        $this->role = $role;
    }

    #[On('hide:modal')]
    public function onHideModal($id)
    {
        if ($id == 'modalAddAccount') {
            $this->render();
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[Computed]
    public function users()
    {
        $userQuery = User::query()->role($this->role);

        $userQuery->when($this->search, function ($q) {
            $q->search(['name', 'email'], $this->search);
        });

        return $userQuery->paginate(5);
    }

    public function confirmDelete(User $user)
    {
        $this->dispatch('show:modal', id: 'modalDeleteAccount');
        $this->selectedUser = $user;
        $this->resetPage();
    }

    public function deleteConfirmed()
    {
        $repo = new UserRepository();
        if ($repo->delete($this->selectedUser)) {
            sweetalert('Delete User Success', title: 'Success');
        } else {
            sweetalert('Delete User Success', title: 'Success', type: 'error');
        }
        $this->dispatch('hide:modal', id: 'modalDeleteAccount');
        $this->reset('selectedUser');
    }
};
?>
<div>
    <x-dashboard.page-title title="List {{ $role }} Account">
        <x-dashboard.page-title-item title="{{ $role }} Account" />
    </x-dashboard.page-title>
    <x-table :search="$search" :paginate="$this->users()" col="7">
        <x-slot:header>
            <x-button.add title="Add {{ $role }}" @click="$dispatch('show:modal', { id: 'modalAddAccount' })" />
        </x-slot:header>

        <x-slot:head>
            <tr class="text-center">
                <th>{{ Str::title($role?->value) }}</th>
                <th>Email</th>
                <th>Email Verification</th>
                @if ($role == UserRole::MEMBER)
                    <th>Phone</th>
                    <th>Address</th>
                @endif
                <th>Registration At</th>
                <th>Action</th>
            </tr>
        </x-slot:head>
        <x-slot:body>
            @forelse ($this->users() as $user)
                <tr wire:key='{{ md5($user->id) }}'>
                    <td>
                        <div class="userimgname cust-imgname">
                            <a class="product-img" href="javascript:void(0);">
                                <img src="{{ $user->avatar }}" alt="product">
                            </a>
                            <a href="javascript:void(0);">{{ $user->name }}</a>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">
                        @if ($user->email_verified_at)
                            <span class="badge bg-success">Verified</span>
                        @else
                            <span class="badge bg-danger">Not Verified</span>
                        @endif
                    </td>
                    @if ($role == UserRole::MEMBER)
                        <td>{{ $user?->owner?->phone }}</td>
                        <td>{{ $user?->owner?->address }}</td>
                    @endif
                    <td>{{ $user->created_at->format('Y-m-d h:i') }}</td>
                    <td>
                        <div class="hstack fs-15 justify-content-center gap-2">
                            <x-button.icon-action type="a" href="/" icon="ri ri-eye-line" color="info" />
                            <x-button.icon-action type="button" wire:click="confirmDelete({{ $user->id }})"
                                target="confirmDelete({{ $user->id }})" icon="ri ri-delete-bin-line" color="danger" />
                        </div>
                    </td>
                </tr>
            @empty
                <x-table.empty-state col="7" />
            @endforelse
        </x-slot:body>
    </x-table>
    <x-modal id="modalAddAccount" title="Add Account {{ $role }}" backDrop>
        <livewire:user.user-add :role="$role" />
    </x-modal>
    <x-modal-delete id="modalDeleteAccount" confirmAction="deleteConfirmed()" />
</div>