<x-layouts.app title="Pengaturan">
<h5 class="fw-bold py-3 mb-4">Selamat Datang</h5>

<!-- Striped Rows -->
<div class="card">
    <h5 class="card-header">Data Akun Saniter</h5>
    <div class="card-body">
        <a href="{{ route('user.form-add') }}" class="mb-4 btn btn-primary">Tambah User</a>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="tabel-user">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Regional</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    {{-- <?php $no = 1; ?>
                    @foreach ($users as $key => $u)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->regional_name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->role_name }}</td>
                        <td>
                            <button
                            type="button"
                            class="btn btn-info btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#detail{{ $key }}">
                            Detail
                            </button>

                            <button
                            type="button"
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#">
                            Update
                            </button>
                        </td>

                        <div class="modal fade" id="detail{{ $key }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Name</label>
                                                <input type="text" id="nameBasic" class="form-control" value="{{ $u->name }}" readonly/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">E-mail</label>
                                                <input type="text" id="nameBasic" class="form-control" value="{{ $u->email }}" readonly/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">NIK</label>
                                                <input type="text" id="nameBasic" class="form-control" value="{{ $u->nik }}" readonly/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Telepon</label>
                                                <input type="text" id="nameBasic" class="form-control" value="{{ $u->telp }}" readonly/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Regional</label>
                                                <input type="text" id="nameBasic" class="form-control" value="{{ $u->regional_name }}" readonly/>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="nameBasic" class="form-label">Jabatan</label>
                                                <input type="text" id="nameBasic" class="form-control" value="{{ $u->role_name }}" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-layouts.app>
