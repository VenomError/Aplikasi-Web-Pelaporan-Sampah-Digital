@use('App\Enum\UserRole')
<x-dashboard.side-menu title="Dashboard">
    <x-dashboard.side-item title="Dashboard" :href="route('dashboard')" icon="dashboard-line" />
    <x-dashboard.side-item title="Map Penjemputan" :href="route('dashboard.report-map')" icon="map-line" />
    <x-dashboard.side-item title="Penukaran Point" :href="route('dashboard')" icon="exchange-line" />
</x-dashboard.side-menu>

<x-dashboard.side-menu title="Laporan">
    <x-dashboard.side-item title="Penjemputan Sampah" :href="route('dashboard.account.list', ['role' => UserRole::ADMIN])" icon="caravan-line" />
    <x-dashboard.side-item title="History Penukaran" :href="route('dashboard.account.list', ['role' => UserRole::ADMIN])" />
</x-dashboard.side-menu>

<x-dashboard.side-menu title="Master Data">
    <x-dashboard.side-group href="/dashboard/account" title="account" icon="user-3-line">
        <x-dashboard.side-group-item title="Admin" :href="route('dashboard.account.list', ['role' => UserRole::ADMIN])" />
        <x-dashboard.side-group-item title="Member" :href="route('dashboard.account.list', ['role' => UserRole::MEMBER])" />
        <x-dashboard.side-group-item title="Operator" :href="route('dashboard.account.list', ['role' => UserRole::OPERATOR])" icon="tools-line" />
    </x-dashboard.side-group>
    <x-dashboard.side-item title="Insentif" :href="route('dashboard.incentive.list')" icon="gift-line" />
</x-dashboard.side-menu>
