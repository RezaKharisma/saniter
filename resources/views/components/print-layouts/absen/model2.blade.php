<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rekap Absensi Karyawan</title>

    <style>
        @page {
            margin-bottom: 120px;
            margin-top: 180px;
            margin-left: 0px !important;
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

            /** Extra personal styles **/
            color: white;
            text-align: center;
            line-height: 35px;

            display: block;
            content: "";
        }

        footer {
            position: fixed;
            bottom: -40px;
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
        <img src="{{ public_path('assets/img/print/header.jpeg') }}" alt="" >
    </header>

    <footer>
        <img src="{{ public_path('assets/img/print/footer.jpeg') }}" alt="" width="73%">
    </footer>

    <div style="width: 90%;margin: auto">

        <div class="spacer"></div>

        <h3 style="text-align: center;margin-bottom: 30px; margin-left: 20px; margin-right: 20px;width: 100%">REKAP ABSENSI KARYAWAN - SANITER</h3>
        {{-- <hr style="margin-bottom: 30px; margin-left: 20px; margin-right: 20px;width: 100%"/> --}}

        <div style="margin-bottom: 10px; margin-left: 20px; margin-right: 20px;width:100%">

            <table style="margin-bottom: 20px">
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ $start }} - {{ $end }}</td>
                </tr>
            </table>

            <table class="table" border="1" width="100%">
                <thead>
                    <th rowspan="2">No</th>
                    <th rowspan="2">Nama Karyawan</th>
                    <th colspan="6">Status</th>
                </thead>
                <tbody>
                    <tr>
                        <th width="100px">Normal</th>
                        <th width="100px">Terlambat</th>
                        <th width="100px">Alfa</th>
                        <th width="100px">Cuti</th>
                        <th width="100px">Sakit</th>
                        <th width="100px">Izin</th>
                    </tr>
                    @php
                        $no=1;
                        $status = ['Normal','Terlambat','Alfa','Cuti','Izin','Sakit'];
                    @endphp
                    @foreach ($user as $key => $item)
                        <tr>
                            <td align="center" width="30px">{{ $no; }}</td>
                            <td style="padding-left: 10px">{{ $key; }}</td>

                            @for ($i = 0; $i < count($status); $i++)
                                @if (isset($item[$status[$i]]))
                                    <td align="center">{{ $item[$status[$i]] }}</td>
                                @else
                                    <td> </td>
                                @endif
                            @endfor
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
