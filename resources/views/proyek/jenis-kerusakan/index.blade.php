<x-layouts.app title="Jenis Kerusakan">

    <x-slot name="style">
        <style>
            /* .btnBackPrimary{
                color: #8592a3;
                border-color: rgba(0, 0, 0, 0);
                background: #ebeef0;
            }

            .btnBackPrimary:hover{
                color: #ebeef0;
                background-color: #8592a3;
            } */
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proyek /</span> Kerusakan</h4>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                <div class="d-flex flex-column justify-content-center">
                    <h4 class="mb-1 mt-3">{{ $area->areaNama }}</h4>
                    <p class="text-muted">{{ $area->lantai }} - {{ $area->listNama }}</p>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-2">
                    <a href="{{ route('detail-data-proyek.index', $detailKerja->tgl_kerja_id) }}" class="btn btn-secondary"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalDenah" >Denah</button>
                    <a href="{{ route('jenis-kerusakan.create', $detailKerja->id) }}" class="btn btn-primary"><i class="bx bx-plus"></i> Tambah</a>
                </div>
            </div>

            @forelse ($jenisKerusakan as $item)
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header flex-grow-0">
                            <div class="d-flex">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="../../assets/img/avatars/20.png" alt="User" class="rounded-circle" />
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-1">
                                    <div class="me-2">
                                        <h5 class="mb-0">Olivia Shared Event</h5>
                                        <small class="text-muted">07 Sep 2020 at 10:30 AM</small>
                                    </div>
                                    <div class="dropdown d-none d-sm-block">
                                        <button class="btn p-0" type="button" id="eventList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="eventList">
                                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img class="img-fluid" src="../../assets/img/backgrounds/event.jpg" alt="Card image cap" />
                        <div class="featured-date mt-n4 ms-4 bg-white rounded w-px-50 shadow text-center p-1">
                            <h5 class="mb-0 text-dark">21</h5>
                            <span class="text-primary">May</span>
                        </div>
                        <div class="card-body">
                            <h5 class="text-truncate">How To Excel In A Technical Terminology?</h5>
                            <div class="d-flex gap-2">
                                <span class="badge bg-label-primary">Technical</span>
                                <span class="badge bg-label-primary">Account</span>
                                <span class="badge bg-label-primary">Excel</span>
                            </div>
                            <div class="d-flex my-3">
                                <ul class="list-unstyled m-0 d-flex align-items-center avatar-group">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Vinnie Mostowy" data-bs-original-title="Vinnie Mostowy">
                                        <img class="rounded-circle" src="../../assets/img/avatars/5.png" alt="Avatar" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Allen Rieske" data-bs-original-title="Allen Rieske">
                                        <img class="rounded-circle" src="../../assets/img/avatars/12.png" alt="Avatar" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Julee Rossignol" data-bs-original-title="Julee Rossignol">
                                        <img class="rounded-circle" src="../../assets/img/avatars/6.png" alt="Avatar" />
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" aria-label="Darcey Nooner" data-bs-original-title="Darcey Nooner">
                                        <img class="rounded-circle" src="../../assets/img/avatars/10.png" alt="Avatar" />
                                    </li>
                                </ul>
                                <a href="javascript:;" class="btn btn-primary ms-auto" role="button">Join Now</a>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="card-actions">
                                    <a href="javascript:;" class="text-muted me-3"><i class="bx bx-heart me-1"></i> 236</a>
                                    <a href="javascript:;" class="text-muted"><i class="bx bx-message me-1"></i> 12</a>
                                </div>
                                <div class="dropup d-none d-sm-block">
                                    <button class="btn p-0" type="button" id="sharedList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sharedList">
                                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">Belum ada kerusakan ditambahkan!</div>
                </div>
            @endforelse

        </div>
    </div>

    <div class="modal fade" id="modalDenah" tabindex="-1" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Denah</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body justify-content-center d-flex">
                        <div class="card overflow-hidden p-3" style="height: 500px">
                            <div class="card-body p-4" id="both-scrollbars-example">
                                <img src="{{ asset('storage/'.$area->denah) }}" width="700px">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="script"> </x-slot>
</x-layouts.app>
