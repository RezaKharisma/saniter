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
                    <div id="cardFormPengajuan">

                        @php
                            $kode = bin2hex(random_bytes(10));
                        @endphp

                        <input type="hidden" name="kode_material[]" id="kode_material-{{ $kode }}">
                        <input type="hidden" name="nama_material[]" id="nama_material-{{ $kode }}">

                        <div class="card-body">

                            {{-- Nama Material --}}
                            <div class="mb-3">
                                <x-partials.label title="Nama Material" required/>
                                <select name="material_id[]" data-kode="{{ $kode }}" class="form-control @error('material_id')is-invalid @enderror" id="select-field" required data-placeholder="Pilih nama..." onchange="getNamaMaterial(this)">
                                    <option></option>
                                    @foreach ($namaMaterial as $item)
                                        <option value="{{ $item['id'] }}">{{ $item['kode_material'] }} | {{ $item['nama_material'] }}</option>
                                    @endforeach
                                </select>
                                <x-partials.error-message name="material_id" class="d-block" />
                            </div>

                            <div class="mb-3">
                                <div class="row">

                                    {{-- Jenis Pekerjaan --}}
                                    <div class="col-12 col-sm-4 col-sm-6 mb-3">
                                        <x-input-text title="Jenis Pekerjaan" name='jenis_pekerjaan[]' id="jenis_pekerjaan-{{ $kode }}" readonly />
                                    </div>

                                    {{-- Jenis Material --}}
                                    <div class="col-12 col-sm-4 col-sm-6 mb-3">
                                        <x-input-text title="Jenis Material" name='jenis_material[]' id="jenis_material-{{ $kode }}" readonly />
                                    </div>

                                    {{-- Stok Logistik (qty) --}}
                                    <div class="col-12 col-sm-4 col-sm-6 mb-3 mb-sm-0">
                                        <x-input-text title="Stok Gudang Logistik" name='qty[]' id="qty-{{ $kode }}" readonly />
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
                    url: "{{ route('ajax.getListMaterialHtml') }}",
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
                    url: "{{ route('material.getNamaMaterial') }}",
                    data: {
                        id: $(e).val()
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#jenis_pekerjaan-'+kode).val('');
                        $('#jenis_material-'+kode).val('');
                        $('#qty-'+kode).val('');
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
                        $('#kode_material-'+kode).val(data.kode_material);
                        $('#nama_material-'+kode).val(data.nama_material);
                        $('#jenis_pekerjaan-'+kode).val(data.jenis_pekerjaan);
                        $('#jenis_material-'+kode).val(data.jenis_material);
                        $('#qty-'+kode).val(data.qty);
                        $('#hargaSubmit-'+kode).val(data.harga_beli.replace(/[_\W]+/g, ""));
                        $('#harga-'+kode).val('Rp. '+ formatRupiah(data.harga_beli.replace(/[_\W]+/g, "")));

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

                    if ($('#select-field').val() === '' || $('#stokMasuk-'+kode).val() === '' || $('#select-field-'+kode).val() === '') {

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
                        var stokMasuk = parseInt($('#stokMasuk-'+kode).val());
                        var stokLogistik = parseInt($('#qty-'+kode).val());
                        var harga = parseInt($('#hargaSubmit-'+kode).val());

                        if (harga > 5000000) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'center',
                                icon: 'danger',
                                customClass: {
                                    popup: 'colored-toast',
                                },
                                showConfirmButton: false,
                                timer: 4000,
                            })

                            ;(async () => {
                            await Toast.fire({
                                icon: 'warning',
                                title: 'Harga material melebihi Rp. 5.000.00, Silakan mengajukan ke bagian logistik',
                            })})()
                            $('#stokMasuk-'+kode).addClass('is-invalid');
                            submit = false;
                        }

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
                            $('#stokMasuk-'+kode).addClass('is-invalid');
                            submit = false;
                        }
                    }
                });

                if (submit == true) {
                    $('#formSubmit').submit();
                }
            });
        </script>
    </x-slot>
</x-layouts.app>
