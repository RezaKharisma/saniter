@php
    function intToRoman($integer) {
        // Daftar simbol Romawi dan nilainya
        $romanNumerals = array(
            'M'  => 1000,
            'CM' => 900,
            'D'  => 500,
            'CD' => 400,
            'C'  => 100,
            'XC' => 90,
            'L'  => 50,
            'XL' => 40,
            'X'  => 10,
            'IX' => 9,
            'V'  => 5,
            'IV' => 4,
            'I'  => 1
        );

        $result = '';
        foreach ($romanNumerals as $roman => $value) {
            // Tulis simbol Romawi sesuai nilai yang dapat dikurangi
            $matches = intval($integer / $value);
            $result .= str_repeat($roman, $matches);
            $integer = $integer % $value;
        }
        return $result;
    }
    function intToLetter($integer) {
        // Konversi nilai ke huruf dengan menambahkan nilai ASCII huruf 'A'
        return chr($integer + ord('A') - 1);
    }
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Prestasi Phisik</title>

    <style>
        table{
            border-collapse: collapse;
        }

        table tr{
            padding: 10px;
        }

        table td{
            padding: 10px;
        }

        @page{
            margin-top: 10px;
            margin-left: 10px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        body{
            font-size: 12px;
        }
    </style>

</head>
<body>
    <table border="1" width="100%">
        <thead>
            <th style="padding: 10px" colspan="7">LAMPIRAN LAPORAN MINGGU KE {{ $mingguKe }}</th>
        </thead>
        <thead>
            <th style="padding: 5px" colspan="7">
                PERIODE <br/>
                {{ Carbon\Carbon::parse($start)->isoFormat('dddd, D MMMM Y') }} - {{ Carbon\Carbon::parse($end)->isoFormat('dddd, D MMMM Y') }}
            </th>
        </thead>
        <thead>
            <th rowspan="2">No</th>
            <th rowspan="2">Uraian Pekerjaan</th>
            <th rowspan="2">Volume</th>
            <th rowspan="2">Sat.</th>
            <th>Volume Realisasi</th>
            <th rowspan="2">Harga Satuan <br/> (Rp.)</th>
            <th>Jumlah Harga Relasi</th>
        </thead>
        <thead>
            <th>Minggu Ini</th>
            <th>Minggu Ini</th>
        </thead>
        <tbody>
            @php
                $no = 1;
                $total = 0;
            @endphp
            @foreach ($list as $keyKategori => $kategori)
                <tr>
                    <td align="center">{{ intToRoman($no) }}</td>
                    <td>{{ $keyKategori }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @php
                    $noSub = 1;
                    $subTotal = 0;
                @endphp
                @foreach ($kategori as $keySubKategori => $subKategori)
                    <tr>
                        <td align="center">{{ intToLetter($noSub) }}</td>
                        <td>-- {{ $keySubKategori }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @php
                        $noItem = 1;
                    @endphp
                    @foreach ($subKategori as $keyItemPekerjaan => $itemPekerjaan)
                    @php
                        $subTotal = floatval($subTotal) + $itemPekerjaan['totalHargaDipilih'];
                    @endphp
                        <tr>
                            <td align="center">{{ $noItem }}</td>
                            <td>---- {{ $keyItemPekerjaan }}</td>
                            <td align="center">{{ $itemPekerjaan['volume'] }}</td>
                            <td align="center">{{ $itemPekerjaan['satuan'] }}</td>
                            <td align="center">{{ floatval($itemPekerjaan['totalMingguDipilih']) }}</td>
                            <td align="right">{{ $itemPekerjaan['harga'] }}</td>
                            <td align="right">{{ $itemPekerjaan['totalHargaDipilih'] != 0 ? $itemPekerjaan['totalHargaDipilih'] : "-" }}</td>
                        </tr>
                        @if ($loop->last)
                            <tr>
                                <td colspan="5"></td>
                                <td align="right" style="font-weight: bold; border-right: 1px solid white;border-left: 1px solid white">Sub Total</td>
                                <td align="right" style="font-weight: bold">{{ $subTotal != 0 ? $subTotal : '-' }}</td>
                            </tr>
                        @endif
                    @php
                        $noItem++;
                    @endphp
                    @endforeach
                @php
                    $noSub++;
                    $total = floatval($total) + floatval($subTotal);
                    $subTotal = 0;
                @endphp
                @endforeach
                <tr>
                    <td colspan="5"></td>
                    <td align="right" style="font-weight: bold; border-right: 1px solid white;border-left: 1px solid white">TOTAL</td>
                    <td align="right" style="font-weight: bold">{{ $total }}</td>
                </tr>
            @php
                $no++;
            @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
