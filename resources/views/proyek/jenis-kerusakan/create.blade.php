<x-layouts.app title="Tambah Kerusakan">
    <x-slot name="style">
        <style>
            .select2 {
                width: 100% !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proyek / </span> Tambah Kerusakan </h4>

    <a href="{{ route('jenis-kerusakan.index', $detailKerja->id) }}" class="btn btn-secondary mb-3"><i class="bx bx-arrow-back me-1"></i> Kembali</a>

    <div class="row">
        <form method="post" action="{{ route('jenis-kerusakan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="col-12 mb-3">
                <div class="card">
                    <h5 class="card-header mb-0">Form Kerusakan</h5>
                    <div class="card-body">
                        <input type="hidden" name="detail_tgl_kerja_id" value="{{ $detailKerja->id }}" />

                        {{-- Status Kerusakan --}}
                        <div class="mb-3">
                            <x-partials.label title="Status Kerusakan" />
                            <select name="status_kerusakan" id="status_kerusakan" class="form-control" required onchange="setMaterialVisible(this)">
                                <option value="" selected disabled>Pilih status kerusakan...</option>
                                <option @if(old('status_kerusakan') == "Penggantian") selected @endif value="Penggantian">Penggantian</option>
                                <option @if(old('status_kerusakan') == "Dengan Material") selected @endif value="Dengan Material">Dengan Material</option>
                                <option @if(old('status_kerusakan') == "Tanpa Material") selected @endif value="Tanpa Material">Tanpa Material</option>
                            </select>
                            <x-partials.error-message name="status_kerusakan" />
                        </div>

                        {{-- Dikerjakan Oleh --}}
                        <div class="mb-3">
                            <x-partials.label title="Dikerjakan Oleh" />
                            <select name="dikerjakan_oleh" id="dikerjakan_oleh" class="form-control" required>
                                <option value="" selected disabled>Pilih PIC...</option>
                                @foreach ($teknisi as $item)
                                    <option @if(old('dikerjakan_oleh') == $item->id) selected @endif  value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <x-partials.error-message name="dikerjakan_oleh" />
                        </div>

                        {{-- Foto --}}
                        <div class="mb-3">
                            <x-partials.label title="Foto" />
                            <div class="">
                                <div class="col-auto mb-3">
                                    {{-- Foto Preview --}}
                                    <img src="{{ asset('storage/jenis-kerusakan/default.jpg') }}" alt="user-avatar" class="d-block rounded img-fluid" style="max-height: 200px;" id="fotoPreview" />
                                </div>

                                <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg" required/>
                            </div>
                            <x-partials.error-message name="foto" class="d-block" />
                        </div>

                        <div class="mb-3">
                            <x-partials.label title="Deskripsi" />
                            <textarea name="deskripsi" rows="4" class="form-control" placeholder="Deskripsi">{{ old('deskripsi') }}</textarea>
                        </div>

                        {{-- <hr class="mt-5 mb-4" /> --}}

                        <div class="mb-2">
                            <div class="col-12">
                                <x-partials.label title="Perbaikan" />
                                <select name="perbaikan" id="perbaikan" class="form-control" required>
                                    <option value="" selected disabled>Pilih status kerusakan...</option>
                                    <option @if(old('perbaikan') == "Wastafel") selected @endif value="Wastafel">Wastafel</option>
                                    <option @if(old('perbaikan') == "Closet") selected @endif value="Closet">Closet</option>
                                    <option @if(old('perbaikan') == "Urinal") selected @endif value="Urinal">Urinal</option>
                                    <option @if(old('perbaikan') == "Plafond") selected @endif value="Plafond">Plafond</option>
                                    <option @if(old('perbaikan') == "Lantai") selected @endif value="Lantai">Lantai</option>
                                    <option @if(old('perbaikan') == "Dinding") selected @endif value="Dinding">Dinding</option>
                                    <option @if(old('perbaikan') == "Musholla") selected @endif value="Musholla">Musholla</option>
                                    <option @if(old('perbaikan') == "Nursing Room") selected @endif value="Nursing Room">Nursing Room</option>
                                    <option @if(old('perbaikan') == "Cubical") selected @endif value="Cubical">Cubical</option>
                                    <option @if(old('perbaikan') == "Janitor") selected @endif value="Janitor">Janitor</option>
                                    <option @if(old('perbaikan') == "Jet Shower") selected @endif value="Jet Shower">Jet Shower</option>
                                </select>
                                <x-partials.error-message name="perbaikan" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->can('tanggal kerja_input item pekerjaan'))
            <div class="col-12 mb-3">
                <div class="card">
                    <h5 class="card-header">Pekerja</h5>
                    <div class="card-body">
                        <div id="pekerjaList">
                            <div class="row">
                                <div class="col-12">
                                    <div class="divider text-start">
                                        <div class="divider-text">Pekerja 1</div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Nama Pekerja" />
                                    <select name="nama_pekerja[]" id="nama_pekerja" class="form-control w-100 @error('nama_pekerja') is-invalid @enderror" required>
                                        <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama pekerja...</option>
                                        @foreach ($pekerja as $item)
                                            <option value="{{ $item->id }}" data-upah="{{ $item->upah }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message name="nama_pekerja[]" class="d-block"/>
                                </div>
                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Volume" />
                                    <div class="input-group">
                                        <input type="hidden" name="satuan_pekerja[]" id="satuan_pekerja">
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume_pekerja') is-invalid @enderror" id="volume_pekerja" name="volume_pekerja[]" placeholder="Volume" required/>
                                        <span class="input-group-text">satuan*</span>
                                    </div>
                                    <x-partials.error-message name="volume_pekerja[]" class="d-block"/>
                                    <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary mb-3 mb-sm-3 mb-md-0" onclick="addListPekerja(this)"><i class="bx bx-plus"></i> Tambah Pekerja</button>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="card">
                    <h5 class="card-header">Item Pekerjaan</h5>
                    <div class="card-body">
                        <div id="itemPekerjaanList">
                            <div class="row">
                                <div class="col-12">
                                    <div class="divider text-start">
                                        <div class="divider-text">Item Pekerjaan 1</div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Item Pekerjaan" />
                                    <select name="item_pekerjaan[]" id="item_pekerjaan" class="form-control w-100 @error('item_pekerjaan') is-invalid @enderror" required>
                                        <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih item pekerjaan...</option>
                                        @foreach ($itemPekerjaan as $item)
                                            <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message name="item_pekerjaan[]" class="d-block"/>
                                </div>
                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Volume" />
                                    <div class="input-group">
                                        <input type="hidden" name="satuan_item_pekerjaan[]" id="satuan_item_pekerjaan">
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume_item_pekerjaan') is-invalid @enderror" id="volume_item_pekerjaan" name="volume_item_pekerjaan[]" placeholder="Volume" required/>
                                        <span class="input-group-text">satuan*</span>
                                    </div>
                                    <x-partials.error-message name="volume_item_pekerjaan[]" class="d-block"/>
                                    <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" onclick="addListItemPekerjaan(this)"><i class="bx bx-plus"></i> Tambah Item Pekerjaan</button>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-12 mb-3">
                <div class="card">
                    <h5 class="card-header">Material</h5>
                    <div class="card-body">
                        <div id="perbaikanList" class="">
                            <div class="row">
                                <div class="col-12">
                                    <div class="divider text-start">
                                        <div class="divider-text">Material 1</div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Nama Material" />
                                    <select name="nama_material[]" id="nama_material" class="form-control w-100 @error('nama_material') is-invalid @enderror" required>
                                        <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama material...</option>
                                        @foreach ($stokMaterial as $item)
                                            <option value="{{ $item->kode_material }}" data-kode_material="{{ $item->kode_material }}" data-harga="{{ $item->harga }}">{{ $item->nama_material }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message name="nama_material[]" class="d-block"/>
                                </div>
                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Volume" />
                                    <div class="input-group">
                                        <input type="hidden" name="satuan[]" id="satuan">
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume') is-invalid @enderror" id="volume" name="volume[]" placeholder="Volume" required/>
                                        <span class="input-group-text">satuan*</span>
                                    </div>
                                    <x-partials.error-message name="volume[]" class="d-block"/>
                                    <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="btnAddMaterial" onclick="addList(this)"><i class="bx bx-plus"></i> Tambah Material</button>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">
                        Denah
                    </h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <x-partials.label title="Nomor Denah" />
                                <input type="text" name="nomor_denah" oninput="this.value = this.value.replace(/[^0-9,]/g, '')" class="form-control @error('nomor_denah') is-invalid @enderror" id="nomor_denah" value="{{ old('nomor_denah') }}">
                                <x-partials.error-message name="nomor_denah" />
                                <x-partials.input-desc text="Pisahkan dengan tanda ' , ' (koma) " />
                            </div>
                            <div class="col-12">
                                <x-partials.label title="Denah" />
                                <div class="card shadow">
                                    <h5 class="card-header">
                                        {{ $detailKerja->lantai }} - {{ $detailKerja->nama }}
                                    </h5>
                                    <div class="card-body p-4 text-center">
                                        <img src="{{ asset('storage/'.$detailKerja->denah) }}" class="img-fluid" height="300px">
                                    </div>
                                </div>
                                {{-- <div class="card shadow " style="height: 300px">
                                    <h5 class="card-header">
                                        {{ $detailKerja->lantai }} - {{ $detailKerja->nama }}
                                    </h5>
                                    <div class="card-body p-4" id="both-scrollbars-example">
                                        <img src="{{ asset('storage/'.$detailKerja->denah) }}" width="800px">
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('jenis-kerusakan.index', $detailKerja->id) }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <x-slot name="script">

        <script>
            $(document).ready(function () {
                $('#status_kerusakan').trigger('change');
            });
        </script>

        <script>
            var count = [];

            $(document).ready(() => {
                $("#nama_material").select2({
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

                $("#perbaikan").select2({
                    theme: "bootstrap-5",
                });

                $("#nama_pekerja").select2({
                    theme: "bootstrap-5",
                    createTag: function (params) {
                        return {
                            id: params.term,
                            text: params.term + $select.data('appendme'),
                            upah: $select.data('upah'),
                            newOption: true
                        }
                    },
                    templateResult: formatPekerjaOptionTemplate,
                });

                $("#item_pekerjaan").select2({
                    theme: "bootstrap-5",
                    createTag: function (params) {
                        return {
                            id: params.term,
                            text: params.term + $select.data('appendme'),
                            harga: $select.data('harga'),
                            newOption: true
                        }
                    },
                    templateResult: formatItemPekerjaanOptionTemplate,
                });

                $("#status_kerusakan").select2({
                    theme: "bootstrap-5",
                });

                $("#dikerjakan_oleh").select2({
                    theme: "bootstrap-5",
                });

                $("#foto").change(function () {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#fotoPreview").attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            function formatPekerjaOptionTemplate(state) {

                var originalOption = $(state.element);

                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<div class="mb-0"><u>'+state.text+'</u></div>'+
                    '<div>Rp. '+formatRupiah(originalOption.data('upah'))+' (satuan)</div>'+
                    '<div></div>'
                );
                return $state;
            }

            function formatItemPekerjaanOptionTemplate(state) {

                var originalOption = $(state.element);

                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<div class="mb-0"><u>'+state.text+'</u></div>'+
                    '<div>Rp. '+formatRupiah(originalOption.data('harga'))+' (satuan)</div>'+
                    '<div></div>'
                );
                return $state;
            }

            function formatMaterialOptionTemplate(state) {

                var originalOption = $(state.element);

                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<div class="mb-0"><u>'+originalOption.data('kode_material')+'</u></div>'+
                    '<div>'+state.text+'</div>'+
                    '<div>Rp. '+formatRupiah(originalOption.data('harga'))+' (satuan)</div>'+
                    '<div></div>'
                );
                return $state;
            }

            function setMaterialVisible(e){
                if($(e).val() == "Tanpa Material"){
                    $('#btnAddMaterial').attr('disabled', true);
                    $('#btnAddMaterial').removeClass('btn-primary');
                    $('#btnAddMaterial').addClass('btn-outline-secondary');
                    $('#nama_material').attr('disabled', true);
                    $('#nama_material').val('').trigger('change');
                    $('#volume').attr('disabled', true);
                    $('#volume').val('');
                    $('#satuan').attr('disabled', true);
                    $('#satuan').val('');

                    $.each(count, function (index, value) {
                        $("#list-"+value.replace('#nomor-','')).remove();
                        count = jQuery.grep(count, function (value2) {
                            return value2 != value;
                        });
                    });
                }else{
                    $('#btnAddMaterial').attr('disabled', false);
                    $('#btnAddMaterial').removeClass('btn-outline-secondary');
                    $('#btnAddMaterial').addClass('btn-primary');
                    $('#nama_material').attr('disabled', false);
                    $('#volume').attr('disabled', false);
                    $('#satuan').attr('disabled', false);
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
                        if (count.length <= 8) {
                            $(response.list).appendTo("#perbaikanList").hide().fadeIn(200);
                            count.push("#nomor-" + response.kode);
                            $.each(count, function (index, value) {
                                $(value).html("Material " + (index + 2));
                            });
                            $("#select-field-" + response.kode).select2({
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
                                theme: "bootstrap-5",
                            });
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
                count = jQuery.grep(count, function (value) {
                    return value != "#nomor-" + e.dataset.id;
                });

                $("#list-" + e.dataset.id).fadeOut(200, function(){
                    $(this).remove();
                });

                $.each(count, function (index, value) {
                    $(value).html("Material " + (index + 2));
                });
            }

            function addListPekerja(e) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('ajax.getListPekerjaHtml') }}",
                    dataType: "json",
                    success: function (response) {
                        if (count.length <= 8) {
                            $(response.list).appendTo("#pekerjaList").hide().fadeIn(200);
                            count.push("#nomor-" + response.kode);
                            $.each(count, function (index, value) {
                                $(value).html("Pekerja " + (index + 2));
                            });
                            $("#nama_pekerja-" + response.kode).select2({
                                createTag: function (params) {
                                    return {
                                        id: params.term,
                                        text: params.term + $select.data('appendme'),
                                        upah: $select.data('upah'),
                                        newOption: true
                                    }
                                },
                                templateResult: formatPekerjaOptionTemplate,
                                theme: "bootstrap-5",
                            });
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

            function deleteListPekerja(e) {
                count = jQuery.grep(count, function (value) {
                    return value != "#nomor-" + e.dataset.id;
                });

                $("#list-pekerja-" + e.dataset.id).fadeOut(200, function(){
                    $(this).remove();
                });

                $.each(count, function (index, value) {
                    $(value).html("Pekerja " + (index + 2));
                });
            }

            function addListItemPekerjaan(e) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('ajax.getListItemPekerjaanHtml') }}",
                    dataType: "json",
                    success: function (response) {
                        if (count.length <= 8) {
                            $(response.list).appendTo("#itemPekerjaanList").hide().fadeIn(200);
                            count.push("#nomor-" + response.kode);
                            $.each(count, function (index, value) {
                                $(value).html("Pekerja " + (index + 2));
                            });
                            $("#item_pekerjaan-" + response.kode).select2({
                                createTag: function (params) {
                                    return {
                                        id: params.term,
                                        text: params.term + $select.data('appendme'),
                                        upah: $select.data('upah'),
                                        newOption: true
                                    }
                                },
                                templateResult: formatItemPekerjaanOptionTemplate,
                                theme: "bootstrap-5",
                            });
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

            function deleteListItemPekerjaan(e) {
                count = jQuery.grep(count, function (value) {
                    return value != "#nomor-" + e.dataset.id;
                });

                $("#list-item-pekerjaan-" + e.dataset.id).fadeOut(200, function(){
                    $(this).remove();
                });

                $.each(count, function (index, value) {
                    $(value).html("Pekerja " + (index + 2));
                });
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
