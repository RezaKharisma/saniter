<x-layouts.app title=" Nama Material">

    <x-slot name="style">
        <style>
            .table th {
                text-align: left !important;
            }

            .btnBackTransparent{
                color: #ebeef0;
                border-color: rgba(0, 0, 0, 0);
                background: #03c3ec;
            }
        </style>
    </x-slot>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Material /</span> Nama Material</h4>

    <div class="row">
        <div class="col-md-12">

            <div class="card">

                <h5 class="card-header mb-2">Data Nama Material</h5>

                <div class="card-body mb-0">
                    <div class="alert alert-info d-flex" role="alert">
                        <span class="badge badge-center rounded-pill bg-info border-label-info p-3 me-2"><i class="bx bx-info-circle fs-6"></i></span>
                        <div class="d-flex flex-column ps-1">
                            <h6 class="alert-heading d-flex align-items-center mb-1">Info!</h6>
                            <span>Data nama material sinkron dengan Q-tech.</span>
                        </div>
                    </div>
                </div>

                <div style="position: relative">
                    <div class="table-responsive text-nowrap">
                        <table id="nama-material-table" class="table table-hover table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Material</th>
                                    <th>Jenis Pekerjaan</th>
                                    <th>Nama Material</th>
                                    <th>Jenis Material</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
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
                                    <td>Rp. {{ number_format(str_replace(",", "", $item['harga_beli']),0,'','.') }}</td>
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
                                    <th>Jenis Pekerjaan</th>
                                    <th>Nama Material</th>
                                    <th>Jenis Material</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                // Datatables
                $('#nama-material-table').DataTable({
                    pagingType: 'first_last_numbers'
                })
            })
        </script>
    </x-slot>

</x-layouts.app>
