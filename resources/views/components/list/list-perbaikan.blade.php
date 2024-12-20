<div class="row" id="list-{{ $kode }}">

    <div class="col-12">
        <div class="divider text-start">
            <div class="divider-text" id="nomor-{{ $kode }}">Material 1</div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-5 mb-3">
        <x-partials.label title="Nama Material" />
        <select name="nama_material[]" id="select-field-{{ $kode }}" class="form-control w-100" required>
            <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama material...</option>
            @foreach ($stokMaterial as $item)
                <option value="{{ $item->kode_material }}" data-kode_material="{{ $item->kode_material }}" data-harga="{{ $item->harga }}">{{ $item->nama_material }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-12 col-md-5 mb-3">
        <x-partials.label title="Volume" />
        <div class="input-group">
            <input type="hidden" name="satuan[]" id="satuan-{{ $kode }}">
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control" name="volume[]" id="volume-{{ $kode }}" placeholder="Volume" required>
            <span class="input-group-text" id="satuan-{{ $kode }}HTML">satuan*</span>
        </div>
        <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
    </div>
    <div class="col-12 col-sm-12 col-md-1 mb-3">
        <x-partials.label title="Aksi" />
        <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}" onclick="deleteList(this)"><i class="bx bx-x"></i></button>
    </div>
</div>
