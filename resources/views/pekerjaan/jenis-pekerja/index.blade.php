<x-layouts.app title="Jenis Pekerja">
    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pekerjaan /</span> Pekerja</h4>

    @can('pekerja_create')
    <a href="{{ route('jenis-pekerja.create') }}" class="btn btn-primary mb-3">
        <i class="bx bx-plus"></i> Tambah Pekerja
    </a>
    @endcan

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header mb-3">Data Pekerja</h5>

            <div style="position: relative">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover nowrap" id="pekerja-table" width="100%">
                        <thead>
                            <th>No</th>
                            <th>Jenis Pekerja</th>
                            <th>Upah</th>
                            <th>Aksi</th>
                        </thead>

                        <tfoot>
                            <th>No</th>
                            <th>Jenis Pekerja</th>
                            <th>Upah</th>
                            <th>Aksi</th>
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
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Pekerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameBasic" class="form-label">Nama Pekerja</label>
                            <input type="text" name="nama" id="nama" class="form-control"/>
                            <x-partials.error-message name="nama" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <x-partials.label title="Upah"/>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" @error('upah') style="border: 0.5px solid red" @enderror>Rp. </span>
                                <input type="text" id="upah" name="upah" onkeyup="formatRupiah(this)" class="form-control @error('upah') is-invalid @enderror" placeholder="Upah" />
                            </div>
                            <x-partials.error-message name="upah" class="d-block"/>
                        </div>
                        <div class="col-12">
                            <x-partials.label title="Satuan"/>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" @error('satuan') style="border: 0.5px solid red"  @enderror><i class="bx bx-user"></i></span>
                                <input type="text" id="satuan" name="satuan" class="form-control @error('satuan') is-invalid @enderror" placeholder="org/hr" />
                            </div>
                            <x-partials.error-message name="satuan" class="d-block"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Datatables
            $('#pekerja-table').DataTable({
                    ajax: {
                        method: "POST",
                        url: "{{ route('ajax.getPekerja') }}"
                    },
                    processing: true,
                    serverSide: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'nama', name: 'nama'},
                        {data: 'upah', name: 'upah'},
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
                    url: "{{ route('ajax.getEditPekerja') }}",
                    data: {
                        id: e.dataset.id // Mengambil id pada event
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        var pekerja = response.data;
                        var url = "{{ route('jenis-pekerja.update', ':id') }}"; // Action pada form edit
                        url = url.replace(':id', pekerja.id );
                        $("#formEdit")[0].reset();
                        $('#formEdit').attr('action', url);
                        $('#modalPekerjaEdit').modal('show');
                        $('#nama').val(pekerja.nama);
                        formatRupiah($('#upah').val(pekerja.upah));
                        $('#satuan').val(pekerja.satuan);
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
        <script>
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
        @if (Session::has('modalEdit'))
            <script>
                $(document).ready(function () {
                    $('#modalPekerjaEdit').modal('show')
                });
            </script>
        @endif
    </x-slot>

</x-layouts.app>
