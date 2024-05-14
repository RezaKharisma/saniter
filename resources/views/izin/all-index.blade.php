<x-layouts.app title="Semua Izin">

    <x-slot name="style">
        <style>
            input[type=checkbox]:checked{
                background-color: #71dd37;
            }

            .redCheck:checked{
                background-color: red !important;
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

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi / </span>Semua Izin</h4>

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
                    <a class="btn btnPrimary" href="{{ route('izin.index') }} "><i class="bx bx-task me-1"></i> Izin</a>

                    @can('all_izin')
                        <a class="btn btn-primary" href="{{ route('all.izin.index') }}"><i class="bx bx-task me-1"></i> Semua Izin</a>
                    @endcan
                </div>
            </div>
        @endcan

        <div class="card mb-4">
            <h5 class="card-header">
                Data Semua Izin
            </h5>
            <div style="position: relative">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover" id="tabel-izin" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Tanggal</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Keterangan</th>
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
                                <th>Tanggal Pengajuan</th>
                                <th>Keterangan</th>
                                <th>File</th>
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
                        <div class="alert alert-warning" role="alert">
                            Tidak dapat diubah setelah validasi!
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="card shadow w-100">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 justify-content-center d-flex mb-3">
                                        <div class="form-check d-block">
                                            <input class="form-check-input" type="checkbox" value="{{ auth()->user()->name }}" name="validasi1" id="validasi1"  onchange="setInputanStatusValidasiSOM(this)">
                                            <label class="form-check-label" for="defaultCheck1">Validasi SOM</label>
                                        </div>
                                    </div>
                                    <div class="col-12 justify-content-center d-flex">
                                        <span class="badge bg-label-secondary w-100" id="validasi1nama">Belum Divalidasi</span>
                                    </div>
                                    <div class="d-none" id="deskripsiValidasi1">
                                        <table>
                                            <tr height="50px">
                                                <td>Status</td>
                                                <td>:</td>
                                                <td id="status1"></td>
                                            </tr>
                                            <tr height="50px">
                                                <td>Keterangan</td>
                                                <td>:</td>
                                                <td id="keterangan1"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-12 mt-3 d-none" id="inputanStatusValidasiSOM">
                                    {{-- Select Status Validasi SOM --}}
                                    <select name="status_validasi_1" id="status_validasiSOM" class="form-control @error('status_validasi_1') is-invalid @enderror">
                                        <option value="" disabled selected>Pilih status...</option>
                                        <option @if(old('status_validasi_1') == 'ACC') selected @endif value="ACC">ACC</option>
                                        <option @if(old('status_validasi_1') == 'Tolak') selected @endif value="Tolak">Tolak</option>
                                    </select>
                                    <x-partials.error-message name="status_validasi_1" class="d-block" />

                                    {{-- Input Keterangan --}}
                                    <textarea name="keterangan_1" id="keterangan_1" rows="3" class="form-control mt-2" placeholder="Keterangan">{{ old('keterangan_1') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card shadow w-100">
                            <div class="card-body">
                                @can('validasi2_izin')
                                <div class="alert alert-warning" role="alert">
                                    Mohon menunggu validasi dari SOM.
                                </div>
                                @endcan
                                <div class="row">
                                    <div class="col-12 justify-content-center d-flex mb-3">
                                        <div class="form-check d-block">
                                            <input class="form-check-input" type="checkbox" value="{{ auth()->user()->name }}" name="validasi2" id="validasi2" onchange="setInputanStatusValidasiPM(this)">
                                            <label class="form-check-label" for="defaultCheck1">Validasi PM</label>
                                        </div>
                                    </div>
                                    <div class="col-12 justify-content-center d-flex">
                                        <span class="badge bg-label-secondary w-100" id="validasi2nama">Belum Divalidasi</span>
                                    </div>
                                    <div class="d-none" id="deskripsiValidasi2">
                                        <table>
                                            <tr height="50px">
                                                <td>Status</td>
                                                <td>:</td>
                                                <td id="status2"></td>
                                            </tr>
                                            <tr height="50px">
                                                <td>Keterangan</td>
                                                <td>:</td>
                                                <td id="keterangan2"></td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-12 mt-3 d-none" id="inputanStatusValidasiPM">
                                        {{-- Select Status Validasi PM --}}
                                        <select name="status_validasi_2" id="status_validasiPM" class="form-control @error('status_validasi_2') is-invalid @enderror">
                                            <option value="" disabled selected>Pilih status...</option>
                                            <option @if(old('status_validasi_2') == 'ACC') selected @endif value="ACC">ACC</option>
                                            <option @if(old('status_validasi_2') == 'Tolak') selected @endif value="Tolak">Tolak</option>
                                        </select>
                                        <x-partials.error-message name="status_validasi_2" class="d-block" />

                                        {{-- Input Keterangan --}}
                                        <textarea name="keterangan_2" id="keterangan_2" rows="3" class="form-control mt-2" placeholder="Keterangan">{{ old('keterangan_2') }}</textarea>
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
                ajax: "{{ route('ajax.getAllIzin') }}",
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    {data: 'userName', name: 'userName'},
                    {data: 'jenis', name: 'jenis'},
                    {data: 'tanggal', name: 'tanggal'},
                    {data: 'tanggal-pengajuan', name: 'tanggal-pengajuan'},
                    {data: 'keterangan', name: 'keterangan'},
                    {data: 'file', name: 'file'},
                    {data: 'action', name: 'action'},
                ],
            })
        });

        function setInputanStatusValidasiSOM(e){
            if ($(e).is(':checked')) {
                $('#inputanStatusValidasiSOM').removeClass('d-none');
                $('#inputanStatusValidasiSOM').addClass('d-block');
            }else{
                $('#inputanStatusValidasiSOM').removeClass('d-block');
                $('#inputanStatusValidasiSOM').addClass('d-none');
            }
        }

        function setInputanStatusValidasiPM(e){
            if ($(e).is(':checked')) {
                $('#inputanStatusValidasiPM').removeClass('d-none');
                $('#inputanStatusValidasiPM').addClass('d-block');
            }else{
                $('#inputanStatusValidasiPM').removeClass('d-block');
                $('#inputanStatusValidasiPM').addClass('d-none');
            }
        }
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

            $('#deskripsiValidasi1').removeClass('d-block')
            $('#deskripsiValidasi1').addClass('d-none')
            $('#status1').html('')
            $('#keterangan1').html('')
            $('#validasi1').removeClass('redCheck')

            $('#deskripsiValidasi2').removeClass('d-block')
            $('#deskripsiValidasi2').addClass('d-none')
            $('#status2').html('')
            $('#keterangan2').html('')
            $('#validasi2').removeClass('redCheck')
        }
    </script>

    <script>
        function checkValid(response){
            resetValid()
            if ($.isFunction(validasi1)) {
                validasi1();
            }
            if ($.isFunction(validasi2)) {
                if (response.validasi1 == 0) {
                    $('#validasi1').prop('disabled', true);
                    $('#validasi2').prop('disabled', true);
                }else{
                    validasi2();
                }
            }
            if (response.validasi2) {
                $('#validasi2').prop('checked', true);
                $('#validasi2').prop('disabled', true);
                $('#validasi2nama').html(response.validasi2nama)
                $('#deskripsiValidasi2').removeClass('d-none')
                $('#deskripsiValidasi2').addClass('d-block')
                $('#status2').html(response.validasi2status)
                $('#keterangan2').html(response.validasi2keterangan)

                if (response.validasi2status == "Tolak") {
                    $('#validasi2').addClass('redCheck')
                }

            }

            if (response.validasi1) {
                $('#validasi1').prop('checked', true);
                $('#validasi1').prop('disabled', true);
                $('#validasi1nama').html(response.validasi1nama)
                $('#deskripsiValidasi1').removeClass('d-none')
                $('#deskripsiValidasi1').addClass('d-block')
                $('#status1').html(response.validasi1status)
                $('#keterangan1').html(response.validasi1keterangan)

                if (response.validasi1status == "Tolak") {
                    $('#validasi1').addClass('redCheck')
                }
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
