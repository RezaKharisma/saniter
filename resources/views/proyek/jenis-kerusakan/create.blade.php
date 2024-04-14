<x-layouts.app title="Tambah Kerusakan">
    <x-slot name="style">
        <style>
            .select2 {
                width: 100% !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proyek / </span> Tambah</h4>

    <a href="{{ route('jenis-kerusakan.index', $detailKerja->id) }}" class="btn btn-secondary mb-3"><i class="bx bx-arrow-back me-1"></i> Kembali</a>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header mb-0">Form Kerusakan</h5>

                <form method="post" action="{{ route('jenis-kerusakan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <input type="hidden" name="detail_tgl_kerusakan_id" value="{{ $detailKerja->id }}" />

                        <div class="mb-3">
                            <x-partials.label title="Status Kerusakan" />
                            <select name="status_kerusakan" id="status_kerusakan" class="form-control" required autofocus>
                                <option value="" selected disabled>Pilih status kerusakan...</option>
                                <option value="Penggantian">Penggantian</option>
                                <option value="Dengan Material">Dengan Material</option>
                                <option value="Tanpa Material">Tanpa Material</option>
                            </select>
                            <x-partials.error-message name="status_kerusakan" />
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
                            <textarea name="deskripsi" rows="4" class="form-control" placeholder="Deskripsi"></textarea>
                        </div>

                        <hr class="mt-5 mb-4" />

                        <div class="mb-2">
                            <div class="col-12">
                                <x-partials.label title="Perbaikan" />
                                <select name="perbaikan" id="perbaikan" class="form-control" required>
                                    <option value="" selected disabled>Pilih status kerusakan...</option>
                                    <option value="Wastafel">Wastafel</option>
                                    <option value="Closet">Closet</option>
                                    <option value="Urinal">Urinal</option>
                                    <option value="Plafond">Plafond</option>
                                    <option value="Lantai">Lantai</option>
                                    <option value="Dinding">Dinding</option>
                                    <option value="Musholla">Musholla</option>
                                    <option value="Nursing Room">Nursing Room</option>
                                    <option value="Cubical">Cubical</option>
                                    <option value="Janitor">Janitor</option>
                                    <option value="Jet Shower">Jet Shower</option>
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
                                    <select name="nama_material[]" id="select-field" class="form-control w-100" required>
                                        <option value="" selected disabled>Pilih nama material...</option>
                                        @foreach ($stokMaterial as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_material }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Volume" />
                                    <div class="input-group">
                                        <input type="hidden" name="satuan[]" id="satuan">
                                        <input type="text" class="form-control" name="volume[]" placeholder="Volume" />
                                        <span class="input-group-text">satuan*</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-outline-success" onclick="addList(this)"><i class="bx bx-plus"></i> Tambah Material</button>
                        </div>

                        <hr class="mt-5 mb-4" />

                        <div class="mt-3">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <x-partials.label title="Nomor Denah" />
                                    <input type="text" name="nomor_denah" class="form-control" id="nomor_denah" >
                                    <x-partials.input-desc text="Pisahkan dengan tanda ' , ' (koma) " />
                                </div>
                                <div class="col-12">
                                    <x-partials.label title="Denah" />
                                    <div class="card shadow overflow-hidden p-3" style="height: 300px">
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
            var count = [];

            $(document).ready(() => {
                $("#select-field").select2({
                    theme: "bootstrap-5",
                });

                $("#perbaikan").select2({
                    theme: "bootstrap-5",
                });

                $("#status_kerusakan").select2({
                    theme: "bootstrap-5",
                });

                $("#foto").change(function () {
                    const file = this.files[0];
                    console.log(file);
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#fotoPreview").attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            // $('#nomor_denah').on('keypress',function(e){
            //     if(e.which === 32){
            //         var str = $(this).val().split('');
            //         if(str[str.length - 2] === ','){
            //             $(this).val($(this).val().replace(' ',''));
            //         }
            //         $(this).val($(this).val().replace(' ',','));
            //     }
            // });

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
                            $("#perbaikanList").append(response.list);
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

                $("#list-" + e.dataset.id).remove();

                $.each(count, function (index, value) {
                    $(value).html("Material " + (index + 2));
                });
            }
        </script>
    </x-slot>
</x-layouts.app>
