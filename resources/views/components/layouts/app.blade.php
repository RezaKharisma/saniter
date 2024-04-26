<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        {{-- Variable dari atribut x-app-layout component view --}}
        <title>{{ $title }} - Saniter</title>

        {{-- Asset Css --}}
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/logo-qinar.ico') }}" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        {{-- <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" /> --}}
        <link rel="stylesheet" href="{{ asset('assets/css/publicsans.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}" />
        {{-- <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables/datatables.min.css') }}" /> --}}
        <link rel="stylesheet" href="{{ asset('assets/vendor/css/jquery-ui.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/css/select2.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/css/select2-bootstrap-5-theme.min.css') }}" />
        <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
        <script src="{{ asset('assets/js/config.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/choices/choices.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/css/custom-datatables.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/dropzone/dropzone.css') }}" />

        <style>
            .swal2-container {
                z-index: 10000;
            }
        </style>

        {{-- Custom style (jika ada) --}}
        {{ $style ?? null }}
    </head>

    <body>
        @php
            if (Auth()->user()->is_active != 1) {
                toast('Terjadi kesalahan!','error');
                Auth::logout();
                Redirect::route('login');
            }

            setlocale(LC_TIME, 'id_ID');
            \Carbon\Carbon::setLocale('id');
        @endphp

        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                {{-- Sidebar --}}
                <x-layouts.sidebar />

                <div class="layout-page">
                    {{-- Navbar atas --}}
                    <x-layouts.navbar />

                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">

                            {{-- Isi di dalam tag x-app-layout component --}}
                            {{ $slot }}

                        </div>

                        {{-- Footer --}}
                        <footer class="content-footer footer bg-footer-theme">
                            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                                <div class="mb-2 mb-md-0">
                                    COPYRIGHT © <script>document.write(new Date().getFullYear());</script>
                                    <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">Qinar Raya Mandiri</a>, All rights Reserved
                                </div>
                            </div>
                        </footer>

                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>

            <div class="layout-overlay layout-menu-toggle"></div>
        </div>

        <div class="modal fade" id="searchMenu" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">Search Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <x-input-text title="menu" name="nama_menu" id="nama_menu" autofocus/>

                        <div class="demo-inline-spacing mt-3">
                            <ul class="list-group" id="list-search-menu">
                            </ul>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Asset Javascript --}}
        <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/js/numberOnly.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/datatables.min.js') }}"></script> --}}
        <script src="{{ asset('assets/vendor/libs/datatables/pdfmake.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/datatables/vfs_fonts.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
        <script async defer src="https://buttons.github.io/buttons.js"></script>

        {{-- Sweet Alert --}}
        @include('sweetalert::alert')

        <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/extended-ui-perfect-scrollbar.js') }}"></script>

        <script src="{{ asset('assets/vendor/libs/choices/choices.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
        <script src="{{ asset('assets/vendor/libs/dropzone/dropzone-min.js') }}"></script>

        {{-- Custom script (jika ada) --}}

        <script>
            function searchMenu(){
                loadMenu();
                $('#searchMenu').modal('show')
            }

            $('#nama_menu').on('hidden.bs.modal', function () {
                $('#list-search-menu').html('');
            })

            $('#nama_menu').on('keyup', function () {
                loadMenu();
            });

            function loadMenu(){
                $.ajax({
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    type: "POST",
                    url: "{{ route('search-menu') }}",
                    data: {
                        nama: $('#nama_menu').val()
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#list-search-menu').html('');
                        $.each(response.SubMenu, function (index, value) {
                            $('#list-search-menu').append('<a href="'+$(location).attr('origin')+'/'+value.urlMenu+'/'+value.urlSub+'" class="list-group-item d-flex align-items-center"><i class="bx bx-'+value.icon+' me-2"></i>'+value.judulSub+'</a>')
                        });
                        $.each(response.Menu, function (index, value) {
                            $('#list-search-menu').append('<a href="'+$(location).attr('origin')+'/'+value.url+'" class="list-group-item d-flex align-items-center"><i class="bx bx-'+value.icon+' me-2"></i>'+value.judul+'</a>')
                        });
                    }
                });
            }
        </script>

        {{ $script ?? null }}
    </body>
</html>
