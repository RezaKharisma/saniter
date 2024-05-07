<x-layouts.app title="Tambah Jenis Pekerja">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pekerjaan /</span> Tambah Pekerja</h4>
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary" href="{{ route('jenis-pekerja.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="card mb-12">
        <div class="card-header">
            <h5 class="mb-0">Form Tambah Pekerja</h5>
        </div>
        <form method="post" action="{{ route('jenis-pekerja.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <x-partials.label title="Nama Pekerja"/>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" @error('nama') style="border: 0.5px solid red"  @enderror><i class="bx bx-user"></i></span>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Pekerja" />
                    </div>
                    <x-partials.error-message name="nama" class="d-block"/>
                </div>
                <div class="row">
                    <div class="col-6">
                        <x-partials.label title="Upah"/>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" @error('upah') style="border: 0.5px solid red" @enderror>Rp. </span>
                            <input type="text" name="upah" onkeyup="formatRupiah(this)" class="form-control @error('upah') is-invalid @enderror" placeholder="Upah" />
                        </div>
                        <x-partials.error-message name="upah" class="d-block"/>
                    </div>
                    <div class="col-6">
                        <x-partials.label title="Satuan"/>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" @error('satuan') style="border: 0.5px solid red"  @enderror><i class="bx bx-user"></i></span>
                            <input type="text" name="satuan" class="form-control @error('satuan') is-invalid @enderror" placeholder="org/hr" />
                        </div>
                        <x-partials.error-message name="satuan" class="d-block"/>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('jenis-pekerja.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <x-slot name='script'>
        <script>
            function formatRupiah(e){
            var number_string = $(e).val().replace(/[^,\d]/g, '').toString(),
                split	= number_string.split(','),
                sisa 	= split[0].length % 3,
                rupiah 	= split[0].substr(0, sisa),
                ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            $(e).val(rupiah);
        }
        </script>
    </x-slot>

</x-layouts.app>
