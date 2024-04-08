<x-layouts.app title="List Stok Material">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material / </span>Stok Material</h4>

    <!-- Striped Rows -->
    <div class="card">
        <h5 class="card-header">Data Stok Material</h5>
        <div class="card-body">
            <table class=" table-responsive table table-hover" id="stok-material-table" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Tanggal Input</th>
                        {{-- <th>Diterima Oleh</th> --}}
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th>#</th>
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Tanggal Input</th>
                        {{-- <th>Diterima Oleh</th> --}}
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // Datatables
                $('#stok-material-table').DataTable({
                    ajax: "{{ route('ajax.getListStokMaterial') }}",
                    processing: true,
                    // serverSide: true,
                    responsive: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'kode_material', name: 'kode_material'},
                        {data: 'nama_material', name: 'nama_material'},
                        {data: 'masuk', name: 'masuk'},
                        {data: 'harga', name: 'harga'},
                        {data: 'tgl_input', name: 'tgl_input'},
                        // {data: 'action', name: 'action'},
                    ],
                    columnDefs: [
                        {targets: [3,5], className: 'text-center'}
                    ]
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
