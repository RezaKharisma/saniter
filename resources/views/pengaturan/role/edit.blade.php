<x-layouts.app title="Test">

{{-- Form Tambah Menu --}}
<form id="formEdit" method="POST">
    <div class="modal-header">
        <h5 class="modal-title" id="modalCenterTitle">Edit Role</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    @csrf
    @method('PUT')

    <div class="modal-body">

        {{-- Input Judul --}}
        <x-input-text title="Role" name="name" id="nameEdit" placeholder="Masukkan role" margin="mb-3"/>


        {{-- Input Permisson --}}
        <x-partials.label title="Permission"/>
        <select id="choices-multiple-remove-button" name="permissions[]" placeholder="Pilih hak akses." multiple>
            @foreach ($permissions as $item)

                @for ($i = 0; $i < count($role->permissions); $i++)
                    @if ($role->permissions[$i]->name == $item->name)
                        <option selected value="{{ $item->name }}">{{ $item->name }}</option>
                        @break
                    @endif
                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                @endfor

            @endforeach
        </select>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>

        {{-- Button Submit --}}
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

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
