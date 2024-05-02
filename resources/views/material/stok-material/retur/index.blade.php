<x-layouts.app title="Pengajuan Stok Material">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material / </span>Retur</h4>

    <div class="alert bg-danger w-100 text-white text-center">PENDING</div>

    <!-- Striped Rows -->
    <div class="card">
        <h5 class="card-header mb-3">Data Retur Material</h5>
        <div style="position: relative">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover" id="retur-table" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <th>#</th>
                            <th>Kode Material</th>
                            <th>Nama Material</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                            <th>Dibuat Oleh</th>
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
                $('#retur-table').DataTable({
                    ajax: "{{ route('ajax.getRetur') }}",
                    processing: true,
                    // serverSide: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'kode_material', name: 'kode_material'},
                        {data: 'nama_material', name: 'nama_material'},
                        {data: 'status', name: 'status'},
                        {data: 'keterangan', name: 'keterangan'},
                        {data: 'jumlah', name: 'jumlah'},
                        {data: 'created_by', name: 'created_by'},
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
