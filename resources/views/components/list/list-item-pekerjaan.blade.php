<div class="row" id="list-item-pekerjaan-{{ $kode }}">

    <div class="col-12">
        <div class="divider text-start">
            <div class="divider-text" id="nomor-{{ $kode }}">Item Pekerjaan 1</div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-5 mb-3">
        <x-partials.label title="Item Pekerjaan" />
        <select name="item_pekerjaan[]" id="item_pekerjaan-{{ $kode }}" class="form-control w-100 @error('item_pekerjaan') is-invalid @enderror" required>
            <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih item pekerjaan...</option>
            @foreach ($itemPekerjaan as $item)
                <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">{{ $item->nama }}</option>
            @endforeach
        </select>
        <x-partials.error-message name="item_pekerjaan[]" class="d-block"/>
    </div>
    <div class="col-12 col-sm-12 col-md-5 mb-3">
        <x-partials.label title="Volume" />
        <div class="input-group">
            <input type="hidden" name="satuan_item_pekerjaan[]" id="satuan_item_pekerjaan">
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume_item_pekerjaan') is-invalid @enderror" id="volume_item_pekerjaan" name="volume_item_pekerjaan[]" placeholder="Volume" required/>
            <span class="input-group-text">satuan*</span>
        </div>
        <x-partials.error-message name="volume_item_pekerjaan[]" class="d-block"/>
        <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
    </div>
    <div class="col-12 col-sm-12 col-md-1 mb-3">
        <x-partials.label title="Aksi" />
        <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}" onclick="deleteListItemPekerjaan(this)"><i class="bx bx-x"></i></button>
    </div>
</div>
