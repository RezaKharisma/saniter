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
                    <form method="POST" target="_blank" id="formFilter" action="{{ route('prestasi-phisik.model1') }}">
                        @csrf

                        <div class="row mb-2">
                            <div class="col-4">
                                <x-partials.label title="Bulan" />
                                <select name="bulan" id="bulan" class="form-control" required>
                                    <option value="" selected disabled>Pilih bulan...</option>
                                    @foreach ($bulan as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 mb-3">
                                <x-partials.label title="Minggu Ke" />
                                <select name="mingguKe" id="minggu" class="form-control" required>
                                    <option value="" selected disabled>Pilih minggu...</option>
                                    <option value="1">Minggu Pertama</option>
                                    <option value="2">Minggu Kedua</option>
                                    <option value="3">Minggu Ketiga</option>
                                    <option value="4">Minggu Keempat</option>
                                    <option value="5">Minggu Kelima</option>
                                </select>
                            </div>
                            <div class="col-4 mb-3">
                                <x-partials.label title="Tahun" />
                                <input type="number" class="form-control" name="tahun" placeholder="Tahun" autocomplete="off" required value="{{ Carbon\Carbon::now()->format('Y') }}" />
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
                $("#bulan").select2({
                    theme: "bootstrap-5",
                });

                $("#minggu").select2({
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
