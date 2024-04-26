<x-layouts.app title="Jenis Pekerja">
    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pekerjaan /</span> Jenis Pekerja</h4>

    

    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item">
            <a class="nav-link active" href="{{ route('jenis-pekerja.index') }}"><i class="bx bx-user me-1"></i>Jenis Pekerja</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('kategori-pekerjaan.index') }}"><i class="bx bxs-spreadsheet me-1"></i>Kategori Pekerjaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bx bxs-spreadsheet me-1"></i>Sub Kategori Pekerjaan</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"><i class="bx bx-collection me-1"></i>Item Pekerjaan</a>
        </li>
    </ul>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header mb-3">Data Jenis Pekerja</h5>

            {{-- @can('user_create') --}}
            <div class="card-body">
                <a href="{{ route('jenis-pekerja.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus"></i> Tambah Jenis Pekerja
                </a>
            </div>
            {{-- @endcan --}}

            <div style="position: relative">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover nowrap" id="user-table" width="100%">
                        <thead>
                            <th>No</th>
                            <th>Jenis Pekerja</th>
                            <th>Aksi</th>
                        </thead>
                        
                        <?php
                        $no = 0; 
                        foreach($users as $u) {
                            $no++; 
                        ?>
                            <tbody>
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $u->nama }}</td>
                                    <td><button type="button" class="btn btn-sm btn-danger">Delete</button></td>
                                </tr>
                            </tbody>
                        <?php } ?>

                        <tfoot>
                            <th>No</th>
                            <th>Jenis Pekerja</th>
                            <th>Aksi</th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</x-layouts.app>
