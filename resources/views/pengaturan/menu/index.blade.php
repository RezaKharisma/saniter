<x-layouts.app title="Menu">

    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> Menu</h4>

    <div class="row">
        <div class="col-md-12">

            {{-- Menu --}}
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    {{-- Jika request url adalah url yg di tentukan, set class active --}}
                    <a class="nav-link active" href="{{ route('pengaturan.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
                </li>
            </ul>

            <div class="card mb-4">

                {{-- Update Profile --}}
                <h5 class="card-header">Manajemen Menu</h5>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-2">
                        <button type="button" class="btn btn-secondary me-0" data-bs-toggle="modal" data-bs-target="#modalMenu"><i class="bx bx-plus"></i>Tambah Menu</button>
                        <a class="btn btn-primary" href="{{ route('pengaturan.submenu.index') }}"><i class="bx bx-plus"></i>Tambah Sub Menu</a>
                    </div>
                </div>

                <div class="card-body">

                    <table id="menu-table" class="table table-hover table-sm" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Order</th>
                                <th>Url</th>
                                <th>Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

    {{-- Modal Tambah Menu --}}
    <div class="modal fade" id="modalMenu" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                {{-- Form Tambah Menu --}}
                <form action="{{ route('pengaturan.menu.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @csrf

                    <div class="modal-body">
                        {{-- Input Judul --}}
                        <x-input-text title="Judul" name="judul" placeholder="Masukkan judul menu" margin="mb-3" onkeyup="convertToSlug(this)"/>

                        <div class="row">
                            <div class="col">

                                {{-- Input Kategori --}}
                                <div class="mb-3">
                                    <x-partials.label title="Kategori"/>
                                    <select id="id_kategori" name="id_kategori" class="form-select @error('id_kategori')is-invalid @enderror" onchange="selectKategori()">
                                        <option value="" selected disabled>Pilih Kategori...</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message class="d-block" name="id_kategori" />
                                </div>

                            </div>
                            <div class="col">

                                {{-- Input URL --}}
                                <x-input-text title="Url" name="url" id="url" placeholder="Masukkan url menu" />
                                <x-partials.input-desc text="Harap gunakan url sesuai nama kategori." />

                            </div>
                        </div>

                        {{-- Input Order --}}
                        <x-input-number title="Urutan Order" name="order" style="width: 30%" placeholder="Masukkan order" />

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

    {{-- Modal Edit Menu --}}
    <div class="modal fade" id="modalMenu" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                {{-- Form Tambah Menu --}}
                <form action="{{ route('pengaturan.menu.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @csrf

                    <div class="modal-body">
                        {{-- Input Judul --}}
                        <x-input-text title="Judul" name="judul" placeholder="Masukkan judul menu" margin="mb-3" onkeyup="convertToSlug(this)"/>

                        <div class="row">
                            <div class="col">

                                {{-- Input Kategori --}}
                                <div class="mb-3">
                                    <x-partials.label title="Kategori"/>
                                    <select id="id_kategori" name="id_kategori" class="form-select @error('id_kategori')is-invalid @enderror" onchange="selectKategori()">
                                        <option value="" selected disabled>Pilih Kategori...</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message class="d-block" name="id_kategori" />
                                </div>

                            </div>
                            <div class="col">

                                {{-- Input URL --}}
                                <x-input-text title="Url" name="url" id="url" placeholder="Masukkan url menu" />
                                <x-partials.input-desc text="Harap gunakan url sesuai nama kategori." />

                            </div>
                        </div>

                        {{-- Input Order --}}
                        <x-input-number title="Urutan Order" name="order" style="width: 30%" placeholder="Masukkan order" />

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
                $('#menu-table').DataTable({
                    ajax: "{{ route('ajax.getMenu') }}",
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'judul', name: 'judul'},
                        {data: 'order', name: 'order'},
                        {data: 'url', name: 'url'},
                        {data: 'nama_kategori', name: 'kategori'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                })

                $(document).on("click", "button.confirm-delete", function () {
                    var form = $(this).closest("form");
                    event.preventDefault();
                    Swal.fire({
                        title: "Apa kamu yakin?",
                        text: "Data akan terhapus!",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yakin",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            var kategori = "";
            var judul_menu = "";

            function selectKategori(){
                kategori = $('#id_kategori').find(":selected").text().toLowerCase()+'/';
                $('#url').val(kategori+judul_menu);
            }

            function convertToSlug(e) {
                judul_menu = $(e).val();
                judul_menu = judul_menu.toLowerCase().replace(/ /g, "_").replace(/[^\w-]+/g, "");
                $("#url").val(kategori+judul_menu)
            }

            function editData(e){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.getMenuEdit') }}",
                    data: {
                        id: e.dataset.id
                    },
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                    }
                });
            }
        </script>

        @if ($errors->count() > 0)
            <script>
                $(document).ready(function () {
                    $('#modalMenu').modal('show');
                });
            </script>
        @endif
    </x-slot>

</x-layouts.app>
