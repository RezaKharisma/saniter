<x-layouts.app title="Prestasi Phisik">
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}" />
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan /</span> Prestasi Phisik</h4>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header mb-3">Form Prestasi Phisik</h5>
                <div class="card-body">
                    <form method="POST" target="_blank" id="formFilter" action="{{ route('dokumentasi.model1') }}">
                        @csrf

                        {{-- Tanggal --}}
                        <div class="row mb-2">
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <x-partials.label title="Tanggal Awal" />
                                <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Tanggal Mulai" autocomplete="off" />
                            </div>
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <x-partials.label title="Tanggal Akhir" />
                                <input type="text" class="form-control" id="end_date" name="end_date" placeholder="Tanggal Akhir" autocomplete="off" />
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
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>
        <script>
            $(document).ready(function () {
                $("#area_id").select2({
                    theme: "bootstrap-5",
                });

                $("#start_date").datepicker({
                    dateFormat: "dd/mm/yy",
                });

                $("#end_date").datepicker({
                    dateFormat: "dd/mm/yy",
                });
            });
        </script>
    </x-slot>
</x-layouts.app>
