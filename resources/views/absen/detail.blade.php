<x-layouts.app title="Detail Absen">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi / Absen /</span> Detail</h4>

    <div class="row">
        <div class="col-12">

            {{-- Menu --}}
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    {{-- Jika request url adalah url yg di tentukan, set class active --}}
                    <a class="nav-link active" href="{{ route('absen.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
                </li>
            </ul>

            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Laporan Absen
                </h5>
                <div class="card-body">
                    <table class="table table-hover table-responsive" id="tabel-log-absen">
                        <thead>
                            <th>No</th>
                            <th width="280px">Foto</th>
                            <th>Tanggal</th>
                            <th>Shift</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status</th>
                        </thead>

                        <tfoot>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Tanggal</th>
                            <th>Shift</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Status</th>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function(){
                $('#tabel-log-absen').DataTable({
                    ajax: "{{ route('ajax.getAbsenDetail') }}",
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    searching: true,
                    lengthChange: true,
                    paging: true,
                    info: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'foto', name: 'foto'},
                        {data: 'tanggalAbsen', name: 'tanggalAbsen'},
                        {data: 'shift', name: 'shift'},
                        {data: 'jamMasuk', name: 'jamMasuk'},
                        {data: 'jamPulang', name: 'jamPulang'},
                        {data: 'status', name: 'status'},
                    ],
                });
            });
        </script>
    </x-slot>

</x-layouts.app>
