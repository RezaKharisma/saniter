<x-layouts.app title="Peralatan">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proyek / </span> Peralatan</h4>

    <div class="row">
        <div class="col-md-12">

        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
                <a href="{{ route('peralatan.create') }}" class="mb-2 btn btn-primary">
                    <i class="bx bx-plus"></i> Tambah Peralatan
                </a>
            </li>
        </ul>

            <div class="card mb-4">
                <h5 class="card-header">
                    Kategori Pekerjaan
                </h5>

                <div style="position: relative">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover nowrap" id="pekerja-table" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peralatan</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Peralatan</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPeralatanEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <form method="POST" id="formEdit">
            @csrf
            @method('PUT')
                <input type="hidden" id="editID" value="{{ Session::get('editID') ?? '0' }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Kategori Pekerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Nama Peralatan</label>
                        <input type="text" id="nama_peralatan" name="nama_peralatan" class="form-control @error('nama_peralatan') is-invalid  @enderror" placeholder="Nama Peralatan" value="{{ old('nama_peralatan') }}" />
                        <x-partials.error-message name="nama_peralatan" class="d-block" />
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">Satuan</label>
                            <input type="text" id="satuan" name="satuan" class="form-control @error('satuan') is-invalid  @enderror" placeholder="Satuan" value="{{ old('satuan') }}" />
                            <x-partials.error-message name="satuan" class="d-block" />
                        </div>
                        <div class="col-12 col-md-8">
                            <x-partials.label title="Harga" />
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" @error('harga') style="border: solid red 1px;" @enderror>Rp. </span>
                                <input type="text" id="harga" name="harga" class="form-control @error('harga') is-invalid @enderror" placeholder="Harga Satuan" onkeyup="formatRupiah(this)" value="{{ old('harga') }}" required/>
                            </div>
                            <x-partials.error-message name="harga" class="d-block"/>
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
                        url: "{{ route('ajax.getPeralatan') }}"
                    },
                    processing: true,
                    serverSide: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'nama_peralatan', name: 'nama_peralatan'},
                        {data: 'harga', name: 'harga'},
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
                    url: "{{ route('ajax.getEditPeralatan') }}",
                    data: {
                        id: e.dataset.id // Mengambil id pada event
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        var kategori = response.data;
                        var url = "{{ route('peralatan.update', ':id') }}"; // Action pada form edit
                        url = url.replace(':id', kategori.id );
                        $("#formEdit")[0].reset();
                        $('#formEdit').attr('action', url);
                        $('#modalPeralatanEdit').modal('show');
                        $('#nama_peralatan').val(kategori.nama_peralatan);
                        $('#satuan').val(kategori.satuan);
                        formatRupiah($('#harga').val(parseInt(kategori.harga)));
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

            function formatRupiah(e){
                var number_string = $(e).val().replace(/[^,\d]/g, '').toString(),
                    split	= number_string.split(','),
                    sisa 	= split[0].length % 3,
                    rupiah 	= split[0].substr(0, sisa),
                    ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                $(e).val(rupiah);
            }
        </script>

        {{-- Jika terdapat session dengan nama modalEdit, untuk validasi popup otomatis --}}
        @if (Session::has('modalEdit') && Session::has('editID'))
        <script>
            $(document).ready(function () {
                var url = "{{ route('peralatan.update', ':id') }}"; // Action pada form edit
                url = url.replace(':id', $('#editID').val() );
                $('#formEdit').attr('action', url);
                $('#modalPeralatanEdit').modal('show');
            });
        </script>
        @endif
    </x-slot>

    </x-layouts.app>
