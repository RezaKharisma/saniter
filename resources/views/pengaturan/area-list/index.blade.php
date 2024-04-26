<x-layouts.app title="Area List">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan / </span> Area List</h4>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bx bx-plus"></i> Tambah Area List
    </button>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <h5 class="card-header">
                    Data Area
                </h5>

                <div style="position: relative">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover" id="area-table" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Denah</th>
                                    <th>Area</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Denah</th>
                                    <th>Area</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <form method="POST" class="d-inline" action="{{ route('list-area.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Area List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="nameBasic" class="form-label">Nama Area</label>
                        <select name="regional_id" id="regional_id" class="form-control select-field-regional" required onchange="setArea(this,'#area_id')">
                            <option value="" selected disabled>Pilih regional...</option>
                            @foreach ($regional as $item)
                                <option value="{{ old('regional_id') ?? $item['id'] }}">{{ $item['nama'] }}</option>
                            @endforeach
                        </select>
                        <x-partials.error-message name="regional_id" />
                    </div>

                    <div class="mb-3">
                        <label for="nameBasic" class="form-label">Nama Area</label>
                        <select name="area_id" id="area_id" class="form-control select-field-area" required>
                            <option value="" selected disabled>Pilih nama area...</option>
                        </select>
                        <x-partials.error-message name="area_id" />
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <x-partials.label title="Lantai" />
                            <select name="lantai" class="form-control" required>
                                <option value="" selected disabled>Pilih lantai...</option>
                                <option @if(old('lantai') == 'Lantai 1') selected @endif value="Lantai 1">Lantai 1</option>
                                <option @if(old('lantai') == 'Lantai 2') selected @endif value="Lantai 2">Lantai 2</option>
                                <option @if(old('lantai') == 'Lantai 3') selected @endif value="Lantai 3">Lantai 3</option>
                            </select>
                        </div>
                        <div class="col-8">
                            <x-partials.label title="Nama Area" />
                            <input type="text" name="nama" class="form-control" placeholder="Nama Area" value="{{ old('nama') }}" required/>
                            <x-partials.error-message name="nama" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <x-partials.label title="Denah" />
                        <img src="{{ asset('storage/denah/default.png' ) }}" class="d-block rounded mb-3" style="max-height: 220px" id="imagePreviewAdd" />
                        <x-partials.input-file name="denah" id="imageUploadAdd" accept="image/png, image/jpeg, image/jpg" required/>
                        <x-partials.error-message name="denah" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Keluar
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <form method="POST" class="d-inline" id="formEdit" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Area</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="nameBasic" class="form-label">Nama Area</label>
                        <select name="regional_id" id="regional_idEdit" class="form-control select-field-regional-edit" required onchange="setArea(this,'#area_idEdit')">
                            <option value="" selected disabled>Pilih regional...</option>
                            @foreach ($regional as $item)
                                <option value="{{ old('regional_id') ?? $item['id'] }}">{{ $item['nama'] }}</option>
                            @endforeach
                        </select>
                        <x-partials.error-message name="regional_id" />
                    </div>

                    <div class="mb-3">
                        <label for="nameBasic" class="form-label">Nama Area</label>
                        <select name="area_idEdit" id="area_idEdit" class="form-control select-field-area-edit" required>
                            <option value="" selected disabled>Pilih regional...</option>
                        </select>
                        <x-partials.error-message name="area_idEdit" />
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <x-partials.label title="Lantai" />
                            <select name="lantaiEdit" id="lantaiEdit" class="form-control" required>
                                <option value="" selected disabled>Pilih lantai...</option>
                                <option @if(old('lantai') == 'Lantai 1') selected @endif value="Lantai 1">Lantai 1</option>
                                <option @if(old('lantai') == 'Lantai 2') selected @endif value="Lantai 2">Lantai 2</option>
                                <option @if(old('lantai') == 'Lantai 3') selected @endif value="Lantai 3">Lantai 3</option>
                            </select>
                            <x-partials.error-message name="lantaiEdit" class="d-block" />
                        </div>
                        <div class="col-8">
                            <x-partials.label title="Nama Area" />
                            <input type="text" id="namaEdit" name="namaEdit" class="form-control" placeholder="Nama Area" value="{{ old('nama') }}" required/>
                            <x-partials.error-message name="namaEdit" />
                        </div>
                    </div>

                    <div class="mb-3">
                        <x-partials.label title="Denah" />
                        <img class="d-block rounded mb-3" style="max-height: 220px" id="imagePreviewEdit" />
                        <x-partials.input-file name="denahEdit" id="imageUploadEdit" accept="image/png, image/jpeg, image/jpg"/>
                        <x-partials.error-message name="denahEdit" />
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Keluar
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // Datatables
                $('#area-table').DataTable({
                    ajax: "{{ route('ajax.getAreaList') }}",
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    lengthMenu: [[5, 10, 15], [5, 10, 15]],
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'denah', name: 'denah',orderable: false},
                        {data: 'area', name: 'area'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    columnDefs: [
                        {targets: [1], className: 'text-center'}
                    ]
                })

                $('#area_id').prop('disabled', true);

                $( '.select-field-regional' ).select2( {
                    theme: 'bootstrap-5',
                    dropdownParent: $("#modalAdd")
                } );

                $( '.select-field-area' ).select2( {
                    theme: 'bootstrap-5',
                    dropdownParent: $("#modalAdd")
                } );

                $( '.select-field-regional-edit' ).select2( {
                    theme: 'bootstrap-5',
                    dropdownParent: $("#modalEdit")
                } );

                $( '.select-field-area-edit' ).select2( {
                    theme: 'bootstrap-5',
                    dropdownParent: $("#modalEdit")
                } );

                // Jika tombol delete diklik
                $(document).on("click", "button.confirm-delete", function () {
                    var form = $(this).closest("form");
                    event.preventDefault();
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
                            form.submit();
                        }
                    });
                });

                $("#imageUploadAdd").change(function () {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#imagePreviewAdd").attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });

                $("#imageUploadEdit").change(function () {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#imagePreviewEdit").attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            $("#modalAdd").on('hide.bs.modal', function () {
                $('#regional_id').val('').trigger('change');
                $('#area_id').prop('disabled', true);
            });

            $("#modalEdit").on('hide.bs.modal', function () {
                $('#regional_idEdit').val('').trigger('change');
                $('#area_idEdit').prop('disabled', true);
            });

            // Ketika tombol edit diklik
            function editData(e){

                resetFormValidation();

                // Mengatur ajax csrf
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.getAreaListEdit') }}",
                    data: {
                        id: e.dataset.id // Mengambil id pada event
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        areaList = response.data;
                        regional = response.regional;
                        var url = "{{ route('list-area.update', ':id') }}"; // Action pada form edit
                        url = url.replace(':id', areaList.id );
                        $("#formEdit")[0].reset();
                        $('#formEdit').attr('action', url);
                        $('#namaEdit').val(areaList.nama);
                        $('#regional_idEdit').val(regional).trigger('change');
                        $('#lantaiEdit option[value="'+areaList.lantai+'"]').attr('selected','selected');
                        $("#imagePreviewEdit").attr("src", "{{ asset('storage') }}/"+areaList.denah);
                        setArea($('#regional_idEdit'),'#area_idEdit', areaList.area_id)
                        $('#area_idEdit').val(areaList.areaID).trigger('change');
                    }
                });
            }

            // Reset is-invalid form validation
            function resetFormValidation(){
                $(".is-invalid").removeClass("is-invalid")
                $(".invalid-feedback").addClass("d-none")
            }

            function setArea(e, areaSelect, selectedID = null)
            {
                $(areaSelect).prop('disabled',false);

                // Mengatur ajax csrf
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.getAreaListRegional') }}",
                    data: {
                        regional_id: $(e).val() // Mengambil id pada event
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        var area = response.data;
                        $(areaSelect).empty().append('<option value="" selected disabled>Pilih nama area...</option>')
                        $.each(area, function (index, value) {
                            if (value.id == selectedID) {
                                $(areaSelect).append('<option selected value='+value.id+'>'+value.nama+'</option>')
                            }else{
                                $(areaSelect).append('<option value='+value.id+'>'+value.nama+'</option>')
                            }
                        });
                    }
                });
            }
        </script>

        {{-- Jika terdapat session dengan nama modalEdit, untuk validasi popup otomatis --}}
        @if (Session::has('modalAdd'))
            <script>
                $(document).ready(function () {
                    $('#modalAdd').modal('show')
                });
            </script>
        @endif

        {{-- Jika terdapat session dengan nama modalEdit, untuk validasi popup otomatis --}}
        @if (Session::has('modalEdit'))
            <script>
                $(document).ready(function () {
                    $('#modalEdit').modal('show')
                });
            </script>
        @endif

    </x-slot>

    </x-layouts.app>
