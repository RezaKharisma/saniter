<x-layouts.app title="Harian Proyek">
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}" />
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan /</span> Dokumentasi</h4>

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
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                            <form method="POST" target="_blank" id="formFilter" action="{{ route('harian.model1') }}">
                                @csrf

                                {{-- Tanggal --}}
                                <div class="row mb-2">
                                    <div class="col-12 col-sm-12 col-md-4 mb-3">
                                        <x-partials.label title="Tanggal Awal" />
                                        <input type="text" class="form-control" id="start_date" name="start_date" onchange="tanggalAkhir(this)" placeholder="Tanggal Mulai" autocomplete="off" />
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 mb-3">
                                        <x-partials.label title="Tanggal Akhir" />
                                        <input type="text" class="form-control" id="end_date" name="end_date" placeholder="Tanggal Akhir" autocomplete="off" />
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-4 mb-3">
                                        <x-partials.label title="Area" />
                                        <select name="area_id" id="area_id" class="form-control" required>
                                            <option value="" selected disabled>Pilih area...</option>
                                            @foreach ($area as $item)
                                                <option value="{{ $item->id }}"><b>{{ $item->regionalNama }}</b> | {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
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
        </div>
    </div>

    <div class="modal fade" id="model1" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalToggleLabel">Contoh Print Model 1</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('assets/img/model-print/model1Harian.png') }}" class="img-fluid" alt="Model Print 1">
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
                $('#end_date').prop('disabled',true)

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
        </script>
    </x-slot>
</x-layouts.app>
