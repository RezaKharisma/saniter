<div class="modal fade" id="detailUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-auto col-sm-12 col-md-auto mb-3">
                        <label class="form-label" for="basic-icon-default-phone">Foto</label>
                        {{-- Foto Profile --}}
                        <img src="{{ asset('storage/'. $user->foto) }}" alt="user-avatar" class="d-block rounded img-fluid" style="max-height: 200px"/>
                    </div>
                    <div class="col-sm-12 col-md">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nameBasic" class="form-label">Nama</label>
                                <input type="text" id="nameBasic" class="form-control" value="{{ $user->name }}" readonly/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nameBasic" class="form-label">E-mail</label>
                                <input type="text" id="nameBasic" class="form-control" value="{{ $user->email }}" readonly/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nameBasic" class="form-label">Telepon</label>
                                <input type="text" id="nameBasic" class="form-control" value="{{ $user->telp }}" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nameBasic" class="form-label">NIK</label>
                                <input type="text" id="nameBasic" class="form-control" value="{{ $user->nik }}" readonly/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nameBasic" class="form-label">Regional</label>
                                <input type="text" id="nameBasic" class="form-control" value="{{ $user->regional_name }}" readonly/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nameBasic" class="form-label">Jabatan</label>
                                <input type="text" id="nameBasic" class="form-control" value="{{ $user->roles_name }}" readonly/>
                            </div>
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
