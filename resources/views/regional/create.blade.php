<x-layouts.app title="Pengaturan">
<div class="card mb-12">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Form User Baru</h5>

    </div>
    <div class="card-body">
      <form method="post" action="{{ route('regional.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-fullname">Nama Regional</label>
          <div class="input-group input-group-merge">
            <span id="basic-icon-default-fullname" class="input-group-text"><i class="bx bx-user"></i></span>
            <input type="text" name="nama" class="form-control" id="basic-icon-default-fullname" placeholder="Nama Regional">
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('regional.index') }}" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>

</x-layouts.app>
