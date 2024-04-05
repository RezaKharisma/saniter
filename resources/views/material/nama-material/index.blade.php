<x-layouts.app title=" Nama Material">

    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material /</span> Nama Material</h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">

                <h5 class="card-header mb-3">Data Nama Material</h5>

                <div class="card-body">

                    <div class="alert alert-info alert-dismissible" role="alert">
                        Data nama material sinkron dengan Q-tech.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <table id="nama-material-table" class="table table-hover table-sm" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Material</th>
                                <th>Jenis Pekerjaan</th>
                                <th>Nama Material</th>
                                <th>Jenis Material</th>
                                <th>Stok</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $no=1;
                            @endphp
                            @foreach ($namaMaterial as $item)
                            <tr>
                                <td>{{ $no; }}</td>
                                <td>{{ $item['kode_material'] }}</td>
                                <td>{{ $item['jenis_pekerjaan'] }}</td>
                                <td>{{ $item['nama_material'] }}</td>
                                <td>{{ $item['jenis_material'] }}</td>
                                <td class="text-center">{{ $item['qty'] }}</td>
                            </tr>
                            @php
                                $no++;
                            @endphp
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Kode Material</th>
                                <th>Nama Material</th>
                                <th>Jenis Material</th>
                                <th>Stok</th>
                            </tr>
                        </tfoot>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // Datatables
                $('#nama-material-table').DataTable({
                    // ajax: "{{ route('material.getNamaMaterial') }}",
                    // processing: true,
                    // serverSide: true,
                    // responsive: true,
                    // columns: [
                    //     {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false },
                    //     {data: 'kode_material', name: 'kode_material'},
                    //     {data: 'nama_material', name: 'nama_material'},
                    //     {data: 'jenis_material', name: 'jenis_material'},
                    //     {data: 'qty', name: 'qty'},
                    // ],
                })
            })
        </script>
    </x-slot>

</x-layouts.app>
