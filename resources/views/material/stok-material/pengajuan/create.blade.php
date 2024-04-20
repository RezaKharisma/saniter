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
                    <input type="hidden" name="kode_material" id="kode_material">
                    <input type="hidden" name="nama_material" id="nama_material">

                    <div class="card-body">

                        {{-- Nama Material --}}
                        <div class="mb-3">
                            <x-partials.label title="Nama Material" required/>
                            <select name="material_id" class="form-control @error('material_id')is-invalid @enderror" id="select-field" required data-placeholder="Pilih nama..." onchange="getNamaMaterial(this)">
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
                                    <x-input-text title="Jenis Pekerjaan" name='jenis_pekerjaan' id="jenis_pekerjaan" readonly />
                                </div>

                                {{-- Jenis Material --}}
                                <div class="col-12 col-sm-4 col-sm-6 mb-3">
                                    <x-input-text title="Jenis Material" name='jenis_material' id="jenis_material" readonly />
                                </div>

                                {{-- Stok Logistik (qty) --}}
                                <div class="col-12 col-sm-4 col-sm-6 mb-3 mb-sm-0">
                                    <x-input-text title="Stok Gudang Logistik" name='qty' id="qty" readonly />
                                </div>

                                {{-- Harga --}}
                                <div class="col-12 col-sm-4 col-sm-6 mb-3 mb-sm-0">
                                    <input type="hidden" name="harga" id="hargaSubmit">
                                    <x-input-text title="Harga" name="display" id="harga" readonly/>
                                </div>
                            </div>
                        </div>

                        {{-- Stok Input --}}
                        <div class="">
                            <x-partials.label title="Jumlah Stok Masuk" required />
                            <x-partials.input-text name="masuk" id="stokMasuk" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57"/>
                        </div>

                    </div>
                    <div class="card-footer">
                        <a href="{{ route('stok-material.pengajuan.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="button" class="btn btn-primary" id="submitForm">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(document).ready(function () {
                $( '#select-field' ).select2( {
                    theme: 'bootstrap-5'
                } );
            });

            function getNamaMaterial(e){
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
                        $('#jenis_pekerjaan').val('');
                        $('#jenis_material').val('');
                        $('#qty').val('');
                        $('#harga').val('');
                        $("#stokMasuk").val('');
                        $("#stokMasuk").prop('disabled', true);
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

                        $("#stokMasuk").prop('disabled', false);
                    },
                    success: function (response) {
                        console.log(response);
                        var data = response.data;
                        $('#kode_material').val(data.kode_material);
                        $('#nama_material').val(data.nama_material);
                        $('#jenis_pekerjaan').val(data.jenis_pekerjaan);
                        $('#jenis_material').val(data.jenis_material);
                        $('#qty').val(data.qty);
                        $('#hargaSubmit').val(data.harga_beli.replace(/[_\W]+/g, ""));
                        $('#harga').val('Rp. '+ formatRupiah(data.harga_beli.replace(/[_\W]+/g, "")));

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
    </x-slot>
</x-layouts.app>
