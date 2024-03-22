<x-layouts.app title="Pengaturan">
<h5 class="fw-bold py-3 mb-4">Selamat Datang</h5>

<!-- Striped Rows -->
<div class="card">
    <h5 class="card-header">Data Regional</h5>
    <div class="card-body">
        @can('regional_create')
            <a href="{{ route('regional.create') }}" class="mb-4 btn btn-secondary"><i class="bx bx-plus"></i> Tambah Regional</a>
        @endcan

        <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="tabel-regional">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        @if(auth()->user()->can('regional_update') || auth()->user()->can('regional_update'))
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        @if(auth()->user()->can('regional_update') || auth()->user()->can('regional_update'))
                            <th>Aksi</th>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<x-slot name="script">
    <script>
        $(document).ready(function () {
            // Datatables
            $('#tabel-regional').DataTable({
                ajax: "{{ route('ajax.getRegional') }}",
                processing: true,
                serverSide: true,
                responsive: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    {data: 'nama', name: 'nama'},
                    {data: 'action', name: 'action'},
                ],
            })
        });
    </script>
</x-slot>

</x-layouts.app>
