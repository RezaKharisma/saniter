<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Absensi Karyawan</title>
</head>
<body>
    @php
        $bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
    @endphp
    <h3 style="text-align: center;">Laporan Absensi Karyawan</h3>
    <hr/>

    <div style="margin-bottom: 50px">
        <table>
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td>Test</td>
            </tr>
        </table>
    </div>


    <table class="mt-5" border="1" cellspacing="0" cellpadding="5" width="100%">
        <thead>
            <th rowspan="2">No</th>
            <th rowspan="2">Bulan</th>
            @for ($i = 0; $i < 31; $i++)
            <th rowspan="2" width="20px">{{ $i+1 }}</th>
            @endfor
            <th colspan="5" >Total</th>
        </tr>
        <tbody>
            <tr>
                <td style="text-align: center;" width="15px">t</td>
                <td style="text-align: center;" width="15px">a</td>
                <td style="text-align: center;" width="15px">c</td>
                <td style="text-align: center;" width="15px">i</td>
                <td style="text-align: center;" width="15px">s</td>
            </tr>

            @php
                $no=1;
                $normal = [];
                $terlambat = [];
                $alfa = [];
                $cuti = [];
                $izin = [];
                $sakit = [];
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
                                    @php $normal[$bulan[$i]] = !empty($normal[$bulan[$i]]) + 1; @endphp
                                    <td style="text-align: center; background-color: green"> </td>
                                @elseif($item['status'] == "Terlambat")
                                    @php $terlambat[$bulan[$i]] = !empty($terlambat[$bulan[$i]]) + 1; @endphp
                                    <td style="text-align: center; background-color: red"> </td>
                                @elseif($item['status'] == "Alfa")
                                    @php $alfa[$bulan[$i]] = !empty($alfa[$bulan[$i]]) + 1; @endphp
                                    <td style="text-align: center;background-color: grey"> </td>
                                @elseif($item['status'] == "Cuti")
                                    @php $cuti[$bulan[$i]] = !empty($cuti[$bulan[$i]]) + 1; @endphp
                                    <td style="text-align: center; background-color: orange">c</td>
                                @elseif($item['status'] == "Izin")
                                    @php $izin[$bulan[$i]] = !empty($izin[$bulan[$i]]) + 1; @endphp
                                    <td style="text-align: center; background-color: orange">i</td>
                                @elseif($item['status'] == "Sakit")
                                    @php $sakit[$bulan[$i]] = !empty($sakit[$bulan[$i]]) + 1; @endphp
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
                    <td>{{ !empty($terlambat[$bulan[$i]]) ? json_encode($terlambat[$bulan[$i]]) : '' }}</td>
                    <td>{{ !empty($alfa[$bulan[$i]]) ? json_encode($alfa[$bulan[$i]]) : '' }}</td>
                    <td>{{ !empty($cuti[$bulan[$i]]) ? json_encode($cuti[$bulan[$i]]) : '' }}</td>
                    <td>{{ !empty($izin[$bulan[$i]]) ? json_encode($izin[$bulan[$i]]) : '' }}</td>
                    <td>{{ !empty($sakit[$bulan[$i]]) ? json_encode($sakit[$bulan[$i]]) : '' }}</td>
                </tr>
            @php
                $no++;
                // $normal = [];
                // $terlambat[$bulan[$i]] = 0;
                // $alfa[$bulan[$i]] = 0;
                // $cuti[$bulan[$i]] = 0;
                // $izin[$bulan[$i]] = 0;
                // $sakit[$bulan[$i]] = 0;
            @endphp
            @endfor
        </tbody>
    </table>
</body>
</html>
