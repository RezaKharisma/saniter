<x-layouts.app title="Semua Detail Absen">

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}">
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi /</span> Semua Detail Absen</h4>

    <div class="row">
        <div class="col-12">

            {{-- Menu --}}
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    {{-- Jika request url adalah url yg di tentukan, set class active --}}
                    <a class="btn btn-secondary" href="{{ route('absen.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
                </li>
            </ul>

            <div class="row mb-3">
                <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3 mb-md-3">
                    <div class="card">
                        <h6 class="card-header">Model 1</h6>
                        <div class="card-body">
                            <form method="POST" target="_blank" id="formFilter" action="{{ route('absen.pdf') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <x-partials.label title="Nama Karyawan"/>
                                        <input type="text" class="form-control" name="thn_nama_karyawan" placeholder="Nama Karyawan" autocomplete="off"/>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <x-partials.label title="Status"/>
                                        <select name="thn_status" class="form-control">
                                            <option value="" selected disabled>Pilih status...</option>
                                            <option value="Normal">Normal</option>
                                            <option value="Terlambat">Terlambat</option>
                                            <option value="Alfa">Alfa</option>
                                            <option value="Cuti">Cuti</option>
                                            <option value="Izin">Izin</option>
                                            <option value="Sakit">Sakit</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-6 mb-3">
                                        <x-partials.label title="Tanggal Mulai"/>
                                        <input type="text" class="form-control" id="thn_start_date" name="thn_start_date" placeholder="Tanggal Mulai" autocomplete="off"/>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 mb-3">
                                        <x-partials.label title="Tanggal Akhir"/>
                                        <input type="text" class="form-control" id="thn_end_date" name="thn_end_date"  placeholder="Tanggal Akhir" autocomplete="off"/>
                                    </div>
                                    <div class="col-auto">
                                        <x-partials.label title="Export"/><br/>
                                        <div class="d-inline"><button type="submit" class="btn btn-secondary">Print</button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12">
                    <div class="card">
                        <h6 class="card-header">Model 2</h6>
                        <div class="card-body">
                            {{-- Material --}}
                            <div class="row mb-2">
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <x-partials.label title="Nama Karyawan"/>
                                    <input type="text" class="form-control" name="nama_karyawan" placeholder="Nama Karyawan" autocomplete="off"/>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <x-partials.label title="Status"/>
                                    <select name="status" id="status" class="form-control">
                                        <option value="" selected disabled>Pilih status...</option>
                                        <option value="Normal">Normal</option>
                                        <option value="Terlambat">Terlambat</option>
                                        <option value="Alfa">Alfa</option>
                                        <option value="Cuti">Cuti</option>
                                        <option value="Izin">Izin</option>
                                        <option value="Sakit">Sakit</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div class="row mb-2">
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <x-partials.label title="Tanggal Mulai"/>
                                    <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Tanggal Mulai" autocomplete="off"/>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <x-partials.label title="Tanggal Akhir"/>
                                    <input type="text" class="form-control" id="end_date" name="end_date"  placeholder="Tanggal Akhir" autocomplete="off"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-auto">
                                    <x-partials.label title="Export"/><br/>
                                    <div class="my-buttons d-inline"></div>
                                </div>
                                <div class="col-auto">
                                    <x-partials.label title="Aksi"/><br/>
                                    <div class="d-block">
                                        <button type="button" class="btn btn-primary filterDate" id="filterDate"><i class="bx bx-search"></i></button>
                                        <button type="button" class="btn btn-primary filterDate" id="resetFilter"><i class="bx bx-refresh"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header mb-3">Laporan Semua Absen</h5>

                        <div style="position: relative">
                            <div class="table-responsive">
                                <table class="table table-hover" id="tabel-log-absen" width="100%">
                                    <thead>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Foto</th>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                    </thead>

                                    <tfoot>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Foto</th>
                                        <th>Tanggal</th>
                                        <th>Shift</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        <th>Status</th>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(document).ready(function(){
                dataAbsen();

                $("#start_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                });

                $("#end_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                });
            });

            $('#filterDate').on('click', function (e) {
                $('#tabel-log-absen').DataTable().destroy();
                dataAbsen();
            })

            $('#resetFilter').on('click', function (e) {
                $('#tabel-log-absen').DataTable().destroy();
                $('input[name="start_date"]').val(''),
                $('input[name="end_date"]').val('')
                dataAbsen();
            })

            function dataAbsen(){
                new DataTable('#tabel-log-absen',{
                    ajax: {
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('ajax.getAbsenAllDetail') }}",
                        data: {
                            start_date: $('input[name="start_date"]').val(),
                            end_date: $('input[name="end_date"]').val(),
                            nama_karyawan: $('input[name="nama_karyawan"]').val(),
                            status: $('select[name="status"]').val()
                        }
                    },
                    processing: true,
                    // serverSide: true,
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                        {data: 'nama', name: 'nama'},
                        {data: 'foto', name: 'foto'},
                        {data: 'tanggalAbsen', name: 'tanggalAbsen'},
                        {data: 'shift', name: 'shift'},
                        {data: 'jamMasuk', name: 'jamMasuk'},
                        {data: 'jamPulang', name: 'jamPulang'},
                        {data: 'status', name: 'status'},
                    ],
                    dom:'lBfrtip',
                    buttons: [
                        {
                            extend: 'print',
                            text: 'Print 1',
                            orientation: 'landscape',
                            exportOptions: {
                                columns: [0,1,3,4,5,6,7],
                                page: 'all'
                            },
                            customize: function (win) {
                                var last = null;
                                var current = null;
                                var bod = [];

                                var css = '@page { size: landscape; }',
                                    head = win.document.head || win.document.getElementsByTagName('head')[0],
                                    style = win.document.createElement('style');

                                style.type = 'text/css';
                                style.media = 'print';

                                if (style.styleSheet)
                                {
                                style.styleSheet.cssText = css;
                                }
                                else
                                {
                                style.appendChild(win.document.createTextNode(css));
                                }

                                head.appendChild(style);

                                $(win.document.body)
                                    .find('title')
                                    .css('text-align', 'center')
                                    .css('font-size', '5px');

                                $(win.document.body)
                                    .find('table')
                                    .addClass('text-nowrap')
                                    .css('width', '100%');
                            }
                        }
                        // 'excel', 'pdf', 'print'
                    ],
                }).buttons().container().appendTo('.my-buttons');
            }

            function printPDF(){
                var url = "{{ route('absen.pdf') }}"; // Action pada form edit
                $('#formFilter').attr('action', url);
                $('#formFilter').submit()


                // // Mengatur ajax csrf
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });

                // $.ajax({
                //     type: "POST",
                //     url: "{{ route('absen.pdf') }}",
                //     data: {
                //         start_date: $('input[name="start_date"]').val(),
                //         end_date: $('input[name="end_date"]').val(),
                //         nama_karyawan: $('input[name="nama_karyawan"]').val(),
                //         status: $('select[name="status"]').val()
                //     },
                //     success: function(){
                //         window.open("{{ route('absen.pdf') }}", '_blank');
                //     }
                // });
            }
        </script>
    </x-slot>

</x-layouts.app>
