<x-layouts.app title="Edit Role">

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan / Role /</span> Edit Role</h4>

    <div class="row mb-4">
        <div class="col-md-12">

            <div class="card">
                <h5 class="card-header">Manajemen Hak Akses</h5>
                {{-- Form Tambah Menu --}}
                <form action="{{ route('pengaturan.role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        {{-- Input Judul --}}
                        <x-input-text title="Role" name="name" placeholder="Masukkan role" margin="mb-3" value="{{ $role->name ?? old('name') }}"/>


                        {{-- Input Permisson --}}
                        <x-partials.label title="Permission"/>
                        <select id="choices-multiple-remove-button" name="permissions[]" placeholder="Pilih permission." multiple>

                            {{-- Perulangan select permissions --}}
                            @foreach ($permissions as $item)

                                {{-- Tetapkan variabel print ke true --}}
                                @php $print = true; @endphp

                                {{-- Perulangan permission pada role yg diedit --}}
                                @for ($i = 0; $i < count($role->permissions); $i++)

                                    {{-- Jika permission pada role yg diedit sesuai dengan nama pada permission --}}
                                    @if ($role->permissions[$i]->name == $item->name)

                                        {{-- Print dan select permission tersebut --}}
                                        <option selected value='{{ $item->name }}'>{{ $item->name }}</option>

                                        {{-- Ubah print ke false karna permission ini sudah tampil dan sudah terselect otomatis --}}
                                        @php $print = false; @endphp
                                    @endif
                                @endfor

                                {{-- Jika permission belum tampil maka print permission tersebut dan jangan diselect--}}
                                @if ($print == true)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>

                <div class="card-footer">
                    {{-- Button Submit --}}
                    <a href="{{ route('pengaturan.role.index') }}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

                </form>

            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                        removeItemButton: true,
                    });
            });
        </script>
    </x-slot>

</x-layouts.app>
