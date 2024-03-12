<x-layouts.app title="Sub Menu">

    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> Sub Menu</h4>

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
                <h5 class="card-header">Manajemen Sub Menu</h5>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-2">
                        <button type="button" class="btn btn-secondary me-0" data-bs-toggle="modal" data-bs-target="#modalSubMenu"><i class="bx bx-plus"></i>Tambah Sub Menu</button>
                    </div>
                </div>

                <div class="card-body">

                    <table id="sub-menu-table" class="table table-hover table-sm" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Menu</th>
                                <th>Judul</th>
                                <th>Order</th>
                                <th>Url</th>
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
    <div class="modal fade" id="modalSubMenu" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                {{-- Form Tambah Menu --}}
                <form action="{{ route('pengaturan.submenu.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tambah Sub Menu</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @csrf

                    <div class="modal-body">
                        {{-- Input Judul --}}
                        <x-input-text title="Judul" name="judul" placeholder="Masukkan judul sub menu" margin="mb-3" onkeyup="convertToSlug(this)" />

                        <div class="row">
                            <div class="col">

                                {{-- Input Kategori --}}
                                <div class="mb-3">
                                    <x-partials.label title="Menu"/>
                                    <select id="id_menu" name="id_menu" class="form-select @error('id_menu')is-invalid @enderror">
                                        <option value="" selected disabled>Pilih Menu...</option>
                                        @foreach ($menu as $item)
                                            <option value="{{ $item->id }}">{{ $item->judul }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message class="d-block" name="id_kategori" />
                                </div>

                            </div>
                            <div class="col">

                                {{-- Input URL --}}
                                <x-input-text title="Url" name="url" id="url" placeholder="Masukkan url menu" :value="old('url')"/>

                            </div>
                        </div>

                        {{-- Input Order --}}
                        <x-input-number title="Urutan Order" name="order" style="width: 30%" placeholder="Masukkan order" :value="old('order')" />

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
                $('#sub-menu-table').DataTable({
                    ajax: "{{ route('ajax.getSubMenu') }}",
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'judul_menu', name: 'judul_menu'},
                        {data: 'judul', name: 'judul'},
                        {data: 'order', name: 'order'},
                        {data: 'url', name: 'url'},
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

            function convertToSlug(e) {
                var key = $(e).val().toLowerCase().replace(/ /g, "_").replace(/[^\w-]+/g, "");
                $("#url").val(key)
            }
        </script>

        @if ($errors->count() > 0)
            <script>
                $(document).ready(function () {
                    $('#modalSubMenu').modal('show');
                });
            </script>
        @endif
    </x-slot>

</x-layouts.app>
