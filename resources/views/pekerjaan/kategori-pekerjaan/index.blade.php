<x-layouts.app title="Pengaturan">
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan / </span> Kategori Pekerjaan</h4>

<div class="row">
    <div class="col-md-12">

    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('jenis-pekerja.index') }}"><i class="bx bx-user me-1"></i>Jenis Pekerja</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('kategori-pekerjaan.index') }}"><i class="bx bxs-spreadsheet me-1"></i>Kategori Pekerjaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bx bxs-spreadsheet me-1"></i>Sub Kategori Pekerjaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bx bx-collection me-1"></i>Item Pekerjaan</a>
        </li>
    </ul>

    {{-- <ul class="nav nav-pills flex-md-row mb-3">
            <li class="nav-item">
                <a class="nav-link btn-regional" href="#"></a><i class="bx bx-plus-circle me-1"></i> Judul Pekerjaan </a>
            </li>

            <li class="nav-item">
                <a class="nav-link btn-regional" href="#"></a><i class="bx bx-plus-circle me-1"></i> Item Pekerjaan </a>
            </li>
    </ul> --}}
        <div class="card mb-4">
            <h5 class="card-header">
                Kategori Pekerjaan
            </h5>

            <div class="card-body">
            <a href="{{ route('kategori-pekerjaan.create') }}" class="mb-4 btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Kategori Pekerjaan
            </a>
                <table class="table table-hover" id="izin-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kategori Pekerjaan</th>
                            {{-- <th>Jenis Pekerja</th> --}}
                            <th>aksi</th>
                        </tr>
                    </thead>

                    <?php
                        $no = 0; 
                        foreach($kategori as $k) {
                            $no++; 
                        ?>
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $k->nama }}</td>
                                    <td><button type="button" class="btn btn-sm btn-danger">Delete</button></td>
                                </tr>
                            </tbody>
                        <?php } ?>

                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Kategori Pekerjaan</th>
                            {{-- <th>Jenis Pekerja</th> --}}
                            <th>aksi</th>
                        </tr>
                    </tfoot>

                </table>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>
