<div id="list-{{ $kode }}">
    <hr class="w-100" />

    <input type="hidden" name="kode_material[]" id="kode_material-{{ $kode }}">
    <input type="hidden" name="nama_material[]" id="nama_material-{{ $kode }}">

    <div class="card-body">

        {{-- Nama Material --}}
        <div class="mb-3">
            <x-partials.label title="Nama Material" required/>
            <select name="material_id[]" data-kode="{{ $kode }}" class="form-control @error('material_id')is-invalid @enderror" id="select-field-{{ $kode }}" required data-placeholder="Pilih nama..." onchange="getNamaMaterial(this)">
                <option></option>
                @foreach ($namaMaterial as $item)
                    <option value="{{ $item['id'] }}">{{ $item['kode_material'] }} | {{ $item['nama_material'] }}</option>
                @endforeach
            </select>
            <x-partials.error-message name="material_id" class="d-block" />
        </div>

        <div class="mb-3">
            <div class="row">

                {{-- Jenis Pekerjaan --}}
                <div class="col-12 col-sm-4 col-sm-6 mb-3">
                    <x-input-text title="Jenis Pekerjaan" name='jenis_pekerjaan[]' id="jenis_pekerjaan-{{ $kode }}" readonly />
                </div>

                {{-- Jenis Material --}}
                <div class="col-12 col-sm-4 col-sm-6 mb-3">
                    <x-input-text title="Jenis Material" name='jenis_material[]' id="jenis_material-{{ $kode }}" readonly />
                </div>

                {{-- Stok Logistik (qty) --}}
                <div class="col-12 col-sm-4 col-sm-6 mb-3 mb-sm-0">
                    <x-input-text title="Stok Gudang Logistik" name='qty[]' id="qty-{{ $kode }}" readonly />
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
