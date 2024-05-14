<x-layouts.app title="Edit Jenis Kerusakan">

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.css') }}">
        <style>
            .select2 {
                width:100%!important;
            }

            .borderRed{
                border: 2px solid red;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Proyek /</span> Edit Kerusakan</h4>

    <a href="{{ route('jenis-kerusakan.index', $jenisKerusakan->detailKerjaID) }}" class="btn btn-secondary mb-3"><i class="bx bx-arrow-back me-1"></i> Kembali</a>
    <a href="{{ $_SERVER["REQUEST_URI"] }}" class="btn btn-primary mb-3"><i class="bx bx-refresh"></i></a>

    <form action="{{ route('jenis-kerusakan.update', $jenisKerusakan->jenisKerusakanID) }}" method="POST" id="formUpdate" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div id="cekFoto"></div>
    <input type="hidden" name="btnStatus" id="btnStatus">
    <input type="hidden" name="detail_tgl_kerja_id" value="{{ $jenisKerusakan->detailKerjaID }}">
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-0 order-md-0">
            <!-- User Card -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="rounded-3 text-center mb-3 pt-1">
                        <img class="img-fluid w-100" src="{{ asset('storage/'.$detail->foto) }}" id="imagePreview" style="height: 250px; object-fit: cover;background-position: center" />

                        @if ($jenisKerusakan->tgl_selesai_pekerjaan == null)
                            <label for="upload" class="btn btn-primary me-2 mb-1 w-100 mt-3" tabindex="0">
                                <span class="d-none d-sm-block">Unggah Foto Baru</span>
                                <i class="bx bx-upload d-block d-sm-none"></i>
                                <input type="file" id="upload" name="foto" class="account-file-input imageUpload @error('foto') is-invalid @enderror" hidden="" accept="image/png, image/jpeg">
                            </label>
                            <x-partials.error-message name="foto" class="d-block"/>
                        @endif

                    </div>
                    <div class="d-flex justify-content-around flex-wrap my-4 py-3" style="padding-bottom: 0px !important;">
                        <div class="d-flex align-items-start me-4 gap-3">
                            <span class="badge @if ($detail->tgl_selesai_pekerjaan == null) bg-label-danger @else bg-label-success @endif p-2 rounded">
                                @if ($detail->tgl_selesai_pekerjaan == null)
                                <i class="bx bx-x bx-sm"></i>
                                @else
                                <i class="bx bx-check bx-sm"></i>
                                @endif
                            </span>
                            <div>
                                <h5 class="mb-0">Status Pekerjaan</h5>
                                @if ($detail->tgl_selesai_pekerjaan == null)
                                <span>Belum Selesai</span>
                                @else
                                <span>Selesai</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- <h5 class="pb-2 border-bottom mb-4">Detail</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <x-partials.label title="Dikerjakan Oleh" />
                                <select name="dikerjakan_oleh" id="dikerjakan_oleh" class="form-control" @if($jenisKerusakan->tgl_selesai_pekerjaan != null) disabled @endif>
                                    <option value="" selected disabled>Pilih PIC...</option>
                                    @foreach ($teknisi as $item)
                                        <option @if($detail->dikerjakan_oleh == $item->id) selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <x-partials.error-message name="dikerjakan_oleh" />
                            </li>
                            <li class="mb-3">
                                <x-partials.label title="Tanggal Dikerjakan"/>
                                <input type="text" class="form-control" id="start_time" name="tgl_pengerjaan" placeholder="Tanggal Mulai" autocomplete="off" @if ($detail->tgl_selesai_pekerjaan != null) disabled @endif value="{{ Carbon\Carbon::parse($detail->jenisCreatedAt)->format('d/m/Y') }}"/>
                                <x-partials.error-message name="tgl_pengerjaan" class="d-block" />
                            </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-1" >
            <div class="card mb-4">
                <h5 class="card-header mb-3">Detail Kerusakan</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Dikerjakan Oleh</label>
                                <div class="col-sm-9">
                                    <select name="dikerjakan_oleh" id="dikerjakan_oleh" class="form-control">
                                        <option value="" selected disabled>Pilih PIC...</option>
                                        @foreach ($teknisi as $item)
                                            <option @if($detail->dikerjakan_oleh == $item->id) selected @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message name="dikerjakan_oleh" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Tanggal Dikerjakan</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="start_time" name="tgl_pengerjaan" placeholder="Tanggal Mulai" autocomplete="off" value="{{ Carbon\Carbon::parse($detail->jenisCreatedAt)->format('d/m/Y') }}"/>
                                    <x-partials.error-message name="tgl_pengerjaan" class="d-block" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Perbaikan</label>
                                <div class="col-sm-9">
                                    <select name="perbaikan" id="perbaikan" class="form-control" required>
                                        <option value="" selected disabled>Pilih status kerusakan...</option>
                                        <option @if($detail->nama_kerusakan == "Wastafel") selected @endif value="Wastafel">Wastafel</option>
                                        <option @if($detail->nama_kerusakan == "Closet") selected @endif value="Closet">Closet</option>
                                        <option @if($detail->nama_kerusakan == "Urinal") selected @endif value="Urinal">Urinal</option>
                                        <option @if($detail->nama_kerusakan == "Plafond") selected @endif value="Plafond">Plafond</option>
                                        <option @if($detail->nama_kerusakan == "Lantai") selected @endif value="Lantai">Lantai</option>
                                        <option @if($detail->nama_kerusakan == "Dinding") selected @endif value="Dinding">Dinding</option>
                                        <option @if($detail->nama_kerusakan == "Musholla") selected @endif value="Musholla">Musholla</option>
                                        <option @if($detail->nama_kerusakan == "Nursing Room") selected @endif value="Nursing Room">Nursing Room</option>
                                        <option @if($detail->nama_kerusakan == "Cubical") selected @endif value="Cubical">Cubical</option>
                                        <option @if($detail->nama_kerusakan == "Janitor") selected @endif value="Janitor">Janitor</option>
                                        <option @if($detail->nama_kerusakan == "Jet Shower") selected @endif value="Jet Shower">Jet Shower</option>
                                    </select>
                                    <x-partials.error-message name="perbaikan" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Status Kerusakan</label>
                                <div class="col-sm-9">
                                    <select name="status_kerusakan" id="status_kerusakan" class="form-control" onchange="setMaterialVisible(this)">
                                        <option value="" selected disabled>Pilih status kerusakan...</option>
                                        <option @if($detail->status_kerusakan == "Penggantian") selected @endif value="Penggantian">Penggantian</option>
                                        <option @if($detail->status_kerusakan == "Dengan Material") selected @endif value="Dengan Material">Dengan Material</option>
                                        <option @if($detail->status_kerusakan == "Tanpa Material") selected @endif value="Tanpa Material">Tanpa Material</option>
                                    </select>
                                    <x-partials.error-message name="status_kerusakan" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea name="deskripsi" rows="3" class="form-control" placeholder="Deskripsi">{{ $detail->deskripsi }}</textarea>
                                    <x-partials.error-message name="status_kerusakan" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-1">
            <div class="card mb-4">
                <h5 class="card-header mb-3">Detail Kerusakan</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Perbaikan</label>
                                <div class="col-sm-9">
                                    <select name="perbaikan" id="perbaikan" class="form-control" required>
                                        <option value="" selected disabled>Pilih status kerusakan...</option>
                                        <option @if($detail->nama_kerusakan == "Wastafel") selected @endif value="Wastafel">Wastafel</option>
                                        <option @if($detail->nama_kerusakan == "Closet") selected @endif value="Closet">Closet</option>
                                        <option @if($detail->nama_kerusakan == "Urinal") selected @endif value="Urinal">Urinal</option>
                                        <option @if($detail->nama_kerusakan == "Plafond") selected @endif value="Plafond">Plafond</option>
                                        <option @if($detail->nama_kerusakan == "Lantai") selected @endif value="Lantai">Lantai</option>
                                        <option @if($detail->nama_kerusakan == "Dinding") selected @endif value="Dinding">Dinding</option>
                                        <option @if($detail->nama_kerusakan == "Musholla") selected @endif value="Musholla">Musholla</option>
                                        <option @if($detail->nama_kerusakan == "Nursing Room") selected @endif value="Nursing Room">Nursing Room</option>
                                        <option @if($detail->nama_kerusakan == "Cubical") selected @endif value="Cubical">Cubical</option>
                                        <option @if($detail->nama_kerusakan == "Janitor") selected @endif value="Janitor">Janitor</option>
                                        <option @if($detail->nama_kerusakan == "Jet Shower") selected @endif value="Jet Shower">Jet Shower</option>
                                    </select>
                                    <x-partials.error-message name="perbaikan" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Status Kerusakan</label>
                                <div class="col-sm-9">
                                    <select name="status_kerusakan" id="status_kerusakan" class="form-control" onchange="setMaterialVisible(this)" >
                                        <option value="" selected disabled>Pilih status kerusakan...</option>
                                        <option @if($detail->status_kerusakan == "Penggantian") selected @endif value="Penggantian">Penggantian</option>
                                        <option @if($detail->status_kerusakan == "Dengan Material") selected @endif value="Dengan Material">Dengan Material</option>
                                        <option @if($detail->status_kerusakan == "Tanpa Material") selected @endif value="Tanpa Material">Tanpa Material</option>
                                    </select>
                                    <x-partials.error-message name="status_kerusakan" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label" for="basic-default-name">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea name="deskripsi" rows="3" class="form-control" placeholder="Deskripsi">{{ $detail->deskripsi }}</textarea>
                                    <x-partials.error-message name="status_kerusakan" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h5 class="card-header border-top mb-0 mt-3">Detail Material</h5>
                <div class="card overflow-hidden" style="height: 455px">
                    <div class="card-body" id="vertical-example" style="margin-top: -20px" >
                        <div class="alert alert-warning" role="alert">Mohon perhatikan volume stok material yang ingin diupdate untuk menghindari terjadi kesalahan saat pengurangan material!</div>
                        <div id="perbaikanList">
                                <input type="hidden" id="countUpdate" value="{{ count($detailMaterial) }}">
                                @forelse ($detailMaterial as $key => $itemMaterial)
                                    @php
                                        $kode = bin2hex(random_bytes(10));
                                    @endphp
                                    <input type="hidden" name="kodeList[]" value="{{ $kode }}">
                                    <div class="row" id="list-{{ $kode }}">
                                        <div class="col-12">
                                            <div class="divider text-start">
                                                <div class="divider-text" id="nomor-{{ $kode }}">Material {{ $key+1 }}</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-5 mb-3">
                                            <x-partials.label title="Nama Material" />
                                            <select name="nama_material[]" id="select-field-{{ $kode }}" class="form-control w-100 @error('nama_material') is-invalid @enderror">
                                                <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama material...</option>
                                                @foreach ($stokMaterial as $item)
                                                    <option @if($itemMaterial->kode_material == $item->kode_material) selected @endif value="{{ $item->kode_material }}" data-kode_material="{{ $item->kode_material }}" data-harga="{{ $item->harga }}">{{ $item->nama_material }}</option>
                                                @endforeach
                                            </select>
                                            <x-partials.error-message name="nama_material[]" class="d-block"/>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-5 mb-3">
                                            <x-partials.label title="Volume" />
                                            <div class="input-group">
                                                <input type="hidden" name="satuan[]" id="satuan-{{ $kode }}" value="{{ $itemMaterial->satuan }}">
                                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" class="form-control @error('volume') is-invalid @enderror" id="volume-{{ $kode }}" name="volume[]" placeholder="Volume" value="{{ $itemMaterial->volume }}" />
                                                <span class="input-group-text">{{ $itemMaterial->satuan }}</span>
                                            </div>
                                            <x-partials.error-message name="volume[]" class="d-block"/>
                                            <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-1 mb-3">
                                            <x-partials.label title="Aksi" />
                                            <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteList(this)"><i class="bx bx-x"></i></button>
                                        </div>
                                    </div>
                                @empty
                                    @php
                                        $kode = bin2hex(random_bytes(10));
                                    @endphp
                                    <input type="hidden" name="kodeList[]" value="{{ $kode }}">
                                    <div class="row" id="list-{{ $kode }}">
                                        <div class="col-12">
                                            <div class="divider text-start">
                                                <div class="divider-text" id="nomor-{{ $kode }}">Material 1</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-5 mb-3">
                                            <x-partials.label title="Nama Material" />
                                            <select name="nama_material[]" id="select-field-{{ $kode }}" class="form-control w-100 @error('nama_material') is-invalid @enderror">
                                                <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama material...</option>
                                                @foreach ($stokMaterial as $item)
                                                    <option value="{{ $item->kode_material }}" data-kode_material="{{ $item->kode_material }}" data-harga="{{ $item->harga }}">{{ $item->nama_material }}</option>
                                                @endforeach
                                            </select>
                                            <x-partials.error-message name="nama_material[]" class="d-block"/>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-5 mb-3">
                                            <x-partials.label title="Volume" />
                                            <div class="input-group">
                                                <input type="hidden" name="satuan[]" id="satuan-{{ $kode }}">
                                                <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" class="form-control @error('volume') is-invalid @enderror" id="volume-{{ $kode }}" name="volume[]" placeholder="Volume"/>
                                                <span class="input-group-text">satuan*</span>
                                            </div>
                                            <x-partials.error-message name="volume[]" class="d-block"/>
                                            <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-1 mb-3">
                                            <x-partials.label title="Aksi" />
                                            <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteList(this)"><i class="bx bx-x"></i></button>
                                        </div>
                                    </div>
                                @endforelse
                        </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-outline-success" id="btnAddMaterial" onclick="addList(this)"><i class="bx bx-plus"></i> Tambah Material</button>
                            </div>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div> --}}

        @if (auth()->user()->can('tanggal kerja_input item pekerjaan'))

            {{-- DETAIL PEKERJA --}}
            <div class="col-12 order-2 order-md-1 mb-3">
                <div class="card">
                    <h5 class="card-header mb-2">Detail Pekerja</h5>
                    <div class="card-body">
                        <div id="listPekerja">
                            @forelse ($detailPekerja as $key => $itemPekerja)
                                @php
                                    $kode = bin2hex(random_bytes(10));
                                @endphp
                                <input type="hidden" name="kodeListPekerja[]" value="{{ $kode }}">
                                <div class="row" id="list-pekerja-{{ $kode }}">
                                    <div class="col-12">
                                        <div class="divider text-start">
                                            <div class="divider-text" id="nomorPekerja-{{ $kode }}">Pekerja {{ $key+1 }}</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-5 mb-3">
                                        <x-partials.label title="Nama Pekerja" />
                                        <select name="nama_pekerja[]" id="nama_pekerja-{{ $kode }}" class="form-control w-100 @error('nama_pekerja') is-invalid @enderror" required>
                                            <option value="" selected disabled>Pilih nama pekerja...</option>
                                            @foreach ($pekerja as $item)
                                                <option @if($itemPekerja->pekerja_id == $item->id) selected @endif value="{{ $item->id }}" data-upah="{{ $item->upah }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        <x-partials.error-message name="nama_pekerja[]" class="d-block"/>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-5 mb-3">
                                        <x-partials.label title="Volume" />
                                        <div class="input-group">
                                            <input type="hidden" name="satuan_pekerja[]" id="satuan_pekerja-{{ $kode }}" value="{{ $itemPekerja->satuan }}">
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume_pekerja') is-invalid @enderror" id="volume_pekerja-{{ $kode }}" name="volume_pekerja[]" placeholder="Volume" required value="{{ $itemPekerja->volume }}"/>
                                            <span class="input-group-text">satuan*</span>
                                        </div>
                                        <x-partials.error-message name="volume_pekerja[]" class="d-block"/>
                                        <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-1 mb-3">
                                        <x-partials.label title="Aksi" />
                                        <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteListPekerja(this)"><i class="bx bx-x"></i></button>
                                    </div>
                                </div>
                            @empty
                                @php
                                    $kode = bin2hex(random_bytes(10));
                                @endphp
                                <input type="hidden" name="kodeListPekerja[]" value="{{ $kode }}">
                                <div class="row" id="list-pekerja-{{ $kode }}">
                                    <div class="col-12">
                                        <div class="divider text-start">
                                            <div class="divider-text" id="nomorPekerja-{{ $kode }}">Pekerja 1</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-5 mb-3">
                                        <x-partials.label title="Nama Pekerja" />
                                        <select name="nama_pekerja[]" id="nama_pekerja-{{ $kode }}" class="form-control w-100 @error('nama_pekerja') is-invalid @enderror" required>
                                            <option value="" selected disabled>Pilih nama pekerja...</option>
                                            @foreach ($pekerja as $item)
                                                <option value="{{ $item->id }}" data-upah="{{ $item->upah }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        <x-partials.error-message name="nama_pekerja[]" class="d-block"/>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-5 mb-3">
                                        <x-partials.label title="Volume" />
                                        <div class="input-group">
                                            <input type="hidden" name="satuan_pekerja[]" id="satuan_pekerja-{{ $kode }}">
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume_pekerja') is-invalid @enderror" id="volume_pekerja-{{ $kode }}" name="volume_pekerja[]" placeholder="Volume" required/>
                                            <span class="input-group-text">satuan*</span>
                                        </div>
                                        <x-partials.error-message name="volume_pekerja[]" class="d-block"/>
                                        <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-1 mb-3">
                                        <x-partials.label title="Aksi" />
                                        <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteListPekerja(this)"><i class="bx bx-x"></i></button>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" onclick="addListPekerja(this)"><i class="bx bx-plus"></i> Tambah Pekerja</button>
                    </div>
                </div>
            </div>

            {{-- DETAIL ITEM PEKERJAAN --}}
            <div class="col-12 order-2 order-md-1 mb-3">
                <div class="card">
                    <h5 class="card-header mb-2">Detail Item Pekerjaan</h5>
                    <div class="card-body">
                        <div id="listItemPekerjaan">
                            <input type="hidden" id="countUpdate" value="{{ count($detailMaterial) }}">
                            @forelse ($detailItemPekerjaan as $key => $itemPekerjaan)
                                @php
                                    $kode = bin2hex(random_bytes(10));
                                @endphp
                                <input type="hidden" name="kodeListItemPekerjaan[]" value="{{ $kode }}">
                                <div class="row" id="list-item-pekerjaan-{{ $kode }}">
                                    <div class="col-12">
                                        <div class="divider text-start">
                                            <div class="divider-text" id="nomorItemPekerjaan-{{ $kode }}">Item Pekerjaan {{ $key+1 }}</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-5 mb-3">
                                        <x-partials.label title="Item Pekerjaan" />
                                        <select name="item_pekerjaan[]" id="item_pekerjaan-{{ $kode }}" class="form-control w-100 @error('item_pekerjaan') is-invalid @enderror" required>
                                            <option value="" selected disabled>Pilih item pekerjaan...</option>
                                            @foreach ($itemPekerjaans as $item)
                                                <option @if($itemPekerjaan->item_pekerjaan_id == $item->id) selected @endif  value="{{ $item->id }}" data-harga="{{ $item->harga }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        <x-partials.error-message name="item_pekerjaan[]" class="d-block"/>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-5 mb-3">
                                        <x-partials.label title="Volume" />
                                        <div class="input-group">
                                            <input type="hidden" name="satuan_item_pekerjaan[]" id="satuan_item_pekerjaan-{{ $kode }}" value="{{ $itemPekerjaan->satuan }}">
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume_item_pekerjaan') is-invalid @enderror" id="volume_item_pekerjaan-{{ $kode }}" name="volume_item_pekerjaan[]" placeholder="Volume" value="{{ $itemPekerjaan->volume }}" required/>
                                            <span class="input-group-text">satuan*</span>
                                        </div>
                                        <x-partials.error-message name="volume_item_pekerjaan[]" class="d-block"/>
                                        <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-1 mb-3">
                                        <x-partials.label title="Aksi" />
                                        <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteListItemPekerjaan(this)"><i class="bx bx-x"></i></button>
                                    </div>
                                </div>
                            @empty
                                @php
                                    $kode = bin2hex(random_bytes(10));
                                @endphp
                                <input type="hidden" name="kodeListItemPekerjaan[]" value="{{ $kode }}">
                                <div class="row" id="list-item-pekerjaan-{{ $kode }}">
                                    <div class="col-12">
                                        <div class="divider text-start">
                                            <div class="divider-text" id="nomorItemPekerjaan-{{ $kode }}">Item Pekerjaan 1</div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-5 mb-3">
                                        <x-partials.label title="Item Pekerjaan" />
                                        <select name="item_pekerjaan[]" id="item_pekerjaan-{{ $kode }}" class="form-control w-100 @error('item_pekerjaan') is-invalid @enderror" required>
                                            <option value="" selected disabled>Pilih item pekerjaan...</option>
                                            @foreach ($itemPekerjaans as $item)
                                                <option value="{{ $item->id }}" data-harga="{{ $item->harga }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                        <x-partials.error-message name="item_pekerjaan[]" class="d-block"/>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-5 mb-3">
                                        <x-partials.label title="Volume" />
                                        <div class="input-group">
                                            <input type="hidden" name="satuan_item_pekerjaan[]" id="satuan_item_pekerjaan-{{ $kode }}">
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')"  class="form-control @error('volume_item_pekerjaan') is-invalid @enderror" id="volume_item_pekerjaan-{{ $kode }}" name="volume_item_pekerjaan[]" placeholder="Volume" required/>
                                            <span class="input-group-text">satuan*</span>
                                        </div>
                                        <x-partials.error-message name="volume_item_pekerjaan[]" class="d-block"/>
                                        <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-1 mb-3">
                                        <x-partials.label title="Aksi" />
                                        <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteListItemPekerjaan(this)"><i class="bx bx-x"></i></button>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" onclick="addListItemPekerjaan(this)"><i class="bx bx-plus"></i> Tambah Item Pekerjaan</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- DETAIL MATERIAL --}}
        <div class="col-12 order-2 order-md-1 mb-3">
            <div class="card">
                <h5 class="card-header mb-2">Detail Material</h5>
                <div class="card-body">
                    <div id="perbaikanList">
                        <input type="hidden" id="countUpdate" value="{{ count($detailMaterial) }}">
                        @forelse ($detailMaterial as $key => $itemMaterial)
                            @php
                                $kode = bin2hex(random_bytes(10));
                            @endphp
                            <input type="hidden" name="kodeList[]" value="{{ $kode }}">
                            <div class="row" id="list-{{ $kode }}">
                                <div class="col-12">
                                    <div class="divider text-start">
                                        <div class="divider-text" id="nomor-{{ $kode }}">Material {{ $key+1 }}</div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Nama Material" />
                                    <select name="nama_material[]" id="select-field-{{ $kode }}" class="form-control w-100 @error('nama_material') is-invalid @enderror">
                                        <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama material...</option>
                                        @foreach ($stokMaterial as $item)
                                            <option @if($itemMaterial->kode_material == $item->kode_material) selected @endif value="{{ $item->kode_material }}" data-kode_material="{{ $item->kode_material }}" data-harga="{{ $item->harga }}">{{ $item->nama_material }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message name="nama_material[]" class="d-block"/>
                                </div>
                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Volume" />
                                    <div class="input-group">
                                        <input type="hidden" name="satuan[]" id="satuan-{{ $kode }}" value="{{ $itemMaterial->satuan }}">
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" class="form-control @error('volume') is-invalid @enderror" id="volume-{{ $kode }}" name="volume[]" placeholder="Volume" value="{{ $itemMaterial->volume }}" />
                                        <span class="input-group-text">{{ $itemMaterial->satuan }}</span>
                                    </div>
                                    <x-partials.error-message name="volume[]" class="d-block"/>
                                    <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                </div>
                                <div class="col-12 col-sm-12 col-md-1 mb-3">
                                    <x-partials.label title="Aksi" />
                                    <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteList(this)"><i class="bx bx-x"></i></button>
                                </div>
                            </div>
                        @empty
                            @php
                                $kode = bin2hex(random_bytes(10));
                            @endphp
                            <input type="hidden" name="kodeList[]" value="{{ $kode }}">
                            <div class="row" id="list-{{ $kode }}">
                                <div class="col-12">
                                    <div class="divider text-start">
                                        <div class="divider-text" id="nomor-{{ $kode }}">Material 1</div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Nama Material" />
                                    <select name="nama_material[]" id="select-field-{{ $kode }}" class="form-control w-100 @error('nama_material') is-invalid @enderror">
                                        <option value="" data-kode_material="0" data-harga="0" selected disabled>Pilih nama material...</option>
                                        @foreach ($stokMaterial as $item)
                                            <option value="{{ $item->kode_material }}" data-kode_material="{{ $item->kode_material }}" data-harga="{{ $item->harga }}">{{ $item->nama_material }}</option>
                                        @endforeach
                                    </select>
                                    <x-partials.error-message name="nama_material[]" class="d-block"/>
                                </div>
                                <div class="col-12 col-sm-12 col-md-5 mb-3">
                                    <x-partials.label title="Volume" />
                                    <div class="input-group">
                                        <input type="hidden" name="satuan[]" id="satuan-{{ $kode }}">
                                        <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '')" class="form-control @error('volume') is-invalid @enderror" id="volume-{{ $kode }}" name="volume[]" placeholder="Volume"/>
                                        <span class="input-group-text">satuan*</span>
                                    </div>
                                    <x-partials.error-message name="volume[]" class="d-block"/>
                                    <x-partials.input-desc text="Gunakan ' . ' (titik) untuk angka desimal" />
                                </div>
                                <div class="col-12 col-sm-12 col-md-1 mb-3">
                                    <x-partials.label title="Aksi" />
                                    <button type="button" class="btn btn-danger d-block" data-id="{{ $kode }}"  onclick="deleteList(this)"><i class="bx bx-x"></i></button>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="btnAddMaterial" onclick="addList(this)"><i class="bx bx-plus"></i> Tambah Material</button>
                </div>
            </div>
        </div>

        <div class="col-12 order-2 order-md-1 mb-3">
            <div class="card">
                <h5 class="card-header mb-3">Denah</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mb-3">
                            <x-partials.label title="Nomor Denah" />
                            <input type="text" name="nomor_denah" oninput="this.value = this.value.replace(/[^0-9,]/g, '')" class="form-control @error('nomor_denah') is-invalid @enderror" id="nomor_denah" value="{{ $detail->nomor_denah ?? '' }}">
                            <x-partials.error-message name="nomor_denah" />
                            <x-partials.input-desc text="Pisahkan dengan tanda ' , ' (koma) " />
                        </div>
                        <div class="col-12">
                            <x-partials.label title="Denah" />
                            <div class="card shadow p-3" >
                                <h5 class="card-header">
                                    {{ $jenisKerusakan->lantai }} - {{ $jenisKerusakan->nama }}
                                </h5>
                                <div class="card-body p-4 text-center">
                                    <img src="{{ asset('storage/'.$jenisKerusakan->denah) }}" class="img-fluid" height="300px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

    <div class="row">
        <div class="col-12 order-1 order-md-1">
            <div class="card">
                <div class="card-header">
                    <h5>Foto Kerusakan</h5>
                </div>
                    <div class="card-body mb-0">
                        <form class="dropzone @error('foto_kerusakan') borderRed @enderror" id="dropzone-custom" action="{{ route('ajax.uploadFotoJenisKerusakan') }}" autocomplete="off" novalidate>
                            <div class="fallback">
                                <input name="file" type="file" multiple/>
                            </div>
                            <div class="dz-message">
                                <h3 class="dropzone-msg-title">Upload Foto Kerusakan</h3>
                                <span class="dropzone-msg-desc">Maksimal upload 12 foto</span>
                            </div>
                        </form>
                        @error('foto_kerusakan')
                            <div id="borderRed" style="color: red" class="mt-2">
                                foto kerusakan wajib diisi
                            </div>
                        @enderror
                    </div>
                <div class="card-body mt-0">
                    <div class="row mt-0" id="loadFoto">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 order-1 order-md-1 mt-3 mb-0">
            <div class="card ">
                <div class="card-body">
                    <div class="row justify-content-between d-flex">
                        <div class="col-12 col-sm-auto col-md-auto mb-1 mb-sm-1 mb-md-0 text-center">
                            <a href="{{ route('jenis-kerusakan.index', $detail->detailKerjaID) }}" class="btn btn-secondary me-2 mb-3 mb-sm-3 mb-md-0">Kembali</a>
                            <button type="button" class="btn btn-primary me-2 mb-3 mb-sm-3 mb-md-0" id="btnSimpanPerubahan">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{ asset('assets/vendor/libs/jquery-ui/jquery-ui.js') }}"></script>

        <script>
            Dropzone.autoDiscover = false;
            var countPekerja = [];
            var countItemPekerjaan = [];
            var count = [];
            $(document).ready(function () {
                load_images();
            });
        </script>

        <script>
            $(document).ready(function () {
                // Pekerja
                var pekerja = $("input[name='kodeListPekerja[]']").map(function(){return $(this).val();}).get();
                $.each(pekerja, function (index, value) {
                    countPekerja.push("#nomorPekerja-"+value);
                });
                $.each(countPekerja, function (index, value) {
                    $("#nama_pekerja-" + value.replace('#nomorPekerja-','')).select2({
                        theme: "bootstrap-5",
                        createTag: function (params) {
                            return {
                                id: params.term,
                                text: params.term + $select.data('appendme'),
                                upah: $select.data('upah'),
                                newOption: true
                            }
                        },
                        templateResult: formatPekerjaOptionTemplate,
                    });
                    $("#nama_pekerja-" + value.replace('#nomorPekerja-','')).trigger('change');
                });
                $.each(countPekerja, function (index, value) {
                    $(value).html("Pekerja " + (index+1));
                });

                // Item Pekerjaan
                var itemPekerjaan = $("input[name='kodeListItemPekerjaan[]']").map(function(){return $(this).val();}).get();
                $.each(itemPekerjaan, function (index, value) {
                    countItemPekerjaan.push("#nomorItemPekerjaan-"+value);
                });
                $.each(countItemPekerjaan, function (index, value) {
                    $("#item_pekerjaan-" + value.replace('#nomorItemPekerjaan-','')).select2({
                        theme: "bootstrap-5",
                        createTag: function (params) {
                            return {
                                id: params.term,
                                text: params.term + $select.data('appendme'),
                                harga: $select.data('harga'),
                                newOption: true
                            }
                        },
                        templateResult: formatItemPekerjaanOptionTemplate,
                    });
                    $("#item_pekerjaan-" + value.replace('#nomorItemPekerjaan-','')).trigger('change');
                });
                $.each(countItemPekerjaan, function (index, value) {
                    $(value).html("Item Pekerjaan " + (index+1));
                });
            });
        </script>

        @if ($detail->status_kerusakan == "Tanpa Material")
            <script>
                $(document).ready(function () {
                    var test = $("input[name='kodeList[]']").map(function(){return $(this).val();}).get();
                    $.each(test, function (index, value) {
                        count.push("#nomor-"+value);
                    });
                    $.each(count, function (index, value) {
                        $('#btnAddMaterial').attr('disabled', true);
                        $('#btnAddMaterial').removeClass('btn-outline-success');
                        $('#btnAddMaterial').addClass('btn-outline-secondary');
                        $('#select-field-'+value.replace('#nomor-','')).trigger('change');
                        $('#select-field-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#volume-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#satuan-'+value.replace('#nomor-','')).attr('disabled', true);
                    });
                });
            </script>
        @else
            <script>
                $(document).ready(function () {
                    var test = $("input[name='kodeList[]']").map(function(){return $(this).val();}).get();
                    $.each(test, function (index, value) {
                        count.push("#nomor-"+value);
                    });

                    $.each(count, function (index, value) {
                        $("#select-field-" + value.replace('#nomor-','')).select2({
                            theme: "bootstrap-5",
                            createTag: function (params) {
                                return {
                                    id: params.term,
                                    text: params.term + $select.data('appendme'),
                                    kode_material: $select.data('kode_material'),
                                    harga: $select.data('harga'),
                                    newOption: true
                                }
                            },
                            templateResult: formatMaterialOptionTemplate,
                        });
                        $("#select-field-" + value.replace('#nomor-','')).trigger('change');
                    });
                    $.each(count, function (index, value) {
                        $(value).html("Material " + (index+1));
                    });

                });
            </script>
        @endif

        {{-- @if ($jenisKerusakan->tgl_selesai_pekerjaan == null) --}}
            <script>
                $(document).ready(function () {
                    $("#dikerjakan_oleh").select2({
                        theme: "bootstrap-5",
                    });

                    $("#status_kerusakan").select2({
                        theme: "bootstrap-5",
                    });

                    $("#start_time").datepicker({
                        dateFormat: 'dd/mm/yy',
                    });

                    $("#perbaikan").select2({
                        theme: "bootstrap-5",
                    });

                    var myDropzone = new Dropzone("#dropzone-custom",{
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        autoProcessQueue : true,
                        acceptedFiles : ".png,.jpg,.jpeg",
                        uploadMultiple: true,
                        maxFiles: 10,
                        sending: function(file, xhr, formData){
                            $('#dropzone-custom').removeClass('borderRed');
                            $('#borderRed').remove();
                            formData.append('perbaikan', '{{ $detail->nama_kerusakan }}');
                            formData.append('jenis_kerusakan_id', '{{ $jenisKerusakan->jenisKerusakanID }}');
                        },
                        init:function(){
                            this.on("maxfilesexceeded", function() {
                                if (this.files[1]!=null){
                                this.removeFile(this.files[0]);
                                }
                            });
                            this.on("complete", function(){
                                if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
                                {
                                    var _this = this;
                                    _this.removeAllFiles();
                                }
                                load_images();
                            });
                        }
                    })
                });
            </script>
        {{-- @endif --}}

        <script>
            function load_images()
            {
                // Mengatur ajax csrf
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    method: "POST",
                    url:"{{ route('ajax.getFotoJenisKerusakan') }}",
                    data: {
                        id: "{{ $jenisKerusakan->jenisKerusakanID }}"
                    },
                    dataType: "json",
                    success:function(response){
                        $('#loadFoto').html('');
                        var foto = response.data;
                        if (foto.length == 0) {
                            $('#loadFoto').html('<div class="col-12"><div class="alert alert-warning mt-0" role="alert">Belum ada foto kerusakan ditambahkan!</div></div>');
                            $('#cekFoto').html('<input type="hidden" name="cekFoto" value="false" />');
                        }else{
                            var url = "{{ route('pengaturan.menu.update', ':id') }}"; // Action pada form edit
                            url = url.replace(':id', menu.id );
                            $('#cekFoto').html('<input type="hidden" name="cekFoto" value="true" />');
                            $.each(foto, function (index, value) {
                                var url = "{{ asset('storage/:id') }}"; // Action pada form edit
                                url = url.replace(':id', value.foto );
                                $('#loadFoto').append('<div class="col-6 col-sm-6 col-md-3 mb-5 mt-3">'+
                                    '<img src="'+url+'"style="width: 100%;height: auto;">'+
                                    '<button type="button" data-id="'+value.id+'" id="btnHapus-'+value.id+'" class="btn btn-danger mt-2 w-100">Hapus</button>'+
                                '</div>');

                                $('#btnHapus-'+value.id).on('click', function(){
                                    $.ajax({
                                        method: "POST",
                                        url:"{{ route('ajax.deleteFotoJenisKerusakan') }}",
                                        data:{
                                            jenis_kerusakan_id : "{{ $jenisKerusakan->jenisKerusakanID }}",
                                            id: $(this).attr('data-id'),
                                            perbaikan: "{{ $detail->nama_kerusakan }}"
                                        },
                                        success:function(data){
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                icon: "success",
                                                customClass: {
                                                    popup: "colored-toast",
                                                },
                                                showConfirmButton: false,
                                                timer: 1000,
                                            });

                                            (async () => {
                                                await Toast.fire({
                                                    icon: "success",
                                                    title: "Foto berhasil terhapus",
                                                });
                                            })();

                                            load_images();
                                        }
                                    })
                                });
                            });
                        }
                    }
                })
            }
        </script>

        <script>
            $(document).ready(function () {
                $(".imageUpload").change(function () {
                    const file = this.files[0];
                    if (file) {
                        let reader = new FileReader();
                        reader.onload = function (event) {
                            $("#imagePreview").attr("src", event.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            function setMaterialVisible(e){
                if($(e).val() == "Tanpa Material"){
                    $.each(count, function (index, value) {
                        if (index != 0) {
                            $("#list-"+value.replace('#nomor-','')).remove();
                            count = jQuery.grep(count, function (value2) {
                                return value2 != value;
                            });
                        }
                    });

                    $.each(count, function (index, value) {
                        $('#btnAddMaterial').attr('disabled', true);
                        $('#btnAddMaterial').removeClass('btn-outline-success');
                        $('#btnAddMaterial').addClass('btn-outline-secondary');
                        $('#select-field-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#select-field-'+value.replace('#nomor-','')).val('').attr('selected','selected').trigger('change');
                        $('#volume-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#volume-'+value.replace('#nomor-','')).val('');
                        $('#satuan-'+value.replace('#nomor-','')).attr('disabled', true);
                        $('#satuan-'+value.replace('#nomor-','')).val('');
                    });
                }else{
                    $.each(count, function (index, value) {
                        $('#btnAddMaterial').attr('disabled', false);
                        $('#btnAddMaterial').removeClass('btn-outline-secondary');
                        $('#btnAddMaterial').addClass('btn-outline-success');
                        $('#select-field-'+value.replace('#nomor-','')).attr('disabled', false);
                        $('#volume-'+value.replace('#nomor-','')).attr('disabled', false);
                        $('#satuan-'+value.replace('#nomor-','')).attr('disabled', false);

                        $("#select-field-" + value.replace('#nomor-','')).select2({
                            theme: "bootstrap-5",
                            createTag: function (params) {
                                return {
                                    id: params.term,
                                    text: params.term + $select.data('appendme'),
                                    kode_material: $select.data('kode_material'),
                                    harga: $select.data('harga'),
                                    newOption: true
                                }
                            },
                            templateResult: formatMaterialOptionTemplate,
                        });
                    });
                }
            }

            function addList(e) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('ajax.getListHtml') }}",
                    dataType: "json",
                    success: function (response) {
                        if (count.length <= 9) {
                            $(response.list).appendTo("#perbaikanList").hide().fadeIn(200);
                            count.push("#nomor-" + response.kode);
                            $.each(count, function (index, value) {
                                $(value).html("Material " + (index + 1));
                            });
                            $("#select-field-" + response.kode).select2({
                                theme: "bootstrap-5",
                                createTag: function (params) {
                                return {
                                    id: params.term,
                                    text: params.term + $select.data('appendme'),
                                    kode_material: $select.data('kode_material'),
                                    harga: $select.data('harga'),
                                    newOption: true
                                }
                                },
                                templateResult: formatMaterialOptionTemplate,
                            });
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "center",
                                icon: "danger",
                                customClass: {
                                    popup: "colored-toast",
                                },
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            (async () => {
                                await Toast.fire({
                                    icon: "error",
                                    title: "Batas maksimal penginputan perbaikan!",
                                });
                            })();
                        }
                    },
                });
            }

            function deleteList(e) {
                $.each(count, function (index, value) {
                    if (count.length != 1) {
                        count = jQuery.grep(count, function (value) {
                            return value != "#nomor-" + e.dataset.id;
                        });

                        $("#list-" + e.dataset.id).fadeOut(200, function(){
                            $(this).remove();
                        });
                    }

                    if (index == 0) {
                        plus = 1;
                    }else{
                        plus = 0;
                    }

                    $(value).html("Material " + (index+plus));
                });
            }

            function addListPekerja(e) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('ajax.getListPekerjaHtml') }}",
                    dataType: "json",
                    success: function (response) {
                        if (countPekerja.length <= 9) {
                            $(response.list).appendTo("#listPekerja").hide().fadeIn(200);
                            countPekerja.push("#nomorPekerja-" + response.kode);
                            $.each(countPekerja, function (index, value) {
                                $(value).html("Pekerja " + (index + 1));
                            });
                            $("#nama_pekerja-" + response.kode).select2({
                                createTag: function (params) {
                                    return {
                                        id: params.term,
                                        text: params.term + $select.data('appendme'),
                                        upah: $select.data('upah'),
                                        newOption: true
                                    }
                                },
                                templateResult: formatPekerjaOptionTemplate,
                                theme: "bootstrap-5",
                            });
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "center",
                                icon: "danger",
                                customClass: {
                                    popup: "colored-toast",
                                },
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            (async () => {
                                await Toast.fire({
                                    icon: "error",
                                    title: "Batas maksimal penginputan perbaikan!",
                                });
                            })();
                        }
                    },
                });
            }

            function deleteListPekerja(e) {
                $.each(countPekerja, function (index, value) {
                    if (countPekerja.length != 1) {
                        countPekerja = jQuery.grep(countPekerja, function (value) {
                            return value != "#nomorPekerja-" + e.dataset.id;
                        });

                        $("#list-pekerja-" + e.dataset.id).fadeOut(200, function(){
                            $(this).remove();
                        });
                    }

                    $('#nama_pekerja-'+e.dataset.id).val('').trigger('change');
                    $('#satuan_pekerja-'+e.dataset.id).val('');
                    $('#volume_pekerja-'+e.dataset.id).val('');

                    if (index == 0) {
                        plus = 1;
                    }else{
                        plus = 0;
                    }

                    $(value).html("Pekerja " + (index+plus));
                });
            }

            function addListItemPekerjaan(e) {
                $.ajaxSetup({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('ajax.getListItemPekerjaanHtml') }}",
                    dataType: "json",
                    success: function (response) {
                        if (countItemPekerjaan.length <= 8) {
                            $(response.list).appendTo("#listItemPekerjaan").hide().fadeIn(200);
                            countItemPekerjaan.push("#nomorItemPekerjaan-" + response.kode);
                            $.each(countItemPekerjaan, function (index, value) {
                                $(value).html("Item Pekerjaan " + (index + 2));
                            });
                            $("#item_pekerjaan-" + response.kode).select2({
                                createTag: function (params) {
                                    return {
                                        id: params.term,
                                        text: params.term + $select.data('appendme'),
                                        harga: $select.data('harga'),
                                        newOption: true
                                    }
                                },
                                templateResult: formatItemPekerjaanOptionTemplate,
                                theme: "bootstrap-5",
                            });
                        } else {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "center",
                                icon: "danger",
                                customClass: {
                                    popup: "colored-toast",
                                },
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            (async () => {
                                await Toast.fire({
                                    icon: "error",
                                    title: "Batas maksimal penginputan perbaikan!",
                                });
                            })();
                        }
                    },
                });
            }

            function deleteListItemPekerjaan(e) {
                $.each(countItemPekerjaan, function (index, value) {
                    if (countItemPekerjaan.length != 1) {
                        countItemPekerjaan = jQuery.grep(countItemPekerjaan, function (value) {
                            return value != "#nomorItemPekerjaan-" + e.dataset.id;
                        });

                        $("#list-item-pekerjaan-" + e.dataset.id).fadeOut(200, function(){
                            $(this).remove();
                        });
                    }

                    $('#item_pekerjaan-'+e.dataset.id).val('').trigger('change');
                    $('#satuan_item_pekerjaan-'+e.dataset.id).val('');
                    $('#volume_item_pekerjaan-'+e.dataset.id).val('');

                    if (index == 0) {
                        plus = 1;
                    }else{
                        plus = 0;
                    }

                    $(value).html("Item Pekerjaan " + (index+plus));
                });
            }

            $('#btnSimpanPerubahan').on('click', function () {
                $('#btnStatus').val('simpanPerubahanSOM')

                var submit1 = false;
                var submit2 = false;
                var submit3 = false;

                if($('#status_kerusakan').val() != "Tanpa Material"){
                    $.each(count, function (index, value) {
                        if($('#select-field-'+value.replace('#nomor-','')).val() == '' || $('#volume-'+value.replace('#nomor-','')).val() == ''){
                            $('#select-field-'+value.replace('#nomor-','')).addClass('is-invalid');
                            $('#volume-'+value.replace('#nomor-','')).addClass('is-invalid');
                            $(value).css('color','red');
                            submit1 = false;
                        }else{
                            $('#select-field-'+value.replace('#nomor-','')).removeClass('is-invalid');
                            $('#volume-'+value.replace('#nomor-','')).removeClass('is-invalid');
                            $(value).css('color','');
                            submit1 = true;
                        }
                    });
                }else{
                    submit1 = true;
                }

                $.each(countPekerja, function (index, value) {
                    if($('#nama_pekerja-'+value.replace('#nomorPekerja-','')).val() == '' || $('#volume_pekerja-'+value.replace('#nomorPekerja-','')).val() == ''){
                        $('#nama_pekerja-'+value.replace('#nomorPekerja-','')).addClass('is-invalid');
                        $('#volume_pekerja-'+value.replace('#nomorPekerja-','')).addClass('is-invalid');
                        $(value).css('color','red');
                        submit2 = false;
                    }else{
                        $('#nama_pekerja-'+value.replace('#nomorPekerja-','')).removeClass('is-invalid');
                        $('#volume_pekerja-'+value.replace('#nomorPekerja-','')).removeClass('is-invalid');
                        $(value).css('color','');
                        submit2 = true;
                    }
                });

                $.each(countItemPekerjaan, function (index, value) {
                    if($('#item_pekerjaan-'+value.replace('#nomorItemPekerjaan-','')).val() == '' || $('#volume_item_pekerjaan-'+value.replace('#nomorItemPekerjaan-','')).val() == ''){
                        $('#item_pekerjaan-'+value.replace('#nomorItemPekerjaan-','')).addClass('is-invalid');
                        $('#volume_item_pekerjaan-'+value.replace('#nomorItemPekerjaan-','')).addClass('is-invalid');
                        $(value).css('color','red');
                        submit3 = false;
                    }else{
                        $('#item_pekerjaan-'+value.replace('#nomorItemPekerjaan-','')).removeClass('is-invalid');
                        $('#volume_item_pekerjaan--'+value.replace('#nomorItemPekerjaan-','')).removeClass('is-invalid');
                        $(value).css('color','');
                        submit3 = true;
                    }
                });


                if (submit1 == true && submit2 == true && submit3 == true) {
                    $('#formUpdate').submit();
                }else{
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "center",
                        icon: "danger",
                        customClass: {
                            popup: "colored-toast",
                        },
                        showConfirmButton: false,
                        timer: 1000,
                    });

                    (async () => {
                        await Toast.fire({
                            icon: "error",
                            title: "Pastikan form diisi lengkap!",
                        });
                    })();
                }
            });

            $('#btnPekerjaanSelesai').on('click', function () {
                Swal.fire({ // SweetAlert
                    icon: "question",
                    title: "Anda yakin?",
                    text: "Selesaikan pekerjaan sekarang.",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yakin",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) { // Jika iyaa form akan tersubmit
                        $('#btnStatus').val('pekerjaanSelesai')

                        var submit = false;
                        if($('#status_kerusakan').val() != "Tanpa Material"){
                            $.each(count, function (index, value) {
                                if($('#select-field-'+value.replace('#nomor-','')).val() == '' || $('#volume-'+value.replace('#nomor-','')).val() == ''){
                                    $('#select-field-'+value.replace('#nomor-','')).addClass('is-invalid');
                                    $('#volume-'+value.replace('#nomor-','')).addClass('is-invalid');
                                    $(value).css('color','red');
                                    submit = false;
                                }else{
                                    $('#select-field-'+value.replace('#nomor-','')).removeClass('is-invalid');
                                    $('#volume-'+value.replace('#nomor-','')).removeClass('is-invalid');
                                    $(value).css('color','');
                                    submit = true;
                                }
                            });
                        }else{
                            submit = true;
                        }

                        if (submit == true) {
                            $('#formUpdate').submit();
                        }else{
                            const Toast = Swal.mixin({
                                toast: true,
                                position: "center",
                                icon: "danger",
                                customClass: {
                                    popup: "colored-toast",
                                },
                                showConfirmButton: false,
                                timer: 1000,
                            });

                            (async () => {
                                await Toast.fire({
                                    icon: "error",
                                    title: "Pastikan material diisi lengkap!",
                                });
                            })();
                        }
                    }
                });
            });

            function formatMaterialOptionTemplate(state) {

                var originalOption = $(state.element);

                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<div class="mb-0"><u>'+originalOption.data('kode_material')+'</u></div>'+
                    '<div>'+state.text+'</div>'+
                    '<div>Rp. '+formatRupiah(originalOption.data('harga'))+'</div>'+
                    '<div></div>'
                );
                return $state;
            }

            function formatPekerjaOptionTemplate(state) {

                var originalOption = $(state.element);

                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<div class="mb-0"><u>'+state.text+'</u></div>'+
                    '<div>Rp. '+formatRupiah(originalOption.data('upah'))+' (satuan)</div>'+
                    '<div></div>'
                );
                return $state;
            }

            function formatItemPekerjaanOptionTemplate(state) {

                var originalOption = $(state.element);

                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<div class="mb-0"><u>'+state.text+'</u></div>'+
                    '<div>Rp. '+formatRupiah(originalOption.data('harga'))+' (satuan)</div>'+
                    '<div></div>'
                );
                return $state;
            }

            function formatRupiah(angka, prefix = null){
                var number_string = angka.toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 3,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

                if(ribuan){
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                return rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            }

            function readExifMetadata(file, callback) {
                var reader = new FileReader();
                reader.onload = function(e) {
                var exif = EXIF.readFromBinaryFile(new BinaryFile(e.target.result));
                var orientation = exif.Orientation || 1;
                callback(orientation);
                };
                reader.readAsBinaryString(file);
            }

            function rotateImage(file, orientation, callback) {
                var reader = new FileReader();
                reader.onload = function(e) {
                var img = new Image();
                img.onload = function() {
                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");
                    var width = img.width;
                    var height = img.height;
                    // Rotate the image if necessary
                    if ([5, 6, 7, 8].includes(orientation)) {
                    canvas.width = height;
                    canvas.height = width;
                    } else {
                    canvas.width = width;
                    canvas.height = height;
                    }
                    switch (orientation) {
                    case 2: ctx.transform(-1, 0, 0, 1, width, 0); break;
                    case 3: ctx.transform(-1, 0, 0, -1, width, height); break;
                    case 4: ctx.transform(1, 0, 0, -1, 0, height); break;
                    case 5: ctx.transform(0, 1, 1, 0, 0, 0); break;
                    case 6: ctx.transform(0, 1, -1, 0, height, 0); break;
                    case 7: ctx.transform(0, -1, -1, 0, height, width); break;
                    case 8: ctx.transform(0, -1, 1, 0, 0, width); break;
                    default: break;
                    }
                    ctx.drawImage(img, 0, 0);
                    // Convert canvas to data URL
                    var rotatedDataURL = canvas.toDataURL("image/jpeg");
                    callback(rotatedDataURL);
                };
                img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        </script>
    </x-slot>
</x-layouts.app>
