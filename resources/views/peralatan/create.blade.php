<x-layouts.app title="Tambah Peralatan">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Peralatan /</span> Tambah Peralatan</h4>
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary" href="{{ route('peralatan.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="card mb-12">
        <h5 class="card-header mb-0">Form Tambah Peralatan</h5>
        <form method="post" action="{{ route('peralatan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Nama Peralatan</label>
                    <input type="text" name="nama_peralatan" class="form-control @error('nama_peralatan') is-invalid  @enderror" placeholder="Nama Peralatan" value="{{ old('nama_peralatan') }}" />
                    <x-partials.error-message name="nama_peralatan" class="d-block" />
                </div>
                <div class="row">
                    <div class="col-4 mb-3">
                        <label for="exampleFormControlSelect1" class="form-label">Satuan</label>
                        <input type="text" name="satuan" class="form-control @error('satuan') is-invalid  @enderror" placeholder="Satuan" value="{{ old('satuan') }}" />
                        <x-partials.error-message name="satuan" class="d-block" />
                    </div>
                    <div class="col-8">
                        <x-partials.label title="Harga" />
                        <div class="input-group input-group-merge">
                            <span class="input-group-text" @error('harga') style="border: solid red 1px;" @enderror>Rp. </span>
                            <input type="text" name="harga" class="form-control @error('harga') is-invalid @enderror" placeholder="Harga Satuan" onkeyup="formatRupiah(this)" value="{{ old('harga') }}" required/>
                        </div>
                        <x-partials.error-message name="harga" class="d-block"/>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('kategori-pekerjaan.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // $('#id_pekerja').select2({
                //     theme: "bootstrap-5",
                // });
            });

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
