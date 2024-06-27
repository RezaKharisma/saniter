<x-layouts.app title="Dashboard">
    @role('Teknisi')
        @include('dashboard.dashboard-karyawan')
    @else
        @include('dashboard.dashboard-admin')
    @endrole
</x-layouts.app>
