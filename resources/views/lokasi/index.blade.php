<x-layouts.app title="Pengaturan">
    <h5 class="fw-bold py-3 mb-4">Regional & Lokasi >> Lokasi</h5>

    <!-- Striped Rows -->
    <div class="card">
        <h5 class="card-header">Data Lokasi</h5>
        <div class="card-body">
            <a href="{{ route('lokasi.create') }}" class="mb-4 btn btn-primary">Tambah Lokasi</a>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped" id="tabel-user">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Regional</th>
                            <th>Nama Bandara</th>
                            <th>Lokasi</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Radius</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $no = 1; ?>
                        @foreach ($lokasi as $key => $u)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $u->regional_name }}</td>
                            <td>{{ $u->nama_bandara }}</td>
                            <td>{{ $u->lokasi_proyek }}</td>
                            <td>{{ $u->latitude }}</td>
                            <td>{{ $u->longitude }}</td>
                            <td>{{ $u->radius }} Meter</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#update{{ $key }}">
                                    Update
                                </button>

                                <form method="POST" action="{{ route('lokasi.delete', $u->lokasi_id) }}" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>

                            <div class="modal fade" id="update{{ $key }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('lokasi.update', $u->id) }}" class="d-inline">
                                            @csrf @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel1">Detail Nama Regional</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlSelect1" class="form-label">Regional Kerja</label>
                                                        <select class="form-select" name="regional_id" id="exampleFormControlSelect1" aria-label="Default select example">
                                                            <option disabled selected="">Pilih Regional Kerja</option>
                                                            @foreach ($regional as $r)
                                                            <option value="{{ $r->id }}"> {{ $r->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div id="defaultFormControlHelp" class="form-text">
                                                            dipilih ulang karena melakukan update
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-icon-default-company">Nama Bandara</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bxs-plane-alt"></i></span>
                                                            <input type="text" name="nama_bandara" id="basic-icon-default-company" class="form-control" value="{{ $u->nama_bandara }}" />
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-icon-default-company">Lokasi Proyek (Terminal)</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bxs-map"></i></span>
                                                            <input type="text" name="lokasi_proyek" id="basic-icon-default-company" class="form-control" value="{{ $u->lokasi_proyek }}" />
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-icon-default-company">Latitude</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-area"></i></span>
                                                            <input type="text" name="latitude" id="basic-icon-default-company" class="form-control" value="{{ $u->latitude }}" />
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-icon-default-company">Longitude</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-area"></i></span>
                                                            <input type="text" name="longitude" id="basic-icon-default-company" class="form-control" value="{{ $u->longitude }}" />
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="basic-icon-default-company">Radius</label>
                                                        <div class="input-group input-group-merge">
                                                            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-trip"></i></span>
                                                            <input type="text" name="radius" id="basic-icon-default-company" class="form-control" value="{{ $u->radius }}" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts.app>
