<x-layouts.app title="Profil">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Profil /</span> Profil</h4>

    <div class="row">
        <div class="col-md-12">

            {{-- Menu --}}
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    {{-- Jika request url adalah url yg di tentukan, set class active --}}
                    <a class="nav-link @if(request()->is('profil'))active @endif" href="#"><i class="bx bx-user me-1"></i> Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(request()->is('profil/password-reset'))active @endif" href="{{ route('profile.indexResetPassword') }}">
                        <i class="bx bx-lock-alt me-1"></i> Reset Password</a>
                </li>
            </ul>

            <div class="card mb-4">

                {{-- Update Profile --}}
                <h5 class="card-header">Informasi Profil</h5>
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">

                        <div class="row">

                            <div class="col-auto">
                                {{-- Foto Profile --}}
                                <img src="{{ asset('storage/'. Auth()->user()->path) }}" alt="user-avatar" class="d-block rounded" width="120" id="imagePreview" />
                            </div>

                            <div class="col-sm-12 col-md-auto mt-3">
                                {{-- Form Upload New Photo --}}
                                <form action="{{ route('profile.updateImage', $user->id) }}" method="POST" enctype="multipart/form-data"> {{-- Mengirim parameter user id pada route --}}
                                    @csrf
                                    @method('PUT')

                                    <x-partials.input-file name="foto" id="imageUpload" accept="image/png, image/jpeg, image/jpg" />
                                    <x-partials.error-message name="foto" />

                                    <button class="btn btn-primary mt-2" type="submit">Upload Foto</button>
                                    <a class="btn btn-outline-secondary mt-2" href="{{ route('profile.index') }}">Reset</a>

                                    <p class="text-muted mt-2">File berupa JPG, JPEG, PNG. Maksimal 1 MB</p>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <hr class="my-0" />

                <div class="card-body">

                    {{-- Form Update Profile --}}
                    <form action="{{ route('profile.updateProfil', $user->id) }}" method="POST"> {{-- Mengirim parameter user id pada route --}}
                        @csrf
                        @method('PUT')
                        <div class="row">

                            {{-- Input Nama --}}
                            <div class="mb-3 col-md-6">
                                {{-- old(NAMA_REQUEST) mengembalikan inputan sebelumnya --}}
                                <x-input-text title="Nama Lengkap" name="name" :value="old('name') ?? $user->name" placeholder="Masukkan Nama Lengkap" />
                            </div>

                            {{-- Input Email --}}
                            <div class="mb-3 col-md-6">
                                <x-input-text title="Email" name="email" :value="old('email') ?? $user->email" placeholder="Masukkan email" />
                            </div>

                            {{-- Input Nomor Telepon --}}
                            <div class="mb-3 col-md-6">
                                <x-partials.label title="Nomor Telepon" />
                                <x-partials.input-text-group name="telp" :value="old('telp') ?? $user->telp" placeholder="Masukkan nomor telepon" front="(+62)" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57"/>
                                <x-partials.error-message name="telp" class="d-block"/>
                            </div>

                            {{-- Input Nik --}}
                            <div class="mb-3 col-md-6">
                                <x-input-number title="NIK" name="nik" :value="old('nik') ?? $user->nik" placeholder="Masukkan NIK" />
                            </div>

                            {{-- Input Regional --}}
                            <div class="mb-3 col-md-6">
                                <x-partials.label title="Regional" />
                                <x-partials.input-text name="regional" :value="$user->namaRegional" readonly />
                            </div>

                            {{-- Input Jabatan --}}
                            <div class="mb-3 col-md-6">
                                <x-partials.label title="Jabatan" />
                                <x-partials.input-text name="role" :value="$user->getRoleNames()" readonly />
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(() => {
                $("#imageUpload").change(function () {
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
