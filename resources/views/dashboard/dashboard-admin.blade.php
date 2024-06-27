<div class="row">
    <div class="col-lg-2 col-md-3 col-6 mb-4">
        <div class="card">
            <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <span class="badge bg-label-success rounded p-2">
                    <i class="bx bx-user bx-sm"></i>
                </span>
            </div>
            <span class="fw-semibold d-block mb-1">Total Karyawan</span>
            <div class="d-flex">
                <h3 class="card-title mb-2 d-inline">{{ $userStat['user_total_akhir'] }}</h3>
                @if ($userStat['user_baru'] != 0)
                    <small class="text-success fw-semibold ms-3 mt-1 d-inline"><i class="bx bx-up-arrow-alt"></i> +{{ $userStat['user_baru'] }}</small>
                @endif
                @if ($userStat['user_delete'] != 0)
                    <small class="text-danger fw-semibold ms-3 mt-1 d-inline"><i class="bx bx-down-arrow-alt"></i> +{{ $userStat['user_delete'] }}</small>
                @endif
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-6 mb-4">
        <div class="card">
            <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <span class="badge bg-label-primary rounded p-2">
                    <i class="bx bx-list-check bx-sm"></i>
                </span>
            </div>
            <span class="fw-semibold d-block mb-1">Absen Hari Ini</span>
            <div class="d-flex">
                <h3 class="card-title mb-2">{{ $absenStat ?? 0 }}</h3>
                <small class="text-success fw-semibold">&nbsp; </small>
            </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-3 col-6 mb-4">
        <div class="card">
            <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <span class="badge bg-label-warning rounded p-2">
                    <i class="bx bx-list-minus bx-sm"></i>
                </span>
            </div>
            <span class="fw-semibold d-block mb-1">Izin Hari Ini</span>
            <div class="d-flex">
                <h3 class="card-title mb-2">{{ $izinStat }}</h3>
                <small class="text-success fw-semibold">&nbsp; </small>
            </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-2 col-md-3 col-6 mb-4">
        <div class="card">
            <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
                <span class="badge bg-label-secondary rounded p-2">
                    <i class="bx bx-briefcase-alt-2 bx-sm"></i>
                </span>
            </div>
            <span class="fw-semibold d-block mb-1">Pekerjaan {{ Carbon\Carbon::now()->isoFormat('MMMM') }}</span>
            <div class="d-flex">
                <h3 class="card-title mb-2">{{ $kerusakanStat }}</h3>
                <small class="text-success fw-semibold">&nbsp; </small>
            </div>
            </div>
        </div>
    </div> --}}
    <div class="col-lg-6 col-md-12 col-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex align-items-start justify-content-between">
                    <span class="badge bg-label-success rounded p-2">
                        <i class="bx bx-money bx-sm"></i>
                    </span>
                </div>
                <span class="fw-semibold d-block mb-1">Prestasi Phisik Minggu Ke {{ $prestasiPhisikStat['mingguKe'] }}</span>
                <h3 class="card-title mb-2">Rp. {{ number_format($prestasiPhisikStat['grandTotal'], 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-md-6 col-lg-4 order-1 mb-4">
        <div class="card h-100">
            <div class="card-header mb-0 pb-0">
                <h5>Statistik Kerusakan</h5>
            </div>
            <div class="card-body px-0">
                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                        <div class="d-flex p-4">
                            <span class="badge bg-label-primary rounded me-3">
                                <i class="bx bx-briefcase-alt-2 bx-sm"></i>
                            </span>
                            <div>
                            <small class="text-muted d-block">Total Kerusakan Tahun {{ Carbon\Carbon::now()->format('Y') }}</small>
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0 me-1">$459.10</h6>
                                <small class="text-success fw-semibold">
                                <i class="bx bx-chevron-up"></i>
                                42.9%
                                </small>
                            </div>
                            </div>
                        </div>
                        <div id="incomeChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-lg-8 col-mb-8 col-12 order-1 mb-4 h-50">
        <div class="card">
            <div class="card-header mb-0 pb-0">
                <h5>Statistik Kerusakan</h5>
            </div>
            <div class="card-body px-0">
                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                        <div class="d-flex p-4">
                            <span class="badge bg-label-primary rounded me-3">
                                <i class="bx bx-briefcase-alt-2 bx-sm"></i>
                            </span>
                            <div>
                            <small class="text-muted d-block">Total Kerusakan Tahun {{ Carbon\Carbon::now()->format('Y') }}</small>
                            <div class="d-flex align-items-center">
                            <h6 class="mb-0 me-1">{{ $kerusakanStat['totalPerTahun'] }}</h6>
                            </div>
                            </div>
                        </div>
                        {!! $kerusakanChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-mb-4 col-12 order-1 mb-4 h-50">
        <div class="card">
            <div class="card-header mb-0 pb-0">
                <h5>Statistik Stok Material</h5>
            </div>
            <div class="card-body px-0">
                <div class="tab-content p-0">
                    <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                        <div class="d-flex p-4">
                            <span class="badge bg-label-primary rounded me-3">
                                <i class="bx bx-layer bx-sm"></i>
                            </span>
                            <div>
                                <div class="d-flex align-items-center mt-2">
                                    <h6 class="mb-0 me-1">Top 5 Material Digunakan Tahun {{ Carbon\Carbon::now()->format('Y') }}</h6>
                                </div>
                            </div>
                        </div>
                        {!! $stokMaterialChart->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-lg-4 order-2 mb-4">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">User Aktif Upload {{ Carbon\Carbon::now()->format('Y') }}</h5>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    @foreach ($kerusakanStat['userTeraktif'] as $item)
                    <li class="d-flex @if(!$loop->last) mb-4 @endif pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('storage/'.$item['foto']) }}" alt="User" class="rounded">
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                {{-- <small class="text-muted d-block mb-1">{{ $item['name'] }}</small> --}}
                                <h6 class="mb-0">{{ $item['name'] }}</h6>
                            </div>
                            <div class="user-progress d-flex align-items-center gap-1">
                                <h6 class="mb-0">{{ $item['total'] }}x</h6>
                                <span class="text-muted">Upload</span>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            </div>
        </div>
    </div>

{{-- <div class="card">
    <div class="card-body">
        <x-partials.label title="Nomor" />
        <input type="text" id="nomorDenah" class="form-control" readonly>
    </div>
    <div class="card-body">
        <div class="row justify-content-center d-flex">
            <div class="col-12 col-sm-12 col-md-8">
                <div class="card shadow overflow-hidden" style="height: 500px">
                    <h5 class="card-header">Denah</h5>
                    <div class="card-body p-4" id="both-scrollbars-example">
                        <canvas id="canvas" width="600" height="800"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-slot name="script">
    <script src="{{ asset('assets/vendor/libs/jcanvas/jcanvas.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var nomor = [];

            $('canvas').drawRect({
                layer: true,
                strokeStyle: 'rgb(204,51,51)',
                strokeWidth: 5,
                x: 100, y: 80,
                width: 80,
                height: 140,
                cornerRadius: 10,
                click: function(layer) {
                    if (layer.strokeStyle == 'rgb(204,51,51)') {
                        addNomor("tambah",1);
                        $(this).animateLayer(layer, {
                            strokeStyle: 'rgb(40,167,69)',
                        }, 1);
                    }

                    if (layer.strokeStyle == 'rgb(40,167,69)') {
                        addNomor("hapus",1);
                        $(this).animateLayer(layer, {
                            strokeStyle: 'rgb(204,51,51)',
                        }, 1);
                    }
                }
            });

            $('canvas').drawRect({
                layer: true,
                strokeStyle: 'rgb(204,51,51)',
                strokeWidth: 5,
                x: 192, y: 80,
                width: 80,
                height: 140,
                cornerRadius: 10,
                click: function(layer) {
                    if (layer.strokeStyle == 'rgb(204,51,51)') {
                        addNomor("tambah",2);
                        $(this).animateLayer(layer, {
                            strokeStyle: 'rgb(40,167,69)',
                        }, 1);
                    }

                    if (layer.strokeStyle == 'rgb(40,167,69)') {
                        addNomor("hapus",2);
                        $(this).animateLayer(layer, {
                            strokeStyle: 'rgb(204,51,51)',
                        }, 1);
                    }
                }
            });

            function addNomor(event, no){
                if (event == "tambah") {
                    nomor.push(no)
                    nomor.sort();
                    $('#nomorDenah').val(nomor);
                }else{
                    nomor = $.grep(nomor, function(value) {
                        return value != no;
                    });
                    nomor.sort();
                    $('#nomorDenah').val(nomor);
                }
            }
        });
    </script>
</x-slot> --}}

<x-slot name='script'>
    {{-- <script src="{{ $kerusakanChart->cdn() }}"></script> --}}
    {{ $kerusakanChart->script() }}
    {{ $stokMaterialChart->script() }}
</x-slot>
