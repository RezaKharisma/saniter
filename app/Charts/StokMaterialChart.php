<?php

namespace App\Charts;

use App\Models\DetailJenisKerusakan;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StokMaterialChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $totalMaterialDigunakan = $this->totalMaterialDigunakan();

        return $this->chart->pieChart()
            ->addData($totalMaterialDigunakan['volume_material'])
            ->setHeight(250)
            ->setLabels($totalMaterialDigunakan['nama_material']);
    }

    protected function totalMaterialDigunakan()
    {
        $data = DetailJenisKerusakan::groupBy('detail_jenis_kerusakan.kode_material')
            ->join('stok_material', 'detail_jenis_kerusakan.kode_material', '=', 'stok_material.kode_material')
            ->selectRaw('stok_material.nama_material, sum(detail_jenis_kerusakan.volume) as sum')
            ->whereYear('detail_jenis_kerusakan.created_at', Carbon::now()->format('Y'))
            ->limit(5)
            ->get();

        $result = [
            'nama_material' => array(),
            'volume_material' => array()
        ];

        foreach ($data as $item) {
            array_push($result['nama_material'], $item->nama_material);
            array_push($result['volume_material'], floatval($item->sum));
        }

        return $result;
    }
}
