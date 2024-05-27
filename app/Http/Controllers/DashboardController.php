<?php

namespace App\Http\Controllers;

use App\Charts\KerusakanChart;
use App\Charts\StokMaterialChart;
use Carbon\Carbon;
use App\Models\Izin;
use App\Models\Menu;
use App\Models\User;
use App\Models\Absen;
use App\Models\Pekerja;
use App\Models\SubMenu;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use App\Models\DetailPekerja;
use App\Models\ItemPekerjaan;
use App\Models\JenisKerusakan;

use App\Models\KategoriPekerjaan;
use App\Models\DetailItemPekerjaan;
use App\Models\DetailJenisKerusakan;
use App\Models\SubKategoriPekerjaan;
use Illuminate\Support\Facades\DB;

use function App\Helpers\getUserRole;
use Spatie\Permission\Models\Permission;

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
