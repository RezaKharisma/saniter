<x-layouts.app title="Stok Material">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material / </span>Stok Material</h4>

    <!-- Striped Rows -->
    <div class="card">
        <h5 class="card-header">Data Stok Material</h5>
        <div class="card-body">
            <a href="{{ route('stok-material.create') }}" class="mb-4 btn btn-primary"><i class="bx bx-plus"></i> Tambah Stok Material</a>
            <table class=" table-responsive table table-hover" id="lokasi-table" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Stok Masuk</th>
                        <th>Harga</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th>#</th>
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Stok Masuk</th>
                        <th>Harga</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // Datatables
                $('#lokasi-table').DataTable({
                    ajax: "{{ route('ajax.getStokMaterial') }}",
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'kode_material', name: 'kode_material'},
                        {data: 'nama_material', name: 'nama_material'},
                        {data: 'masuk', name: 'masuk'},
                        {data: 'action', name: 'action'},
                    ],
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
        </script>
    </x-slot>
</x-layouts.app>
