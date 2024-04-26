<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Absensi Karyawan</title>
    <style>
        .angry-grid {
           display: grid;

           grid-template-rows: 1fr 1fr 1fr;
           grid-template-columns: 1fr 1fr 1fr 1fr 1fr;

           gap: 0px;
           height: 100%;

        }

        #item-0 {

           background-color: #5BBB7A;
           grid-row-start: 1;
           grid-column-start: 2;

           grid-row-end: 2;
           grid-column-end: 3;

        }
        #item-1 {

           background-color: #B77FD9;
           grid-row-start: 1;
           grid-column-start: 1;

           grid-row-end: 2;
           grid-column-end: 2;

        }

        @page {
            margin-top: 25px;
            margin-bottom: 10px;
            margin-left: 0px !important;
        }
        body {
            font-size: 14px;
            margin-left: 0px !important;
            margin-top: 25px;
            margin-bottom: 10px;
        }
        </style>
</head>
<body>
    @php
        $bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    @endphp

    <h3 style="text-align: center;margin-bottom: 0px; margin-left: 20px; margin-right: 20px;width: 100%">LAPORAN ABSENSI KARYAWAN - SANITER</h3>
    <hr style="margin-bottom: 30px; margin-left: 20px; margin-right: 20px;width: 100%"/>

    <div style="margin-bottom: 10px; margin-left: 20px; margin-right: 20px">
        <table>
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>{{ $user['name'] }}</td>
                <td style="width: 100px"></td>
                <td>Alamat KTP</td>
                <td>:</td>
                <td>{{ $user['alamat_ktp'] }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{ $user['email'] }}</td>
                <td style="width: 100px"></td>
                <td>Alamat Domisili</td>
                <td>:</td>
                <td>{{ $user['alamat_dom'] }}</td>
            </tr>
            <tr>
                <td>Nomor Telepon</td>
                <td>:</td>
                <td>{{ $user['telp'] }}</td>
                <td style="width: 100px"></td>
                <td>Regional</td>
                <td>:</td>
                <td>{{ $user['nama'] }} | {{ $user['nama_bandara'] }} - {{ $user['lokasi_proyek'] }}</td>
            </tr>
            <tr>

            </tr>
        </table>
    </div>


    <table class="mt-5" border="1" cellspacing="0" cellpadding="5" width="100%" style="margin-left: 20px; margin-right: 20px">
        <thead>
            <th rowspan="2" width="5px">No</th>
            <th rowspan="2" width="25px">Bulan</th>
            <th colspan="31">{{ $tahun }}</th>
            <th colspan="6" >Total</th>
        </thead>
        <tbody>
            @for ($i = 0; $i < 31; $i++)
            <th width="20px" align='center'>{{ $i+1 }}</th>
            @endfor
            <th style="text-align: center;" width="15px">n</th>
            <th style="text-align: center;" width="15px">t</th>
            <th style="text-align: center;" width="15px">a</th>
            <th style="text-align: center;" width="15px">c</th>
            <th style="text-align: center;" width="15px">i</th>
            <th style="text-align: center;" width="15px">s</th>

            @php
                $no=1;
            @endphp
            @php
                $normal = [];
                $terlambat = [];
                $alfa = [];
                $cuti = [];
                $izin = [];
                $sakit = [];
                $count = ["Normal"=>0, "Terlambat"=>0, "Alfa"=>0,"Sakit"=>0,"Izin"=>0,"Cuti"=>0];

                for ($i = 0; $i < count($bulan); $i++) {
                    $normal[$bulan[$i]] = 0;
                    $terlambat[$bulan[$i]] = 0;
                    $alfa[$bulan[$i]] = 0;
                    $cuti[$bulan[$i]] = 0;
                    $izin[$bulan[$i]] = 0;
                    $sakit[$bulan[$i]] = 0;
                }
            @endphp
            @for ($i = 0; $i < count($bulan); $i++)
                <tr>
                    <td style="text-align: center">{{ $no }}</td>
                    <td>{{ $bulan[$i] }}</td>
                    @for ($j = 1; $j <= 31; $j++)
                        @php
                            $print = true;
                        @endphp
                        @foreach (json_decode($absen, true) as $item)
                            @if ($print == true && Carbon\Carbon::parse($item['tgl_masuk'])->isoFormat('MMMM') == $bulan[$i] && Carbon\Carbon::parse($item['tgl_masuk'])->format('d') == $j)

                                @if ($item['status'] == "Normal")
                                    @php isset($normal[$bulan[$i]]) ? $normal[$bulan[$i]] += 1 : ''; @endphp
                                    <td style="text-align: center; background-color: green"> </td>
                                @elseif($item['status'] == "Terlambat")
                                    @php isset($terlambat[$bulan[$i]]) ? $terlambat[$bulan[$i]] += 1 : ''; @endphp
                                    <td style="text-align: center; background-color: red"> </td>
                                @elseif($item['status'] == "Alfa")
                                    @php isset($alfa[$bulan[$i]]) ? $alfa[$bulan[$i]] += 1 : ''; @endphp
                                    <td style="text-align: center;background-color: grey"> </td>
                                @elseif($item['status'] == "Cuti")
                                    @php isset($cuti[$bulan[$i]]) ? $cuti[$bulan[$i]] += 1 : ''; @endphp
                                    <td style="text-align: center; background-color: orange">c</td>
                                @elseif($item['status'] == "Izin")
                                    @php isset($izin[$bulan[$i]]) ? $izin[$bulan[$i]] += 1 : ''; @endphp
                                    <td style="text-align: center; background-color: orange">i</td>
                                @elseif($item['status'] == "Sakit")
                                    @php isset($sakit[$bulan[$i]]) ? $sakit[$bulan[$i]] += 1 : ''; @endphp
                                    <td style="text-align: center; background-color: orange">s</td>
                                @endif

                                @php
                                    $print = false;
                                @endphp
                            @endif
                        @endforeach
                        @if ($print == true)
                            <td style="text-align: center;"> </td>
                        @endif
                    @endfor
                    <td>{{ !empty($normal[$bulan[$i]]) ? json_encode($normal[$bulan[$i]]) : '' }}</td>
                    <td>{{ !empty($terlambat[$bulan[$i]]) ? json_encode($terlambat[$bulan[$i]]) : '' }}</td>
                    <td>{{ !empty($alfa[$bulan[$i]]) ? json_encode($alfa[$bulan[$i]]) : '' }}</td>
                    <td>{{ !empty($cuti[$bulan[$i]]) ? json_encode($cuti[$bulan[$i]]) : '' }}</td>
                    <td>{{ !empty($izin[$bulan[$i]]) ? json_encode($izin[$bulan[$i]]) : '' }}</td>
                    <td>{{ !empty($sakit[$bulan[$i]]) ? json_encode($sakit[$bulan[$i]]) : '' }}</td>
                </tr>
            @php
                $no++;
                $count['Normal'] = $normal[$bulan[$i]] + $count['Normal'];
                $count['Terlambat'] = $terlambat[$bulan[$i]] + $count['Terlambat'];
                $count['Alfa'] = $alfa[$bulan[$i]] + $count['Alfa'];
                $count['Sakit'] = $sakit[$bulan[$i]] + $count['Sakit'];
                $count['Izin'] = $izin[$bulan[$i]] + $count['Izin'];
                $count['Cuti'] = $cuti[$bulan[$i]] + $count['Cuti'];

                $normal[$bulan[$i]] = 0;
                $terlambat[$bulan[$i]] = 0;
                $alfa[$bulan[$i]] = 0;
                $cuti[$bulan[$i]] = 0;
                $izin[$bulan[$i]] = 0;
                $sakit[$bulan[$i]] = 0;
            @endphp
            @endfor
            <tr>
                <td colspan="33" align="center"><b>Total</b></td>
                <td align="center">{{ $count['Normal'] }}</td>
                <td align="center">{{ $count['Terlambat'] }}</td>
                <td align="center">{{ $count['Alfa'] }}</td>
                <td align="center">{{ $count['Cuti'] }}</td>
                <td align="center">{{ $count['Izin'] }}</td>
                <td align="center">{{ $count['Sakit'] }}</td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 10px;margin-left: 20px; margin-right: 20px">
        <tr style="border-style: hidden; border-top: 0.5px solid;">
            <td colspan="39">
                <div style="width: 12px;height: 12px;background-color: green"></div>
            </td>
            <td style="font-size: 14px;">: Normal (n)</td>

            <td colspan="39" style="padding-left: 20px">
                <div style="width: 12px;height: 12px;background-color: red"></div>
            </td>
            <td style="font-size: 14px">: Terlambat (t)</td>

            <td colspan="39" style="padding-left: 20px">
                <div style="width: 11px;height: 11px;background-color: grey"></div>
            </td>
            <td style="font-size: 14px">: Alfa (a)</td>

            <td colspan="39" style="padding-left: 20px">
                <div style="width: 11px;height: 11px;background-color: orange"></div>
            </td>
            <td style="font-size: 14px">: Sakit (s) / Cuti (c)</td>
        </tr>
    </table>
    <table style="margin-top: 15px;float: right;margin-left: 20px; margin-right: 20px">
        <tr align="center">
            <td style="font-size: 14px">............... , ......................</td>
        </tr>
        <tr style="border-style: hidden; border-top: 0.5px solid;">
            <td style="font-size: 14px;padding-top:60px">(...........................................)</td>
        </tr>
    </table>
</body>
</html>
