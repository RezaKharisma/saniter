<div class="row" id="list-pekerja-{{ $kode }}">

    <div class="col-12">
        <div class="divider text-start">
            <div class="divider-text" id="nomor-{{ $kode }}">Pekerja 1</div>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-5 mb-3">
        <x-partials.label title="Nama Pekerja" />
        <select name="nama_pekerja[]" id="nama_pekerja-{{ $kode }}" class="form-control w-100 @error('nama_pekerja') is-invalid @enderror" required>
            <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama pekerja...</option>
            @foreach ($pekerja as $item)
                <option value="{{ $item->id }}" data-upah="{{ $item->upah }}">{{ $item->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12 col-sm-12 col-md-5 mb-3">
        <x-partials.label title="Volume" />
        <div class="input-group">
            <input type="hidden" name="satuan_pekerja[]" id="satuan_pekerja">
            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume_pekerja') is-invalid @enderror" id="volume_pekerja" name="volume_pekerja[]" placeholder="Volume" required/>
            <span class="input-group-text">satuan*</span>
        </div>
        <x-partials.error-message name="volume_pekerja[]" class="d-block"/>
        <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
    </div>
    <div class="col-12 col-sm-12 col-md-1 mb-3">
        <x-partials.label title="Aksi" />
        <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}" onclick="deleteListPekerja(this)"><i class="bx bx-x"></i></button>
    </div>
</div>
