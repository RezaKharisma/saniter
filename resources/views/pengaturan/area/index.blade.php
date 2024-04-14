<x-layouts.app title="Pengaturan">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan / </span> Area</h4>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
        <i class="bx bx-plus"></i> Tambah Area
    </button>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <h5 class="card-header">
                    Data Area
                </h5>

                <div class="card-body">

                    <table class="table table-hover" id="area-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Regional</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Regional</th>
                                <th>Nama</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <form method="POST" class="d-inline" action="{{ route('area.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Area</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="nameBasic" class="form-label">Nama Area</label>
                        <select name="regional_id" class="form-control select-field-add" required>
                            <option value="" selected disabled>Pilih regional...</option>
                            @foreach ($regional as $item)
                                <option @if(old('regional_id') == $item->id) selected @endif value="{{ old('regional_id') ?? $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <x-partials.error-message name="regional_id" />
                    </div>

                    <div class="mb-3">
                        <x-partials.label title="Nama Area" />
                        <input type="text" name="nama" class="form-control" placeholder="Nama Area" value="{{ old('nama') }}" required/>
                        <x-partials.error-message name="nama" />
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
            <form method="POST" class="d-inline" id="formEdit">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Tambah Area</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="nameBasic" class="form-label">Nama Area</label>
                        <select name="regional_id" id="regional_idEdit" class="form-control select-field-edit" required>
                            <option value="" selected disabled>Pilih regional...</option>
                            @foreach ($regional as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <x-partials.error-message name="regional_id" />
                    </div>

                    <div class="mb-3">
                        <x-partials.label title="Nama Area" />
                        <input type="text" name="nama" id="namaEdit" class="form-control" placeholder="Nama Area" value="{{ old('nama') }}" required/>
                        <x-partials.error-message name="nama" />
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
                $( '.select-field-add' ).select2( {
                    theme: 'bootstrap-5',
                    dropdownParent: $("#modalAdd")
                } );

                $( '.select-field-edit' ).select2( {
                    theme: 'bootstrap-5',
                    dropdownParent: $("#modalEdit")
                } );

                // Datatables
                $('#area-table').DataTable({
                    ajax: "{{ route('ajax.getArea') }}",
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'regionalNama', name: 'regionalNama'},
                        {data: 'nama', name: 'nama'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    rowGroup: {
                        dataSrc: 'regionalNama'
                    },
                    order : [[1,'asc']],
                    columnDefs: [
                    {
                        target: 1,
                        visible: false,
                        searchable: false
                    }]
                })
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
                    url: "{{ route('ajax.getAreaEdit') }}",
                    data: {
                        id: e.dataset.id // Mengambil id pada event
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        var area = response.data;
                        var url = "{{ route('area.update', ':id') }}"; // Action pada form edit
                        url = url.replace(':id', area.id );
                        $("#formEdit")[0].reset();
                        $('#formEdit').attr('action', url);
                        $('#namaEdit').val(area.nama);
                        $('#regional_idEdit').val(area.regional_id).trigger('change');
                    }
                });
            }

            // Reset is-invalid form validation
            function resetFormValidation(){
                $(".is-invalid").removeClass("is-invalid")
                $(".invalid-feedback").addClass("d-none")
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

    </x-slot>

    </x-layouts.app>
