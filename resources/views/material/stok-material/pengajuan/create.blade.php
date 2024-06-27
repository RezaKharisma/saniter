<x-layouts.app title="Tambah Stok Material">

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}">
        <style>
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
                <form method="post" action="{{ route('stok-material.pengajuan.store') }}" enctype="multipart/form-data" id="formSubmit">
                    @csrf
                    <input type="hidden" name="typeForm" value="SANITER">

                    <div id="cardFormPengajuan">

                        @php
                            $kode = bin2hex(random_bytes(10));
                        @endphp

                        <div class="card-body">

                            {{-- Nama Material --}}
                            <div class="mb-3">
                                <x-partials.label title="Nama Material" required/>
                                <input type="hidden" name="nama_material[]" id="nama_material-{{ $kode }}">
                                <select name="material_id[]" data-kode="{{ $kode }}" class="form-control @error('material_id')is-invalid @enderror" id="select-field" required data-placeholder="Pilih nama..." onchange="getNamaMaterial(this)">
                                    <option></option>
                                    @foreach ($namaMaterial as $item)
                                        <option value="{{ $item['id'] }}">{{ ucwords($item['nama_material']) }}</option>
                                    @endforeach
                                </select>
                                <x-partials.error-message name="material_id" class="d-block" />
                            </div>

                            <div class="mb-3">
                                <div class="row">

                                    {{-- Kode Material --}}
                                    <div class="col-12 col-sm-12 col-sm-12 mb-3">
                                        <x-input-text title="Kode Material" name='kode_material[]' id="kode_material-{{ $kode }}" readonly/>
                                    </div>

                                    {{-- Kategori Material --}}
                                    <div class="col-12 col-sm-12 col-sm-12 mb-3">
                                        <x-input-text title="Kategori Material" name='kategori_material[]' id="kategori_material-{{ $kode }}" readonly />
                                    </div>

                                    {{-- Satuan Material --}}
                                    <div class="col-12 col-sm-4 col-sm-6 mb-3">
                                        <x-input-text title="Satuan" name='satuan[]' id="satuan-{{ $kode }}" readonly />
                                    </div>

                                    {{-- Harga --}}
                                    <div class="col-12 col-sm-4 col-sm-6 mb-3 mb-sm-0">
                                        <input type="hidden" name="harga[]" id="hargaSubmit-{{ $kode }}">
                                        <x-input-text title="Harga" name="display[]" id="harga-{{ $kode }}" readonly/>
                                        <x-partials.input-desc text='Harga satuan.' />
                                    </div>

                                </div>
                            </div>

                            {{-- Stok Input --}}
                            <div class="">
                                <x-partials.label title="Jumlah Stok Masuk" required />
                                <input type="text" class="form-control stokMasuk" data-kode="{{ $kode }}" name="masuk[]" id="stokMasuk-{{ $kode }}" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" required>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-between d-flex">
                            <div class="col-12 col-sm-auto col-md-auto mb-3 mb-sm-3 mb-md-0 text-center">
                                <a href="{{ route('stok-material.pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
                                <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
                            </div>
                            <div class="col-12 col-sm-auto col-md-auto text-center">
                                <button type="button" class="btn btn-success" id="btnTambahMaterial" onclick="addList(this)"><i class="bx bx-plus"></i> Tambah Material Lainnya</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#select-field').select2( {
                    theme: 'bootstrap-5'
                } );
            });

            function addList(e) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('ajax.getListMaterialSaniterHtml') }}",
                    dataType: "json",
                    beforeSend: function () {
                        $(e).prop('disabled', true);
                    },
                    complete: function(){
                        $(e).prop('disabled', false);
                    },
                    success: function (response) {
                        $(response.list).appendTo("#cardFormPengajuan");
                        $('#select-field-'+response.kode).select2({
                            theme: 'bootstrap-5'
                        });
                    },
                });
            }

            function deleteList(e) {
                $("#list-" + e.dataset.kode).fadeOut(200, function(){
                    $(this).remove();
                });
            }

            function getNamaMaterial(e){

                $(e).removeClass('is-invalid');
                var kode = $(e).data('kode');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.getNamaMaterialSaniter') }}",
                    data: {
                        id: $(e).val()
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#kode_material-'+kode).val('');
                        $('#kategori_material-'+kode).val('');
                        $('#nama_material-'+kode).val('');
                        $('#satuan-'+kode).val('');
                        $('#harga-'+kode).val('');
                        $("#stokMasuk-"+kode).val('');
                        $("#stokMasuk-"+kode).prop('disabled', true);
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            icon: 'info',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                        })

                        ;(async () => {
                        await Toast.fire({
                            icon: 'info',
                            title: 'Memuat...',
                        })})()
                    },
                    complete: function(){
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'center',
                            icon: 'info',
                            customClass: {
                                popup: 'colored-toast',
                            },
                            showConfirmButton: false,
                            timer: 900
                        })

                        ;(async () => {
                        await Toast.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                        })})()
                        $("#stokMasuk-"+kode).prop('disabled', false);
                    },
                    success: function (response) {
                        var data = response.data;
                        var harga = data.harga.toString();
                        $('#kode_material-'+kode).val(data.kode_material);
                        $('#nama_material-'+kode).val(data.nama_material);
                        $('#kategori_material-'+kode).val(data.kategori_material);
                        $('#satuan-'+kode).val(data.satuan);
                        $('#hargaSubmit-'+kode).val(harga.replace(/[_\W]+/g, ""));
                        $('#harga-'+kode).val('Rp. '+ formatRupiah(harga.replace(/[_\W]+/g, "")));

                    }
                });
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

            $("#submitForm").on('click', function () {
                submit = true;

                $('.stokMasuk').each(function() {
                    var kode = $(this).data('kode');

                    $('#select-field').removeClass('is-invalid');
                    $('#stokMasuk-'+kode).removeClass('is-invalid');
                    $('#select-field-'+kode).removeClass('is-invalid');
                    $('#kode_material-'+kode).removeClass('is-invalid');

                    if ($('#select-field').val() === '' || $('#stokMasuk-'+kode).val() === '' || $('#select-field-'+kode).val() === '' || $('#kode_material-'+kode).val() === '') {

                        if ($('#select-field').val() === '') {
                            $('#select-field').addClass('is-invalid');
                        }

                        if ($('#stokMasuk-'+kode).val() === '') {
                            $('#stokMasuk-'+kode).addClass('is-invalid');
                        }

                        if ($('#select-field-'+kode).val() === '') {
                            $('#select-field-'+kode).addClass('is-invalid');
                        }

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
                            title: 'Mohon periksa form kembali!',
                        })})()
                        submit = false;
                    }else{
                        submit = true;
                    }
                });

                if (submit == true) {
                    $('#formSubmit').submit();
                }
            });
        </script>
    </x-slot>
</x-layouts.app>
