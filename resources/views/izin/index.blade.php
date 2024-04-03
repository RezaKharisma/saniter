<x-layouts.app title="Izin">

    <x-slot name="style">
        <style>
            input[type=checkbox]:checked{
                background-color: #71dd37 !important;
            }
        </style>
    </x-slot>

<h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Izin /</span> Data Izin Teknisi</h5>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills flex-md-row mb-3">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('izin.create') }}"><i class="bx bx-plus-circle me-1"></i> Buat Izin</a>
            </li>
        </ul>
        <div class="card mb-4">

            <div class="card-body">
                <table class="table table-hover table-responsive" id="tabel-izin">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Tanggal</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
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
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
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
                responsive: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    {data: 'userName', name: 'userName'},
                    {data: 'jenis', name: 'jenis'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'file', name: 'file'},
                    {data: 'action', name: 'action'},
                ],
            })
        });
    </script>
    <script>
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

        function checkValid(response){
            resetValid()
            kecualiRole1(response);
            kecualiRole2(response);
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

            if (response.status != "Admin") {
                    $('#validasi2').prop('disabled', true);
                }
            if (response.validasi2) {
                $('#validasi2').prop('checked', true);
                $('#validasi2').prop('disabled', true);
                $('#validasi2nama').html(response.validasi2nama)

            }

            if (response.status != "Staff") {
                $('#validasi1').prop('disabled', true);
            }
            if (response.validasi1) {
                $('#validasi1').prop('checked', true);
                $('#validasi1').prop('disabled', true);
                $('#validasi1nama').html(response.validasi1nama)
            }
        }
    </script>
</x-slot>

</x-layouts.app>
