<x-layouts.app title="Absen">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi /</span> Absen</h4>

    <div class="row">
        <div class="col-12">

            <div class="card mb-3">
                <div class="card-body mt-2">
                    <div class="row justify-content-center text-center">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                            <div class="alert alert-secondary p-5" role="alert">
                                <h2 class="card-title">
                                    <div id="clock" class="text-primary"></div>
                                </h2>
                                <p class="card-text">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y'); }}</p>
                                <a href="{{ route('absen.create') }}" class="btn btn-primary btn-block btn-lg w-100 mt-3">Absen</a>
                            </div>
                        </div>
                        <div class="col-12">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Log Absen
                    <a class="btn btn-info btn-sm" href="{{ route('absen.detail') }}">Detail</a>
                </h5>
                <div class="card-body">
                    <table class="table table-hover table-responsive" id="tabel-log-absen">
                        <thead>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                        </thead>

                        <tfoot>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                        </tfoot>
                    </table>
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
                    responsive: true,
                    searching: false,
                    lengthChange: false,
                    paging: false,
                    info: false,
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'tanggalAbsen', name: 'tanggalAbsen'},
                        {data: 'jamMasuk', name: 'jamMasuk'},
                        {data: 'jamPulang', name: 'jamPulang'},
                    ],
                    columnDefs: [
                    {
                        target: 0,
                        visible: false,
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
                var currentTime = new Date( );
                var currentHours = currentTime.getHours ( );
                var currentMinutes = currentTime.getMinutes ( );
                var currentSeconds = currentTime.getSeconds ( );

                // Pad the minutes and seconds with leading zeros, if required
                currentHours = ( currentHours < 10 ? "0" : "" ) + currentHours;
                currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
                currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

                // Choose either "AM" or "PM" as appropriate
                var timeOfDay = ( currentHours < 11 ) ? "Pagi" : (currentHours < 15) ? "Siang" : (currentHours < 18) ? "Sore" : "Malam";

                // Convert the hours component to 12-hour format if needed
                currentHours = ( currentHours > 24 ) ? currentHours - 24 : currentHours;

                // Convert an hours component of "0" to "12"
                currentHours = ( currentHours == 0 ) ? 12 : currentHours;

                // Compose the string for display
                var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;

                $("#clock").html(currentTimeString);
            }
        </script>
    </x-slot>

</x-layouts.app>
