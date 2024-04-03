<x-layouts.app title="Pengaturan">
<h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Izin /</span> Setting Jumlah Izin Teknisi</h5>

<div class="row">
    <div class="col-md-12">

    <div class="alert alert-warning alertRegional" role="alert">Pilih regional terlebih dahulu untuk melihat data!</div>

    <ul class="nav nav-pills flex-md-row mb-3">
        @foreach ($regional as $item)
            <li class="nav-item">
                <a class="nav-link btn-regional" href="#" data-id="{{ $item->id }}" onclick="getIzin(this)"><i class="bx bx-plus-circle me-1"></i> Regional {{ $item->nama }}</a>
            </li>
        @endforeach
    </ul>
        <div class="card mb-4">
            <h5 class="card-header">
                Jumlah Izin
            </h5>

            <div class="card-body">
            <a href="{{ route('pengaturan.izin.create') }}" class="mb-4 btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Jumlah Izin
            </a>
                <table class="table table-hover" id="izin-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah Izin</th>
                            <th>aksi</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jumlah Izin</th>
                            <th>aksi</th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalIzinEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <form method="POST" class="d-inline" id="formEdit">
        @csrf
        @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Update Jumlah Izin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Jumlah Izin</label>
                        <input type="text" name="jumlahIzinEdit" id="jumlahIzinEdit" class="form-control" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" />
                        <x-partials.error-message name="jumlahIzinEdit" />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>

<x-slot name="script">
    <script>
        var tableIzin;
        $(document).ready(function () {
            tableIzin = $('#izin-table').DataTable();
        });

        // Fungsi mengambil jumlah izin user sesuai regional
        function getIzin(e){
            $(".alertRegional").addClass('d-none');
            // Menghapus seluruh btn-regional yg memiliki class active
            $('.btn-regional').removeClass('active');

            // Menambah class active pada btn regional yg dipilih
            $(e).addClass('active');

            // Mengatur ajax csrf
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "{{ route('ajax.getJumlahIzin') }}",
                data: {
                    id: e.dataset.id // Mengambil id pada event
                },
                dataType: "json",
                success: function (response) { // Jika ajax sukses dan memberikan respon
                    // Reload table
                    if (tableIzin != undefined) {
                        tableIzin.clear().destroy();
                    };

                    // Datatables
                    tableIzin = $('#izin-table').DataTable({
                        responsive: true,
                        data: response.data,
                        columns: [
                            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                            {data: 'name'},
                            {data: 'jumlah_izin'},
                            {data: 'action', searchable: false , orderable: false}
                        ],
                    })
                }
            });
        }

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
                url: "{{ route('ajax.getJumlahIzinEdit') }}",
                data: {
                    id: e.dataset.id // Mengambil id pada event
                },
                dataType: "json",
                success: function (response) { // Jika ajax sukses dan memberikan respon
                    var jumlahIzin = response.data;
                    var url = "{{ route('pengaturan.izin.update', ':id') }}"; // Action pada form edit
                    url = url.replace(':id', jumlahIzin.id );
                    $("#formEdit")[0].reset();
                    $('#formEdit').attr('action', url);
                    $('#jumlahIzinEdit').val(jumlahIzin.jumlah_izin);
                }
            });
        }

        // Reset is-invalid form validation
        function resetFormValidation(){
            $(".is-invalid").removeClass("is-invalid")
            $(".invalid-feedback").addClass("d-none")
        }
    </script>

    {{-- Jika terdapat session dengan nama modalEdit, untuk validasi popup otomatis --}}
    @if (Session::has('modalEdit'))
    <script>
        $(document).ready(function () {
            $('#modalEditMenu').modal('show')
        });
    </script>
@endif
</x-slot>

</x-layouts.app>
