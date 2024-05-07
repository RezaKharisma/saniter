<x-layouts.app title="Tambah Jenis Pekerja">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pekerjaan /</span> Kategori Pekerja</h4>
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary" href="{{ route('kategori-pekerjaan.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="card mb-12">
        <h5 class="card-header mb-0">Form Tambah Kategori Pekerjaan</h5>
        <form method="post" action="{{ route('kategori-pekerjaan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                {{-- <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Pekerja</label>
                    <select class="form-select  @error('id_pekerja') is-invalid  @enderror" name="id_pekerja" id="id_pekerja">
                        <option value="" selected disabled>Pilih pekerja...</option>
                        @foreach ($pekerja as $item)
                            <option @if (old('id_pekerja') == $item->id) selected @endif value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <x-partials.error-message name="id_pekerja" class="d-block" />
                </div> --}}
                <div class="">
                <label for="exampleFormControlSelect1" class="form-label">Nama Kategori</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" @error('name') style="border: 0.5px solid red"  @enderror><i class="bx bxs-category"></i></span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid  @enderror" placeholder="Kategori" />
                    </div>
                    <x-partials.error-message name="name" class="d-block" />
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('kategori-pekerjaan.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // $('#id_pekerja').select2({
                //     theme: "bootstrap-5",
                // });
            });
        </script>
    </x-slot>
</x-layouts.app>
