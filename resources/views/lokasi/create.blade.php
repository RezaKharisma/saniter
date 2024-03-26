
<x-layouts.app title="Pengaturan">
<div class="card mb-12">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Form Lokasi Baru</h5>

    </div>
    <div class="card-body">
      <form method="post" action="{{ route('lokasi.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="exampleFormControlSelect1" class="form-label">Regional Kerja</label>
            <select class="form-select" name="regional_id" id="exampleFormControlSelect1" aria-label="Default select example">
              <option disabled selected="">Pilih Regional Kerja</option>
              @foreach ($regional as $r)
                <option value="{{ $r->id }}"> {{ $r->nama }}</option>
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
        <a href="{{ route('lokasi.index') }}" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>

</x-layouts.app>
