<x-layouts.app title="Shift">

    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan /</span> Shift</h4>

    @can('shift_create')
        <a href="{{ route('shift.create') }}" class="mb-3 btn btn-primary"><i class="bx bx-plus"></i> Tambah Shift</a>
    @endcan

    <!-- Striped Rows -->
    <div class="card">
        <h5 class="card-header mb-3">Data Shift</h5>

            <div style="position: relative">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover" id="tabel-shift" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Regional</th>
                                <th>Nama</th>
                                <th>Timezone</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Potongan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Regional</th>
                                <th>Nama</th>
                                <th>Timezone</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Potongan</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $('#tabel-shift').DataTable({
                    ajax: "{{ route('ajax.getShift') }}",
                    processing: true,
                    // serverSide: true,
                    columns:[
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'regionalNama', name: 'regionalNama'},
                        {data: 'nama', name: 'nama'},
                        {data: 'timezone', name: 'timezone'},
                        {data: 'jam_masuk', name: 'jam_masuk'},
                        {data: 'jam_pulang', name: 'jam_pulang'},
                        {data: 'potongan', name: 'potongan'},
                        {data: 'action', name: 'action', searchable: false, orderable: false},
                    ],
                    rowGroup: {
                        dataSrc: 'regionalNama'
                    },
                    columnDefs: [
                    {
                        target: 1,
                        visible: false,
                        searchable: false
                    }]
                });

                $("#jam_masuk").flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    defaultDate: "00:00"
                });

                $("#jam_pulang").flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    defaultDate: "00:00"
                });
            });
        </script>

        <script>
            $(document).ready(function () {
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
