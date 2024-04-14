<x-layouts.app title="Tambah Jumlah Izin">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi / </span>Tambah Jumlah Izin</h4>

    {{-- Menu --}}
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary d-block" href="{{ route('pengaturan.izin.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="card mb-12">

        <h5 class="card-header">Form Tambah Jumlah Izin</h5>

        <form method="post" action="{{ route('pengaturan.izin.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <x-partials.label title="Teknisi" />
                    <select class="form-select @error('tahun') is-invalid @enderror" name="user_id" id="user_id">
                        <option disabled selected="">Pilih Teknisi</option>
                        @foreach ($user as $u)
                        <option value="{{ $u->user_id }}"> {{ $u->user_name }}</option>
                        @endforeach
                    </select>
                    <x-partials.error-message name='user_id' class="d-block"/>
                </div>
                <div class="mb-3">
                    <x-partials.label title="Tahun" />
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text" @error('tahun') style="border: solid red 1px;border-right: 0px" @enderror><i class="bx bxs-calendar"></i></span>
                        <input type="text" name="tahun" id="basic-icon-default-company" class="form-control @error('tahun') is-invalid @enderror" placeholder="20.." onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" />
                    </div>
                    <x-partials.error-message name='tahun' class="d-block"/>
                </div>

                <div class="">
                    <x-partials.label title="Jumlah Izin" />
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text" @error('jumlah_izin') style="border: solid red 1px;border-right: 0px" @enderror><i class="bx bx-plus-circle"></i></span>
                        <input type="text" name="jumlah_izin" id="basic-icon-default-company" class="form-control @error('jumlah_izin') is-invalid @enderror" placeholder="12" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" />
                    </div>
                    <x-partials.error-message name='jumlah_izin' class="d-block"/>
                </div>
            </div>
            <div class="card-footer mt-0">
                <a href="{{ route('pengaturan.izin.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $('#user_id').select2({
                    theme: 'bootstrap-5'
                });
            });
        </script>
    </x-slot>

</x-layouts.app>
