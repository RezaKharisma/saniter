<x-layouts.app title="Tambah Jenis Pekerja">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pekerjaan /</span> Jenis Pekerja</h4>
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary" href="{{ route('jenis-pekerja.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="card mb-12">
        <div class="card-header">
            <h5 class="mb-0">Form Tambah Jenis Pekerja</h5>
        </div>
        <form method="post" action="{{ route('jenis-pekerja.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Nama" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('jenis-pekerja.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</x-layouts.app>
