<x-layouts.app title="Tambah Jenis Pekerja">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pekerjaan /</span> Item Pekerjaan</h4>
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="btn btn-secondary" href="{{ route('item-pekerjaan.index') }}"><i class="bx bx-left-arrow-alt me-1"></i> Kembali</a>
        </li>
    </ul>

    <div class="card mb-12">
        <div class="card-header">
            <h5 class="mb-0">Form Tambah Item Pekerjaan</h5>
        </div>
        <form method="post" action="{{ route('item-pekerjaan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Sub Kategori Pekerjaan</label>
                    <select class="form-select @error('id_sub_kategori_pekerjaan') is-invalid @enderror" name="id_sub_kategori_pekerjaan" id="id_sub_kategori_pekerjaan" aria-label="Default select example">
                        <option selected="" disabled>Pilih Sub Kategori Pekerjaan</option>
                        @foreach ($sub_kategori as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <x-partials.error-message name="id_sub_kategori_pekerjaan" class="d-block" />
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlSelect1" class="form-label">Nama Item Pekerjaan</label>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" @error('harga') style="border: solid red 0.5px;" @enderror><i class="bx bxs-spreadsheet"></i></span>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Item Pekerjaan" />
                    </div>
                    <x-partials.error-message name="name" class="d-block" />
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="exampleFormControlSelect1" class="form-label">Volume</label>
                            <input type="text" name="volume" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" id="volume" class="form-control @error('volume') is-invalid @enderror" placeholder="Volume" />
                            <x-partials.error-message name="volume" class="d-block" />
                        </div>
                        <div class="col-6">
                            <label for="exampleFormControlSelect1" class="form-label">Satuan</label>
                            <input type="text" name="satuan" id="satuan" class="form-control @error('satuan') is-invalid @enderror" placeholder="Satuan" />
                            <x-partials.error-message name="satuan" class="d-block" />
                        </div>
                    </div>

                </div>
                <div class="">
                    <x-partials.label title="Harga" />
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" @error('harga') style="border: solid red 0.5px;" @enderror>Rp. </span>
                        <input type="text" name="harga" class="form-control @error('harga') is-invalid @enderror" placeholder="Harga" onkeyup="formatRupiah(this)" value="{{ old('harga') }}"/>
                    </div>
                    <x-partials.error-message name="harga" class="d-block"/>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('item-pekerjaan.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                $('#id_sub_kategori_pekerjaan').select2({
                    theme: "bootstrap-5"
                });
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
