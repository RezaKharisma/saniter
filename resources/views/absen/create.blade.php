<x-layouts.app title="Absen">

    <x-slot name="style">
        <style>
            #my_camera {
                width: 100% !important;
                height: auto !important;
            }

            #my_camera video {
                width: 100% !important;
                height: auto !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi / Absen /</span> Proses</h4>

    <div class="row d-flex justify-content-center text-center mb-4">
        <div class="col-12">
            <div class="card">

                {{-- Form Absen --}}
                <form action="{{ route('absen.store') }}" method="post" id="formAbsen" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="image" class="image-tag">
                    <input type="hidden" name="kategori" id="kategori">
                    <input type="hidden" name="lokasi_id" value="{{ $lokasiUser->lokasi_id }}">
                    <input type="hidden" name="lokasi_proyek" value="{{ $lokasiUser->lokasi_proyek }}">
                    <input type="hidden" name="latitude" id="latitudeUser">
                    <input type="hidden" name="longitude" id="longitudeUser">
                    <input type="hidden" name="latitude" value="{{ $lokasiUser->latitude }}" id="latitude">
                    <input type="hidden" name="longitude" value="{{ $lokasiUser->longitude }}" id="longitude">
                    <input type="hidden" name="radius" value="{{ $lokasiUser->radius }}" id="radius">

                    {{-- Tombol pilih shift --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="mb-3">Pilih Shift :</p>
                                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                    {{-- Data shift --}}
                                    @foreach ($shift as $key => $item)
                                        <input type="radio" class="btn-check btnShift" name="shiftChecked" id="btnradio{{ $item->nama }}" value="{{ $item->id }}" disabled>
                                        <label class="btn btn-outline-primary" for="btnradio1" data-id="{{ $item->id }}" data-name="btnradio{{ $item->nama }}" onclick="getShift(this)">
                                            {{ $item->nama }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Akan menampilkan gambar webcam --}}
                    <div class="card-body mb-0 justify-content-center" id="showJadwal">
                        <div class="alert alert-warning" role="alert">Pilih shift terlebih dahulu!</div>
                    </div>

                    {{-- Button absen masuk dan absen keluar --}}
                    <div class="card-body mt-0">
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-block btn-lg w-100" disabled style="text-align: center" id="btnAbsenMasuk">
                                    <small class="d-block mb-2 text-light fw-medium">Absen Masuk</small>
                                    Belum Absen
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-primary btn-block btn-lg w-100" disabled style="text-align: center" id="btnAbsenPulang">
                                    <small class="d-block mb-2 text-light fw-medium " id="modal">Absen Pulang</small>
                                    Belum Absen
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="script">
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script> --}}
        <script src="{{ asset('assets/js/webcam.js') }}"></script>

        <script>
                $(document).ready(function(){

                // Disable button pada awal load
                $('input[name=shiftChecked]').prop('disabled', true);
                $('#btnAbsenMasuk').prop('disabled', true);
                $('#btnAbsenPulang').prop('disabled', true);

                // Pemanggilan fungsi cek lokasi
                getGeo();
            });

            // Ambil longitude dan latitude device
            function getGeo(){
                const config = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                };

                if (navigator.geolocation) {
                    // Cek lokasi sesuai map, parameter jika sukses dan error
                    navigator.geolocation.getCurrentPosition(locationSuccess, showError, config);
                } else {
                    // Jika tidak mendukung geolocation
                    sweetAlertMessage('Peringatan!', 'Browser anda tidak mendukung lokasi.');
                }
            }

            // Fungsi jika pencarian lokasi sukes
            function locationSuccess(position) {
                // Masukkan longitude dan latitude user saat ini
                var lat = position.coords.latitude;
                var long = position.coords.longitude;
                $('#latitudeUser').val(lat);
                $('#longitudeUser').val(long);

                // fetch('http://www.geoplugin.net/json.gp')
                //     .then((resp) => {
                //     if(!resp.ok) {
                //         sweetAlertMessage('Terjadi Kesalahan!', 'Pastikan absen pada lokasi yang ditentukan dan aktifkan akses lokasi.', 'warning');
                //         return
                //     }
                //     return resp.json()
                // }).then((data) => {
                //     console.log(position);
                //     if(Math.abs(lat - data.geoplugin_latitude) < 1 && Math.abs(long - data.geoplugin_longitude) < 1) {
                        if (distance() <= $('#radius').val()){
                            alertAbsen();
                            propDisabled();
                        } else {
                            // Jika diluar radius
                            sweetAlertMessage('Anda diluar radius!', 'Pastikan absen pada lokasi yang ditentukan.', 'warning');
                        }
                //     } else {
                //         sweetAlertMessage('Peringatan!', 'Sistem mendeteksi adanya anomali.', 'warning');
                //     }
                // })
            }

            // Fungsi pemberian lokasi pada input hidden
            function distance(){
                var latitude = $('#latitude').val();
                var longitude = $('#longitude').val();

                var latitudeUser = $('#latitudeUser').val();
                var longitudeUser = $('#longitudeUser').val();

                // Radius bumi pada KM
                var R = 6371;

                // Rumus perhitungan radius
                return Math.acos(Math.sin(latitudeUser)*Math.sin(latitude) + Math.cos(latitudeUser)*Math.cos(latitude) * Math.cos(longitude-longitudeUser)) * R;
            }

            // Fungsi jika pencarian lokasi gagal
            function showError(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        sweetAlertMessage('Peringatan!', 'Aktifkan pencarian lokasi pada browser dan device.', 'warning');
                    break;
                    case error.POSITION_UNAVAILABLE:
                        sweetAlertMessage('Peringatan!', 'Informasi lokasi tidak tersedia.', 'warning');
                    break;
                    case error.TIMEOUT:
                        sweetAlertMessage('Peringatan!', 'Timeout saat mencari lokasi.', 'warning');
                    break;
                    case error.UNKNOWN_ERROR:
                        sweetAlertMessage('Peringatan!', 'Terdapat kesalahan saat mencari lokasi.', 'warning');
                    break;
                }
            }

            // SweetAlert
            function sweetAlertMessage($title, $message, $icon)
            {
                Swal.fire({
                    title: $title,
                    text: $message,
                    icon: $icon,
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Refresh",
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) { // Jika tombol refresh ditekan
                        location.reload();
                    }
                });
            }
        </script>

        <script>
            // Fungsi penentuan shift
            function getShift(e)
            {
                $('#btnAbsenMasuk').prop('disabled', false);
                $('.btnShift').prop('checked', false);

                // Mengatur ajax csrf
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.getAbsenShift') }}",
                    data: {
                        id: e.dataset.id // Mengambil id pada event
                    },
                    dataType: "json",
                    success: function (response) { // Jika ajax sukses dan memberikan respon
                        var shift = response.data;
                        var shiftHtml = response.html;
                        $('#'+e.dataset.name).prop('checked', true); // Check button yang dipilih

                        // Append pada html
                        $('#showJadwal').html('');
                        $('#showJadwal').html(shiftHtml);

                        setCamera();
                    }
                });
            }

            // Jika tombol absen masuk di klik
            $('#btnAbsenMasuk').on('click', function (e) {
                e.preventDefault();
                // Tangkap gambar webcam dan masukkan kedalam input
                Webcam.snap(function(data_uri) {
                    $(".image-tag").val(data_uri);
                } );

                $("#kategori").val('absenMasuk');

                // Submit form
                $('#formAbsen').submit();
            });

            // Jika tombol absen pulang di klik
            $('#btnAbsenPulang').on('click', function (e) {
                e.preventDefault();

                // Tangkap gambar webcam dan masukkan kedalam input
                Webcam.snap(function(data_uri) {
                    $(".image-tag").val(data_uri);
                } );

                $("#kategori").val('absenPulang');

                // Submit form
                $('#formAbsen').submit();
            });
        </script>

        @if ($cekAbsen == 0)
        <script>
            function alertAbsen(){
                Swal.fire({
                    title: 'Anda Di Dalam Radius',
                    text: 'Absen hari ini sudah selesai.',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Lanjutkan",
                    }).then((result) => {
                        if (result.isConfirmed) { // Jika tombol refresh ditekan
                            return;
                        }
                });
            };
            function propDisabled(){
                $('#showJadwal').html('<div class="alert alert-success" role="alert">Silakan melakukan absen kembali besok.</div>');
                $('input[name=shiftChecked]').prop('disabled', true);
                $('#btnAbsenMasuk').prop('disabled', true);
                $('#btnAbsenPulang').prop('disabled', true);
            };
        </script>
        @elseif ($cekAbsen == 1)
        <script>
            function alertAbsen(){
                Swal.fire({
                    title: 'Anda Di Dalam Radius',
                    text: 'Silakan Melakukan Absen Masuk.',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Lanjutkan",
                    }).then((result) => {
                        if (result.isConfirmed) { // Jika tombol refresh ditekan
                            return;
                        }
                });
            };
            function propDisabled(){
                $('input[name=shiftChecked]').prop('disabled', false);
                $('#btnAbsenMasuk').prop('disabled', true);
                $('#btnAbsenPulang').prop('disabled', true);
            };
        </script>
        @elseif($cekAbsen == 2)
        <script>
            function alertAbsen(){
                Swal.fire({
                    title: 'Anda Di Dalam Radius',
                    text: 'Silakan Melakukan Absen Pulang.',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Lanjutkan",
                    }).then((result) => {
                        if (result.isConfirmed) { // Jika tombol refresh ditekan
                            return;
                        }
                });
            };
            function propDisabled(){
                $('#showJadwal').html('');
                $('input[name=shiftChecked]').prop('disabled', true);
                $('#btnAbsenMasuk').prop('disabled', true);
                $('#btnAbsenPulang').prop('disabled', false);
                $('#showJadwal').html(
                '<div class="row justify-content-center">'+
                    '<div class="col-auto justify-content-center">'+
                        '<div id="my_camera" style="width: 100% !important;"></div>'+
                    '</div>'+
                '</div>');
                setCamera();
            };
        </script>
        @else
        <script>
            function alertAbsen(){
                Swal.fire({
                    title: 'Anda Di Dalam Radius',
                    text: 'Belum saatnya absen pulang.',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Lanjutkan",
                    }).then((result) => {
                        if (result.isConfirmed) { // Jika tombol refresh ditekan
                            return;
                        }
                });
            };
            function propDisabled(){
                $('#showJadwal').html('<div class="alert alert-warning" role="alert">Kembali absen saat sudah jam pulang.</div>');
                $('input[name=shiftChecked]').prop('disabled', true);
                $('#btnAbsenMasuk').prop('disabled', true);
                $('#btnAbsenPulang').prop('disabled', true);
            };
        </script>
        @endif

        <script>
            function setCamera()
            {
                var width = 720;
                var height = 540;

                Webcam.on( 'error', function(err) {
                    sweetAlertMessage('Kesalahan Pada Kamera!','Pastikan akses kamera pada browser aktif.','warning');
                } );

                if (screen.height <= screen.width) {
                    // Landscape
                    Webcam.set({
                        width: width,
                        height: height,
                        dest_width: width,
                        dest_height: height,
                    });
                } else {
                    // Portrait
                    Webcam.set({
                        width: height,
                        height: width,
                        dest_width: height,
                        dest_height: width,
                    });
                }

                // Set webcam untuk mengambil gambar absen
                Webcam.set({
                    crop_width: 500,
                    crop_height: 500,
                    align: 'center',
                    image_format: 'jpeg',
                    jpeg_quality: 90,
                    flip_horiz: true,
                });

                // Sambungkan dengan html
                Webcam.attach( '#my_camera' );
            }
        </script>
    </x-slot>
</x-layouts.app>
