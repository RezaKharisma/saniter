<x-layouts.app title="Material">
    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}" />
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Laporan /</span> Material</h4>

    <div class="row">
        <div class="col-12 mt-3">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">
                            List Material
                        </button>
                    </li>
                    {{-- <li class="nav-item">
                        <button type="button" disabled class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false">
                            History Pengajuan
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" disabled class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false">
                            Retur Material
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" disabled class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-messages" aria-controls="navs-top-messages" aria-selected="false">
                            History Penggunaan
                        </button>
                    </li> --}}
                </ul>

                {{-- List --}}
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="navs-top-home" role="tabpanel">
                        <form method="POST" target="_blank" id="formFilter" action="{{ route('laporan.material.printList') }}">
                            @csrf

                            <div class="row">
                                {{-- Material --}}
                                <div class="row mb-2">
                                    <div class="col-12 col-sm-12 col-md-12 mb-3">
                                        <x-partials.label title="Material"/>
                                        <select name="kode_material" id="nama_material" class="form-control w-100 @error('nama_material') is-invalid @enderror" required>
                                            <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih material...</option>
                                            @foreach ($stokMaterial as $item)
                                                <option value="{{ $item->kode_material }}" data-kode_material="{{ $item->kode_material }}" data-harga="{{ $item->harga }}">{{ $item->nama_material }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 mb-3">
                                        <x-partials.label title="Tanggal Awal"/>
                                        <input type="text" class="form-control" id="start_date" name="start_date" onchange="tanggalAkhir(this)" placeholder="Tanggal Awal" autocomplete="off" required/>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-6 mb-3">
                                        <x-partials.label title="Tanggal Akhir"/>
                                        <input type="text" class="form-control" id="end_date" name="end_date"  placeholder="Tanggal Akhir" autocomplete="off" required/>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-12 mb-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="checkAll" name="checkAll" onchange="setSelectMaterial(this)">
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Semua List Material</label>
                                    </div>
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

                    <!--
                    {{-- Pengajuan --}}
                    <div class="tab-pane fade" id="navs-top-profile" role="tabpanel">
                        <form method="POST" target="_blank" id="formFilter" action="{{ route('laporan.material.printPengajuan') }}">
                            @csrf

                            {{-- Tanggal --}}
                            <div class="row mb-2">
                                <div class="col-12 col-sm-12 col-md-6 mb-3">
                                    <x-partials.label title="Tanggal Mulai" />
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

                    {{-- History --}}
                    <div class="tab-pane fade" id="navs-top-messages" role="tabpanel">
                        {{-- Material --}}
                        <div class="row mb-2">
                            <div class="col-12 col-sm-12 col-md-6 mb-3">
                                <x-partials.label title="Nama Karyawan" />
                                {{-- <select name="user_id" id="nama_karyawan_model2" class="form-control" required>
                                    <option value="" selected disabled>Pilih nama karyawan...</option>
                                    @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select> --}}
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
                                <x-partials.label title="Tanggal Mulai" />
                                <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Tanggal Mulai" autocomplete="off" />
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
                    -->

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="model1" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalToggleLabel">Contoh Print Model 2</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('assets/img/model-print/model1Material.png') }}" class="img-fluid" alt="Model Print 1">
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
                $("#end_date").prop('disabled', true);

                $("#nama_material").select2({
                    theme: "bootstrap-5",
                    createTag: function (params) {
                        return {
                            id: params.term,
                            text: params.term + $select.data('appendme'),
                            kode_material: $select.data('kode_material'),
                            newOption: true
                        }
                    },
                    templateResult: formatMaterialOptionTemplate,
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

            function setSelectMaterial(e) {
                if($(e).is(':checked')){
                    $('#nama_material').prop('disabled', true);
                    $('#nama_material').val("").trigger('change');
                }else{
                    $('#nama_material').prop('disabled', false);
                }
            }

            function formatMaterialOptionTemplate(state) {
                var originalOption = $(state.element);

                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<div class="mb-0"><u>'+originalOption.data('kode_material')+'</u></div>'+
                    '<div>'+state.text+'</div>'
                );
                return $state;
            }
        </script>
    </x-slot>
</x-layouts.app>
