<x-layouts.app title="Detail Stok Material">

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}">
        <style>
            input[type=checkbox]:checked{
                background-color: #71dd37 !important;
            }

            .select2 {
                width:100%!important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material / </span>Tambah Stok Material</h4>

    <a class="btn btn-secondary mb-3" href="{{ route('stok-material.pengajuan.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">
                    Form Stok Material
                </h5>
                <form method="post" action="{{ route('stok-material.pengajuan.update', $stokMaterial->id) }}" enctype="multipart/form-data" id="formSubmit">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        {{-- Nama Material --}}
                        <div class="col-12 col-sm-12 col-sm-12 mb-3">
                            <input type="hidden" name="material_id" value="{{ $namaMaterial['id'] }}">
                            <x-input-text title="Nama Material" name='displayNamaMaterial' value="{{ $namaMaterial['kode_material'] }} | {{ $namaMaterial['nama_material'] }}" readonly/>
                        </div>

                        <div class="row">
                            {{-- Jenis Pekerjaan --}}
                            <div class="col-12 col-sm-4 col-sm-6 mb-3">
                                <x-input-text title="Jenis Pekerjaan" name='jenis_pekerjaan' id="jenis_pekerjaan" value="{{ $namaMaterial['jenis_pekerjaan'] }}" readonly />
                            </div>

                            {{-- Jenis Material --}}
                            <div class="col-12 col-sm-4 col-sm-6 mb-3">
                                <x-input-text title="Jenis Material" name='jenis_material' id="jenis_material" value="{{ $namaMaterial['jenis_material'] }}" readonly />
                            </div>

                            {{-- Stok Logistik (qty) --}}
                            <div class="col-12 col-sm-4 col-sm-6 mb-3">
                                <x-input-text title="Stok Gudang Logistik" name='qty' id="qty" value="{{ $namaMaterial['qty'] }}" readonly />
                            </div>

                            {{-- Harga --}}
                            <div class="col-12 col-sm-4 col-sm-6 mb-3">
                                <input type="hidden" name="harga" id="hargaSubmit" value="{{ $namaMaterial['harga_beli'] }}">
                                <x-input-text title="Harga" name="display" id="harga" value="Rp. {{ $namaMaterial['harga_beli'] }}" readonly/>
                            </div>
                        </div>

                        {{-- Kode Material --}}
                        <div class="mb-3">
                            <x-input-text title="Kode Material" name='kode_material' value="{{ $stokMaterial['kode_material'] }}" readonly />
                        </div>

                        {{-- Stok Input --}}
                        <div class="">
                            <x-partials.label title="Jumlah Stok Masuk" required />

                            <input class="form-control" name="masuk" id="stokMasuk" value="{{ $stokMaterial->masuk }}" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57"
                            {{-- Ini Didalam Input Name="Masuk" --}}
                            {{--    Readonly Jika Sudah Diterima PM --}}
                                @if($stokMaterial->diterima_spv == 1) readonly @endif

                            {{--    Hanya SPV Yang Bisa Mengubah Data Masuk --}}
                                @can('validasi_pm_stok_material') readonly @endcan
                            />

                            <x-partials.error-message name="masuk" class="d-block" />
                        </div>

                        <div>
                            <div class="row mt-4">

                                {{-- Validasi SPV --}}
                                <div class="col-12 col-sm-12 col-md-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow w-100">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 justify-content-center d-flex mb-3">
                                                            <div class="form-check d-block">

                                                                {{-- Check Box Validasi SPV --}}
                                                                @can('validasi_spv_stok_material')
                                                                    <input class="form-check-input" type="checkbox" name="diterima_spv" @if($stokMaterial->diterima_spv == 1) checked disabled @endif>
                                                                @else
                                                                    <input class="form-check-input" type="checkbox" name="diterima_spv" disabled @if($stokMaterial->diterima_spv == 1) checked @endif>
                                                                @endcan

                                                                <label class="form-check-label" for="defaultCheck1">Validasi SPV</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 justify-content-center d-flex">

                                                            {{-- Detail Span Dibawah Check Box SPV --}}
                                                            @if($stokMaterial->diterima_spv == 1)
                                                                <span class="badge bg-label-secondary pt-3 pb-3 w-100">
                                                                    <div class="row">
                                                                        <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3 mb-md-0">Oleh : {{ $stokMaterial->diterima_spv_by }}</div>
                                                                        <div class="col-12 col-sm-12 col-md-6">Tanggal : {{ Carbon\Carbon::parse($stokMaterial->tanggal_diterima_spv)->format('d F Y') }}</div>
                                                                    </div>
                                                                </span>
                                                            @else
                                                                <span class="badge bg-label-secondary pt-3 pb-3 w-100">Belum Divalidasi</span>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Validasi PM --}}
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <div class="card shadow w-100">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 justify-content-center d-flex mb-3">
                                                    <div class="form-check d-block">

                                                        {{-- Check Box Validasi PM --}}
                                                        @can('validasi_pm_stok_material')
                                                            <input class="form-check-input setuju" type="checkbox" name="diterima_pm" onchange="setInputanStatusValidasi(this)" @if($stokMaterial->diterima_pm == 1) checked disabled @endif @if(old('diterima_pm')) checked @endif @if($stokMaterial->diterima_spv == 0) disabled @endif>
                                                        @else
                                                            <input class="form-check-input" type="checkbox" name="diterima_pm" disabled @if($stokMaterial->diterima_pm == 1) checked @endif>
                                                        @endcan
                                                        <label class="form-check-label" for="defaultCheck1">Validasi PM</label>

                                                    </div>
                                                </div>

                                                {{-- Alert Jika SPV Belum Validasi Pada Tampilan PM --}}
                                                @can('validasi_pm_stok_material')
                                                    @if($stokMaterial->diterima_spv == 0)
                                                        <div class="col-12">
                                                            <div class="alert alert-warning" role="alert">Mohon menunggu validasi SPV</div>
                                                        </div>
                                                    @endif
                                                @endcan

                                                <div class="col-12 justify-content-center d-flex">

                                                    {{-- Detail Span Dibawah Check Box PM --}}
                                                    @if($stokMaterial->diterima_pm == 1)
                                                        <span class="badge bg-label-secondary pt-3 pb-3 w-100">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3 mb-md-0">Oleh : {{ $stokMaterial->diterima_pm_by }}</div>
                                                                <div class="col-12 col-sm-12 col-md-6">Tanggal : {{ Carbon\Carbon::parse($stokMaterial->tanggal_diterima_pm)->format('d F Y') }}</div>
                                                            </div>
                                                        </span>
                                                    @else
                                                        <span class="badge bg-label-secondary w-100 pt-3 pb-3 ">Belum Divalidasi</span>
                                                    @endif

                                                </div>

                                                <div class="col-12 mt-3 d-none" id="inputanStatusValidasi">

                                                    {{-- Jika PM Belum Validasi --}}
                                                    @if($stokMaterial->diterima_pm == 0 )

                                                        {{-- Select Status Validasi PM --}}
                                                        <select name="status_validasi_pm" id="status_validasi" class="form-control @error('status_validasi_pm') is-invalid @enderror" onchange="cekSebagian()" required>
                                                            <option value="" disabled selected>Pilih status...</option>
                                                            <option @if(old('status_validasi_pm') == 'ACC') selected @endif value="ACC">ACC</option>
                                                            <option @if(old('status_validasi_pm') == 'ACC Sebagian') selected @endif value="ACC Sebagian">ACC Sebagian</option>
                                                            <option @if(old('status_validasi_pm') == 'Tolak') selected @endif value="Tolak">Tolak</option>
                                                        </select>
                                                        <x-partials.error-message name="status_validasi_pm" class="d-block" />

                                                        {{-- Input Sebagian --}}
                                                        <input type="text" class="form-control mt-2 d-none @error('jumlahSebagian') is-invalid @enderror" name="jumlahSebagian" id="jumlahSebagian" placeholder="Jumlah Sebagian" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57">
                                                        <x-partials.error-message name="jumlahSebagian" class="d-block" />

                                                        {{-- Input Keterangan --}}
                                                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control mt-2" placeholder="Keterangan" required>{{ old('keterangan') }}</textarea>
                                                    @else
                                                        {{-- Jika PM Sudah Validasi --}}
                                                        <table>
                                                            <tr height="50px">
                                                                <td>Status</td>
                                                                <td>:</td>
                                                                <td>{{ $stokMaterial->status_validasi_pm }}</td>
                                                            </tr>
                                                            <tr height="50px">
                                                                <td>Jumlah</td>
                                                                <td>:</td>
                                                                <td>{{ $stokMaterial->sebagian != 0 ? $stokMaterial->sebagian : $stokMaterial->masuk}}</td>
                                                            </tr>
                                                            <tr height="50px">
                                                                <td>Keterangan</td>
                                                                <td>:</td>
                                                                <td>{{ $stokMaterial->keterangan }}</td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Jika Tabel Retur Dan List Tidak Kosong --}}
                                @if (!empty($retur) || !empty($diterima))
                                    <div class="col-12 mt-3">
                                        <div class="card shadow w-100">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 justify-content-center d-flex mb-3">
                                                        <h5 >
                                                            Detail
                                                        </h5>
                                                    </div>
                                                    <div class="col-12 justify-content-center">
                                                        <table class="mb-3">
                                                            <tr height="30px">
                                                                <td width='100px'>Tanggal</td>
                                                                <td> : </td>
                                                                <td>{{ \Carbon\Carbon::parse($stokMaterial->created_at)->format('d F Y') }}</td>
                                                            </tr>
                                                            <tr height="30px">
                                                                <td>Oleh</td>
                                                                <td> : </td>
                                                                <td>{{ $stokMaterial->created_by }}</td>
                                                            </tr>
                                                            <tr height="30px">
                                                                <td>Harga</td>
                                                                <td> : </td>
                                                                <td>Rp. {{ number_format($stokMaterial->harga, 0, ',', '.') }}</td>
                                                            </tr>
                                                        </table>

                                                        <div class="table-responsive text-nowrap">
                                                            <table class="table table-bordered" width="100%">
                                                                @php $no=0; @endphp
                                                                <tr>
                                                                    <td>#</td>
                                                                    <td>Material</td>
                                                                    <td>Status</td>
                                                                    <td>Jumlah</td>
                                                                </tr>
                                                                @if (!empty($diterima))
                                                                    <tr>
                                                                        <td>{{ $no+=1; }}</td>
                                                                        <td>{{ $namaMaterial['kode_material'] }} | {{ $namaMaterial['nama_material'] }}</td>
                                                                        <td><span class="badge bg-success">Diterima</span></td>
                                                                        <td>{{ $stokMaterial->sebagian != 0 ? $stokMaterial->sebagian : $stokMaterial->masuk}}</td>
                                                                    </tr>
                                                                @endif
                                                                @if (!empty($retur))
                                                                    <tr>
                                                                        <td>{{ $no+=1; }}</td>
                                                                        <td>{{ $namaMaterial['kode_material'] }} | {{ $namaMaterial['nama_material'] }}</td>
                                                                        <td><span class="badge bg-danger">Retur</span></td>
                                                                        <td>{{ $retur->jumlah }}</td>
                                                                    </tr>
                                                                @endif
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                            </div>
                        </div>

                    </div>
                </form>

                <div class="card-footer">
                    <a href="{{ route('stok-material.pengajuan.index') }}" class="btn btn-secondary">Kembali</a>

                    @if ($stokMaterial->history == 0)
                        <form action="{{ route('stok-material.pengajuan.delete', $stokMaterial->id) }}" method='POST' class='d-inline' id="formDelete">
                            @csrf
                            @method('DELETE')
                            <button type='button' class='btn btn-danger' id="deleteForm">Hapus</button>
                        </form>
                    @endif

                    @can('validasi_pm_stok_material')
                        @if ($stokMaterial->diterima_pm == 0 && $stokMaterial->diterima_spv == 1)
                            <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
                        @endif
                    @else
                        @if ($stokMaterial->diterima_spv == 0)
                            <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(document).ready(function () {
                $( '#select-field' ).select2( {
                    theme: 'bootstrap-5'
                });
            });

            function setInputanStatusValidasi(e){
                if ($(e).is(':checked')) {
                    $('#inputanStatusValidasi').removeClass('d-none');
                    $('#inputanStatusValidasi').addClass('d-block');
                    resetInputanValidasi();
                }else{
                    $('#inputanStatusValidasi').removeClass('d-block');
                    $('#inputanStatusValidasi').addClass('d-none');
                }
            }

            function resetInputanValidasi(){
                $('#status_validasi').val('');
                $('#jumlahSebagian').removeClass('d-block');
                $('#jumlahSebagian').addClass('d-none');
                $('#jumlahSebagian').val('');
                $('#keterangan').val('');
            }

            function cekSebagian(){
                if ($('#status_validasi').val() == 'ACC Sebagian') {
                    $('#jumlahSebagian').removeClass('d-none');
                    $('#jumlahSebagian').addClass('d-block');
                    if ($('#jumlahSebagian').val() == null) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            icon: 'danger',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 1000,
                        })

                        ;(async () => {
                        await Toast.fire({
                            icon: 'error',
                            title: 'Jumlah tidak boleh kosong!',
                        })})()
                    }
                }else{
                    $('#jumlahSebagian').addClass('d-none');
                    $('#jumlahSebagian').removeClass('d-block');
                }
            }

            function formatRupiah(angka, prefix = null){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            }

            $("#deleteForm").on('click', function () {
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
                        $('#formDelete').submit();
                    }
                });
            })
        </script>

        @can('validasi_pm_stok_material')
            <script>
                $("#submitForm").on('click', function () {
                    var stokLogistik = parseInt($('#qty').val());
                    var stokMasuk = parseInt($("#stokMasuk").val());

                    if (stokMasuk > stokLogistik) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            icon: 'danger',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 1000,
                        })

                        ;(async () => {
                        await Toast.fire({
                            icon: 'error',
                            title: 'Stok Gudang Logistik Tidak Mencukupi!',
                        })})()
                    }

                    if(parseInt($('#jumlahSebagian').val()) > parseInt($('#stokMasuk').val())){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            icon: 'danger',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 1000,
                        })

                        ;(async () => {
                        await Toast.fire({
                            icon: 'error',
                            title: 'Jumlah sebagian melebihi stok masuk!',
                        })})()
                    }else{
                        $('#formSubmit').submit();
                    }
                });
            </script>
        @else
            <script>
                $("#submitForm").on('click', function () {
                    var stokLogistik = parseInt($('#qty').val());
                    var stokMasuk = parseInt($("#stokMasuk").val());

                    if (stokMasuk > stokLogistik) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            icon: 'danger',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 1000,
                        })

                        ;(async () => {
                        await Toast.fire({
                            icon: 'error',
                            title: 'Stok Gudang Logistik Tidak Mencukupi!',
                        })})()
                    }else{
                        $('#formSubmit').submit();
                    }
                });
            </script>
        @endcan

        @if (Session::has('jumlahSebagian'))
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasi').removeClass('d-none');
                $('#inputanStatusValidasi').addClass('d-block');
                $('#jumlahSebagian').removeClass('d-none');
                $('#jumlahSebagian').addClass('d-block');
            });
            </script>
        @endif

        @if (Session::has('statusValidasi'))
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasi').removeClass('d-none');
                $('#inputanStatusValidasi').addClass('d-block');
            });
            </script>
        @endif

        @if ($stokMaterial->diterima_pm == 1)
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasi').removeClass('d-none');
            });
        </script>
        @endif
    </x-slot>
</x-layouts.app>
