<x-layouts.app title="Detail Retur">

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

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material / </span>Detail Retur Stok Material</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">
                    Form Retur Material
                </h5>
                <form method="post" action="{{ route('stok-material.retur.update', $retur->id) }}" enctype="multipart/form-data" id="formSubmit">
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
                            <div class="col-12 col-sm-4 col-sm-6 mb-3 mb-sm-0">
                                <x-input-text title="Stok Gudang Logistik" name='qty' id="qty" value="{{ $namaMaterial['qty'] }}" readonly />
                            </div>

                            {{-- Harga --}}
                            <div class="col-12 col-sm-4 col-sm-6 mb-3 mb-sm-3 mb-md-0">
                                <input type="hidden" name="harga" id="hargaSubmit" value="{{ $namaMaterial['harga_beli'] }}">
                                <x-input-text title="Harga" name="display" id="harga" value="Rp. {{ $namaMaterial['harga_beli'] }}" readonly/>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-input-text title="Jumlah" name='retur_by' value="{{ $retur->jumlah }}" readonly/>
                        </div>

                        <div class="mb-3">
                            <x-partials.label title="Dikembalikan Oleh" required />
                            <input type="text" name='retur_by' placeholder="Dikembalikan oleh"class="form-control" value="{{ $retur->retur_by ?? auth()->user()->name }}" required @if($retur->hasil_retur == 'Diterima' || $retur->validasi_by == 1) readonly @endif/>
                        </div>

                        <div class="mb-3">
                            <x-partials.label title="Dikembalikan Kepada" required />
                            <input type="text" name='retur_to'class="form-control"  placeholder="Dikembalikan kepada" value="{{ $retur->retur_to ?? old('retur_to') }}" required @if($retur->hasil_retur == 'Diterima') readonly @endif/>
                        </div>

                        <div class="mb-3">
                            <x-partials.label title="Keterangan" />
                            <textarea name="keterangan" id="keterangan" rows="=4" class="form-control" placeholder="Keterangan" @if($retur->hasil_retur == 'Diterima') readonly @endif>{{ $retur->keterangan ?? old('keterangan') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3 mb-md-0">
                                <x-partials.label title="Tanggal Retur" required/>
                                <input type="text" class="form-control" id="tgl_retur" name="tgl_retur" placeholder="Tanggal Retur" value="{{ \Carbon\Carbon::parse($retur->tgl_retur)->format('d/m/Y') == "0000-00-00" ? '' : \Carbon\Carbon::parse($retur->tgl_retur)->format('d/m/Y') }}" required autocomplete="off" @if($retur->hasil_retur == 'Diterima') disabled @endif/>
                                <x-partials.error-message name="tgl_mulai_izin" class="d-block" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-6">
                                <x-partials.label title="Hasil Retur" required/>
                                <select class="form-control" name="hasil_retur" @if($retur->hasil_retur == 'Diterima') disabled @endif>
                                    <option value="" disabled selected>Pilih hasil retur...</option>
                                    <option @if($retur->hasil_retur == "Diterima") selected @endif value="Diterima">Diterima</option>
                                    <option @if($retur->hasil_retur == "Ditolak") selected @endif value="Ditolak">Ditolak</option>
                                    <option @if($retur->hasil_retur == "Pending") selected @endif value="Pending">Pending</option>
                                    <option @if($retur->hasil_retur == "Proses") selected @endif value="Proses">Proses</option>
                                </select>
                                <x-partials.error-message name="hasil_retur" class="d-block" />
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <a href="{{ route('stok-material.retur.index') }}" class="btn btn-secondary">Kembali</a>
                        @if ($retur->hasil_retur != 'Diterima')
                            <button type="submit" class="btn btn-primary">Submit</button>
                        @endif
                    </div>

                </form>

            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(document).ready(function () {
                var dateToday = new Date();
                $("#tgl_retur").datepicker({
                    dateFormat: 'dd/mm/yy',
                    minDate: dateToday
                });
            });
        </script>
    </x-slot>
</x-layouts.app>
