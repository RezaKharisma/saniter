<x-layouts.app title="Pengaturan">
<h5 class="fw-bold py-3 mb-4">Selamat Datang</h5>

<!-- Striped Rows -->
<div class="card">
    <h5 class="card-header">Data Regional</h5>
    <div class="card-body">
        @can('regional_create')
            <a href="{{ route('regional.create') }}" class="mb-4 btn btn-secondary"><i class="bx bx-plus"></i> Tambah Regional</a>
        @endcan

            <table class="table table-hover" id="tabel-regional">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        @if(auth()->user()->can('regional_update') || auth()->user()->can('regional_update'))
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        @if(auth()->user()->can('regional_update') || auth()->user()->can('regional_update'))
                            <th>Aksi</th>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

{{-- Modal Edit Regional --}}
<div class="modal fade" id="modalRegional" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            {{-- Form Tambah Menu --}}
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Sub Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf

                <div class="modal-body">

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
            // Datatables
            $('#tabel-regional').DataTable({
                ajax: "{{ route('ajax.getRegional') }}",
                processing: true,
                serverSide: true,
                responsive: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    {data: 'nama', name: 'nama'},
                    {data: 'action', name: 'action'},
                ],
            })
        });

        // Ketika tombol edit diklik
        function editData(e){

            resetFormValidation()

            // Mengatur ajax csrf
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('ajax.getSubMenuEdit') }}",
                data: {
                    id: e.dataset.id // Mengambil id pada event
                },
                dataType: "json",
                success: function (response) { // Jika ajax sukses dan memberikan respon
                    var menu = response.data;
                    var url = "{{ route('pengaturan.submenu.update', ':id') }}"; // Action pada form edit
                    url = url.replace(':id', menu.id );
                    $("#formEdit")[0].reset();
                    $('#formEdit').attr('action', url);
                    $('#judulEdit').val(menu.judul);
                    $('#urlEdit').val(menu.url);
                    $('#orderEdit').val(menu.order);
                    $('#id_menuEdit option[value='+menu.id_menu+']').attr('selected','selected');
                }
            });
            }

            // Reset is-invalid form validation
            function resetFormValidation(){
            $(".is-invalid").removeClass("is-invalid")
            $(".invalid-feedback").addClass("d-none")
            }
    </script>
</x-slot>

</x-layouts.app>
