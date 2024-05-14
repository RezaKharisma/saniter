<x-layouts.app title="Detail Tanggal Kerja">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proyek / </span> Detail Tanggal Kerja</h4>

    {{-- Menu --}}
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary d-block" href="{{ route('tanggal-kerja.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
        @if (Carbon\Carbon::now()->format('Y-m-d') == Carbon\Carbon::parse($tglKerja->tanggal)->format('Y-m-d'))
            <li class="nav-item ms-0 ms-sm-0 ms-md-2 mt-2 mt-sm-2 mt-md-0">
                <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#modalAdd" onclick="setLokasi(this)"><i class="bx bx-plus"></i>Tambah Lokasi Kerusakan</button>
            </li>
        @endif
    </ul>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <h5 class="card-header">
                    Detail Tanggal Kerja
                </h5>

                <div class="card-body mb-0">
                    <span class="badge bg-success ">Tanggal : {{ Carbon\Carbon::parse($tglKerja->tanggal)->isoFormat('dddd, D MMMM Y') }}</span>
                </div>

                <div style="position: relative">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover" id="kerja-table" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Regional</th>
                                    <th>Lokasi</th>
                                    <th>Jam</th>
                                    <th>Total Kerusakan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Regional</th>
                                    <th>Lokasi</th>
                                    <th>Jam</th>
                                    <th>Total Kerusakan</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAdd" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                {{-- Form Tambah Menu --}}
                <form action="{{ route('detail-data-proyek.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Lokasi Kerusakan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @csrf
                    <input type="hidden" value="{{ $tglKerja->id }}" name="tgl_kerja_id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <x-partials.label title="Lokasi Kerusakan" />
                            <select name="list_area_id" id="list_area_id" class="form-control select-field" onchange="setDenah(this)" required>
                                <option value="" selected disabled>Pilih lokasi kerusakan...</option>
                            </select>
                            <x-partials.error-message name="list_area_id" class="d-block"/>
                        </div>

                        <div class="justify-content-center d-flex">
                            <img class="d-block rounded mb-3 img-fluid d-none mt-4" style="max-height: 220px" id="imagePreviewAdd" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>

                        {{-- Button Submit --}}
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $( '.select-field' ).select2( {
                    theme: 'bootstrap-5',
                    dropdownParent: $("#modalAdd")
                } );

                // Datatables
                $('#kerja-table').DataTable({
                    ajax: {
                        url: "{{ route('ajax.getDetailTglKerja') }}",
                        data: {
                            id: "{{ $tglKerja->id }}"
                        }
                    },
                    processing: true,
                    serverSide: true,
                    // responsive: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'regionalName', name: 'regionalName'},
                        {data: 'lokasi', name: 'lokasi'},
                        {data: 'jam', name: 'jam'},
                        {data: 'total', name: 'total'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    columnDefs: [
                        {targets: [4], className: 'text-center'}
                    ]
                })

                $('#modalAdd').on('hidden.bs.modal', function () {
                    $('#imagePreviewAdd').removeClass('d-block');
                    $('#imagePreviewAdd').addClass('d-none');
                })

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

            });

            function setLokasi(){
                // Mengatur ajax csrf
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('ajax.getLokasiKerusakan') }}",
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        var lokasi = response.data;
                        $('#list_area_id').empty().append('<option value="" selected disabled>Pilih lokasi kerusakan...</option>')
                        $.each(lokasi, function (index, value) {
                            $('#list_area_id').append('<option value='+value.id+'>'+value.areaNama+' | '+value.lantai+' - '+value.nama+'</option>')
                        });
                    }
                });
            }

            function setDenah(e){
                // Mengatur ajax csrf
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.getDenahLokasi') }}",
                    data: {
                        id: $(e).val()
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        $('#imagePreviewAdd').removeClass('d-none');
                        $('#imagePreviewAdd').addClass('d-block');
                        var denah = response.data.denah;
                        $('#imagePreviewAdd').attr("src", "{{ asset('storage') }}/"+denah);
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
    </x-slot>

    </x-layouts.app>
