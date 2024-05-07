<x-layouts.app title="Izin">

    <x-slot name="style">
        <style>
            input[type=checkbox]:checked{
                background-color: #71dd37 !important;
            }

            .btnPrimary{
                color: #696cff !important;
                border-color: rgba(0, 0, 0, 0) !important;
                background: #e7e7ff !important;
            }

            .btnPrimary:hover{
                color: #e7e7ff !important;
                background: #696cff !important;
            }
        </style>
    </x-slot>

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi / </span>Izin</h4>

<div class="row">
    <div class="col-md-12">

        @can('izin_create')
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="d-flex flex-column justify-content-center">
                    <div class="me-2">
                        <a class="btn btn-primary" href="{{ route('izin.create') }}"><i class="bx bx-plus me-1"></i> Tambah Izin</a>
                    </div>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-2 mt-3 mt-sm-3 mt-md-0">
                    <a class="btn btn-primary" href="javascript:void(0);"><i class="bx bx-task me-1"></i> Izin</a>

                    @can('all_izin')
                        <a class="btn {{ request()->is('administrasi/izin/all') ? 'active' : '' }} btnPrimary" href="{{ route('all.izin.index') }}"><i class="bx bx-task me-1"></i> Semua Izin</a>
                    @endcan
                </div>
            </div>
        @endcan

        <div class="card mb-4">
            <h5 class="card-header mb-3">
                Data Izin
            </h5>

            <div style="position: relative">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover table-responsive" id="tabel-izin">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Dokumen Pendukung</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Dokumen Pendukung</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalValid" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <form method="POST" class="d-inline" id="formEdit">
        @csrf
        @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Validasi Izin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">Tidak dapat diubah setelah validasi!</div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card shadow w-100">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 justify-content-center d-flex mb-3">
                                        <div class="form-check d-block">
                                            <input class="form-check-input" type="checkbox" value="{{ auth()->user()->name }}" name="validasi1" id="validasi1" >
                                            <label class="form-check-label" for="defaultCheck1">Validasi 1</label>
                                        </div>
                                    </div>
                                    <div class="col-12 justify-content-center d-flex">
                                        <span class="badge bg-label-secondary w-100" id="validasi1nama">Belum Divalidasi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card shadow w-100">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 justify-content-center d-flex mb-3">
                                        <div class="form-check d-block">
                                            <input class="form-check-input" type="checkbox" value="{{ auth()->user()->name }}" name="validasi2" id="validasi2">
                                            <label class="form-check-label" for="defaultCheck1">Validasi 2</label>
                                        </div>
                                    </div>
                                    <div class="col-12 justify-content-center d-flex">
                                        <span class="badge bg-label-secondary w-100" id="validasi2nama">Belum Divalidasi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
        </div>
    </div>
</div>

<x-slot name='script'>
    <script>
        $(document).ready(function () {
            // Datatables
            $('#tabel-izin').DataTable({
                ajax: "{{ route('ajax.getIzin') }}",
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    {data: 'userName', name: 'userName'},
                    {data: 'jenis', name: 'jenis'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'keterangan', name: 'keterangan'},
                    {data: 'file', name: 'file'},
                    {data: 'action', name: 'action'},
                ],
            })
        });
    </script>
    <script>
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

        function validasiData(e)
        {
            // Mengatur ajax csrf
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('ajax.getValidIzin') }}",
                data: {
                    id: e.dataset.id // Mengambil id pada event
                },
                dataType: "json",
                success: function (response) { // Jika ajax sukses dan memberikan respon
                    var url = "{{ route('izin.updateValidasi', ':id') }}"; // Action pada form edit
                    url = url.replace(':id', response.id );
                    $("#formEdit")[0].reset();
                    $('#formEdit').attr('action', url);
                    checkValid(response);
                }
            });
        }

        function resetValid(){
            $('#validasi1').prop('checked', false);
            $('#validasi1').prop('disabled', false);
            $('#validasi2').prop('checked', false);
            $('#validasi2').prop('disabled', false);
            $('#validasi1nama').html('Belum Divalidasi');
            $('#validasi2nama').html('Belum Divalidasi');
        }
    </script>

    <script>
        function checkValid(response){
            resetValid()
            if ($.isFunction(validasi1)) {
                validasi1();
            }
            if ($.isFunction(validasi2)) {
                validasi2();
            }
            if (response.validasi2) {
                $('#validasi2').prop('checked', true);
                $('#validasi2').prop('disabled', true);
                $('#validasi2nama').html(response.validasi2nama)
            }

            if (response.validasi1) {
                $('#validasi1').prop('checked', true);
                $('#validasi1').prop('disabled', true);
                $('#validasi1nama').html(response.validasi1nama)
            }
        }
    </script>

    @can('validasi1_izin')
        <script>
            function validasi1() {
                $('#validasi1').prop('disabled', false);
                $('#validasi2').prop('disabled', true);
            }
        </script>
    @endcan

    @can('validasi2_izin')
        <script>
            function validasi2() {
                $('#validasi1').prop('disabled', true);
                $('#validasi2').prop('disabled', false);
            }
        </script>
    @endcan
</x-slot>

</x-layouts.app>
