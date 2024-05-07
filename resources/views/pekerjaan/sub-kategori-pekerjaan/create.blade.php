<x-layouts.app title="Tambah Jenis Pekerja">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pekerjaan /</span> Sub Kategori Pekerjaan</h4>
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary" href="{{ route('sub-kategori-pekerjaan.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="card mb-12">
        <div class="card-header">
            <h5 class="mb-0">Form Tambah Sub Kategori Pekerjaan</h5>
        </div>
        <form method="post" action="{{ route('sub-kategori-pekerjaan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Kategori Pekerjaan</label>
                    <select class="form-select @error('id_kategori_pekerjaan') is-invalid @enderror" name="id_kategori_pekerjaan" id="id_kategori_pekerjaan">
                        <option selected="" disabled>Pilih Kategori Pekerjaan</option>
                        @foreach ($kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <x-partials.error-message name='id_kategori_pekerjaan' class="d-block"/>
                </div>
                <div class="">
                <label for="exampleFormControlSelect1" class="form-label">Nama Sub Kategori</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" @error('name') style="border: 0.5px solid red" @enderror><i class="bx bxs-spreadsheet"></i></span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Sub Kategori" />
                    </div>
                    <x-partials.error-message name='name' class="d-block"/>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('sub-kategori-pekerjaan.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <x-slot name='script'>
        <script>
            $(document).ready(function () {
                $('#id_kategori_pekerjaan').select2({
                    theme: "bootstrap-5"
                });
            });
        </script>
    </x-slot>

</x-layouts.app>
