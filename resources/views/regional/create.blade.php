<x-layouts.app title="Tambah Regional">
    <div class="card mb-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Form Tambah Regional</h5>
        </div>
        <form method="post" action="{{ route('regional.add') }}" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="mb-0">
                    <x-partials.label title="Nama Regional" />
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname" class="input-group-text" @error('nama') style="border: 1px solid red" @enderror><i class="bx bx-user"></i></span>
                        <x-partials.input-text name="nama" placeholder="Nama Regional" />
                    </div>
                    <x-partials.error-message name="nama" class="d-block"/>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('regional.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</x-layouts.app>
