<x-layouts.app title="Tambah Jumlah Izin">
    <div class="card mb-12">
        <form method="post" action="{{ route('pengaturan.izin.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Teknisi</label>
                    <select class="form-select" name="user_id" id="exampleFormControlSelect1" aria-label="Default select example">
                        <option disabled selected="">Pilih Teknisi</option>
                        @foreach ($user as $u)
                        <option value="{{ $u->user_id }}"> {{ $u->user_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="basic-icon-default-company">Tahun</label>
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bxs-calendar"></i></span>
                        <input type="text" name="tahun" id="basic-icon-default-company" class="form-control" placeholder="20.." />
                    </div>
                </div>

                <div class="">
                    <label class="form-label" for="basic-icon-default-company">Jumlah Izin</label>
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-plus-circle"></i></span>
                        <input type="text" name="jumlah_izin" id="basic-icon-default-company" class="form-control" placeholder="12" />
                    </div>
                </div>
            </div>
            <div class="card-footer mt-0">
                <a href="{{ route('pengaturan.izin.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        </div>
    </div>
</x-layouts.app>
