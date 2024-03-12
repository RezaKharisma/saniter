{{-- Modal Edit Menu --}}
<div class="modal fade" id="modalEditMenu" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            {{-- Form Tambah Menu --}}
            <form action="{{ route('pengaturan.menu.update', $menu->id) }}" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @csrf
                @method('PUT')

                <div class="modal-body">

                    {{-- Input Judul --}}
                    <x-input-text title="Judul" name="judul" placeholder="Masukkan judul menu" margin="mb-3" onkeyup="convertToSlug(this)" :value="$menu->judul"/>

                    <div class="row">
                        <div class="col">

                            {{-- Input Kategori --}}
                            <div class="mb-3">
                                <x-partials.label title="Kategori"/>
                                <select id="id_kategori" name="id_kategori" class="form-select @error('id_kategori')is-invalid @enderror" onchange="selectKategori()">
                                    <option value="" selected disabled>Pilih Kategori...</option>
                                    @foreach ($kategori as $item)
                                        <option @if ($menu->id_kategori == $item->id) selected @endif value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                <x-partials.error-message class="d-block" name="id_kategori" />
                            </div>

                        </div>
                        <div class="col">

                            {{-- Input URL --}}
                            <x-input-text title="Url" name="url" id="url" placeholder="Masukkan url menu" :value="$menu->url" />
                            <x-partials.input-desc text="Harap gunakan url sesuai nama kategori." />

                        </div>
                    </div>

                    {{-- Input Order --}}
                    <x-input-number title="Urutan Order" name="order" style="width: 30%" placeholder="Masukkan order" :value="$menu->order" />

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>

                    {{-- Button Submit --}}
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
