<div class="modal fade" id="detailUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="customer-avatar-section mb-4">
                    <div class="d-flex align-items-center flex-column">

                        {{-- Foto Profile --}}
                        <img class="img-fluid rounded my-4" src="{{ asset('storage/'. $user->foto) }}" height="110" width="110" alt="User avatar">

                        {{-- Nama Role --}}
                        <div class="customer-info text-center">
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <small><span class="badge bg-info">{{ $user->roles_name }}</span></small>
                        </div>

                    </div>
                </div>

                <div class="info-container">
                    <small class="d-block pt-4 border-top fw-normal text-uppercase text-muted my-3">DETAIL</small>

                    {{-- All Detail --}}
                    <div class="table-responsive">
                        <table class="table table-striped text-nowrap">
                            <tr>
                                <td>Nama</td>
                                <td>: {{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: {{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>: {{ $user->nik }}</td>
                            </tr>
                            <tr>
                                <td>Alamat KTP</td>
                                <td>: {{ $user->alamat_ktp }}</td>
                            </tr>
                            <tr>
                                <td>Alamat Domisili</td>
                                <td>: {{ $user->alamat_dom }}</td>
                            </tr>
                            <tr>
                                <td>Regional Kerja</td>
                                <td>: {{ $user->regional_name }}</td>
                            </tr>
                            <tr>
                                <td>Lokasi Proyek</td>
                                <td>: {{ $user->bandara }} | {{ $user->lokasi }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Telepon</td>
                                <td>: {{ $user->telp }}</td>
                            </tr>
                            <tr>
                                <td>Tanda Tangan</td>
                                <td>:
                                    @if ($user->ttd)
                                        <img src="{{ asset('storage/'. $user->ttd) }}" alt="user-avatar" class="img-fluid ms-2" style="max-height: 100px"/>
                                    @else
                                        <img src="{{ asset('storage/user-ttd/default.jpg') }}" alt="user-avatar" class="img-fluid ms-2" style="max-height: 100px"/>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
