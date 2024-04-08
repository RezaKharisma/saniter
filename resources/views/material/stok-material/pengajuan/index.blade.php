<x-layouts.app title="Pengajuan Stok Material">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material / </span>Tambah Stok Material</h4>

    @can('stok material pengajuan_create')
    <ul class="nav nav-pills flex-md-row mb-3">
        <li class="nav-item">
            <a href="{{ route('stok-material.pengajuan.create') }}" class="nav-link btn btn-primary active"><i class="bx bx-plus"></i> Tambah Stok Material</a>
        </li>
    </ul>
    @endcan

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
                        <th>Stok Masuk</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <th>#</th>
                        <th>Kode Material</th>
                        <th>Nama Material</th>
                        <th>Stok Masuk</th>
                        <th>Status</th>
                        <th>Dibuat Oleh</th>
                        <th>Aksi</th>
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
                    ajax: "{{ route('ajax.getPengajuanStokMaterial') }}",
                    processing: true,
                    // serverSide: true,
                    responsive: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'kode_material', name: 'kode_material'},
                        {data: 'nama_material', name: 'nama_material'},
                        {data: 'masuk', name: 'masuk'},
                        {data: 'status', name: 'status'},
                        {data: 'oleh', name: 'oleh'},
                        {data: 'action', name: 'action'},
                    ],
                    columnDefs: [
                        {targets: [3,4,5], className: 'text-center'}
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
