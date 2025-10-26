@use('App\Enum\UserRole')
<x-dashboard.side-menu title="Dashboard">
    <x-dashboard.side-item title="Dashboard" :href="route('dashboard')" icon="dashboard-line" />
    {{-- <x-dashboard.side-group title="account" :href="route('dashboard')" icon="user-line">
        <x-dashboard.side-group-item href="/dashboard" title="Setting" />
    </x-dashboard.side-group> --}}
</x-dashboard.side-menu>

<x-dashboard.side-menu title="Account">
    <x-dashboard.side-item title="Admin" :href="route('dashboard.account.list' , ['role' => UserRole::ADMIN])" icon="shield-user-line" />
    <x-dashboard.side-item title="Member" :href="route('dashboard.account.list' , ['role' => UserRole::MEMBER])" icon="user-3-line" />
    <x-dashboard.side-item title="Operator" :href="route('dashboard.account.list' , ['role' => UserRole::OPERATOR])" icon="tools-line" />
</x-dashboard.side-menu>
