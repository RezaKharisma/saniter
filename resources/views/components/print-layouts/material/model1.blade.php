<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Stok Material</title>

    <style>
        @page {
            margin-bottom: 120px;
            margin-top: 180px;
            /* margin-left: 0px !important; */
        }
        /* body {
            font-size: 14px;
            margin-left: 0px !important;
            margin-top: 25px;
            margin-bottom: 10px;
        } */

        .table , .table th, .table td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <style>
        header {
            position: fixed;
            top: -180px;
            left: 0px;
            right: 0px;
            height: 500px;
            width: 100%;
            margin: auto;

            /** Extra personal styles **/
            color: white;
            text-align: center;
            line-height: 35px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            width: 100%;

            /** Extra personal styles **/
            color: white;
            text-align: center;
            line-height: 35px;
            break-after: always;
        }

        .spacer
        {
            width: 100%;
            height: 0px;
        }

        body {
            font-size: 16px;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('assets/img/print/header.jpeg') }}" alt="" width="100%">
    </header>

    <footer>
        <img src="{{ public_path('assets/img/print/footer.jpeg') }}" alt="" width="100%">
    </footer>

    <div style="width: 100%;margin-left:0px !important">

        <div class="spacer"></div>

        <h3 style="text-align: center;margin-bottom: 30px; margin-right: 20px;width: 100%">LIST STOK MATERIAL - SANITER</h3>
        {{-- <hr style="margin-bottom: 30px; margin-right: 20px;width: 100%"/> --}}

        <div style="margin-bottom: 10px; margin-right: 20px;width:100%">

            <table style="margin-bottom: 20px">
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ $start }} - {{ $end }}</td>
                </tr>
            </table>

            <table class="table" border="1" width="100%">
                <thead>
                    <th>No</th>
                    <th>Kode Material</th>
                    <th>Nama Material</th>
                    <th>Stok</th>
                    <th>Harga</th>
                </thead>
                <tbody>
                    @php
                        $no=1;
                    @endphp
                    @foreach ($list as $key => $item)
                        <tr>
                            <td align="center">{{ $no }}</td>
                            <td style="padding-top: 10px;padding-left: 10px;padding-bottom: 10px">{{ $item->kode_material }}</td>
                            <td style="padding-top: 10px;padding-left: 10px;padding-bottom: 10px">{{ $item->nama_material }}</td>
                            <td align="center">{{ $item->stok_update }}</td>
                            <td align="center">Rp. {{ number_format($item->harga,'0','','.') }}</td>
                        </tr>
                    @php
                        $no++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
