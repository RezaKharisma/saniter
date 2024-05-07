<x-layouts.app title="Absen">

    <?php
        date_default_timezone_set($regional->timezone);
    ?>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi /</span> Absen</h4>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card mb-3 ">
                <div class="card-body mt-2">
                    <div class="row justify-content-center text-center">
                        <div class="col-12">
                            <div class="alert alert-secondary p-5" role="alert">
                                <h2 class="card-title">
                                    <div id="clock" class="text-primary"></div>
                                </h2>
                                <p class="card-text">{{ $timezone->isoFormat('dddd, D MMMM Y'); }}</p>
                                <a href="{{ route('absen.create') }}" class="btn btn-primary btn-block btn-lg w-100 mt-3">Absen</a>
                            </div>
                        </div>
                        <div class="col-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Sisa Cuti</h5>
                                    <span class="badge bg-label-warning rounded-pill">Tahun {{ Carbon\Carbon::now()->isoFormat('Y') }}</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ $countJumlahIzin->jumlah_izin ?? '0' }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Total Kehadiran</h5>
                                    <span class="badge bg-label-info rounded-pill">Bulan {{ Carbon\Carbon::now()->isoFormat('MMMM') }}</span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ $countKehadiranPerBulan }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-2">Pengajuan</h5>
                            <p class="card-text text-center mb-4">Ajukan cuti ataupun izin.</p>
                            <div class="d-block d-flex justify-content-center">
                                <a href="{{ route('izin.create') }}" class="btn btn-warning d-block w-100">Ajukan</a>
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
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Log Absen
                    <div>
                        <a class="btn btn-info btn-sm" href="{{ route('absen.detail') }}">Detail</a>
                    </div>
                </h5>
                <div style="position: relative">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover" id="tabel-log-absen" width="100%" style="margin-top: -40px !important;margin-bottom: -20px !important">
                            <thead>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Waktu Terlambat</th>
                            </thead>

                            <tfoot>
                                <th>Tanggal</th>
                                <th>Shift</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Waktu Terlambat</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function(){
                // Fungsi live jam
                setInterval('updateClock()', 1000);

                $('#tabel-log-absen').DataTable({
                    ajax: "{{ route('ajax.getAbsenLog') }}",
                    processing: true,
                    serverSide: true,
                    searching: false,
                    lengthChange: false,
                    paging: false,
                    info: false,
                    ordering: false,
                    columns: [
                        {data: 'tanggalAbsen', name: 'tanggalAbsen'},
                        {data: 'shift', name: 'shift'},
                        {data: 'jamMasuk', name: 'jamMasuk'},
                        {data: 'jamPulang', name: 'jamPulang'},
                        {data: 'selisihTerlambat', name: 'selisihTerlambat'},
                    ],
                    columnDefs: [
                    {
                        target: 0,
                        searchable: false
                    }],
                    order: [
                        [ 0, "DESC" ]
                    ]
                });
            });
        </script>

        <script>
            // Fungsi live jam
            function updateClock (){
                // Get date dan pisahkan jam, menit, detik
                var timeZone = new Date( );
                var tzOffset = timeZone.toLocaleString('en-US', {timeZone: "{{ $regional->timezone }}"});

                var currentTime = new Date(tzOffset);
                var currentHours = currentTime.getHours ( );
                var currentMinutes = currentTime.getMinutes ( );
                var currentSeconds = currentTime.getSeconds ( );


                // Pad the minutes and seconds with leading zeros, if required
                currentHours = ( currentHours < 10 ? "0" : "" ) + currentHours;
                currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
                currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

                // Choose either "AM" or "PM" as appropriate
                var timeOfDay = ( currentHours < 11 ) ? "Pagi" : (currentHours < 15) ? "Siang" : (currentHours < 18) ? "Sore" : "Malam";

                // Compose the string for display
                var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

                $("#clock").html(currentTimeString);
            }
        </script>
    </x-slot>

</x-layouts.app>
