<div id="list-{{ $kode }}">
    <hr class="w-100" />

    <div class="card-body">

        {{-- Nama Material --}}
        <div class="mb-3">
            <x-partials.label title="Nama Material" required/>
            <input type="hidden" name="nama_material[]" id="nama_material-{{ $kode }}">
            <select name="material_id[]" data-kode="{{ $kode }}" class="form-control @error('material_id')is-invalid @enderror" id="select-field-{{ $kode }}" required data-placeholder="Pilih nama..." onchange="getNamaMaterial(this)">
                <option></option>
                @foreach ($namaMaterial as $item)
                    <option value="{{ $item['id'] }}">{{ $item['nama_material'] }}</option>
                @endforeach
            </select>
            <x-partials.error-message name="material_id" class="d-block" />
        </div>

        <div class="mb-3">
            <div class="row">

                {{-- Kode Material --}}
                <div class="col-12 col-sm-12 col-sm-12 mb-3">
                    <x-input-text title="Kode Material" name='kode_material[]' id="kode_material-{{ $kode }}" required readonly/>
                </div>

                {{-- Kategori Material --}}
                <div class="col-12 col-sm-12 col-sm-12 mb-3">
                    <x-input-text title="Kategori Material" name='kategori_material[]' id="kategori_material-{{ $kode }}" readonly />
                </div>

                {{-- Satuan Material --}}
                <div class="col-12 col-sm-4 col-sm-6 mb-3">
                    <x-input-text title="Satuan" name='satuan[]' id="satuan-{{ $kode }}" readonly />
                </div>

                {{-- Harga --}}
                <div class="col-12 col-sm-4 col-sm-6 mb-3 mb-sm-0">
                    <input type="hidden" name="harga[]" id="hargaSubmit-{{ $kode }}">
                    <x-input-text title="Harga" name="display[]" id="harga-{{ $kode }}" readonly/>
                    <x-partials.input-desc text='Harga satuan.' />
                </div>

            </div>
        </div>

        {{-- Stok Input --}}
        <div>
            <x-partials.label title="Jumlah Stok Masuk" required />
            <div class="d-flex">
                <x-partials.input-text data-kode="{{ $kode }}" name="masuk[]" id="stokMasuk-{{ $kode }}" class="d-inline stokMasuk" onkeypress="return event.charCode &gt;= 48 &amp;&amp; event.charCode &lt;= 57" required/>
                <button type="button" data-kode="{{ $kode }}" class="btn btn-danger d-inline ms-2" onclick="deleteList(this)"><i class="bx bx-x"></i></button>
            </div>
        </div>
    </div>
</div>
