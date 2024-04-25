<x-layouts.app title="Jenis Pekerja">
    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pekerjaan /</span> Jenis Pekerja</h4>

    {{-- @can('user_create') --}}
        <a href="{{ route('jenis-pekerja.create') }}" class="mb-3 btn btn-primary"><i class="bx bx-plus"></i> Tambah Jenis Pekerja</a>
    {{-- @endcan --}}

    <div class="card">
        <h5 class="card-header mb-3">Data Jenis Pekerja</h5>

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
                                <td>{{ $u->name }}</td>
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

</x-layouts.app>
