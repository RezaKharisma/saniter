<x-layouts.app title="Pengaturan">
<ul class="nav nav-pills flex-md-row mb-3">
    <li class="nav-item">
        <a class="nav-link active" href="{{ route('izin.setting') }}"><i class="bx bx-left-arrow-circle me-1"></i> Kembali</a>
    </li>
</ul>
<div class="card mb-12">
    <div class="card-body">
      <form method="post" action="#" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleFormControlSelect1" class="form-label">Nama Teknisi</label>
            <select class="form-select" name="user_id" id="exampleFormControlSelect1" aria-label="Default select example">
              <option disabled selected="">Nama & Jabatan</option>
              @foreach ($user as $u)
                <option value="{{ $u->id }}"> {{ $u->user_name }}</option>
              @endforeach
            </select>
        </div>
        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-company">Nama Bandara</label>
          <div class="input-group input-group-merge">
            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bxs-plane-alt"></i></span>
            <input type="text" name="nama_bandara" id="basic-icon-default-company" class="form-control" placeholder="Bandara International I Gusti Ngurah Rai">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-company">Lokasi Proyek (Terminal)</label>
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bxs-map"></i></span>
              <input type="text" name="lokasi_proyek" id="basic-icon-default-company" class="form-control" placeholder="Terminal Domestik / International">
            </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-company">Latitude</label>
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-area"></i></span>
              <input type="text" name="latitude" id="basic-icon-default-company" class="form-control" placeholder="-8.6605651">
            </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-company">Longitude</label>
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-area"></i></span>
              <input type="text" name="longitude" id="basic-icon-default-company" class="form-control" placeholder="115.2154872">
            </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-company">Radius</label>
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-trip"></i></span>
              <input type="text" name="radius" id="basic-icon-default-company" class="form-control" placeholder="150">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="#" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>

</x-layouts.app>