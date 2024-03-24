<x-layouts.app title="Absen">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi /</span> Absen</h4>

    <div class="row d-flex justify-content-center text-center mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body mt-2">
                    <div class="row justify-content-center ">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-5">
                            <div class="alert alert-secondary p-5" role="alert">
                                <h2 class="card-title">
                                    <div id="clock" class="text-primary"></div>
                                </h2>
                                <p class="card-text">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y'); }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body mb-0" style="margin-bottom: -30px !important">
                    <p class="mb-3">Jadwal Anda :</p>
                    <h4 class="mb-2">Shift Pagi</h4>
                    <h2>09:00 - 13:00</h2>
                </div>
                <div class="card-body mt-0">
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary btn-block btn-lg w-100" style="text-align: center">
                                <small class="d-block mb-2 text-light fw-medium">Absen Masuk</small>
                                Belum Absen
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary btn-block btn-lg w-100 disabled" style="text-align: center">
                                <small class="d-block mb-2 text-light fw-medium ">Absen Pulang</small>
                                Belum Absen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    Log Absen
                </div>
                <div class="card-body">
                    <table class="table table-striped ">
                        <td>
                            <td></td>
                        </td>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function(){
                setInterval('updateClock()', 1000);
            });

            function updateClock (){
                var currentTime = new Date( );
                var currentHours = currentTime.getHours ( );
                var currentMinutes = currentTime.getMinutes ( );
                var currentSeconds = currentTime.getSeconds ( );

                // Pad the minutes and seconds with leading zeros, if required
                currentMinutes = ( currentMinutes < 10 ? "0" : "" ) + currentMinutes;
                currentSeconds = ( currentSeconds < 10 ? "0" : "" ) + currentSeconds;

                // Choose either "AM" or "PM" as appropriate
                var timeOfDay = ( currentHours < 11 ) ? "Pagi" : (currentHours < 15) ? "Siang" : (currentHours < 18) ? "Sore" : "Malam";

                // Convert the hours component to 12-hour format if needed
                currentHours = ( currentHours > 12 ) ? currentHours - 12 : currentHours;

                // Convert an hours component of "0" to "12"
                currentHours = ( currentHours == 0 ) ? 12 : currentHours;

                // Compose the string for display
                var currentTimeString = currentHours + ":" + currentMinutes + ":" + currentSeconds + " " + timeOfDay;


                $("#clock").html(currentTimeString);
            }
        </script>
    </x-slot>
</x-layouts.app>
