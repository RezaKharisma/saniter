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
                    <h4 class="mb-1 mt-3">{{ $area->lantai }} - {{ $area->listNama }}</h4>
                    <p class="text-muted">{{ $area->areaNama }}</p>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-2">
                    <a href="{{ route('detail-data-proyek.index', $detailKerja->tgl_kerja_id) }}" class="btn btn-secondary"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
                    <button type="button" class="btn @if (Carbon\Carbon::now()->format('Y-m-d') == Carbon\Carbon::parse($detailKerja->created_at)->format('Y-m-d')) btn-secondary @else btn-primary @endif" data-bs-toggle="modal" data-bs-target="#modalDenah" >Denah</button>
                    @if (Carbon\Carbon::now()->format('Y-m-d') == Carbon\Carbon::parse($detailKerja->created_at)->format('Y-m-d'))
                        <a href="{{ route('jenis-kerusakan.create', $detailKerja->id) }}" class="btn btn-primary"><i class="bx bx-plus"></i> Tambah</a>
                    @endif
                </div>
            </div>

            <div class="row">
                @forelse ($jenisKerusakan as $item)
                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header flex-grow-0">
                                <div class="d-flex">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="{{ asset('storage/'.$item->userFoto) }}" alt="{{ $item->name }}" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-1">
                                        <div class="me-2">
                                            <h5 class="mb-0">{{ $item->name }}</h5>
                                            <small class="text-muted">{{ Carbon\Carbon::parse($item->created_at)->isoFormat('LT')." ".ucfirst(Carbon\Carbon::parse($item->created_at)->isoFormat('A')) }} ({{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }})</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img class="img-fluid" src="{{ asset('storage/'.$item->foto) }}" alt="Card image cap" style="max-height: 300px; object-fit: cover"/>
                            <div class="featured-date mt-n4 ms-4 bg-white rounded w-px-50 shadow text-center p-1">
                                <h5 class="mb-0 text-dark">{{ Carbon\Carbon::parse($item->created_at)->format('d') }}</h5>
                                <span class="text-primary">{{ Carbon\Carbon::parse($item->created_at)->format('M') }}</span>
                            </div>
                            <div class="card-body mb-0">
                                <h5 class="text-truncate">Perbaikan {{ $item->nama_kerusakan }}</h5>
                                <div class="d-flex gap-2">
                                    @if ($item->tgl_selesai_pekerjaan != null)
                                        <span class="badge bg-success">Selesai</span>
                                    @endif
                                    @if ($item->status_kerusakan == "Perbaikan")
                                        <span class="badge bg-label-primary">{{ $item->status_kerusakan }}</span>
                                    @elseif($item->status_kerusakan == "Dengan Material")
                                        <span class="badge bg-label-primary">{{ $item->status_kerusakan }}</span>
                                    @else
                                        <span class="badge bg-label-primary">{{ $item->status_kerusakan }}</span>
                                    @endif
                                </div>
                                <div class="d-flex mt-3 mb-0" style="height: 40px">
                                    <p class="small" style="text-align: justify">{{ Str::limit($item->deskripsi, 100) }}@if($item->deskripsi != "-").@endif</p>
                                </div>
                            </div>
                            <div class="card-body border-top">
                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <div class="d-flex flex-column w-50 me-2">
                                        <small class="text-muted text-nowrap d-block mb-2">Tanggal Selesai</small>
                                        @if ($item->tgl_selesai_pekerjaan == null)
                                            <h6 class="mb-0">-</h6>
                                        @else
                                            <h6 class="mb-0">{{ Carbon\Carbon::parse($item->tgl_selesai_pekerjaan)->isoFormat('dddd, D MMMM Y') }}</h6>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted text-nowrap d-block mb-2">Jangka Waktu</small>
                                        @if ($item->tgl_selesai_pekerjaan == null)
                                            <h6 class="mb-0">-</h6>
                                        @else
                                            @php
                                                $startDate = Carbon\Carbon::parse($item->created_at);
                                                $endDate = Carbon\Carbon::parse($item->tgl_selesai_pekerjaan)
                                            @endphp
                                            <h6 class="mb-0">{{ $startDate->diffInDays($endDate) != 0 ? $startDate->diffInDays($endDate).' Hari' : ($startDate->diffInHours($endDate) != 0 ? $startDate->diffInHours($endDate).' Jam' : ($startDate->diffInMinutes($endDate) != 0 ? $startDate->diffInMinutes($endDate).' Menit' : $startDate->diffInSeconds($endDate).' Detik')) }}</h6>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">

                                    @if ($item->tgl_selesai_pekerjaan != null && auth()->user()->can('jenis kerusakan_update'))
                                        <a href="{{ route('jenis-kerusakan.edit', $item->id) }}" class="btn btn-warning w-100 d-grid me-2">Update</a>
                                    @endif

                                    <a href="{{ route('jenis-kerusakan.detail', $item->id) }}" class="btn btn-primary w-100 d-grid me-2">Detail</a>

                                    @if ($item->tgl_selesai_pekerjaan == null)
                                        <form action="{{ route('jenis-kerusakan.delete', $item->id) }}" method="POST" class="w-100 d-grid">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" value="{{ $detailKerja->id }}" name="detail_tgl_kerusakan_id">
                                            <button type="submit" class="btn btn-danger confirm-delete">Hapus</button>
                                        </form>
                                    @endif

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

    <x-slot name="script">
        <script>
            $(document).on("click", "button.confirm-delete", function () {
                    var form = $(this).closest("form");
                    event.preventDefault();
                    Swal.fire({ // SweetAlert
                        title: "Apa kamu yakin?",
                        text: "Data akan terhapus!",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yakin",
                        cancelButtonText: "Batal",
                    }).then((result) => {
                        if (result.isConfirmed) { // Jika iyaa form akan tersubmit
                            form.submit();
                        }
                    });
                });
        </script>
    </x-slot>
</x-layouts.app>
