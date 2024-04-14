<x-layouts.app title="Ubah User">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi /</span> Ubah User</h4>

    {{-- Menu --}}
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary" href="{{ route('user.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="card mb-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Ubah User</h5>
        </div>
        <form method="post" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- Nama Lengkap --}}
                <div class="mb-3">
                    <x-partials.label title="Nama Lengkap" required/>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" @error('name') style="border: solid red 1px;" @enderror><i class="bx bx-user"></i></span>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name') ?? $user->name }}"/>
                    </div>
                    <x-partials.error-message name="name" class="d-block" />
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <x-partials.label title="Email" required/>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" @error('email') style="border: solid red 1px;" @enderror><i class="bx bx-envelope"></i></span>
                        <input type="text" name="email" class="form-control  @error('email') is-invalid @enderror" placeholder="email@gmail.com" value="{{ old('email') ?? $user->email }}"/>
                    </div>
                    <x-partials.error-message name="email" class="d-block" />
                </div>

                {{-- NIK --}}
                <div class="mb-3">
                    <x-partials.label title="NIK" required/>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" @error('nik') style="border: solid red 1px;" @enderror><i class="bx bx-id-card"></i></span>
                        <input type="text" name="nik" class="form-control  @error('nik') is-invalid @enderror" placeholder="NIK" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" maxlength="20" value="{{ old('nik') ?? $user->nik }}"/>
                    </div>
                    <x-partials.error-message name="nik" class="d-block" />
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3 mb-md-0">
                        {{-- Alamat KTP --}}
                        <x-partials.label title="Alamat KTP" required/>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" @error('alamat_ktp') style="border: solid red 1px;" @enderror><i class="bx bx-location-plus"></i></span>
                            <textarea name="alamat_ktp" class="form-control  @error('alamat_ktp') is-invalid @enderror" rows="3">{{ old('alamat_ktp') ?? $user->alamat_ktp  }}</textarea>
                        </div>
                        <x-partials.error-message name="alamat_ktp" class="d-block" />
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3 mb-md-0">
                        {{-- Alamat Domisili --}}
                        <x-partials.label title="Alamat Domisili" required/>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" @error('alamat_dom') style="border: solid red 1px;" @enderror><i class="bx bx-location-plus"></i></span>
                            <textarea name="alamat_dom" class="form-control @error('alamat_dom') is-invalid @enderror" rows="3">{{ old('alamat_dom') ?? $user->alamat_dom  }}</textarea>
                        </div>
                        <x-partials.error-message name="alamat_dom" class="d-block" />
                    </div>
                </div>

                {{-- Regional --}}
                <div class="mb-3">
                    <x-partials.label title="Regional Kerja" required/>
                    <select class="form-select  @error('regional_id') is-invalid @enderror" name="regional_id" id="regional_id" onchange="setLokasiKerja(this)">
                        <option value="" disabled selected>Pilih Regional Kerja</option>
                        @foreach ($regional as $r)
                            <option @if(old('regional_id') == $r->id || $user->regional_id == $r->id) selected @endif value="{{ $r->id }}"> {{ $r->nama }}</option>
                        @endforeach
                    </select>
                    <x-partials.error-message name="regional_id" class="d-block" />
                </div>

                {{-- Lokasi --}}
                <div class="mb-3">
                    <x-partials.label title="Lokasi Kerja" required/>
                    <select class="form-select  @error('lokasi_id') is-invalid @enderror" name="lokasi_id" id="lokasi_id">
                        <option value="" disabled selected>Pilih Lokasi Kerja</option>
                        @foreach ($lokasi as $l)
                            <option @if(old('lokasi_id') == $l->id || $user->lokasi_id == $l->id) selected @endif value="{{ $l->id }}"> {{ $l->nama_bandara }} | {{ $l->lokasi_proyek }}</option>
                        @endforeach
                    </select>
                    <x-partials.error-message name="lokasi_id" class="d-block" />
                </div>

                {{-- Role --}}
                <div class="mb-3">
                    <x-partials.label title="Role" required/>
                    <select class="form-select  @error('role_id') is-invalid @enderror" name="role_id" id="role_id">
                        <option value="" disabled selected>Pilih Role</option>
                        @foreach ($roles as $rl)
                            <option @if(old('role_id') == $rl->id || $user->role_id == $rl->id) selected @endif value="{{ $rl->id }}"> {{ $rl->name }}</option>
                        @endforeach
                    </select>
                    <x-partials.error-message name="role_id" class="d-block" />
                </div>

                {{-- Nomor Telepon --}}
                <div class="mb-3">
                    <x-partials.label title="Nomor Telepon" required/>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" @error('telp') style="border: solid red 1px;" @enderror><i class="bx bx-phone"></i></span>
                        <input type="text" name="telp" class="form-control phone-mask  @error('telp') is-invalid @enderror" placeholder="0819 3456 1882" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" maxlength="15" value="{{ old('telp') ?? $user->telp  }}"/>
                    </div>
                    <x-partials.error-message name="telp" class="d-block" />
                </div>

                <div class="row">

                    {{-- Foto --}}
                    <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3 mb-md-0">
                        <x-partials.label title="Foto" />
                        <div class="col-auto mb-3 justify-content-center d-flex">
                            {{-- Foto Profile --}}
                            @if ($user->foto != null)
                                <img src="{{ asset('storage/'.$user->foto) }}" alt="user-avatar" class="d-block rounded img-fluid" style="max-height: 200px" id="fotoPreview" />
                            @else
                                <img src="{{ asset('storage/user-images/default.jpg') }}" alt="user-avatar" class="d-block rounded img-fluid" style="max-height: 200px" id="fotoPreview" />
                            @endif
                        </div>
                        <input class="form-control  @error('foto') is-invalid @enderror" type="file" id="foto" name="foto" accept="image/png, image/jpeg, image/jpg" />
                        <x-partials.error-message name="foto" class="d-block" />
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 mb-3 mb-sm-3 mb-md-0">

                        {{-- Tanda Tangan --}}
                        <x-partials.label title="Tanda Tangan" />
                        <div class="col-auto mb-3 justify-content-center d-flex">
                            {{-- Foto Profile --}}
                            @if ($user->ttd != null)
                                <img src="{{ asset('storage/'.$user->ttd) }}" alt="user-avatar" class="d-block rounded img-fluid" style="max-height: 200px" id="ttdPreview" />
                            @else
                                <img src="{{ asset('storage/user-ttd/default.jpg') }}" alt="user-avatar" class="d-block rounded img-fluid" style="max-height: 200px" id="ttdPreview" />
                            @endif
                        </div>
                        <input class="form-control  @error('ttd') is-invalid @enderror" type="file" id="ttd" name="ttd" accept="image/png, image/jpeg, image/jpg" />
                        <x-partials.error-message name="tdd" class="d-block" />

                    </div>
                </div>

            </div>
            <div class="card-footer">
                <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(() => {
                // Select 2
                $('#regional_id').select2({
                    theme: 'bootstrap-5'
                });

                $('#lokasi_id').select2({
                    theme: 'bootstrap-5'
                });

                $('#role_id').select2({
                    theme: 'bootstrap-5'
                });

                $("#foto").change(function () {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#fotoPreview").attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });

                $("#ttd").change(function () {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#ttdPreview").attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            // Set lokasi kerja dari select regional
            function setLokasiKerja(e){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('ajax.getLokasiKerja') }}",
                    data: {
                        id: $(e).val()
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#lokasi_id').attr('disabled', false);
                        var lokasi = response.data;
                        // foreach response menjadi option pada select
                        if (lokasi.length > 0) {
                            $("#lokasi_id").empty().append('<option value="" selected disabled>Pilih Lokasi Kerja...</option>')
                            $.each(lokasi, function (index, value) {
                                $("#lokasi_id").append('<option value='+value.id+'>'+value.nama_bandara+' | '+value.lokasi_proyek+'</option>')
                            });
                        }else{
                            $('#lokasi_id').attr('disabled', true);
                            $("#lokasi_id").empty().append('<option value="" selected disabled>---- Tidak Ada Lokasi Kerja ----</option>')
                        }
                    }
                });
            }
        </script>
    </x-slot>
</x-layouts.app>
