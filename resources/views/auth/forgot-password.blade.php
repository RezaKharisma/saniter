<x-layouts.auth.app title="Lupa Password">

    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <div class="card">
                <div class="card-body">

                    {{-- Logo --}}
                    <div class="app-brand justify-content-center">
                        <img src="{{ asset('assets/img/logo/logo-qinar.png') }}" alt="Logo Qinar" width="100px">
                        <h4 class="mb-2">PT. Qinar Raya Mandiri</h4>
                    </div>

                    {{-- Header text --}}
                    <h4 class="mb-2 mt-0 d-flex justify-content-center">Halaman Reset Password</h4>
                    <p class="mb-4 d-flex justify-content-center">Silahkan masukkan email aktif anda.</p>

                    {{-- Form --}}
                    <form id="formAuthentication" class="mb-3" action="index.html" method="POST">

                        {{-- Input Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" autofocus />
                        </div>

                        {{-- Submit Button --}}
                        <button class="btn btn-primary d-grid w-100">Kirim Link Reset Password</button>
                    </form>

                    {{-- Back To Login --}}
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                            Kembali ke login
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-layouts.auth.app>
