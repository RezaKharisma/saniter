<x-layouts.app title="Semua Detail Absen">
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}" />
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi /</span> Semua Detail Absen</h4>

    <div class="row">
        <div class="col-12">
            <div class="col-12 mt-2">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">
                                Model 1
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">
                                Model 2
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false">
                                Custom
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                            <form method="POST" target="_blank" id="formFilter" action="{{ route('absen.pdf.model1') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <x-partials.label title="Nama Karyawan" />
                                        <select name="user_id" id="nama_karyawan" class="form-control" required>
                                            <option value="" selected disabled>Pilih nama karyawan...</option>
                                            @foreach ($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-12 mb-3">
                                        <x-partials.label title="Tahun" />
                                        <input type="number" class="form-control" name="tahun" placeholder="Tahun" autocomplete="off" required />
                                    </div>

                                    <div class="col-auto">
                                        <x-partials.label title="Export" /><br />
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#model1">
                                            <i class="bx bx-image"></i>
                                        </button>
                                        <div class="d-inline"><button type="submit" class="btn btn-secondary"><i class="bx bx-printer"></i></button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                            <form method="POST" target="_blank" id="formFilter" action="{{ route('absen.pdf.model2') }}">
                                @csrf

                                {{-- Tanggal --}}
                                <div class="row mb-2">
                                    <div class="col-12 col-sm-12 col-md-6 mb-3">
                                        <x-partials.label title="Tanggal Awal" />
                                        <input type="text" class="form-control" id="start_date_model2" name="start_date" onchange="tanggalAkhir2(this)" placeholder="Tanggal Mulai" autocomplete="off" />
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 mb-3">
                                        <x-partials.label title="Tanggal Akhir" />
                                        <input type="text" class="form-control" id="end_date_model2" name="end_date" placeholder="Tanggal Akhir" autocomplete="off" />
                                    </div>
                                    <div class="col-auto">
                                        <x-partials.label title="Export" /><br />
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#model2">
                                            <i class="bx bx-image"></i>
                                        </button>
                                        <div class="d-inline"><button type="submit" class="btn btn-secondary"><i class="bx bx-printer"></i></button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
                            {{-- Material --}}
                            <div class="row mb-2">
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <x-partials.label title="Nama Karyawan" />
                                    <select name="user_id" id="nama_karyawan_model2" class="form-control" required>
                                        <option value="" selected disabled>Pilih nama karyawan...</option>
                                        @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <x-partials.label title="Status" />
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
                                    <x-partials.label title="Tanggal Awal" />
                                    <input type="text" class="form-control" id="start_date" name="start_date" onchange="tanggalAkhir(this)" placeholder="Tanggal Mulai" autocomplete="off" />
                                </div>
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <x-partials.label title="Tanggal Akhir" />
                                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="Tanggal Akhir" autocomplete="off" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-auto">
                                    <x-partials.label title="Aksi" /><br />
                                    <div class="d-block">
                                        <button type="button" class="btn btn-primary filterDate" id="filterDate"><i class="bx bx-search"></i></button>
                                        <button type="button" class="btn btn-primary filterDate" id="resetFilter"><i class="bx bx-refresh"></i></button>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <x-partials.label title="Export" /><br />
                                    <div class="my-buttons d-inline"></div>
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

                        <div style="position: relative;">
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

    <div class="modal fade" id="model1" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalToggleLabel">Contoh Print Model 1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('assets/img/model-print/modelPrint1.png') }}" class="img-fluid" alt="Model Print 1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="model2" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalToggleLabel">Contoh Print Model 2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('assets/img/model-print/model2Absensi.png') }}" class="img-fluid" alt="Model Print 1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(document).ready(function () {
                $("#end_date_model2").prop('disabled', true);
                $("#end_date").prop('disabled', true);
                dataAbsen();

                $("#nama_karyawan").select2({
                    theme: "bootstrap-5",
                });

                $("#nama_karyawan_model2").select2({
                    theme: "bootstrap-5",
                });

                $("#start_date").datepicker({
                    dateFormat: "dd/mm/yy",
                });

                $("#end_date").datepicker({
                    dateFormat: "dd/mm/yy",
                });

                $("#start_date_model2").datepicker({
                    dateFormat: "dd/mm/yy",
                });

                $("#end_date_model2").datepicker({
                    dateFormat: "dd/mm/yy",
                });
            });

            $("#filterDate").on("click", function (e) {
                $("#tabel-log-absen").DataTable().destroy();
                dataAbsen();
            });

            $("#resetFilter").on("click", function (e) {
                $("#tabel-log-absen").DataTable().destroy();
                $('input[name="start_date"]').val(""), $('input[name="end_date"]').val("");
                dataAbsen();
            });

            function tanggalAkhir(e){
                $("#end_date").prop('disabled', false);
                $("#end_date").val("");

                var startTime = $("#start_date").val().split("/");
                var dateMulai = new Date(startTime[2], startTime[1] - 1, startTime[0])
                $("#end_date").datepicker("destroy");
                $("#end_date").datepicker({
                    dateFormat: 'dd/mm/yy',
                    minDate: dateMulai
                });
                $("#end_date").datepicker("refresh");
            }

            function tanggalAkhir2(e){
                $("#end_date_model2").prop('disabled', false);
                $("#end_date_model2").val("");

                var startTime = $("#start_date_model2").val().split("/");
                var dateMulai = new Date(startTime[2], startTime[1] - 1, startTime[0])
                $("#end_date_model2").datepicker("destroy");
                $("#end_date_model2").datepicker({
                    dateFormat: 'dd/mm/yy',
                    minDate: dateMulai
                });
                $("#end_date_model2").datepicker("refresh");
            }

            function dataAbsen() {
                new DataTable("#tabel-log-absen", {
                    ajax: {
                        type: "POST",
                        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                        url: "{{ route('ajax.getAbsenAllDetail') }}",
                        data: {
                            start_date: $('input[name="start_date"]').val(),
                            end_date: $('input[name="end_date"]').val(),
                            user_id: $("#nama_karyawan_model2").val(),
                            status: $('select[name="status"]').val(),
                        },
                    },
                    processing: true,
                    // serverSide: true,
                    columns: [
                        { data: "DT_RowIndex", name: "DT_RowIndex", searchable: false },
                        { data: "nama", name: "nama" },
                        { data: "foto", name: "foto" },
                        { data: "tanggalAbsen", name: "tanggalAbsen" },
                        { data: "shift", name: "shift" },
                        { data: "jamMasuk", name: "jamMasuk" },
                        { data: "jamPulang", name: "jamPulang" },
                        { data: "status", name: "status" },
                    ],
                    dom: "lBfrtip",
                    buttons: [
                        {
                            extend: "print",
                            text: "<i class='bx bx-printer'></i>",
                            orientation: "landscape",
                            exportOptions: {
                                columns: [0, 1, 3, 4, 5, 6, 7],
                                page: "all",
                            },
                            customize: function (win) {
                                var last = null;
                                var current = null;
                                var bod = [];

                                var css = "@page { size: landscape; }",
                                    head = win.document.head || win.document.getElementsByTagName("head")[0],
                                    style = win.document.createElement("style");

                                style.type = "text/css";
                                style.media = "print";

                                if (style.styleSheet) {
                                    style.styleSheet.cssText = css;
                                } else {
                                    style.appendChild(win.document.createTextNode(css));
                                }

                                head.appendChild(style);

                                $(win.document.body).find("title").css("text-align", "center").css("font-size", "5px");

                                $(win.document.body).find("table").addClass("text-nowrap").css("width", "100%");
                            },
                        },
                        // 'excel', 'pdf', 'print'
                    ],
                })
                    .buttons()
                    .container()
                    .appendTo(".my-buttons");
            }
        </script>
    </x-slot>
</x-layouts.app>
