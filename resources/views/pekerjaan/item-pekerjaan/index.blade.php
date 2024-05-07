<x-layouts.app title="Pengaturan">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan / </span> Item Pekerjaan</h4>

    <div class="row">
        <div class="col-md-12">

        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('kategori-pekerjaan.index') }}"><i class="bx bxs-category me-1"></i>Kategori Pekerjaan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('sub-kategori-pekerjaan.index') }}"><i class="bx bxs-spreadsheet me-1"></i>Sub Kategori Pekerjaan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('item-pekerjaan.index') }}"><i class="bx bx-collection me-1"></i>Item Pekerjaan</a>
            </li>
        </ul>

            <div class="card mb-4">
                <h5 class="card-header">
                    Item Pekerjaan
                </h5>

                <div class="card-body">
                    <a href="{{ route('item-pekerjaan.create') }}" class="mb-2 btn btn-primary">
                        <i class="bx bx-plus"></i> Tambah Item Pekerjaan
                    </a>
                </div>

                    <div style="position: relative">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-hover nowrap" id="pekerja-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Sub Kategori Pekerjaan</th>
                                        <th>Item Pekerjaan</th>
                                        <th>Volume</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Sub Kategori Pekerjaan</th>
                                        <th>Item Pekerjaan</th>
                                        <th>Volume</th>
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
    </div>

    <div class="modal fade" id="modalPekerjaEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
            <form method="POST" id="formEdit">
            @csrf
            @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Item Pekerjaan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Sub Kategori Pekerjaan</label>
                        <select class="form-select @error('id_sub_kategori_pekerjaan') is-invalid @enderror" name="id_sub_kategori_pekerjaan" id="id_sub_kategori_pekerjaan" aria-label="Default select example">
                            <option selected="" disabled>Pilih Sub Kategori Pekerjaan</option>
                            @foreach ($sub_kategori as $item)
                                <option @if(old('id_sub_kategori_pekerjaan')) selected @endif value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <x-partials.error-message name="id_sub_kategori_pekerjaan" class="d-block" />
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Nama Item Pekerjaan</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" @error('harga') style="border: solid red 0.5px;" @enderror><i class="bx bxs-spreadsheet"></i></span>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Item Pekerjaan" value="{{ old('name')  }}"/>
                        </div>
                        <x-partials.error-message name="name" class="d-block" />
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="exampleFormControlSelect1" class="form-label">Volume</label>
                                <input type="text" name="volume" id="volume" class="form-control @error('volume') is-invalid @enderror" placeholder="Volume" value="{{ old('volume')  }}" />
                                <x-partials.error-message name="volume" class="d-block" />
                            </div>
                            <div class="col-6">
                                <label for="exampleFormControlSelect1" class="form-label">Satuan</label>
                                <input type="text" name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror" placeholder="Satuan" value="{{ old('satuan')  }}" />
                                <x-partials.error-message name="satuan" class="d-block" />
                            </div>
                        </div>

                    </div>
                    <div class="">
                        <x-partials.label title="Harga" />
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" @error('harga') style="border: solid red 0.5px;" @enderror>Rp. </span>
                            <input type="text" name="harga" id="harga" class="form-control @error('harga') is-invalid @enderror" placeholder="Pemotongan Upah" onkeyup="formatRupiah(this)" value="{{ old('harga') }}"/>
                        </div>
                        <x-partials.error-message name="harga" class="d-block"/>
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
                $('#id_sub_kategori_pekerjaan').select2({
                    theme: 'bootstrap-5',
                    dropdownParent: $("#modalPekerjaEdit")
                });
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
                        url: "{{ route('ajax.getItemPekerja') }}"
                    },
                    processing: true,
                    serverSide: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'subKategori', name: 'subKategori'},
                        {data: 'nama', name: 'nama'},
                        {data: 'volume', name: 'volume'},
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
                    url: "{{ route('ajax.getEditItemPekerja') }}",
                    data: {
                        id: e.dataset.id // Mengambil id pada event
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        var itemPekerja = response.data;
                        var url = "{{ route('item-pekerjaan.update', ':id') }}"; // Action pada form edit
                        url = url.replace(':id', itemPekerja.id );
                        $("#formEdit")[0].reset();
                        $('#formEdit').attr('action', url);
                        $('#modalPekerjaEdit').modal('show');
                        $('#name').val(itemPekerja.nama);
                        $('#id_sub_kategori_pekerjaan').val(itemPekerja.id_sub_kategori_pekerjaan).trigger('change');
                        $('#volume').val(itemPekerja.volume);
                        $('#satuan').val(itemPekerja.satuan);
                        formatRupiah($('#harga').val(parseInt(itemPekerja.harga)));
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
                $(".redBorder").removeClass("redBorder")
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
        @if (Session::has('modalEdit'))
        <script>
            $(document).ready(function () {
                $('#modalPekerjaEdit').modal('show')
            });
        </script>
        @endif
    </x-slot>

    </x-layouts.app>
