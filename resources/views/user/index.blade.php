<x-layouts.app title="User">
    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi /</span> User</h4>

    @can('user_create')
        <a href="{{ route('user.create') }}" class="mb-3 btn btn-primary"><i class="bx bx-plus"></i> Tambah User</a>
    @endcan

    <div class="card">
        <h5 class="card-header mb-3">Data User</h5>

        <div style="position: relative">
            <div class="table-responsive text-nowrap">
                <table class="table table-hover nowrap" id="user-table" width="100%">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Regional</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </thead>

                    <tfoot>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Role</th>
                        <th>Regional</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div id="modalDetailUser"></div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Datatables
                $('#user-table').DataTable({
                    ajax: {
                        method: "POST",
                        url: "{{ route('ajax.getUser') }}"
                    },
                    processing: true,
                    serverSide: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'name', name: 'name'},
                        {data: 'roles_name', name: 'roles_name'},
                        {data: 'regional_name', name: 'regional_name'},
                        {data: 'is_active', name: 'is_active'},
                        {data: 'action', name: 'action'},
                    ],
                })

                $("#path").change(function () {
                    const file = this.files[0];
                    console.log(file);
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#imagePreview").attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });

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

                // Jika tombol delete diklik
                $(document).on("click", "button.confirm-edit-is-active", function () {
                    var form = $(this).closest("form");
                    event.preventDefault();
                    Swal.fire({ // SweetAlert
                        title: "Apa kamu yakin?",
                        text: "Mengubah status aktif user?",
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
        <script>
            // Ketika tombol edit diklik
            function detailData(e){
                // Mengatur ajax csrf
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.getUserDetail') }}",
                    data: {
                        id: e.dataset.id // Mengambil id pada event
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        $('#modalDetailUser').html('');
                        $('#modalDetailUser').html(response.modal);
                        $('#detailUser').modal('show');
                    }
                });
            }
        </script>
    </x-slot>

</x-layouts.app>
