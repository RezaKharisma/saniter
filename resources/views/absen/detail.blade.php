<x-layouts.app title="Detail Absen">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi / </span> Detail</h4>

    <div class="row">
        <div class="col-12">

            {{-- Menu --}}
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    {{-- Jika request url adalah url yg di tentukan, set class active --}}
                    <a class="btn btn-secondary" href="{{ route('absen.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
                </li>
            </ul>

            <div class="card">
                <h5 class="card-header mb-3">
                    Laporan Absen
                </h5>

                <div style="position: relative">
                    <div class="table-responsive text-nowrap" >
                        <table class="table table-hover" id="tabel-log-absen">
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
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function(){
                $('#tabel-log-absen').DataTable({
                    ajax: "{{ route('ajax.getAbsenDetail') }}",
                    processing: true,
                    serverSide: true,
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
