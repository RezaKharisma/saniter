<x-layouts.app title="Pengaturan">
{{ $errors }}
<h5 class="fw-bold py-3 mb-4">Selamat Datang</h5>

<!-- Striped Rows -->
<div class="card">
    <h5 class="card-header">Data Akun Saniter</h5>
    <div class="card-body">
        <a href="{{ route('user.create') }}" class="mb-4 btn btn-primary">Tambah User</a>
        <div class="table-responsive text-nowrap">
            <table class="table table-striped" id="tabel-user">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Regional</th>
                        <th>Email</th>
                        {{-- <th>Role</th> --}}
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <?php $no = 1; ?>
                    @foreach ($users as $u)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->regional_name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>
                            <button
                            type="button"
                            class="btn btn-info btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#detail{{ $u->id }}">
                            Detail
                            </button>
                            
                            <button
                            type="button"
                            class="btn btn-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#update{{ $u->id }}">
                            Update
                            </button>

                            {{-- <a href="{{ route('user.edit', $u->id) }}">
                                <button
                                type="button"
                                class="btn btn-warning btn-sm">
                                Update
                                </button>
                            </a> --}}
                            <form method="POST" action="{{ route('user.delete', $u->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button
                            type="submit"
                            class="btn btn-danger btn-sm">
                            Hapus
                            </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@foreach ( $users as $u )

<div class="modal fade" id="detail{{ $u->id }}" tabindex="-1" aria-hidden="true">
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
                {{-- <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Jabatan</label>
                        <input type="text" id="nameBasic" class="form-control" value="{{ $u->role_name }}" readonly/>
                    </div>
                </div> --}}
                <div class="mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Foto</label>
                    <div class="mb-3">
                        <div class="col-auto">
                        {{-- Foto Profile --}}
                        <img src="{{ asset('storage/'. $u->path) }}" alt="user-avatar" class="d-block rounded mt-3 img-fluid" width="120" />
                        </div>
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
@endforeach

@foreach($users as $u)
    
<div class="modal fade" id="update{{ $u->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('user.update', $u->id) }}"  enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Name</label>
                        <input type="text" id="nameBasic" class="form-control" value="{{ $u->name }}" name="name"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">E-mail</label>
                        <input type="text" id="nameBasic" class="form-control" value="{{ $u->email }}" name="email"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">NIK</label>
                        <input type="text" id="nameBasic" class="form-control" value="{{ $u->nik }}" name="nik"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="nameBasic" class="form-label">Telepon</label>
                        <input type="text" id="nameBasic" class="form-control" value="{{ $u->telp }}" name="telp"/>
                    </div>
                </div>
                <div class="mb-3">
            <label for="exampleFormControlSelect1" class="form-label">Regional Kerja</label>
            <select class="form-select" name="id_regional" id="exampleFormControlSelect1" aria-label="Default select example">
              <option disabled selected="">Pilih Regional Kerja</option>
              @foreach ($regional as $r)
                <option value="{{ $r->id }}"> {{ $r->nama }}</option>
              @endforeach
            </select>
          </div>
                {{-- <div class="mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Foto</label>
                    <div class="mb-3">
                        <div class="col-auto">
                        Foto Profile
                        <img src="{{ asset('storage/'. $u->path) }}" alt="user-avatar" class="d-block rounded mt-3 img-fluid" width="120" id="imagePreview" />
                        </div>
                    </div>
                </div> --}}

                <div class="mb-3">
                    <label class="form-label" for="basic-icon-default-phone">Foto</label>
                    <div class="mb-3">
                        <input class="form-control" type="file" id="path" name="path"/>
                        {{-- <img id="imagePreview" width="120"> --}}
                        <div class="col-auto">
                        {{-- Foto Profile --}}
                        <img src="{{ asset('storage/'. $u->path) }}" alt="user-avatar" class="d-block rounded mt-3 img-fluid" width="120" id="imagePreview" />
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
@endforeach

<x-slot name="script">
    <script>
        $(document).ready(() => {
            $("#path").change(function () {
                const file = this.files[0];
                console.log(file);
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        $("#imagePreview").attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
</x-slot>
</x-layouts.app>
