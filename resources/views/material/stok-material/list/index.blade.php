<x-layouts.app title="List Stok Material">

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}">
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material / </span>List Stok Material</h4>

    <!-- Striped Rows -->
    <div class="card">
        <h5 class="card-header">Filter Stok Material</h5>
        <div class="card-body">
            {{-- Material --}}
            <div class="row mb-2">
                <div class="col-12 col-sm-12 col-md-6 mb-3">
                    <x-partials.label title="Kode Material"/>
                    <input type="text" class="form-control" name="kode_material" placeholder="Kode Material" autocomplete="off"/>
                </div>
                <div class="col-12 col-sm-12 col-md-6 mb-3">
                    <x-partials.label title="Nama Material"/>
                    <input type="text" class="form-control" name="nama_material"  placeholder="Nama Material" autocomplete="off"/>
                </div>
            </div>

            {{-- Tanggal --}}
            <div class="row mb-2">
                <div class="col-12 col-sm-12 col-md-6 mb-3">
                    <x-partials.label title="Tanggal Mulai"/>
                    <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Tanggal Mulai" autocomplete="off"/>
                </div>
                <div class="col-12 col-sm-12 col-md-6 mb-3">
                    <x-partials.label title="Tanggal Akhir"/>
                    <input type="text" class="form-control" id="end_date" name="end_date"  placeholder="Tanggal Akhir" autocomplete="off"/>
                </div>
            </div>

            <div class="row">
                <div class="col-auto">
                    <x-partials.label title="Export"/><br/>
                    <div class="my-buttons"></div>
                </div>
                <div class="col-auto">
                    <x-partials.label title="Aksi"/><br/>
                    <div class="d-block">
                        <button class="btn btn-primary filterDate" id="filterDate"><i class="bx bx-search"></i></button>
                        <button class="btn btn-primary filterDate" id="resetFilter"><i class="bx bx-refresh"></i></button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="card mt-3">
        <h5 class="card-header">Data Stok Material</h5>
        <div style="position: relative;">
            <div class="table-responsive">
                <table class="table table-hover" id="stok-material-table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Tanggal Input</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Tanggal Input</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(document).ready(function () {
                dataStokMaterial();

                $("#start_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                });

                $("#end_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                });

                // Jika tombol delete diklik
                $(document).on("click", "button.confirm-delete", function () {
                    var form = $(this).closest("form");
                    event.preventDefault();
                    Swal.fire({ // SweetAlert
                        title: "Apa kamu yakin?",
                        text: "Data akan terhapus!",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yakin",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) { // Jika iyaa form akan tersubmit
                            form.submit();
                        }
                    });
                });
            });

            $('#filterDate').on('click', function (e) {
                $('#stok-material-table').DataTable().destroy();
                dataStokMaterial();
            })

            $('#resetFilter').on('click', function (e) {
                $('#stok-material-table').DataTable().destroy();
                $('input[name="start_date"]').val(''),
                $('input[name="end_date"]').val('')
                dataStokMaterial();
            })

            function dataStokMaterial(){
                new DataTable('#stok-material-table',{
                    ajax: {
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('ajax.getListStokMaterial') }}",
                        data: {
                            start_date: $('input[name="start_date"]').val(),
                            end_date: $('input[name="end_date"]').val(),
                            kode_material: $('input[name="kode_material"]').val(),
                            nama_material: $('input[name="nama_material"]').val()
                        }
                    },
                    processing: true,
                    serverSide: true,
                    dom:'lBfrtip',
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'kode_material', name: 'kode_material'},
                        {data: 'nama_material', name: 'nama_material'},
                        {data: 'stok_update', name: 'stok_update'},
                        {data: 'harga', name: 'harga'},
                        {data: 'tanggal_diterima_pm', name: 'tanggal_diterima_pm'},
                        // {data: 'action', name: 'action'},
                    ],
                    buttons: ['excel', 'pdf', 'print'],
                    columnDefs: [
                        {targets: [3,5], className: 'text-center'}
                    ],
                }).buttons().container().appendTo('.my-buttons');
            }
        </script>
    </x-slot>
</x-layouts.app>
