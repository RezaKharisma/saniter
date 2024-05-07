<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dokumentasi</title>
    <style>
        header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 500px;

                /** Extra personal styles **/
                color: white;
                text-align: center;
                line-height: 35px;

                display: block;
                content: "";
            }

            footer {
                position: fixed;
                bottom: 25px;
                left: 0px;
                right: 0px;
                height: 50px;
                width: 100%

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            .spacer
            {
                width: 100%;
                height: 100px;
            }

            body {
                font-size: 16px;
            }
    </style>
</head>
<body>
    <header>
        <img src="{{ public_path('assets/img/print/header.jpeg') }}" alt="">
    </header>

    <footer>
        <img src="{{ public_path('assets/img/print/footer.jpeg') }}" alt="" width="112%">
    </footer>

    <div class="content" style="margin-top: 90px">
        <div style="text-align: center">
            <h5>{{ $area->regionalNama }} | {{ $area->areaNama }}</h5>
            <h2 style="margin-top: -15px">Dokumentasi Pekerjaan</h2>
            <h5 style="margin-top: -10px">{{ $start }} - {{ $end }}</h5>
        </div>

        <div style="margin-top: 30px">
            @foreach (json_decode($jenis_kerusakan) as $key => $item)
                @if (($key % 2) == 0 && !$loop->first)
                    <div class="spacer"></div>
                @endif
                <div @if($key % 2 == 1 && !$loop->last) style="page-break-after:always;margin-top:30px;" @endif>
                    @if (!$loop->first && ($key % 2) != 0)
                        <hr width="100%" style="margin-bottom: 20px;border-style: dashed"/>
                    @endif

                    <table style="margin-top: 10px">
                        <tr>
                            <td style="font-weight: bold">{{ Carbon\Carbon::parse($item->data->tgl_selesai_pekerjaan)->isoFormat('dddd, D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <td>Dikerjakan Oleh</td>
                            <td>:</td>
                            <td>{{ $item->data->namaKaryawan }}</td>
                        </tr>
                        <tr>
                            <td>Kerusakan</td>
                            <td>:</td>
                            <td>{{ $item->data->nama_kerusakan }}</td>
                        </tr>
                        <tr>
                            <td>Deskripsi Kerusakan</td>
                            <td>:</td>
                            <td>{{ $item->data->deskripsi }}</td>
                        </tr>
                        <tr>
                            <td>Status Kerusakan</td>
                            <td>:</td>
                            <td>{{ $item->data->status_kerusakan }}</td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td>:</td>
                            <td>{{ $item->data->lantai }} - {{ $item->data->listNama }} (Denah Nomor: {{ $item->data->nomor_denah }})</td>
                        </tr>
                    </table>
                    <table style="margin-top: 20px;margin-bottom: 30px">
                        <tr>
                            @foreach ($item->foto as $key => $foto)
                                @if ($key < 6)
                                    <td><img src="{{ public_path('storage/'.$foto->foto) }}" alt="" height="100px"></td>
                                @else
                                    @break
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($item->foto as $key => $foto)
                                @if ($key >= 6)
                                    <td><img src="{{ public_path('storage/'.$foto->foto) }}" alt="" width="100px"></td>
                                @endif
                            @endforeach
                        </tr>
                    </table>

                    @if ($loop->last && ($key % 2) != 0)
                        <hr width="100%" style="margin-top: 20px; border-style: dashed" />
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
