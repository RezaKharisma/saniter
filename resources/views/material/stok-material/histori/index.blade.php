<x-layouts.app title="Histori Penggunaan Material">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material / </span>Histori Penggunaan Material</h4>

    <ul class="nav nav-pills flex-md-row mb-3 ">
        <li class="nav-item">
            <a href="{{ route('stok-material.log-histori.index') }}" class="btn btn-secondary active">Log Update</a>
        </li>
    </ul>

    <!-- Striped Rows -->
    <div class="card">
        <h5 class="card-header mb-3">Data Histori Penggunaan Material</h5>
        <div style="position: relative">
            <div class="table-responsive">
                <table class="table table-hover" id="stok-material-table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Material</th>
                            <th>Jenis Kerusakan</th>
                            <th>Volume</th>
                            <th>Harga</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Material</th>
                            <th>Jenis Kerusakan</th>
                            <th>Volume</th>
                            <th>Harga</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // Datatables
                $('#stok-material-table').DataTable({
                    ajax: "{{ route('ajax.getHistoriStokMaterial') }}",
                    processing: true,
                    serverSide: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'stok_material', name: 'stok_material'},
                        {data: 'jenis_kerusakan', name: 'jenis_kerusakan'},
                        {data: 'volume', name: 'volume'},
                        {data: 'total_harga', name: 'total_harga'},
                        {data: 'tanggal', name: 'tanggal'},
                        {data: 'action', name: 'action'},
                    ],
                    columnDefs: [
                        {targets: [3], className: 'text-center'}
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
