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
        <div class="col-12">
            <div class="card">
                <h5 class="card-header mb-0">Form Kerusakan</h5>

                <form method="post" action="{{ route('jenis-kerusakan.store') }}" enctype="multipart/form-data">
                    @csrf
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

                        <hr class="mt-5 mb-4" />

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

                        <div id="perbaikanList">
                            <div class="row">
                                <div class="col-12">
                                    <div class="divider text-start">
                                        <div class="divider-text">Material 1</div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Nama Material" />
                                    <select name="nama_material[]" id="nama_material" class="form-control w-100 @error('nama_material') is-invalid @enderror" required>
                                        <option value="" selected disabled>Pilih nama material...</option>
                                        @foreach ($stokMaterial as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_material }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message name="nama_material[]" class="d-block"/>
                                </div>
                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Volume" />
                                    <div class="input-group">
                                        <input type="hidden" name="satuan[]" id="satuan">
                                        <input type="text" class="form-control @error('volume') is-invalid @enderror" id="volume" name="volume[]" placeholder="Volume" />
                                        <span class="input-group-text">satuan*</span>
                                    </div>
                                    <x-partials.error-message name="volume[]" class="d-block"/>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-success" id="btnAddMaterial" onclick="addList(this)"><i class="bx bx-plus"></i> Tambah Material</button>
                        </div>

                        <hr class="mt-5 mb-4" />

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <x-partials.label title="Nomor Denah" />
                                    <input type="text" name="nomor_denah" class="form-control @error('nomor_denah') is-invalid @enderror" id="nomor_denah" value="{{ old('nomor_denah') }}">
                                    <x-partials.error-message name="nomor_denah" />
                                    <x-partials.input-desc text="Pisahkan dengan tanda ' , ' (koma) " />
                                </div>
                                <div class="col-12">
                                    <x-partials.label title="Denah" />
                                    <div class="card shadow overflow-hidden p-3" style="height: 300px">
                                        <h5 class="card-header">
                                            {{ $detailKerja->lantai }} - {{ $detailKerja->nama }}
                                        </h5>
                                        <div class="card-body p-4" id="both-scrollbars-example">
                                            <img src="{{ asset('storage/'.$detailKerja->denah) }}" width="800px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <a href="{{ route('jenis-kerusakan.index', $detailKerja->id) }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
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
                });

                $("#perbaikan").select2({
                    theme: "bootstrap-5",
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

            function setMaterialVisible(e){
                if($(e).val() == "Tanpa Material"){
                    $('#btnAddMaterial').attr('disabled', true);
                    $('#btnAddMaterial').removeClass('btn-outline-success');
                    $('#btnAddMaterial').addClass('btn-outline-secondary');
                    $('#nama_material').attr('disabled', true);
                    $('#volume').attr('disabled', true);
                    $('#satuan').attr('disabled', true);

                    $.each(count, function (index, value) {
                        if (index != 0) {
                            $("#list-"+value.replace('#nomor-','')).remove();
                            delete count[1];
                        }
                    });
                }else{
                    $('#btnAddMaterial').attr('disabled', false);
                    $('#btnAddMaterial').removeClass('btn-outline-secondary');
                    $('#btnAddMaterial').addClass('btn-outline-success');
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
        </script>
    </x-slot>
</x-layouts.app>