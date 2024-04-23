<x-layouts.app title="Detail Jenis Kerusakan">

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}">
        <style>
            .select2 {
                width:100%!important;
            }

            .borderRed{
                border: 2px solid red;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proyek /</span> Detail Kerusakan</h4>

    <a href="{{ route('jenis-kerusakan.index', $jenisKerusakan->detailKerjaID) }}" class="btn btn-secondary mb-3"><i class="bx bx-arrow-back me-1"></i> Kembali</a>
    <a href="{{ $_SERVER["REQUEST_URI"] }}" class="btn btn-primary mb-3"><i class="bx bx-refresh"></i></a>

    <form action="{{ route('jenis-kerusakan.update', $jenisKerusakan->jenisKerusakanID) }}" method="POST" id="formUpdate" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div id="cekFoto"></div>
    <input type="hidden" name="btnStatus" id="btnStatus">
    <input type="hidden" name="detail_tgl_kerja_id" value="{{ $jenisKerusakan->detailKerjaID }}">
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-0 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="rounded-3 text-center mb-3 pt-1">
                        <img class="img-fluid w-100" src="{{ asset('storage/'.$detail->foto) }}" id="imagePreview" style="height: 400px; object-fit: cover;background-position: center" />

                        @if ($jenisKerusakan->tgl_selesai_pekerjaan == null)
                            <label for="upload" class="btn btn-primary me-2 mb-1 w-100 mt-3" tabindex="0">
                                <span class="d-none d-sm-block">Unggah Foto Baru</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="foto" class="account-file-input imageUpload @error('foto') is-invalid @enderror" hidden="" accept="image/png, image/jpeg">
                            </label>
                            <x-partials.error-message name="foto" class="d-block"/>
                        @endif

                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-4 py-3">
                        <div class="d-flex align-items-start me-4 gap-3">
                            <span class="badge @if ($detail->tgl_selesai_pekerjaan == null) bg-label-danger @else bg-label-success @endif p-2 rounded">
                                @if ($detail->tgl_selesai_pekerjaan == null)
                                <i class="bx bx-x bx-sm"></i>
                                @else
                                <i class="bx bx-check bx-sm"></i>
                                @endif
                            </span>
                            <div>
                                <h5 class="mb-0">Status Pekerjaan</h5>
                                @if ($detail->tgl_selesai_pekerjaan == null)
                                <span>Belum Selesai</span>
                                @else
                                <span>Selesai</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-2 border-bottom mb-4">Detail</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <x-partials.label title="Dikerjakan Oleh" />
                                <select name="dikerjakan_oleh" id="dikerjakan_oleh" class="form-control" @if($jenisKerusakan->tgl_selesai_pekerjaan != null) disabled @endif>
                                    <option value="" selected disabled>Pilih PIC...</option>
                                    @foreach ($teknisi as $item)
                                        <option @if($detail->dikerjakan_oleh == $item->id) selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <x-partials.error-message name="dikerjakan_oleh" />
                            </li>
                            <li class="mb-3">
                                <x-partials.label title="Tanggal Dikerjakan"/>
                                <input type="text" class="form-control" id="start_time" name="tgl_pengerjaan" placeholder="Tanggal Mulai" autocomplete="off" @if ($detail->tgl_selesai_pekerjaan != null) disabled @endif value="{{ Carbon\Carbon::parse($detail->jenisCreatedAt)->format('d/m/Y') }}"/>
                                <x-partials.error-message name="tgl_pengerjaan" class="d-block" />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-1">
            <div class="card mb-4">
                <h5 class="card-header mb-3">Detail Kerusakan</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Perbaikan</label>
                                <div class="col-sm-9">
                                    <select name="perbaikan" id="perbaikan" class="form-control" required @if ($detail->tgl_selesai_pekerjaan != null) disabled @endif >
                                        <option value="" selected disabled>Pilih status kerusakan...</option>
                                        <option @if($detail->nama_kerusakan == "Wastafel") selected @endif value="Wastafel">Wastafel</option>
                                        <option @if($detail->nama_kerusakan == "Closet") selected @endif value="Closet">Closet</option>
                                        <option @if($detail->nama_kerusakan == "Urinal") selected @endif value="Urinal">Urinal</option>
                                        <option @if($detail->nama_kerusakan == "Plafond") selected @endif value="Plafond">Plafond</option>
                                        <option @if($detail->nama_kerusakan == "Lantai") selected @endif value="Lantai">Lantai</option>
                                        <option @if($detail->nama_kerusakan == "Dinding") selected @endif value="Dinding">Dinding</option>
                                        <option @if($detail->nama_kerusakan == "Musholla") selected @endif value="Musholla">Musholla</option>
                                        <option @if($detail->nama_kerusakan == "Nursing Room") selected @endif value="Nursing Room">Nursing Room</option>
                                        <option @if($detail->nama_kerusakan == "Cubical") selected @endif value="Cubical">Cubical</option>
                                        <option @if($detail->nama_kerusakan == "Janitor") selected @endif value="Janitor">Janitor</option>
                                        <option @if($detail->nama_kerusakan == "Jet Shower") selected @endif value="Jet Shower">Jet Shower</option>
                                    </select>
                                    <x-partials.error-message name="perbaikan" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Status Kerusakan</label>
                                <div class="col-sm-9">
                                    <select name="status_kerusakan" id="status_kerusakan" class="form-control" onchange="setMaterialVisible(this)" @if ($detail->tgl_selesai_pekerjaan != null) disabled @endif >
                                        <option value="" selected disabled>Pilih status kerusakan...</option>
                                        <option @if($detail->status_kerusakan == "Penggantian") selected @endif value="Penggantian">Penggantian</option>
                                        <option @if($detail->status_kerusakan == "Dengan Material") selected @endif value="Dengan Material">Dengan Material</option>
                                        <option @if($detail->status_kerusakan == "Tanpa Material") selected @endif value="Tanpa Material">Tanpa Material</option>
                                    </select>
                                    <x-partials.error-message name="status_kerusakan" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea name="deskripsi" rows="3" class="form-control" placeholder="Deskripsi" @if ($detail->tgl_selesai_pekerjaan != null) disabled @endif >{{ $detail->deskripsi }}</textarea>
                                    <x-partials.error-message name="status_kerusakan" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="card-header border-top mb-0 mt-3">Detail Material</h5>
                <div class="card overflow-hidden" style="height: 455px">
                    <div class="card-body" id="vertical-example">
                        <div id="perbaikanList" style="margin-top: -20px">
                            @if ($detail->tgl_selesai_pekerjaan != null)

                                @forelse ($detailMaterial as $key => $itemMaterial)
                                    @php
                                        $kode = bin2hex(random_bytes(10));
                                    @endphp
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="divider text-start">
                                                <div class="divider-text">Material {{ $key+1 }}</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-6 mb-3">
                                            <x-partials.label title="Nama Material" />
                                            <select class="form-control w-100" disabled>
                                                <option value="" selected disabled>Pilih nama material...</option>
                                                @foreach ($stokMaterial as $item)
                                                    <option @if($itemMaterial->stok_material_id == $item->id) selected @endif value="{{ $item->id }}">{{ $item->nama_material }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-6 mb-3">
                                            <x-partials.label title="Volume" />
                                            <div class="input-group">
                                                <input type="hidden" value="{{ $itemMaterial->satuan }}">
                                                <input type="text" class="form-control" placeholder="Volume" value="{{ $itemMaterial->volume }}" disabled/>
                                                <span class="input-group-text disabled" disabled>{{ $itemMaterial->satuan }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="alert alert-info mt-0" role="alert">Tidak menggunakan material.</div>
                                        </div>
                                    </div>
                                @endforelse

                            @else
                                <input type="hidden" id="countUpdate" value="{{ count($detailMaterial) }}">
                                @forelse ($detailMaterial as $key => $itemMaterial)
                                    @php
                                        $kode = bin2hex(random_bytes(10));
                                    @endphp
                                    <input type="hidden" name="kodeList[]" value="{{ $kode }}">
                                    <div class="row" id="list-{{ $kode }}">
                                        <div class="col-12">
                                            <div class="divider text-start">
                                                <div class="divider-text" id="nomor-{{ $kode }}">Material {{ $key+1 }}</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-5 mb-3">
                                            <x-partials.label title="Nama Material" />
                                            <select name="nama_material[]" id="select-field-{{ $kode }}" class="form-control w-100 @error('nama_material') is-invalid @enderror">
                                                <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama material...</option>
                                                @foreach ($stokMaterial as $item)
                                                    <option @if($itemMaterial->stok_material_id == $item->id) selected @endif value="{{ $item->id }}" data-kode_material="{{ $item->kode_material }}" data-harga="{{ $item->harga }}">{{ $item->nama_material }}</option>
                                                @endforeach
                                            </select>
                                            <x-partials.error-message name="nama_material[]" class="d-block"/>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-5 mb-3">
                                            <x-partials.label title="Volume" />
                                            <div class="input-group">
                                                <input type="hidden" name="satuan[]" id="satuan-{{ $kode }}" value="{{ $itemMaterial->satuan }}">
                                                <input type="text" class="form-control @error('volume') is-invalid @enderror" id="volume-{{ $kode }}" name="volume[]" placeholder="Volume" value="{{ $itemMaterial->volume }}" />
                                                <span class="input-group-text">{{ $itemMaterial->satuan }}</span>
                                            </div>
                                            <x-partials.error-message name="volume[]" class="d-block"/>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-1 mb-3">
                                            <x-partials.label title="Aksi" />
                                            <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteList(this)"><i class="bx bx-x"></i></button>
                                        </div>
                                    </div>
                                @empty
                                    @php
                                        $kode = bin2hex(random_bytes(10));
                                    @endphp
                                    <input type="hidden" name="kodeList[]" value="{{ $kode }}">
                                    <div class="row" id="list-{{ $kode }}">
                                        <div class="col-12">
                                            <div class="divider text-start">
                                                <div class="divider-text" id="nomor-{{ $kode }}">Material 1</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-5 mb-3">
                                            <x-partials.label title="Nama Material" />
                                            <select name="nama_material[]" id="select-field-{{ $kode }}" class="form-control w-100 @error('nama_material') is-invalid @enderror">
                                                <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama material...</option>
                                                @foreach ($stokMaterial as $item)
                                                    <option value="{{ $item->id }}" data-kode_material="{{ $item->kode_material }}" data-harga="{{ $item->harga }}">{{ $item->nama_material }}</option>
                                                @endforeach
                                            </select>
                                            <x-partials.error-message name="nama_material[]" class="d-block"/>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-5 mb-3">
                                            <x-partials.label title="Volume" />
                                            <div class="input-group">
                                                <input type="hidden" name="satuan[]" id="satuan-{{ $kode }}">
                                                <input type="text" class="form-control @error('volume') is-invalid @enderror" id="volume-{{ $kode }}" name="volume[]" placeholder="Volume"/>
                                                <span class="input-group-text">satuan*</span>
                                            </div>
                                            <x-partials.error-message name="volume[]" class="d-block"/>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-1 mb-3">
                                            <x-partials.label title="Aksi" />
                                            <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteList(this)"><i class="bx bx-x"></i></button>
                                        </div>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                        @if ($detail->tgl_selesai_pekerjaan == null)
                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-success" id="btnAddMaterial" onclick="addList(this)"><i class="bx bx-plus"></i> Tambah Material</button>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>

        <div class="col-12 order-2 order-md-1 mb-3">
            <div class="card">
                <h5 class="card-header mb-3">Denah</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <x-partials.label title="Nomor Denah" />
                            <input type="text" name="nomor_denah" class="form-control @error('nomor_denah') is-invalid @enderror" id="nomor_denah" value="{{ $detail->nomor_denah ?? '' }}" @if ($detail->tgl_selesai_pekerjaan != null) disabled @endif>
                            <x-partials.error-message name="nomor_denah" />
                            <x-partials.input-desc text="Pisahkan dengan tanda ' , ' (koma) " />
                        </div>
                        <div class="col-12">
                            <x-partials.label title="Denah" />
                            <div class="card shadow overflow-hidden p-3" style="height: 300px">
                                <h5 class="card-header">
                                    {{ $jenisKerusakan->lantai }} - {{ $jenisKerusakan->nama }}
                                </h5>
                                <div class="card-body p-4" id="both-scrollbars-example">
                                    <img src="{{ asset('storage/'.$jenisKerusakan->denah) }}" width="800px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div class="row">
        <div class="col-12 order-1 order-md-1">
            <div class="card">
                <div class="card-header">
                    <h5>Foto Kerusakan</h5>
                </div>
                @if ($detail->tgl_selesai_pekerjaan == null)
                    <div class="card-body mb-0">
                        <form class="dropzone @error('foto_kerusakan') borderRed @enderror" id="dropzone-custom" action="{{ route('ajax.uploadFotoJenisKerusakan') }}" autocomplete="off" novalidate>
                            <div class="fallback">
                                <input name="file" type="file" multiple/>
                            </div>
                            <div class="dz-message">
                                <h3 class="dropzone-msg-title">Upload Foto Kerusakan</h3>
                                <span class="dropzone-msg-desc">Maksimal upload 12 foto</span>
                            </div>
                        </form>
                        @error('foto_kerusakan')
                            <div id="borderRed" style="color: red" class="mt-2">
                                foto kerusakan wajib diisi
                            </div>
                        @enderror
                    </div>
                @endif
                <div class="card-body mt-0">
                    <div class="row mt-0" id="loadFoto">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 order-1 order-md-1 mt-3 mb-0">
            <div class="card ">
                <div class="card-body">
                    <a href="{{ route('jenis-kerusakan.index', $detail->detailKerjaID) }}" class="btn btn-secondary me-2 mb-3 mb-sm-3 mb-md-0">Kembali</a>
                    @if ($detail->tgl_selesai_pekerjaan == null)
                        <button type="button" class="btn btn-primary me-2 mb-3 mb-sm-3 mb-md-0" id="btnSimpanPerubahan">Simpan Perubahan</button>
                        <button type="button" class="btn btn-success mb-md-0" id="btnPekerjaanSelesai">Pekerjaan Selesai</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>

        <script>
            var count = [];
            $(document).ready(function () {
                load_images();
            });
        </script>

        @if ($detail->status_kerusakan == "Tanpa Material")
            <script>
                $(document).ready(function () {
                    var test = $("input[name='kodeList[]']").map(function(){return $(this).val();}).get();
                    $.each(test, function (index, value) {
                        count.push("#nomor-"+value);
                    });
                    $.each(count, function (index, value) {
                        $('#btnAddMaterial').attr('disabled', true);
                        $('#btnAddMaterial').removeClass('btn-outline-success');
                        $('#btnAddMaterial').addClass('btn-outline-secondary');
                        $('#select-field-'+value.replace('#nomor-','')).trigger('change');
                        $('#select-field-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#volume-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#satuan-'+value.replace('#nomor-','')).attr('disabled', true);
                    });
                });
            </script>
        @else
            <script>
                $(document).ready(function () {
                    var test = $("input[name='kodeList[]']").map(function(){return $(this).val();}).get();
                    $.each(test, function (index, value) {
                        count.push("#nomor-"+value);
                    });

                    $.each(count, function (index, value) {
                        $("#select-field-" + value.replace('#nomor-','')).select2({
                            theme: "bootstrap-5",
                            createTag: function (params) {
                                return {
                                    id: params.term,
                                    text: params.term + $select.data('appendme'),
                                    kode_material: $select.data('kode_material'),
                                    harga: $select.data('harga'),
                                    newOption: true
                                }
                            },
                            templateResult: formatMaterialOptionTemplate,
                        });
                        $("#select-field-" + value.replace('#nomor-','')).trigger('change');
                    });
                    $.each(count, function (index, value) {
                        $(value).html("Material " + (index+1));
                    });

                    console.log(count);
                });
            </script>
        @endif

        @if ($jenisKerusakan->tgl_selesai_pekerjaan == null)
            <script>
                $(document).ready(function () {
                    $("#dikerjakan_oleh").select2({
                        theme: "bootstrap-5",
                    });

                    $("#status_kerusakan").select2({
                        theme: "bootstrap-5",
                    });

                    $("#start_time").datepicker({
                        dateFormat: 'dd/mm/yy',
                    });

                    $("#perbaikan").select2({
                        theme: "bootstrap-5",
                    });

                    var myDropzone = new Dropzone("#dropzone-custom",{
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        autoProcessQueue : true,
                        acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",
                        uploadMultiple: true,
                        maxFiles: 10,
                        sending: function(file, xhr, formData){
                            $('#dropzone-custom').removeClass('borderRed');
                            $('#borderRed').remove();
                            formData.append('perbaikan', '{{ $detail->nama_kerusakan }}');
                            formData.append('jenis_kerusakan_id', '{{ $jenisKerusakan->jenisKerusakanID }}');
                        },
                        init:function(){
                            this.on("maxfilesexceeded", function() {
                                if (this.files[1]!=null){
                                this.removeFile(this.files[0]);
                                }
                            });
                            this.on("complete", function(){
                                if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
                                {
                                    var _this = this;
                                    _this.removeAllFiles();
                                }
                                load_images();
                            });
                        }
                    })
                });
            </script>
        @endif

        <script>
            function load_images()
            {
                // Mengatur ajax csrf
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method: "POST",
                    url:"{{ route('ajax.getFotoJenisKerusakan') }}",
                    data: {
                        id: "{{ $jenisKerusakan->jenisKerusakanID }}"
                    },
                    dataType: "json",
                    success:function(response){
                        $('#loadFoto').html('');
                        var foto = response.data;
                        if (foto.length == 0) {
                            $('#loadFoto').html('<div class="col-12"><div class="alert alert-warning mt-0" role="alert">Belum ada foto kerusakan ditambahkan!</div></div>');
                            $('#cekFoto').html('<input type="hidden" name="cekFoto" value="false" />');
                        }else{
                            var url = "{{ route('pengaturan.menu.update', ':id') }}"; // Action pada form edit
                            url = url.replace(':id', menu.id );
                            $('#cekFoto').html('<input type="hidden" name="cekFoto" value="true" />');
                            $.each(foto, function (index, value) {
                                var url = "{{ asset('storage/:id') }}"; // Action pada form edit
                                url = url.replace(':id', value.foto );
                                $('#loadFoto').append('<div class="col-6 col-sm-6 col-md-3 mb-5 mt-3">'+
                                    '<img src="'+url+'" @if($detail->tgl_selesai_pekerjaan == null) style="width: 100%;height:300px ;object-fit: cover;background-position: center" @else style="width: 100%;height: auto;" @endif>'+
                                    '@if($detail->tgl_selesai_pekerjaan == null) <button type="button" data-id="'+value.id+'" id="btnHapus-'+value.id+'" class="btn btn-danger mt-2 w-100">Hapus</button>@endif'+
                                '</div>');

                                $('#btnHapus-'+value.id).on('click', function(){
                                    $.ajax({
                                        method: "POST",
                                        url:"{{ route('ajax.deleteFotoJenisKerusakan') }}",
                                        data:{
                                            jenis_kerusakan_id : "{{ $jenisKerusakan->jenisKerusakanID }}",
                                            id: $(this).attr('data-id'),
                                            perbaikan: "{{ $detail->nama_kerusakan }}"
                                        },
                                        success:function(data){
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                icon: "success",
                                                customClass: {
                                                    popup: "colored-toast",
                                                },
                                                showConfirmButton: false,
                                                timer: 1000,
                                            });

                                            (async () => {
                                                await Toast.fire({
                                                    icon: "success",
                                                    title: "Foto berhasil terhapus",
                                                });
                                            })();

                                            load_images();
                                        }
                                    })
                                });
                            });
                        }
                    }
                })
            }
        </script>

        <script>
            $(document).ready(function () {
                $(".imageUpload").change(function () {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#imagePreview").attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            function setMaterialVisible(e){
                if($(e).val() == "Tanpa Material"){
                    $.each(count, function (index, value) {
                        if (index != 0) {
                            $("#list-"+value.replace('#nomor-','')).remove();
                            count = jQuery.grep(count, function (value2) {
                                return value2 != value;
                            });
                        }
                    });

                    $.each(count, function (index, value) {
                        $('#btnAddMaterial').attr('disabled', true);
                        $('#btnAddMaterial').removeClass('btn-outline-success');
                        $('#btnAddMaterial').addClass('btn-outline-secondary');
                        $('#select-field-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#select-field-'+value.replace('#nomor-','')).val('').attr('selected','selected').trigger('change');
                        $('#volume-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#volume-'+value.replace('#nomor-','')).val('');
                        $('#satuan-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#satuan-'+value.replace('#nomor-','')).val('');
                    });
                    console.log(count);
                }else{
                    $.each(count, function (index, value) {
                        $('#btnAddMaterial').attr('disabled', false);
                        $('#btnAddMaterial').removeClass('btn-outline-secondary');
                        $('#btnAddMaterial').addClass('btn-outline-success');
                        $('#select-field-'+value.replace('#nomor-','')).attr('disabled', false);
                        $('#volume-'+value.replace('#nomor-','')).attr('disabled', false);
                        $('#satuan-'+value.replace('#nomor-','')).attr('disabled', false);

                        $("#select-field-" + value.replace('#nomor-','')).select2({
                            theme: "bootstrap-5",
                            createTag: function (params) {
                                return {
                                    id: params.term,
                                    text: params.term + $select.data('appendme'),
                                    kode_material: $select.data('kode_material'),
                                    harga: $select.data('harga'),
                                    newOption: true
                                }
                            },
                            templateResult: formatMaterialOptionTemplate,
                        });
                    });
                    console.log(count);
                }
            }

            function addList(e) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('ajax.getListHtml') }}",
                    dataType: "json",
                    success: function (response) {
                        if (count.length <= 9) {
                            $(response.list).appendTo("#perbaikanList").hide().fadeIn(200);
                            count.push("#nomor-" + response.kode);
                            $.each(count, function (index, value) {
                                $(value).html("Material " + (index + 1));
                            });
                            $("#select-field-" + response.kode).select2({
                                theme: "bootstrap-5",
                                createTag: function (params) {
                                return {
                                    id: params.term,
                                    text: params.term + $select.data('appendme'),
                                    kode_material: $select.data('kode_material'),
                                    harga: $select.data('harga'),
                                    newOption: true
                                }
                                },
                                templateResult: formatMaterialOptionTemplate,
                            });
                            console.log(count);
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "center",
                                icon: "danger",
                                customClass: {
                                    popup: "colored-toast",
                                },
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            (async () => {
                                await Toast.fire({
                                    icon: "error",
                                    title: "Batas maksimal penginputan perbaikan!",
                                });
                            })();
                        }
                    },
                });
            }

            function deleteList(e) {
                $.each(count, function (index, value) {
                    if (count.length != 1) {
                        count = jQuery.grep(count, function (value) {
                            return value != "#nomor-" + e.dataset.id;
                        });

                        $("#list-" + e.dataset.id).fadeOut(200, function(){
                            $(this).remove();
                        });
                    }

                    if (index == 0) {
                        plus = 1;
                    }else{
                        plus = 0;
                    }

                    $(value).html("Material " + (index+plus));
                });
            }

            $('#btnSimpanPerubahan').on('click', function () {
                $('#btnStatus').val('simpanPerubahan')

                var submit = false;

                if($('#status_kerusakan').val() != "Tanpa Material"){
                    $.each(count, function (index, value) {
                        if($('#select-field-'+value.replace('#nomor-','')).val() == '' || $('#volume-'+value.replace('#nomor-','')).val() == ''){
                            $('#select-field-'+value.replace('#nomor-','')).addClass('is-invalid');
                            $('#volume-'+value.replace('#nomor-','')).addClass('is-invalid');
                            $(value).css('color','red');
                            submit = false;
                        }else{
                            $('#select-field-'+value.replace('#nomor-','')).removeClass('is-invalid');
                            $('#volume-'+value.replace('#nomor-','')).removeClass('is-invalid');
                            $(value).css('color','');
                            submit = true;
                        }
                    });
                }else{
                    submit = true;
                }

                if (submit == true) {
                    $('#formUpdate').submit();
                }else{
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "center",
                        icon: "danger",
                        customClass: {
                            popup: "colored-toast",
                        },
                        showConfirmButton: false,
                        timer: 1000,
                    });

                    (async () => {
                        await Toast.fire({
                            icon: "error",
                            title: "Pastikan material diisi lengkap!",
                        });
                    })();
                }
            });

            $('#btnPekerjaanSelesai').on('click', function () {
                Swal.fire({ // SweetAlert
                    icon: "question",
                    title: "Anda yakin?",
                    text: "Selesaikan pekerjaan sekarang.",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yakin",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) { // Jika iyaa form akan tersubmit
                        $('#btnStatus').val('pekerjaanSelesai')

                        var submit = false;
                        if($('#status_kerusakan').val() != "Tanpa Material"){
                            $.each(count, function (index, value) {
                                if($('#select-field-'+value.replace('#nomor-','')).val() == '' || $('#volume-'+value.replace('#nomor-','')).val() == ''){
                                    $('#select-field-'+value.replace('#nomor-','')).addClass('is-invalid');
                                    $('#volume-'+value.replace('#nomor-','')).addClass('is-invalid');
                                    $(value).css('color','red');
                                    submit = false;
                                }else{
                                    $('#select-field-'+value.replace('#nomor-','')).removeClass('is-invalid');
                                    $('#volume-'+value.replace('#nomor-','')).removeClass('is-invalid');
                                    $(value).css('color','');
                                    submit = true;
                                }
                            });
                        }else{
                            submit = true;
                        }

                        if (submit == true) {
                            $('#formUpdate').submit();
                        }else{
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "center",
                                icon: "danger",
                                customClass: {
                                    popup: "colored-toast",
                                },
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            (async () => {
                                await Toast.fire({
                                    icon: "error",
                                    title: "Pastikan material diisi lengkap!",
                                });
                            })();
                        }
                    }
                });
            });

            function formatMaterialOptionTemplate(state) {

                var originalOption = $(state.element);

                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<div class="mb-0"><u>'+originalOption.data('kode_material')+'</u></div>'+
                    '<div>'+state.text+'</div>'+
                    '<div>Rp. '+formatRupiah(originalOption.data('harga'))+'</div>'+
                    '<div></div>'
                );
                return $state;
            }

            function formatRupiah(angka, prefix = null){
                var number_string = angka.toString(),
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
        </script>
    </x-slot>
</x-layouts.app>
