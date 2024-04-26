<x-layouts.app title="Tambah Jenis Pekerja">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pekerjaan /</span> Kategori Pekerja</h4>
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary" href="{{ route('kategori-pekerjaan.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="card mb-12">
        <div class="card-header">
            <h5 class="mb-0">Form Tambah Kategori Pekerjaan</h5>
        </div>
        <form method="post" action="{{ route('kategori-pekerjaan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                {{-- <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Jenis Pekerja</label>
                        <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example">
                            <option selected="" disabled>Pilih Jenis Pekerja</option>
                            <?php
                            foreach($pekerja as $p) {
                            ?>
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            <?php } ?>
                        </select>
                </div> --}}
                <div class="mb-3">
                <label for="exampleFormControlSelect1" class="form-label">Nama Kategori</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Kategori" />
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('kategori-pekerjaan.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</x-layouts.app>
