<x-layouts.app title="Detail Absen">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi / Absen /</span> Detail</h4>

    <div class="row">
        <div class="col-12">

            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Laporan Absen
                    <button class="btn btn-info btn-sm">Detail</button>
                </h5>
                <div class="card-body">
                    <table class="table table-hover table-responsive" id="tabel-log-absen">
                        <thead>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                        </thead>

                        <tfoot>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
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
                    ajax: "{{ route('ajax.getAbsenLog') }}",
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    searching: false,
                    lengthChange: false,
                    paging: false,
                    info: false,
                    columns: [
                        {data: 'tanggalAbsen', name: 'tanggalAbsen'},
                        {data: 'jamMasuk', name: 'jamMasuk'},
                        {data: 'jamPulang', name: 'jamPulang'},
                    ],
                });
            });
        </script>
    </x-slot>

</x-layouts.app>
