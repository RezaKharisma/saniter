<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Menu;
use App\Models\User;
use App\Models\Absen;
use GuzzleHttp\Client;
use App\Models\Pekerja;
use App\Models\SubMenu;
use Illuminate\Support\Str;
use App\Models\NamaMaterial;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use App\Models\DetailPekerja;
use App\Models\ItemPekerjaan;
use App\Charts\KerusakanChart;

use App\Models\JenisKerusakan;
use App\Charts\StokMaterialChart;
use App\Models\Api\KaryawanTetap;
use App\Models\KategoriPekerjaan;
use Illuminate\Support\Facades\DB;
use App\Models\Api\User as UserApi;
use App\Models\DetailItemPekerjaan;
use App\Models\DetailJenisKerusakan;
use App\Models\SubKategoriPekerjaan;

use function App\Helpers\getUserRole;
use Spatie\Permission\Models\Permission;
use App\Models\Api\NamaMaterial as NamaMaterialAPI;

class DashboardController extends Controller
{
    public function index(KerusakanChart $kerusakanChart, StokMaterialChart $stokMaterialChart)
    {
        // Statistik
        $userStat = $this->userStatistik()->getOriginalContent();
        $absenStat = $this->absenStatistik();
        $izinStat = $this->izinStatistik();
        $stokStat = $this->stokStatistik();
        $kerusakanStat = $this->kerusakanStatistik()->getOriginalContent();
        $prestasiPhisikStat = $this->prestasiPhisikStatistik()->getOriginalContent();

        // Chart
        $kerusakanChart = $kerusakanChart->build();
        $stokMaterialChart = $stokMaterialChart->build();

        // dd($kerusakanStat);

        return view('dashboard', compact(
            'userStat',
            'absenStat',
            'izinStat',
            'kerusakanStat',
            'stokStat',
            'prestasiPhisikStat',
            'kerusakanChart',
            'stokMaterialChart'
        ));
    }

    // public function test()
    // {
    //     $nama_material = array(
    //         'Bata Ringan Uk.10x20x60 cm',
    //         'Batu Andesit Uk.20x20 cm',
    //         'Batu Andesit Uk.20x40 cm',
    //         'Batu Paras Jogja Uk.20x20 cm',
    //         'Calsiboard (1,22x2,44 m) t = 8 mm',
    //         'Coumpound Gypsum',
    //         'Dot Lantai (perbaikan keramik retak pada sisi ujung keramik)',
    //         'Gypsum Board t = 9 mm',
    //         'Gypsum Tape',
    //         'Homogenous tile 10 x 60 cm',
    //         'Homogenous Tile 60x60/80x80 cm',
    //         'Homogenous Tile 100x100 cm',
    //         'HPL Motif',
    //         'Karet tangga',
    //         'Lemkra',
    //         'Metal Furing',
    //         'Mortar Perekat @40 kg',
    //         'Paku Skrup',
    //         'Pasir Pasang',
    //         'Semen Portland (50kg/sak)',
    //         'Skirting',
    //         'nat lantai',
    //         'Granit Tile 60 x 60 cm',
    //         'Granit Tile 100 x 100 cm',
    //         'Tali Senar',
    //         'Amplas',
    //         'Cat Besi Anti Karat',
    //         'Cat Dinding Setara Jotun Exterior (20 ltr/peil)',
    //         'Cat Dinding Setara Jotun Interior (20 ltr/peil)',
    //         'Cat Epoxy',
    //         'Cat Finishing Kayu/Polituran',
    //         'Cat minyak',
    //         'Cat Nippe ',
    //         'Minyak Cat',
    //         'Plamir Tembok setara ICI',
    //         'cat dinding eksterior weather sheild (26 ltr/peil)',
    //         'Cat Dinding secara Jotun Jotashield (2.5ltr/peil)',
    //         'Cat Vernis',
    //         'Lem Kuning',
    //         'Sealent Indoor 300 ml',
    //         'Calsiboard (1,22x2,44 m) t = 6 mm',
    //         'Calsiboard (1,22x2,44 m) t = 8 mm',
    //         'Coumpound gypsum',
    //         'Gypsum Board t = 9 mm',
    //         'Gypsum Tape',
    //         'Gypsum Tile',
    //         'Hollow galvalum uk.20x20x0.35',
    //         'Hollow galvalum uk.40x40x0.35',
    //         'list siku uk. 3x3 cm',
    //         'list T uk. 5x5x5 cm',
    //         'Metal Furing',
    //         'Paku Skrup ',
    //         'Stringer',
    //         'Acoustic Panel',
    //         'Acrylik 5mm',
    //         'Besi siku uk. 3x3 tebal 2mm',
    //         'body panic bar setara rafes',
    //         'Door Closer Pintu Biasa',
    //         'Door Closer Pintu Besi',
    //         'Engsel Pintu',
    //         'Floor Hinges',
    //         'Gagang Pintu',
    //         'Grendel Pintu',
    //         'Gembok + kunci 50mm',
    //         'Gembok + kunci 70mm',
    //         'Handle Pintu Biasa',
    //         'Handle Pintu Besi',
    //         'Handle Pintu Tarik',
    //         'Handle Pintu Swing Aluminum Pipih',
    //         'handle panic bar setara rafes',
    //         'knop panic bar setara rafes',
    //         'Kunci Pintu Biasa',
    //         'Kunci Pintu Besi',
    //         'List alumunium',
    //         'Lock Case',
    //         'lock case panic bar setara rafes',
    //         'Lock Case Pintu Besi',
    //         'Patch fiting',
    //         'Pelumas Sekualitas WD -40',
    //         'ring panic bar setara rafes',
    //         'Silinder Kunci Pintu Biasa',
    //         'Silinder Kunci Pintu Besi',
    //         'door stopper L/H kubikal',
    //         'door stopper R/H kubikal',
    //         'fitment holder kubikal',
    //         'hinge blind for glass kubikal',
    //         'Hinge L/H kubikal',
    //         'Hinge R/H kubikal',
    //         'lock blind kubikal',
    //         'pedestal kubikal',
    //         'shower lock L/H + lock keep kubikal',
    //         'shower lock R/H + lock keep kubikal',
    //         'stabilising bar kubikal',
    //         'wall bracket kubikal',
    //         'wall connection kubikal',
    //         'Oli',
    //         'Gemuk',
    //         'Kayu papan kamper',
    //         'Triplek 4 mm',
    //         'Paku biasa 2 cm - 12 cm',
    //         'Aksesoris flushing closet',
    //         'Aksesoris flushing urinal',
    //         'Aksesoris tangki closet',
    //         'Battery',
    //         'Body Closet Biasa dengan kualifikasi sekelas Toto',
    //         'Body Closet Difable dengan kualifikasi sekelas Toto C704L',
    //         'Body Closet Jongkok dengan kualifikasi sekelas Toto',
    //         'Body Urinoir dengan kualifikasi sekelas Toto',
    //         'Cermin Wastafel ',
    //         'Fillvalve setara Kohler Type GP 1068030',
    //         'Flapper Red',
    //         'Fleksibel Jet Shower setara Grohe Chrome',
    //         'Flexible Kran 30 cm setara Toto',
    //         'Floor Drain Biasa',
    //         'Floor Drain setara Grohe',
    //         'Flushing Closet Anak setara TV 150 NLJ',
    //         'Flushing closet duduk',
    //         'Flushing Closet Eco Washer setara Toto Type TCW07S',
    //         'Flushing closet jongkok',
    //         'Flushing Closet setara TV 150 NSV 7J',
    //         'Flushing urinal dengan kualifikasi sekelas Toto T60P',
    //         'Gasket urinal',
    //         'Hand dryer dengan kualifikasi sekelas Toto',
    //         'Hand Wall Rest setara Grohe - Shower Holder - Chrome  ',
    //         'Handle Flushing setara Kohler Type 85114-CP',
    //         'Head shower setara Grohe Chrome',
    //         'Jet shower',
    //         'Karet Flush Valve setara Kohler',
    //         'Kran Geser dengan kualifikasi sekelas Toto TX 109 LU',
    //         'Kran setara Grohe Euroeco Elektronic Basin Tap',
    //         'Kran Dinding Musholla / Janitor',
    //         'Kran Push dengan kualifikasi sekelas Toto TX 126LE',
    //         'Kran Wastafel Difable dengan kualifikasi sekelas Toto T205QN',
    //         'Kran Wastafel setara Toto Type T205MB',
    //         'Nut setara Kohler type K - 78132',
    //         'Penutup drain urinoir',
    //         'Plester Pipa ',
    //         'Pop Up Wastafel dengan kualifikasi sekelas Toto THX 3A-1N',
    //         'Rel sleding Dan penggantung',
    //         'Seal Diaphragm setara Kohler',
    //         'Seat Cover',
    //         'Selenoid valve Kran setara Grohe',
    //         'Selenoid Valve Urinoir',
    //         'Setara Onda Keran Tembok 1/2"',
    //         'Setara Onda Jet Shower',
    //         'Setara Onda Keran Wastafel ',
    //         'Setara Onda Keran Musolla 1/2" ',
    //         'Setara Onda Keran Musholla 3/4" ',
    //         'Setara Onda Keran Dapur 1/2" ',
    //         'Setara Onda Shower Mandi ',
    //         'Setara Onda Sifon Wastafel ',
    //         'Setara Onda Stop Keran 1/2" ',
    //         'Setara Onda Floor Drain 1/2"',
    //         'Siphon wastafel dengan kualifikasi sekelas Toto THX 1A-6N',
    //         'stabilising bar kubikal',
    //         'Stop Kran setara Grohe Type 22.017',
    //         'Syphon Wastafel',
    //         'Tutup Closet Eco Washer',
    //         'Wasthafel setara setara Toto',
    //         'Sensor urinal setara grohe',
    //         'sensor urinal setara toto toilet promenade',
    //         'baterai urinal setara toto toilet promenade',
    //         'Cacing Urinal Setara Toto Urinal U57M',
    //         'rumah baterai',
    //         'tutup CO',
    //         'trafo/adapter',
    //         'kabel trafo',
    //         'Dinabolt 12mm',
    //     );

    //     $data = array();
    //     foreach ($nama_material as $a) {
    //         array_push($data, $this->kodeMaterialSaniter($a));
    //     }

    //     dd($data);
    // }

    // private function kodeMaterialSaniter($namaMaterial)
    // {
    //     $nameWithoutSymbols = preg_replace('/[^a-zA-Z0-9\s]/', '', $namaMaterial);

    //     // Buat kode dari huruf pertama dari setiap kata yang relevan
    //     $words = explode(' ', $nameWithoutSymbols); // Pisahkan berdasarkan spasi dan titik
    //     $relevantWords = array_filter($words, function ($word) {
    //         return !empty($word); // Abaikan kata kosong
    //     });

    //     // Ambil huruf pertama dari dua kata pertama
    //     $code = '';
    //     $count = 0;
    //     foreach ($relevantWords as $word) {
    //         if ($count < 2) {
    //             $code .= substr($word, 0, 1);
    //             $count++;
    //         } else {
    //             break;
    //         }
    //     }
    //     $code = strtoupper($code);

    //     $uniqueNumber = str_pad(rand(1, 100), 3, '0', STR_PAD_LEFT);

    //     // Buat kode material dengan format '<kode>-<urutan>'
    //     $materialCode = 'SNTR-' . $uniqueNumber . '-' . $code;

    //     return $materialCode;
    // }

    public function searchMenu(Request $request)
    {
        $submenuAll = SubMenu::select('menu.icon', 'menu.id', 'sub_menu.judul as judulSub', 'sub_menu.url as urlSub', 'menu.judul as judulMenu', 'menu.url as urlMenu')
            ->join('menu', 'sub_menu.id_menu', '=', 'menu.id')
            ->where('menu.show', '1')
            ->where('sub_menu.judul', 'LIKE', '%' . $request->nama . '%')->get();
        $submenu = array();
        foreach ($submenuAll as $s) {
            $permission = Permission::with('roles')->where('id_menu', $s->id)->first();
            if (auth()->user()->can($permission->name)) {
                array_push($submenu, $s);
            }
        }

        $menuAll = Menu::select('judul', 'icon', 'id', 'url')->where('show', '1')->where('judul', 'LIKE', '%' . $request->nama . '%')->get();
        $menu = array();
        foreach ($menuAll as $m) {
            $permission = Permission::with('roles')->where('id_menu', $m->id)->first();
            if (auth()->user()->can($permission->name)) {
                array_push($menu, $m);
            }
        }

        return response()->json(['Menu' => $menu, 'SubMenu' => $submenu]);
    }

    public function userStatistik()
    {
        // Ambil tanggal awal dan akhir dari request atau gunakan default hari ini
        $startDate = Carbon::now()->subWeek();
        $endDate = Carbon::now();

        // Hitung jumlah user pada awal periode
        $initialUserCount = User::where('created_at', '<', $startDate)->count();

        // Hitung jumlah user baru yang ditambahkan pada periode tersebut
        $newUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();

        // Hitung jumlah user yang dihapus pada periode tersebut
        // Asumsikan kita menggunakan soft delete
        $deletedUsers = User::where('is_active', 0)->whereBetween('updated_at', [$startDate, $endDate])->count();

        // Hitung jumlah total user pada akhir periode
        $finalUserCount = $initialUserCount + $newUsers - $deletedUsers;

        // Hitung perubahan user
        $userChange = $finalUserCount - $initialUserCount;

        return response()->json([
            'user_total' => $initialUserCount,
            'user_baru' => $newUsers,
            'user_delete' => $deletedUsers,
            'user_total_akhir' => $finalUserCount,
            'user_berubah' => $userChange,
        ]);
    }

    public function absenStatistik()
    {
        return Absen::whereDate('tgl_masuk', Carbon::today())->count();
    }

    public function izinStatistik()
    {
        return Izin::select('tgl_mulai_izin', 'tgl_akhir_izin')
            ->where('validasi_2', 1)
            ->where('status_validasi_2', 'ACC')
            ->whereMonth('created_at', Carbon::now()->format('m'))
            ->count();
    }

    public function kerusakanStatistik()
    {
        $userTerAktif = JenisKerusakan::select('created_by', DB::raw('count(*) as total'), 'users.name', 'users.foto')
            ->join('users', 'jenis_kerusakan.created_by', '=', 'users.id')
            ->whereYear('jenis_kerusakan.created_at', Carbon::now()->format('Y'))
            ->groupBy('created_by')
            ->limit(5)
            ->get();

        $totalPerTahun = JenisKerusakan::where('tgl_selesai_pekerjaan', '!=', null)->whereYear('created_at', Carbon::now()->format('Y'))->count();

        return response()->json([
            'userTeraktif' => $userTerAktif,
            'totalPerTahun' => $totalPerTahun,
        ]);
    }

    public function prestasiPhisikStatistik()
    {
        $awalMinggu = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $akhirMinggu = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $awalBulan = Carbon::now()->startOfMonth();
        $akhirBulan = Carbon::now()->endOfMonth();

        if ($awalMinggu->format('d') != '01' && $awalMinggu->format('m') != $akhirMinggu->format('m')) {
            $awalMinggu = $awalBulan;
        }

        if ($akhirMinggu->greaterThan($akhirBulan)) {
            $akhirMinggu = $akhirBulan;
        }

        $mingguKe = intval(ceil((Carbon::now()->day + $awalBulan->dayOfWeek) / 7));

        $dataItemPekerjaan = array();

        $kategori_pekerjaan = KategoriPekerjaan::all();

        $grandTotal = 0;

        $dataKategori = array();
        foreach ($kategori_pekerjaan as $kategori) {
            $dataSubKategori = array();
            $sub_pekerjaan = SubKategoriPekerjaan::where('id_kategori_pekerjaan', $kategori->id)->get();

            foreach ($sub_pekerjaan as $sub) {
                $dataItemPekerjaan = array();
                $item_pekerjaan = ItemPekerjaan::where('id_sub_kategori_pekerjaan', $sub->id)->get();

                foreach ($item_pekerjaan as $item) {

                    $total = 0;

                    $itemPekerjaan = DetailItemPekerjaan::where('detail_item_pekerjaan.item_pekerjaan_id', $item->id)
                        ->join('jenis_kerusakan', 'detail_item_pekerjaan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                        ->join('item_pekerjaan', 'detail_item_pekerjaan.item_pekerjaan_id', '=', 'item_pekerjaan.id')
                        ->whereBetween('jenis_kerusakan.tgl_selesai_pekerjaan', [$awalMinggu, $akhirMinggu])
                        ->get();

                    foreach ($itemPekerjaan as $ip) {
                        $total += floatval($total) + floatval($ip->volume);
                    }

                    $i['harga'] = number_format($item->harga, 0, '', '');
                    $i['totalMingguDipilih'] = str_replace(".", ",", floatval($total));
                    $i['totalHargaDipilih'] = floatval($i['totalMingguDipilih']) * $i['harga'];

                    $grandTotal = floatval($grandTotal) + floatval($i['totalHargaDipilih']);

                    $dataItemPekerjaan[$item->nama] = $i;
                }

                $dataSubKategori[$sub->nama] = $dataItemPekerjaan;
            }
            $dataKategori[$kategori->nama] = $dataSubKategori;
        }

        $stokMaterial = StokMaterial::select('material_id', 'kode_material', 'nama_material', 'harga', 'stok_update', 'masuk', 'diterima_pm', 'tanggal_diterima_pm', 'diterima_som', 'tanggal_diterima_som', 'diterima_dir', 'tanggal_diterima_dir')
            ->where('diterima_som', 1)
            ->where('diterima_pm', 1)
            ->where('diterima_dir', 1)
            ->where('status_validasi_dir', 'ACC')
            ->whereNot('status_validasi_dir', 'Tolak')
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($stokMaterial as $stok) {
            $total = 0;

            $detailJenisKerusakan = DetailJenisKerusakan::select('detail_jenis_kerusakan.volume', 'detail_jenis_kerusakan.satuan', 'detail_jenis_kerusakan.harga', 'stok_material.nama_material')
                ->join('jenis_kerusakan', 'detail_jenis_kerusakan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                ->join('stok_material', 'detail_jenis_kerusakan.kode_material', '=', 'stok_material.kode_material')
                ->whereBetween('jenis_kerusakan.tgl_selesai_pekerjaan', [$awalMinggu, $akhirMinggu])
                ->where('detail_jenis_kerusakan.kode_material', $stok->kode_material)
                ->get();

            foreach ($detailJenisKerusakan as $jenisKerusakan) {
                $total += floatval($total) + floatval($jenisKerusakan->volume);
            }

            $i['harga'] = number_format($stok->harga, 0, '', '');
            $i['totalMingguDipilih'] = str_replace(".", ",", floatval($total));
            $i['totalHargaDipilih'] = floatval($i['totalMingguDipilih']) * $i['harga'];

            $grandTotal = floatval($grandTotal) + floatval($i['totalHargaDipilih']);

            $dataKategori['Perlengkapan Material']['Material'][$stok->nama_material] = $i;
        }

        $pekerja = Pekerja::all();

        foreach ($pekerja as $pkj) {
            $total = 0;

            $detailPekerja = DetailPekerja::select('detail_pekerja.volume', 'detail_pekerja.satuan', 'detail_pekerja.upah', 'pekerja.nama')
                ->join('jenis_kerusakan', 'detail_pekerja.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                ->join('pekerja', 'detail_pekerja.pekerja_id', '=', 'pekerja.id')
                ->whereBetween('jenis_kerusakan.tgl_selesai_pekerjaan', [$awalMinggu, $akhirMinggu])
                ->where('detail_pekerja.pekerja_id', $pkj->id)
                ->get();

            foreach ($detailPekerja as $pekerja) {
                $total += floatval($total) + floatval($pekerja->volume);
            }

            $i['harga'] = number_format($pkj->upah, 0, '', '');
            $i['totalMingguDipilih'] = str_replace(".", ",", floatval($total));
            $i['totalHargaDipilih'] = floatval($i['totalMingguDipilih']) * $i['harga'];

            $grandTotal = floatval($grandTotal) + floatval($i['totalHargaDipilih']);

            $dataKategori['Upah']['Upah'][$pkj->nama] = $i;
        }

        return response()->json([
            'grandTotal' => $grandTotal,
            'mingguKe' => $mingguKe
        ]);
    }

    public function stokStatistik()
    {
        $data = DetailJenisKerusakan::join('stok_material', 'detail_jenis_kerusakan.kode_material', '=', 'stok_material.kode_material')
            ->selectRaw('stok_material.nama_material, sum(detail_jenis_kerusakan.volume) as totalSum')
            ->whereYear('detail_jenis_kerusakan.created_at', Carbon::now()->format('Y'))
            ->pluck('totalSum')->first();

        return $data;
    }
}
