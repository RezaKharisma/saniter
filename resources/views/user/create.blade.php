<x-layouts.app title="Pengaturan">
<div class="card mb-12">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Form User Baru</h5>

    </div>
    <div class="card-body">
      <form method="post" action="{{ route('user.add') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-fullname">Nama Lengkap</label>
          <div class="input-group input-group-merge">
            <span id="basic-icon-default-fullname" class="input-group-text"><i class="bx bx-user"></i></span>
            <input type="text" name="name" class="form-control" id="basic-icon-default-fullname" placeholder="Nama Lengkap">
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-company">Email</label>
          <div class="input-group input-group-merge">
            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-envelope"></i></span>
            <input type="text" name="email" id="basic-icon-default-company" class="form-control" placeholder="email@gmail.com">
          </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="basic-icon-default-company">NIK</label>
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-id-card"></i></span>
              <input type="text" name="nik" id="basic-icon-default-company" class="form-control" placeholder="ACME Inc." aria-label="ACME Inc." aria-describedby="basic-icon-default-company2">
            </div>
          </div>

          {{-- <div class="mb-3">
            <label for="exampleFormControlSelect1" class="form-label">Kantor Regional</label>
            <select class="form-select" name="regional_id" id="exampleFormControlSelect1" aria-label="Default select example">
              <option disabled selected="">Pilih Regional</option>
              @foreach ($regional as $r)
                <option value="{{ $r->id }}"> {{ $r->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="exampleFormControlSelect1" class="form-label">Jabatan</label>
            <select class="form-select" name="roles_id" id="exampleFormControlSelect1" aria-label="Default select example">
              <option disabled selected="">Pilih Jabatan</option>
              @foreach ($role as $rl)
                <option value="{{ $rl->id }}"> {{ $rl->name }}</option>
              @endforeach
            </select>
          </div> --}}

        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-phone">Phone No</label>
          <div class="input-group input-group-merge">
            <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>
            <input type="text" name="telp" id="basic-icon-default-phone" class="form-control phone-mask" placeholder="658 799 8941">
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="basic-icon-default-phone">Foto</label>
          <div class="mb-3">
            <input class="form-control" type="file" id="path" name="path"/>
            {{-- <img id="imagePreview" width="120"> --}}
            <div class="col-auto">
              {{-- Foto Profile --}}
              <img src="{{ asset('storage/user-images/default.png') }}" alt="user-avatar" class="d-block rounded mt-3 img-fluid" width="120" id="imagePreview" />
            </div>
            
          </div>
        </div>


        <div class="mb-3">
            <label class="form-label" for="basic-icon-default-phone">Password</label>
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-key"></i></span>
              <input type="password" name="password" id="basic-icon-default-password" class="form-control password">
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label" for="basic-icon-default-phone">Confirm Password</label>
            <div class="input-group input-group-merge">
              <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-key"></i></span>
              <input type="password" name="confirmpassword" id="basic-icon-default-confirm-password" class="form-control confirm-password">
            </div>
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>

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
