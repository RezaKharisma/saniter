<?php

namespace App\Charts;

use Carbon\Carbon;
use App\Models\JenisKerusakan;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class KerusakanChart
{
    protected $chart;

    protected $bulan = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $totalKerusakanPerBulan = $this->totalKerusakanPerBulan();

        return $this->chart->areaChart()
            ->addData('Kerusakan', $totalKerusakanPerBulan)
            ->setXAxis($this->bulan)
            ->setHeight(200)
            ->setGrid();
    }

    private function totalKerusakanPerBulan()
    {
        $totalKerusakan = array();
        $kerusakan = JenisKerusakan::all();
        foreach ($this->bulan as $key => $i) {
            foreach ($kerusakan as $j) {
                $totalCount = 0;
                $totalCount = $j->whereMonth('created_at', $key + 1)->whereYear('created_at', Carbon::now()->format('Y'))->count();

                if ($totalCount != null) {
                    $totalKerusakan[$key] = $totalCount;
                } else {
                    $totalKerusakan[$key] = $totalCount;
                }
                $totalCount = 0;
            }
        }

        return $totalKerusakan;
    }
}
