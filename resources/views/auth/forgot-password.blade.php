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
                    <h4 class="mb-2 mt-0 d-flex justify-content-center">Lupa Password</h4>
                    <p class="mb-4 d-flex justify-content-center">Silahkan masukkan email aktif anda.</p>

                    {{-- Form --}}
                    <form id="formSubmit" class="mb-3" action="{{ route('password.email') }}" method="POST">
                        @csrf

                        {{-- Input Email --}}
                        <x-input-text title="Email" name="email" placeholder="Masukkan email" margin="mb-3" />

                        {{-- Submit Button --}}
                        <button type="button" class="btn btn-primary d-grid w-100" id="buttons" onclick="btnSubmit()">Kirim Link Reset Password</button>
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

    <x-slot name="script">

        @if (session('status'))
            <script>
                Swal.fire({
                    title: "Informasi",
                    text: "{{ session('status') }}",
                    icon: "info"
                });
            </script>
        @endif

        <script>
            function btnSubmit(){
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    position: 'top-end',
                    icon: 'info',
                    customClass: {
                        popup: 'colored-toast',
                    },
                    showConfirmButton: false,
                })

                ;(async () => {
                await Toast.fire({
                    icon: 'warning',
                    title: 'Proses...',
                })})()

                $('#buttons').prop('disabled', true);
                $('#formSubmit').submit();
            }
        </script>
    </x-slot>

</x-layouts.auth.app>
