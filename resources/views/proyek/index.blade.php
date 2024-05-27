<x-layouts.app title="Tanggal Kerja">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proyek / </span> Tanggal Kerja</h4>

    {{-- <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bx bx-plus"></i> Tambah Area
    </button> --}}

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <h5 class="card-header mb-3">
                    Tanggal Kerja
                </h5>

                    <div style="position: relative">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover" id="kerja-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Total Lokasi Pengerjaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Total Lokasi Pengerjaan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // Datatables
                $('#kerja-table').DataTable({
                    ajax: "{{ route('ajax.getTglKerja') }}",
                    processing: true,
                    serverSide: true,
                    // responsive: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'tanggal', name: 'tanggal'},
                        {data: 'total', name: 'total'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    columnDefs: [
                        {targets: [2], className: 'text-center'}
                    ]
                })
            });
        </script>
    </x-slot>

    </x-layouts.app>
