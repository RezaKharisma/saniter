<x-layouts.app title="Pengaturan">
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan / </span> Kategori Pekerjaan</h4>

<div class="row">
    <div class="col-md-12">

    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('kategori-pekerjaan.index') }}"><i class="bx bxs-category me-1"></i>Kategori Pekerjaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('sub-kategori-pekerjaan.index') }}"><i class="bx bxs-spreadsheet me-1"></i>Sub Kategori Pekerjaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('item-pekerjaan.index') }}"><i class="bx bx-collection me-1"></i>Item Pekerjaan</a>
        </li>
    </ul>

        <div class="card mb-4">
            <h5 class="card-header">
                Kategori Pekerjaan
            </h5>

            <div class="card-body">
                <a href="{{ route('kategori-pekerjaan.create') }}" class="mb-2 btn btn-primary">
                    <i class="bx bx-plus"></i> Tambah Kategori Pekerjaan
                </a>
            </div>
            <div style="position: relative">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover nowrap" id="pekerja-table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                {{-- <th>Pekerja</th> --}}
                                <th>Kategori Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                {{-- <th>Pekerja</th> --}}
                                <th>Kategori Pekerjaan</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPekerjaEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <form method="POST" id="formEdit">
        @csrf
        @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Edit Kategori Pekerja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    {{-- <div class="col-12 mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Pekerja</label>
                        <select class="form-select @error('id_pekerja') is-invalid  @enderror" name="id_pekerja" id="id_pekerja">
                            <option value="" selected disabled>Pilih pekerja...</option>
                            @foreach ($pekerja as $item)
                                <option @if(old('id_pekerja')) selected @endif value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <x-partials.error-message name="id_pekerja" class="d-block" />
                    </div> --}}
                    <div class="col-12 mb-3">
                        <label for="nameBasic" class="form-label">Nama Kategori</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid  @enderror" value="{{ old('name')  }}"/>
                        <x-partials.error-message name="name" class="d-block"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
                <button type="submit" class="btn btn-primary">Ubah</button>
            </div>
        </form>
        </div>
    </div>
</div>

<x-slot name="script">
    <script>
        $(document).ready(function () {
            // $('#id_pekerja').select2({
            //     theme: 'bootstrap-5',
            //     dropdownParent: $("#modalPekerjaEdit")
            // });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Datatables
        $('#pekerja-table').DataTable({
                ajax: {
                    method: "POST",
                    url: "{{ route('ajax.getKategoriPekerja') }}"
                },
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    // {data: 'pekerja', name: 'pekerja'},
                    {data: 'nama', name: 'nama'},
                    {data: 'action', name: 'action'},
                ],
            })
    </script>

    <script>
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
                url: "{{ route('ajax.getEditKategoriPekerja') }}",
                data: {
                    id: e.dataset.id // Mengambil id pada event
                },
                dataType: "json",
                success: function (response) { // Jika ajax sukses dan memberikan respon
                    var kategori = response.data;
                    var url = "{{ route('kategori-pekerjaan.update', ':id') }}"; // Action pada form edit
                    url = url.replace(':id', kategori.id );
                    $("#formEdit")[0].reset();
                    $('#formEdit').attr('action', url);
                    $('#modalPekerjaEdit').modal('show');
                    $('#name').val(kategori.nama);
                    // $('#id_pekerja').val(kategori.id_pekerja).trigger('change');
                }
            });
        }

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

        // Reset is-invalid form validation
        function resetFormValidation(){
            $(".is-invalid").removeClass("is-invalid")
            $(".invalid-feedback").addClass("d-none")
        }
    </script>

    {{-- Jika terdapat session dengan nama modalEdit, untuk validasi popup otomatis --}}
    @if (Session::has('modalEdit'))
    <script>
        $(document).ready(function () {
            $('#modalPekerjaEdit').modal('show')
        });
    </script>
@endif
</x-slot>

</x-layouts.app>
