<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Harian Proyek</title>

    <style>

        ol {
            margin: 0px !important;
            padding-left: 20px !important;
        }

        /* li:before {
            margin-top: 0px !important;
            top: 0px !important;
            padding-top: 0px !important;
            vertical-align: top;
            padding-right: 10px;
        } */

        .table{
            border: 1px solid black;
            border-collapse: collapse;
        }

        /* .table th{
            border: 1px solid black;
            border-collapse: collapse;
        }

        .table td{
            border: 1px solid black;
            border-collapse: collapse;
        } */


        @page {
            margin-top: 20px;
            margin-bottom: 10px;
            margin-left: 10px !important;
            margin-right: 10px !important;
        }
        body {
            font-size: 12px;
            margin-left: 10px !important;
            margin-right: 10px !important;
            /* margin-top: 25px; */
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    @foreach ($data as $key => $itemKerusakan)
    <div style=" @if(!$loop->last) page-break-after:always; @endif">
        <table style="margin: auto" border="1" width="100%" class="table">
            <tr align="center" >
                <th style="padding: 10px" colspan="3">
                    PEMBERI TUGAS
                </th>
                <th colspan="2">
                    KONTRAKTOR
                </th>
            </tr>
            <tr align="center">
                <td style="padding: 10px" colspan="3">
                    <img src="https://testing.limtek.co.id/assets/img/logo/angkasa-pura-text.png" alt="" width="200px">
                </td>
                <td style="padding: 10px" colspan="2">
                    <img src="https://testing.limtek.co.id/assets/img/logo/qinar-text.jpg" alt="" width="200px">
                </td>
            </tr>
            <tr align="center">
                <td colspan="2" style="padding: 10px; font-weight: bold" colspan="5">LAPORAN HARIAN</td>
            </tr>
            <tr>
                <td colspan="3" width="20%">
                    <table width="100%" border="0" style="border: 0px solid !important;padding: 10px;">
                        <tr>
                            <td width="180px">No Kontrak</td>
                            <td>:</td>
                            <td>APP.1268/KTR/2021/DU</td>
                        </tr>
                        <tr>
                            <td>Tanggal Kontrak</td>
                            <td>:</td>
                            <td>25 November 2021</td>
                        </tr>
                        <tr>
                            <td style="padding-top: 0px;vertical-align: top">Pekerjaan</td>
                            <td style="vertical-align: top">:</td>
                            <td style="text-align: justify">Perawatan perbaikan toilet di terminal internasional, terminal domestik, gedung MLCP Internasional serta perawatan dan perbaikan di gedung MLCP domestik di Bandar Udara Internasional I Gusti Ngurah Rai Bali</td>
                        </tr>
                    </table>
                </td>
                <td colspan="2" style="vertical-align: top">
                    <table width="100%" border="0" style="border: 0px solid !important;padding: 10px;">
                        <tr>
                            <td>Tanggal Laporan Harian</td>
                            <td>:</td>
                            <td>{{ Carbon\Carbon::parse($key)->isoFormat('dddd, D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <td>Penyedia Barang</td>
                            <td>:</td>
                            <td>PT. Qinar Raya Mandiri</td>
                        </tr>
                        <tr>
                            <td>Pemberi Tugas</td>
                            <td>:</td>
                            <td>PT. Angkasa Pura Property</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="5" style="padding: 5px;">TENAGA KERJA</td>
            </tr>
            <tr style="" align="center">
                <td width="100px">PERSONALIA</td>
                <td style="padding: 5px" width="60px">JUMLAH <br/> (orang)</td>
                <td width="400px">URAIAN PEKERJAAN </td>
                <td width="100px">VOL. PEK.</td>
                <td>LOKASI PEKERJAAN</td>
            </tr>
            <tr>
                <td style="padding: 10px;vertical-align: top">
                    <table width="100%" border="0">
                        <tr>
                            <td>Supervisor</td>
                        </tr>
                        <tr>
                            <td>Man Power</td>
                        </tr>
                    </table>
                </td>
                <td style="padding: 10px;vertical-align: top;">
                    <table width="100%" border="0">
                        <tr align="center">
                            <td>3</td>
                        </tr>
                        <tr align="center">
                            <td>6</td>
                        </tr>
                    </table>
                </td>
                <td style="padding: 10px;vertical-align: top">
                    <ol>
                        @foreach ($itemKerusakan as $item)
                            <li style="margin-bottom: 10px">
                                <span class="d-block">({{ $item['jenis_kerusakan']['nama_kerusakan'] }}) {{ ucfirst($item['jenis_kerusakan']['deskripsi']) }}</span>
                                <ul style="padding-left: 0px;list-style-type: none">
                                    @if (isset($item['detail_pekerja']))
                                        @foreach ($item['detail_pekerja'] as $item_pekerja)
                                        <li>- {{ $item_pekerja['nama'] }}</li>
                                        @endforeach
                                    @endif

                                    @if (isset($item['detail_item_pekerjaan']))
                                        @foreach ($item['detail_item_pekerjaan'] as $item_pekerjaan)
                                        <li>- {{ $item_pekerjaan['nama'] }}</li>
                                        @endforeach
                                    @endif

                                    @if (isset($item['detail_kerusakan']))
                                        @foreach ($item['detail_kerusakan'] as $item_kerusakan)
                                        <li>- {{ $item_kerusakan['nama_material'] }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ol>
                </td>
                <td style="padding: 10px;vertical-align: top" align="center" width="100px">
                    <ol style="margin-left:0px !important;padding-left: 0px !important;list-style-type: none">
                        @foreach ($itemKerusakan as $item)
                            <li style="margin-left:0px !important;padding-left: 0px !important;margin-bottom: 10px">
                                <span class="d-block">-</span>
                                <ul style="margin-left:0px !important;padding-left: 0px !important;list-style-type: none">
                                    @if (isset($item['detail_pekerja']))
                                    @foreach ($item['detail_pekerja'] as $item_pekerja)
                                        <li style="margin-left:0px !important;padding-left: 0px !important;">
                                            @if ($item_pekerja != null)
                                                {{ $item_pekerja['volume'] }} ({{ $item_pekerja['satuan'] }})
                                            @else
                                                &nbsp;
                                            @endif
                                        </li>
                                    @endforeach
                                    @endif

                                    @if (isset($item['detail_item_pekerjaan']))
                                    @foreach ($item['detail_item_pekerjaan'] as $item_pekerjaan)
                                        <li style="margin-left:0px !important;padding-left: 0px !important;">
                                            @if ($item_pekerjaan != null)
                                                {{ $item_pekerjaan['volume'] }} ({{ $item_pekerjaan['satuan'] }})
                                            @else
                                                &nbsp;
                                            @endif
                                        </li>
                                    @endforeach
                                    @endif

                                    @if (isset($item['detail_kerusakan']))
                                    @foreach ($item['detail_kerusakan'] as $item_kerusakan)
                                        <li style="margin-left:0px !important;padding-left: 0px !important;">
                                            @if ($item_kerusakan != null)
                                                {{ $item_kerusakan['volume'] }} ({{ $item_kerusakan['satuan'] }})
                                            @else
                                                &nbsp;
                                            @endif
                                        </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ol>
                </td>
                <td style="padding: 10px;vertical-align: top">
                    <ol style="margin-left:0px !important;padding-left: 0px !important;list-style-type: none">
                        @foreach ($itemKerusakan as $item)
                            <li style="margin-left:0px !important;padding-left: 0px !important;margin-bottom: 10px">
                                <span class="d-block">{{ $item['jenis_kerusakan']['namaArea'] }} - Nomor Denah ({{ $item['jenis_kerusakan']['nomor_denah'] }})</span>
                                <ul style="margin-left:0px !important;padding-left: 0px !important;list-style-type: none">
                                    @if (isset($item['detail_pekerja']))
                                    @foreach ($item['detail_pekerja'] as $item_pekerja)
                                        <li style="margin-left:0px !important;padding-left: 0px !important;">#&nbsp;</li>
                                    @endforeach
                                    @endif

                                    @if (isset($item['detail_item_pekerjaan']))
                                    @foreach ($item['detail_item_pekerjaan'] as $item_pekerjaan)
                                        <li style="margin-left:0px !important;padding-left: 0px !important;">#&nbsp;</li>
                                    @endforeach
                                    @endif

                                    @if (isset($item['detail_kerusakan']))
                                    @foreach ($item['detail_kerusakan'] as $item_kerusakan)
                                        <li style="margin-left:0px !important;padding-left: 0px !important;">#&nbsp;</li>
                                    @endforeach
                                    @endif
                                </ul>
                            </li>
                        @endforeach
                    </ol>
                </td>
            </tr>
            <tr align="center">
                <td style="border-top: 1px solid white !important;padding: 10px;">Jumlah</td>
                <td style="border-top: 1px solid white !important">9</td>
                <td style="border-top: 1px solid white !important"></td>
                <td style="border-top: 1px solid white !important"></td>
                <td style="border-top: 1px solid white !important"></td>
            </tr>
            <tr>
                <td colspan="5" style="padding-left: 10px; padding-top: 20px; padding-bottom: 20px">Keterangan : </td>
            </tr>
            <tr>
                <td colspan="5">
                    <table width="100%" border="0" style="padding: 10px">
                        <tr align="center">
                            <td>
                                Disetujui oleh:<br/>
                                <b>PT. ANGKASA PURA PROPERTY</b>
                            </td>
                            <td width="30%"></td>
                            <td>
                                Dibuat oleh:<br/>
                                <b>PT. QINAR RAYA MANDIRI</b>
                            </td>
                        </tr>
                        <tr align="center">
                            <td><div style="height: 70px;"></div><hr style="width: 70%; border: 0.5px solid black">PROJECT MANAGER</td>
                            <td></td>
                            <td><div style="height: 70px;"></div><hr style="width: 70%; border: 0.2px solid black">SUPERVISOR</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    @endforeach
</body>
</html>
