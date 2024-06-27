<x-layouts.app title="Detail Stok Material">

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}">
        <style>
            input[type=checkbox]:checked{
                background-color: #71dd37;
            }

            .redCheck:checked{
                background-color: red !important;
            }

            .select2 {
                width:100%!important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material / </span>Detail Stok Material</h4>

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

                        {{-- Kode Material --}}
                        <div class="mb-3">
                            <x-input-text title="Kode Material" name='kode_material' value="{{ $stokMaterial['kode_material'] }}" readonly />
                        </div>

                        {{-- Nama Material --}}
                        <div class="col-12 col-sm-12 col-sm-12 mb-3">
                            <input type="hidden" name="material_id" value="{{ $namaMaterial['id'] }}">
                            <x-input-text title="Nama Material" name='displayNamaMaterial' value="{{ $namaMaterial['nama_material'] }}" readonly/>
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

                                {{-- Validasi SOM --}}
                                <div class="col-12 col-sm-12 col-md-4 mb-3">
                                    <div class="card shadow w-100">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 justify-content-center d-flex mb-3">
                                                    <div class="form-check d-block">

                                                        {{-- Check Box Validasi SOM --}}
                                                        @can('validasi_som_stok_material')
                                                            <input class="form-check-input setuju @if($stokMaterial->status_validasi_som == "Tolak") redCheck @endif" type="checkbox" name="diterima_som" onchange="setInputanStatusValidasiSOM(this)" @if($stokMaterial->diterima_som == 1) checked disabled @endif @if(old('diterima_som')) checked @endif>
                                                        @else
                                                            <input class="form-check-input @if($stokMaterial->status_validasi_som == "Tolak") redCheck @endif" type="checkbox" name="diterima_som" disabled @if($stokMaterial->diterima_som == 1) checked @endif>
                                                        @endcan
                                                        <label class="form-check-label" for="defaultCheck1">Validasi SOM</label>

                                                    </div>
                                                </div>

                                                <div class="col-12 justify-content-center d-flex">

                                                    {{-- Detail Span Dibawah Check Box SOM --}}
                                                    @if($stokMaterial->diterima_som == 1)
                                                        <span class="badge bg-label-secondary pt-3 pb-3 w-100">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-12 col-md-12 mb-3 mb-sm-3 mb-md-3">Oleh : {{ $stokMaterial->diterima_som_by }}</div>
                                                                <div class="col-12 col-sm-12 col-md-12">Tanggal : {{ Carbon\Carbon::parse($stokMaterial->tanggal_diterima_pm)->isoFormat('dddd, D MMMM Y') }}</div>
                                                            </div>
                                                        </span>
                                                    @else
                                                        <span class="badge bg-label-secondary w-100 pt-3 pb-3 ">Belum Divalidasi</span>
                                                    @endif

                                                </div>

                                                <div class="col-12 mt-3 d-none" id="inputanStatusValidasiSOM">

                                                    {{-- Jika SOM Belum Validasi --}}
                                                    @if($stokMaterial->diterima_som == 0 )

                                                        {{-- Select Status Validasi SOM --}}
                                                        <select name="status_validasi_som" id="status_validasiSOM" class="form-control @error('status_validasi_som') is-invalid @enderror" onchange="cekSebagianSOM()" required>
                                                            <option value="" disabled selected>Pilih status...</option>
                                                            <option @if(old('status_validasi_som') == 'ACC') selected @endif value="ACC">ACC</option>
                                                            <option @if(old('status_validasi_som') == 'ACC Sebagian') selected @endif value="ACC Sebagian">ACC Sebagian</option>
                                                            <option @if(old('status_validasi_som') == 'Tolak') selected @endif value="Tolak">Tolak</option>
                                                        </select>
                                                        <x-partials.error-message name="status_validasi_som" class="d-block" />

                                                        {{-- Input Sebagian --}}
                                                        <input type="text" class="form-control mt-2 d-none @error('jumlahSebagianSOM') is-invalid @enderror" name="jumlahSebagianSOM" id="jumlahSebagianSOM" placeholder="Jumlah Sebagian" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57">
                                                        <x-partials.error-message name="jumlahSebagianSOM" class="d-block" />

                                                        {{-- Input Keterangan --}}
                                                        <textarea name="keterangan_som" id="keterangan_som" rows="3" class="form-control mt-2" placeholder="Keterangan" required>{{ old('keterangan_som') }}</textarea>
                                                    @else
                                                        {{-- Jika PM Sudah Validasi --}}
                                                        <table>
                                                            <tr height="50px">
                                                                <td>Status</td>
                                                                <td>:</td>
                                                                <td>{{ $stokMaterial->status_validasi_som }}</td>
                                                            </tr>
                                                            <tr height="50px">
                                                                <td>Jumlah</td>
                                                                <td>:</td>
                                                                <td>{{ $stokMaterial->sebagian_som != 0 ? $stokMaterial->sebagian_som : $stokMaterial->masuk}}</td>
                                                            </tr>
                                                            <tr height="50px">
                                                                <td>Keterangan</td>
                                                                <td>:</td>
                                                                <td>{{ $stokMaterial->keterangan_som }}</td>
                                                            </tr>
                                                        </table>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Validasi PM --}}
                                <div class="col-12 col-sm-12 col-md-4 mb-3">
                                    <div class="card shadow w-100">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 justify-content-center d-flex mb-3">
                                                    <div class="form-check d-block">

                                                        {{-- Check Box Validasi PM --}}
                                                        @can('validasi_pm_stok_material')
                                                            <input class="form-check-input setuju @if($stokMaterial->status_validasi_pm == "Tolak") redCheck @endif" type="checkbox" name="diterima_pm" onchange="setInputanStatusValidasiPM(this)" @if($stokMaterial->diterima_pm == 1) checked disabled @endif @if(old('diterima_pm')) checked @endif @if($stokMaterial->diterima_som == 0) disabled @endif>
                                                        @else
                                                            <input class="form-check-input @if($stokMaterial->status_validasi_pm == "Tolak") redCheck @endif" type="checkbox" name="diterima_pm" disabled @if($stokMaterial->diterima_pm == 1) checked @endif>
                                                        @endcan
                                                        <label class="form-check-label" for="defaultCheck1">Validasi PM</label>

                                                    </div>
                                                </div>

                                                {{-- Alert Jika SOM Belum Validasi Pada Tampilan PM --}}
                                                @can('validasi_pm_stok_material')
                                                    @if($stokMaterial->diterima_som == 0)
                                                        <div class="col-12">
                                                            <div class="alert alert-warning" role="alert">Mohon menunggu validasi SOM</div>
                                                        </div>
                                                    @endif
                                                @endcan

                                                <div class="col-12 justify-content-center d-flex">

                                                    {{-- Detail Span Dibawah Check Box PM --}}
                                                    @if($stokMaterial->diterima_pm == 1)
                                                        <span class="badge bg-label-secondary pt-3 pb-3 w-100">
                                                            <div class="row">
                                                                <div class="col-12 col-sm-12 col-md-12 mb-3 mb-sm-3 mb-md-3">Oleh : {{ $stokMaterial->diterima_pm_by }}</div>
                                                                <div class="col-12 col-sm-12 col-md-12">Tanggal : {{ Carbon\Carbon::parse($stokMaterial->tanggal_diterima_pm)->isoFormat('dddd, D MMMM Y') }}</div>
                                                            </div>
                                                        </span>
                                                    @else
                                                        <span class="badge bg-label-secondary w-100 pt-3 pb-3 ">Belum Divalidasi</span>
                                                    @endif

                                                </div>

                                                @if ($stokMaterial->status_validasi_som != "Tolak")
                                                    <div class="col-12 mt-3 d-none" id="inputanStatusValidasiPM">

                                                        {{-- Jika PM Belum Validasi --}}
                                                        @if($stokMaterial->diterima_pm == 0)

                                                            {{-- Select Status Validasi PM --}}
                                                            <select name="status_validasi_pm" id="status_validasiPM" class="form-control @error('status_validasi_pm') is-invalid @enderror" onchange="cekSebagianPM()" required>
                                                                <option value="" disabled selected>Pilih status...</option>
                                                                <option @if(old('status_validasi_pm') == 'ACC') selected @endif value="ACC">ACC</option>
                                                                <option @if(old('status_validasi_pm') == 'ACC Sebagian') selected @endif value="ACC Sebagian">ACC Sebagian</option>
                                                                <option @if(old('status_validasi_pm') == 'Tolak') selected @endif value="Tolak">Tolak</option>
                                                            </select>
                                                            <x-partials.error-message name="status_validasi_pm" class="d-block" />

                                                            {{-- Input Sebagian --}}
                                                            <input type="text" class="form-control mt-2 d-none @error('jumlahSebagianPM') is-invalid @enderror" name="jumlahSebagianPM" id="jumlahSebagianPM" placeholder="Jumlah Sebagian" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57">
                                                            <x-partials.error-message name="jumlahSebagianPM" class="d-block" />

                                                            {{-- Input Keterangan --}}
                                                            <textarea name="keterangan_pm" id="keterangan_pm" rows="3" class="form-control mt-2" placeholder="Keterangan" required>{{ old('keterangan_pm') }}</textarea>
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
                                                                    <td>{{ $stokMaterial->sebagian_pm != 0 ? $stokMaterial->sebagian_pm : ($stokMaterial->sebagian_som != 0 ? $stokMaterial->sebagian_som : $stokMaterial->masuk)}}</td>
                                                                </tr>
                                                                <tr height="50px">
                                                                    <td>Keterangan</td>
                                                                    <td>:</td>
                                                                    <td>{{ $stokMaterial->keterangan_pm }}</td>
                                                                </tr>
                                                            </table>
                                                        @endif
                                                    </div>
                                                @else
                                                    <input type="hidden" value="Tolak" name="status_validasi_pm">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Validasi DIR --}}
                                <div class="col-12 col-sm-12 col-md-4 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card shadow w-100">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 justify-content-center d-flex mb-3">
                                                            <div class="form-check d-block">

                                                                {{-- Check Box Validasi DIR --}}
                                                                @can('validasi_dir_stok_material')
                                                                    <input class="form-check-input @if($stokMaterial->status_validasi_dir == "Tolak") redCheck @endif" type="checkbox" onchange="setInputanStatusValidasiDIR(this)" name="diterima_dir" @if($stokMaterial->diterima_dir == 1) checked disabled @endif @if(old('diterima_dir')) checked @endif @if($stokMaterial->diterima_som == 0 || $stokMaterial->diterima_pm == 0) disabled @endif>
                                                                @else
                                                                    <input class="form-check-input @if($stokMaterial->status_validasi_dir == "Tolak") redCheck @endif" type="checkbox" name="diterima_dir" disabled @if($stokMaterial->diterima_dir == 1) checked @endif>
                                                                @endcan

                                                                <label class="form-check-label" for="defaultCheck1">Validasi DIR</label>
                                                            </div>
                                                        </div>
                                                        {{-- Alert Jika SOM Belum Validasi Pada Tampilan DIR --}}
                                                        @can('validasi_dir_stok_material')
                                                            @if($stokMaterial->diterima_som == 0 && $stokMaterial->diterima_pm == 0)
                                                                <div class="col-12">
                                                                    <div class="alert alert-warning" role="alert">Mohon menunggu validasi SOM & PM</div>
                                                                </div>
                                                            @elseif($stokMaterial->diterima_som == 1 && $stokMaterial->diterima_pm == 0)
                                                                <div class="col-12">
                                                                    <div class="alert alert-warning" role="alert">Mohon menunggu validasi PM</div>
                                                                </div>
                                                            @endif
                                                        @endcan

                                                            <div class="col-12 justify-content-center d-flex">

                                                                {{-- Detail Span Dibawah Check Box SOM --}}
                                                                @if($stokMaterial->diterima_dir == 1)
                                                                    <span class="badge bg-label-secondary pt-3 pb-3 w-100">
                                                                        <div class="row">
                                                                            <div class="col-12 col-sm-12 col-md-12 mb-3 mb-sm-3 mb-md-3">Oleh : {{ $stokMaterial->diterima_dir_by }}</div>
                                                                            <div class="col-12 col-sm-12 col-md-12">Tanggal : {{ Carbon\Carbon::parse($stokMaterial->tanggal_diterima_dir)->isoFormat('dddd, D MMMM Y') }}</div>
                                                                        </div>
                                                                    </span>
                                                                @else
                                                                    <span class="badge bg-label-secondary pt-3 pb-3 w-100">Belum Divalidasi</span>
                                                                @endif

                                                            </div>

                                                        @if ($stokMaterial->status_validasi_som != "Tolak" && $stokMaterial->status_validasi_pm != "Tolak")
                                                            <div class="col-12 mt-3 d-none" id="inputanStatusValidasiDIR">
                                                                @can('validasi_dir_stok_material')
                                                                    @if($stokMaterial->diterima_som == 1 && $stokMaterial->diterima_pm == 1 && $stokMaterial->diterima_dir == 0)
                                                                    <div class="col-12 mt-3">
                                                                        <select name="status_validasi_dir" class="form-control @error('status_validasi_dir') is-invalid @enderror" required>
                                                                            <option value="" disabled selected>Pilih status...</option>
                                                                            <option value="ACC">ACC</option>
                                                                            <option value="Tolak">Tolak</option>
                                                                        </select>
                                                                        <x-partials.error-message name="status_validasi_dir" class="d-block"/>

                                                                        {{-- Input Keterangan --}}
                                                                        <textarea name="keterangan_dir" id="keterangan_dir" rows="3" class="form-control mt-2" placeholder="Keterangan" required>{{ old('keterangan_dir') }}</textarea>
                                                                    </div>
                                                                    @endif
                                                                @endcan

                                                                @if ($stokMaterial->diterima_dir == 1)
                                                                    <div class="col-12 mt-3">
                                                                        {{-- Jika PM Sudah Validasi --}}
                                                                        <table>
                                                                            <tr height="50px">
                                                                                <td>Status</td>
                                                                                <td>:</td>
                                                                                <td>{{ $stokMaterial->status_validasi_dir }}</td>
                                                                            </tr>
                                                                            <tr height="50px">
                                                                                <td>Keterangan</td>
                                                                                <td>:</td>
                                                                                <td>{{ $stokMaterial->keterangan_dir }}</td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <input type="hidden" value="Tolak" name="status_validasi_dir">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Jika Tabel Retur Dan List Tidak Kosong --}}
                                @if ($stokMaterial->status_validasi_som != "Tolak" && $stokMaterial->status_validasi_pm != "Tolak" && $stokMaterial->status_validasi_dir != "Tolak")
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
                                                                            <td>{{ $stokMaterial->sebagian_pm != 0 ? $stokMaterial->sebagian_pm : ($stokMaterial->sebagian_som != 0 ? $stokMaterial->sebagian_som : $stokMaterial->masuk)}}</td>
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

                    @if(auth()->user()->can('validasi_pm_stok_material') )
                        @if ($stokMaterial->diterima_pm == 0 && $stokMaterial->diterima_som == 1)
                            <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
                        @endif
                    @elseif(auth()->user()->can('validasi_dir_stok_material'))
                        @if ($stokMaterial->diterima_dir == 0 && $stokMaterial->diterima_som == 1)
                            <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
                        @endif
                    @else
                        @if ($stokMaterial->diterima_som == 0)
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

            function setInputanStatusValidasiSOM(e){
                if ($(e).is(':checked')) {
                    $('#inputanStatusValidasiSOM').removeClass('d-none');
                    $('#inputanStatusValidasiSOM').addClass('d-block');
                    resetInputanValidasi();
                }else{
                    $('#inputanStatusValidasiSOM').removeClass('d-block');
                    $('#inputanStatusValidasiSOM').addClass('d-none');
                }
            }

            function setInputanStatusValidasiPM(e){
                if ($(e).is(':checked')) {
                    $('#inputanStatusValidasiPM').removeClass('d-none');
                    $('#inputanStatusValidasiPM').addClass('d-block');
                    resetInputanValidasi();
                }else{
                    $('#inputanStatusValidasiPM').removeClass('d-block');
                    $('#inputanStatusValidasiPM').addClass('d-none');
                }
            }

            function setInputanStatusValidasiDIR(e){
                if ($(e).is(':checked')) {
                    $('#inputanStatusValidasiDIR').removeClass('d-none');
                    $('#inputanStatusValidasiDIR').addClass('d-block');
                    resetInputanValidasi();
                }else{
                    $('#inputanStatusValidasiDIR').removeClass('d-block');
                    $('#inputanStatusValidasiDIR').addClass('d-none');
                }
            }

            function resetInputanValidasi(){
                $('#status_validasi').val('');
                $('#jumlahSebagian').removeClass('d-block');
                $('#jumlahSebagian').addClass('d-none');
                $('#jumlahSebagian').val('');
                $('#keterangan').val('');
            }

            function cekSebagianSOM(){
                if ($('#status_validasiSOM').val() == 'ACC Sebagian') {
                    $('#jumlahSebagianSOM').removeClass('d-none');
                    $('#jumlahSebagianSOM').addClass('d-block');
                    if ($('#jumlahSebagianSOM').val() == null) {
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
                    $('#jumlahSebagianSOM').addClass('d-none');
                    $('#jumlahSebagianSOM').removeClass('d-block');
                }
            }

            function cekSebagianPM(){
                if ($('#status_validasiPM').val() == 'ACC Sebagian') {
                    $('#jumlahSebagianPM').removeClass('d-none');
                    $('#jumlahSebagianPM').addClass('d-block');
                    if ($('#jumlahSebagianPM').val() == null) {
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
                    $('#jumlahSebagianPM').addClass('d-none');
                    $('#jumlahSebagianPM').removeClass('d-block');
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

        <script>
            $("#submitForm").on('click', function () {
                var stokLogistik = parseInt($('#qty').val());
                var stokMasuk = parseInt($("#stokMasuk").val());

                cekInputSebagian();
            });
        </script>

        @can('validasi_dir_stok_material')
            <script>
                function cekInputSebagian() {
                    $('#formSubmit').submit();
                }
            </script>
        @endcan

        @can('validasi_pm_stok_material')
            <script>
                function cekInputSebagian() {
                    cekInput($('#jumlahSebagianPM').val());
                }
            </script>
        @endcan

        @can('validasi_som_stok_material')
            <script>
                function cekInputSebagian() {
                    cekInput($('#jumlahSebagianSOM').val());
                }
            </script>
        @endcan

        <script>
            function cekInput(sebagian) {
                if(parseInt(sebagian) > parseInt($('#stokMasuk').val())){
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
            }
        </script>

        @if (Session::has('jumlahSebagianSOM'))
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasiSOM').removeClass('d-none');
                $('#inputanStatusValidasiSOM').addClass('d-block');
                $('#jumlahSebagianSOM').removeClass('d-none');
                $('#jumlahSebagianSOM').addClass('d-block');
            });
            </script>
        @endif

        @if (Session::has('jumlahSebagianPM'))
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasiPM').removeClass('d-none');
                $('#inputanStatusValidasiPM').addClass('d-block');
                $('#jumlahSebagianPM').removeClass('d-none');
                $('#jumlahSebagianPM').addClass('d-block');
            });
            </script>
        @endif

        @if (Session::has('statusValidasiSOM'))
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasiSOM').removeClass('d-none');
                $('#inputanStatusValidasiSOM').addClass('d-block');
            });
            </script>
        @endif

        @if (Session::has('statusValidasiPM'))
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasiPM').removeClass('d-none');
                $('#inputanStatusValidasiPM').addClass('d-block');
            });
            </script>
        @endif

        @if (Session::has('statusValidasiDIR'))
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasiDIR').removeClass('d-none');
                $('#inputanStatusValidasiDIR').addClass('d-block');
            });
            </script>
        @endif

        @if ($stokMaterial->diterima_som == 1)
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasiSOM').removeClass('d-none');
            });
        </script>
        @endif

        @if ($stokMaterial->diterima_pm == 1)
        <script>
            $(document).ready(function () {
                $('#inputanStatusValidasiPM').removeClass('d-none');
            });
        </script>
        @endif
    </x-slot>
</x-layouts.app>
