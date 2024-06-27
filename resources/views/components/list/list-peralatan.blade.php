<div class="row" id="list-peralatan-{{ $kode }}">

    <div class="col-12">
        <div class="divider text-start">
            <div class="divider-text" id="nomor-{{ $kode }}">Peralatan 1</div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-5 mb-3">
        <x-partials.label title="Nama Peralatan" />
        <select name="nama_peralatan[]" id="peralatan-{{ $kode }}" class="form-control w-100 @error('nama_peralatan') is-invalid @enderror" required  onchange="fillSatuan('peralatan-{{ $kode }}','satuan_pekerja-{{ $kode }}')">
            <option value="" data-id="0" data-harga="0" selected disabled>Pilih nama peralatan...</option>
            @foreach ($peralatan as $item)
                <option value="{{ $item->id }}" data-harga="{{ $item->harga }}" data-satuan="{{ $item->satuan }}">{{ $item->nama_peralatan }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-12 col-md-5 mb-3">
        <x-partials.label title="Volume" />
        <div class="input-group">
            <input type="hidden" name="satuan_peralatan[]" id="satuan_peralatan-{{ $kode }}">
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume_peralatan') is-invalid @enderror" id="volume_peralatan" name="volume_peralatan[]" placeholder="Volume" required/>
            <span class="input-group-text" id="satuan_peralatan-{{ $kode }}HTML">satuan*</span>
        </div>
        <x-partials.error-message name="volume_peralatan[]" class="d-block"/>
        <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
    </div>
    <div class="col-12 col-sm-12 col-md-1 mb-3">
        <x-partials.label title="Aksi" />
        <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}" onclick="deleteListPeralatan(this)"><i class="bx bx-x"></i></button>
    </div>
</div>
