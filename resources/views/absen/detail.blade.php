<x-layouts.app title="Detail Absen">

    <x-slot name="style">
        <style>
            @media only screen and (min-width: 767px) {
                .h100{
                    height: 100% !important;
                }
            }
            @media only screen and (min-width: 992px) {
                .h100{
                    height: auto !important;
                }
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi / </span> Detail</h4>
    <div class="row">
        <div class="col-12">
            {{-- Menu --}}
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    {{-- Jika request url adalah url yg di tentukan, set class active --}}
                    <a class="btn btn-secondary" href="{{ route('absen.index') }}"> <i class="bx bx-left-arrow-alt me-1"></i> Kembali </a>
                </li>
            </ul>

            <div class="row mb-0">
                <div class="col-md-6 col-lg-8 col-xl-9 mb-sm-3 mb-md-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start p-0">
                                                <div>
                                                    <h3 class="mb-1">{{ $countIzin }}</h3>
                                                    <p class="mb-0">Izin</p>
                                                </div>
                                                <span class="badge bg-label-secondary rounded p-2 mt-2">
                                                    <i class="bx bx-file bx-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start p-0">
                                                <div>
                                                    <h3 class="mb-1">{{ $countCuti }}</h3>
                                                    <p class="mb-0">Cuti</p>
                                                </div>
                                                <span class="badge bg-label-secondary rounded p-2 mt-2">
                                                    <i class="bx bx-timer bx-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start p-0">
                                                <div>
                                                    <h3 class="mb-1">{{ $countSakit }}</h3>
                                                    <p class="mb-0">Sakit</p>
                                                </div>
                                                <span class="badge bg-label-secondary rounded p-2 mt-2">
                                                    <i class="bx bx-capsule bx-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-sm-6 col-md-6 col-lg-3 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start p-0">
                                                <div>
                                                    <h3 class="mb-1">{{ $countAlfa }}</h3>
                                                    <p class="mb-0">Alfa</p>
                                                </div>
                                                <span class="badge bg-label-secondary rounded p-2 mt-2">
                                                    <i class="bx bx-calendar-x bx-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-5 mb-3 mb-sm-3 mb-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="card-info">
                                            <p class="card-text">Total Pemotongan</p>
                                            <div class="d-flex align-items-end mb-2">
                                                <h4 class="card-title mb-0 me-2">Rp. {{ number_format($countPemotongan['total'], 0 ,'','.') }}</h4>
                                            </div>
                                            <small>Pemotongan bulan {{ Carbon\Carbon::now()->isoFormat('MMMM') }}.</small>
                                        </div>
                                        <div class="card-icon">
                                            <span class="badge bg-label-danger rounded p-2">
                                                <i class="bx bx-dollar bx-sm"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7 mb-3 mb-sm-0 mb-md-0 h-100">
                            <div class="row">
                                <div class="col-4">
                                    <div class="card">
                                        {{-- <div class="card-header"> --}}
                                            <span class="avatar-initial rounded bg-label-primary text-center pt-2 pb-2" style="border-bottom-left-radius: 0px !important;border-bottom-right-radius: 0px !important">
                                                <i class="bx bx-time text-center d-block"></i>
                                                {{ $countPemotongan['waktu_1'] }} Menit
                                            </span>
                                        {{-- </div> --}}
                                        <div class="card-body text-center">
                                            <h5>{{ $countPemotongan['terlambat_1'] }}x</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <span class="avatar-initial rounded bg-label-warning text-center pt-2 pb-2" style="border-bottom-left-radius: 0px !important;border-bottom-right-radius: 0px !important">
                                            <i class="bx bx-time text-center d-block"></i>
                                            {{ $countPemotongan['waktu_2'] }} Menit
                                        </span>
                                        <div class="card-body text-center">
                                            <h5>{{ $countPemotongan['terlambat_2'] }}x</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card">
                                        <span class="avatar-initial rounded bg-label-danger text-center pt-2 pb-2" style="border-bottom-left-radius: 0px !important;border-bottom-right-radius: 0px !important">
                                            <i class="bx bx-time text-center d-block"></i>
                                            {{ $countPemotongan['waktu_3'] }} Menit
                                        </span>
                                        <div class="card-body text-center">
                                            <h5>{{ $countPemotongan['terlambat_3'] }}x</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 col-xl-3 mb-sm-2">
                    <div class="card h100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="card-title mb-1">
                                <h5 class="mb-0 me-2">Peraturan Pemotongan</h5>
                                <small class="text-muted">Pemotongan keterlambatan absen.</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="p-0 mb-0">
                                <li class="d-flex mb-2 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class="bx bx-time"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-1 fw-normal">Lebih 20 Menit</h6>
                                        </div>
                                        <div class="user-progress">
                                            <h6 class="mb-0">10k</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-2 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-warning">
                                            <i class="bx bx-time"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-1 fw-normal">Lebih 40 Menit</h6>
                                        </div>
                                        <div class="user-progress">
                                            <h6 class="mb-0">25k</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-danger">
                                            <i class="bx bx-time"></i>
                                        </span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-1 fw-normal">Lebih 60 Menit</h6>
                                        </div>
                                        <div class="user-progress">
                                            <h6 class="mb-0">50k</h6>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-0">
                <h5 class="card-header mb-3">Laporan Absen</h5>
                <div class="card-body justify-content-between d-flex mb-2">
                    <select name="bulan" id="bulan" class="form-control">
                        <option value="" selected disabled>Pilih bulan...</option>
                        @foreach ($namaBulan as $key => $b)
                            <option value="{{ $key+1 }}">{{ $b }}</option>
                        @endforeach
                    </select>

                    <input type="number" class="form-control ms-2" id="tahun" name="tahun" placeholder="Tahun" autocomplete="off" required />

                    <button class="btn btn-primary btn-sm d-inline ms-2" id="btnSearchBulan"><i class="bx bx-search"></i></button>
                    <button class="btn btn-primary btn-sm d-inline ms-1" id="btnRefresh"><i class="bx bx-refresh"></i></button>
                </div>
                <div style="position: relative;">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover" id="tabel-log-absen" width="100%">
                            <thead>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Waktu Terlambat</th>
                                <th>Status</th>
                            </thead>
                            <tfoot>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Waktu Terlambat</th>
                                <th>Status</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            $(document).ready(function () {

                loadTable();

                $("#bulan").select2({
                    theme: "bootstrap-5",
                });

            });

            $('#btnSearchBulan').on('click', function () {
                $("#tabel-log-absen").DataTable().destroy();
                loadTable();
            });

            $('#btnRefresh').on('click', function () {
                $('select[name="bulan"]').val('').trigger('change');
                $("#tabel-log-absen").DataTable().destroy();
                loadTable();
            })

            function loadTable(){
                $("#tabel-log-absen").DataTable({
                    ajax: {
                        type: "POST",
                        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                        url: "{{ route('ajax.getAbsenDetail') }}",
                        data: {
                            bulan: $('select[name="bulan"]').val(),
                            tahun: $('#tahun').val(),
                        },
                    },
                    processing: true,
                    serverSide: true,
                    searching: true,
                    lengthChange: true,
                    paging: true,
                    info: true,
                    columns: [
                        {
                            data: "DT_RowIndex",
                            name: "DT_RowIndex",
                            searchable: false,
                        },
                        {
                            data: "foto",
                            name: "foto",
                        },
                        {
                            data: "tanggalAbsen",
                            name: "tanggalAbsen",
                        },
                        {
                            data: "shift",
                            name: "shift",
                        },
                        {
                            data: "jamMasuk",
                            name: "jamMasuk",
                        },
                        {
                            data: "jamPulang",
                            name: "jamPulang",
                        },
                        {
                            data: "selisihTerlambat",
                            name: "selisihTerlambat",
                        },
                        {
                            data: "status",
                            name: "status",
                        },
                    ],
                });
            }
        </script>
    </x-slot>
</x-layouts.app>
