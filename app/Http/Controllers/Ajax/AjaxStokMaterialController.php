<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\NamaMaterial;
use App\Models\Api\NamaMaterial as NamaMaterialAPI;
use App\Models\HistoryStokMaterial;
use App\Models\LogHistoryStokMaterial;
use App\Models\StokMaterial;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AjaxStokMaterialController extends Controller
{
    private $namaMaterial;

    public function getListStokMaterial(Request $request)
    {
        if ($request->ajax()) {
            $stokMaterial = StokMaterial::select('material_id', 'kode_material', 'nama_material', 'harga', 'stok_update', 'masuk', 'diterima_pm', 'tanggal_diterima_pm', 'diterima_som', 'tanggal_diterima_som', 'diterima_dir', 'tanggal_diterima_dir')
                ->where('diterima_som', 1)
                ->where('diterima_pm', 1)
                ->where('diterima_dir', 1)
                ->where('status_validasi_dir', 'ACC')
                ->where('status_validasi_som', '<>', 'Tolak')
                ->where('status_validasi_pm', '<>', 'Tolak')
                ->orderBy('id', 'DESC')
                ->groupBy('kode_material');

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $stokMaterial->whereBetween('tanggal_diterima_dir', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')]);
            }

            if (!empty($request->kode_material)) {
                $stokMaterial->where('kode_material', 'LIKE', '%' . $request->kode_material . '%');
            }

            if (!empty($request->nama_material)) {
                $stokMaterial->where('nama_material', 'LIKE', '%' . $request->nama_material . '%');
            }

            $data = $stokMaterial->get();

            // Return datatables
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal_diterima_dir', function ($row) {
                    return Carbon::parse($row->tanggal_diterima_pm)->format('d F Y');
                })
                ->addColumn('harga', function ($row) {
                    return "Rp. " . number_format($row->harga, 0, ",", ".");
                })
                ->addColumn('stok_update', function ($row) {
                    $stokLatest = StokMaterial::where('kode_material', $row->kode_material)->where('status_validasi_dir', 'ACC')->latest()->first();
                    return $stokLatest->stok_update;
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete.
                    $btn = '';
                    // if (auth()->user()->can('stok material list_update')) {
                    //     $btn = "<button data-bs-toggle='modal' data-bs-target='#modalIzinEdit' class='btn btn-warning btn-sm d-inline me-1' data-id='".$row->id."' onclick='editData(this)'>Ubah</button>";
                    // }
                    // if (auth()->user()->can('stok material list_delete')) {
                    //     $btn = $btn."<form action=".route('pengaturan.izin.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                    // }
                    // return $btn;
                })
                ->rawColumns(['action', 'harga', 'stok_update', 'tanggal_diterima_pm'])
                ->make(true);
        }
    }

    // Ambil data menu untuk datatable
    public function getValidIzin(Request $request)
    {
        if ($request->ajax()) {
            $stokMaterial = StokMaterial::find($request->id);
            return response()->json([
                'status' => 'success',
                'id' => $stokMaterial->id,
                'diterima_pm' => $stokMaterial->validasi_1,
                'validasi1nama' => $stokMaterial->validasi_1_by,
                'validasi2' => $stokMaterial->validasi_2,
                'validasi2nama' => $stokMaterial->validasi_2_by
            ]);
        }
    }

    public function getPengajuanStokMaterial(Request $request)
    {
        if ($request->ajax()) {
            // Select dimana data belum divalidasi PM
            $stokMaterial = StokMaterial::where('diterima_dir', 0)
                ->orderBy('history', 'ASC')
                ->orderBy('id', 'DESC')
                ->get();

            // Return datatables
            return DataTables::of($stokMaterial)
                ->addIndexColumn()
                ->addColumn('kode_material', function ($row) {
                    return $row->kode_material;
                })
                ->addColumn('kategori', function ($row) {
                    return ucfirst(strtolower($row->kategori));
                })
                ->addColumn('oleh', function ($row) {
                    return $row->created_by . "<p class='text-muted mb-0'>" . Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM Y') . "</p>";
                })
                ->addColumn('harga', function ($row) {
                    return "Rp. " . number_format($row->harga, 0, ",", ".");
                })
                ->addColumn('status', function ($row) {
                    // Validasi SOM
                    if ($row->status_validasi_som == "Tolak") {
                        $html = "<span class='badge bg-danger d-block w-100 mb-1'>SOM | Tolak</span>";
                    }
                    if ($row->status_validasi_som == "ACC") {
                        $html = "<span class='badge bg-success d-block w-100 mb-1'>SOM | ACC</span>";
                    }

                    if ($row->status_validasi_som == "ACC Sebagian") {
                        $html = "<span class='badge bg-warning d-block w-100 mb-1'>SOM | ACC Sebagian</span>";
                    }

                    if ($row->status_validasi_som == "Belum Validasi") {
                        $html = "<span class='badge bg-secondary d-block w-100 mb-1'>SOM | Belum Validasi</span>";
                    }

                    // Validasi PM
                    if ($row->status_validasi_pm == "Tolak") {
                        $html = $html . "<span class='badge bg-danger w-100'>PM | Tolak</span>";
                    }
                    if ($row->status_validasi_pm == "ACC") {
                        $html = $html . "<span class='badge bg-success w-100'>PM | ACC</span>";
                    }

                    if ($row->status_validasi_pm == "ACC Sebagian") {
                        $html = $html . "<span class='badge bg-warning w-100'>PM | ACC Sebagian</span>";
                    }

                    if ($row->status_validasi_pm == "Belum Validasi") {
                        $html = $html . "<span class='badge bg-secondary w-100'>PM | Belum Validasi</span>";
                    }

                    if ($row->status_validasi_dir == 'ACC') {
                        return "<span class='badge bg-success w-100'>ACC</span>";
                    } else if ($row->status_validasi_dir == 'Tolak') {
                        return "<span class='badge bg-danger w-100'>Tolak</span>";
                    } else {
                        return $html;
                    }
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete.
                    $btn = '';

                    // Kondisi validasi SOM
                    if ($row->diterima_som == 1) {
                        $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>SOM</a>";
                    } else {
                        $btn = "<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>SOM</a>";
                    }

                    // Kondisi validasi PM
                    if ($row->diterima_pm == 1) {
                        $btn = $btn . "<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>PM</a>";
                    } else {
                        $btn = $btn . "<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>PM</a>";
                    }

                    // Kondisi validasi PM
                    if ($row->diterima_dir == 1) {
                        $btn = $btn . "<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>DIR</a>";
                    } else {
                        $btn = $btn . "<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>DIR</a>";
                    }

                    // Jika keduanya sudah divalidasi dan merupakan file history
                    if ($row->diterima_pm == 1 && $row->diterima_som == 1 && $row->diterima_dir == 1 && $row->history == 1) {
                        $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'>History</a>";
                    }

                    // Jika semua menolak
                    // if ($row->status_validasi_som == "Tolak" || $row->status_validasi_pm == "Tolak" || $row->status_validasi_dir == "Tolak") {
                    //     $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'>History</a>";
                    // }

                    // Tombol detail
                    $btn = $btn . "<a href=" . route('stok-material.pengajuan.detailPengajuan', $row->id) . " class='btn btn-info btn-sm'><i class='bx bx-detail'></i></a>";
                    $btn = $btn . "<form action=" . route('stok-material.pengajuan.delete', $row->id) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                    return $btn;
                })
                ->rawColumns(['action', 'oleh', 'kode_material', 'status', 'kategori'])
                ->make(true);
        }
    }
    public function getHistoriPengajuanStokMaterial(Request $request)
    {
        if ($request->ajax()) {
            // Select dimana data belum divalidasi PM
            $stokMaterial = StokMaterial::where('diterima_dir', 1)
                ->where('diterima_som', 1)
                ->where('diterima_pm', 1)
                ->where('status_validasi_dir', 'ACC')
                ->orWhere('history', 1)
                ->orderBy('history', 'ASC')
                ->orderBy('id', 'DESC')
                ->get();

            $namaMaterial = new NamaMaterialAPI();
            $this->namaMaterial = $namaMaterial->getAllMaterial();

            // Return datatables
            return DataTables::of($stokMaterial)
                ->addIndexColumn()
                ->addColumn('kode_material', function ($row) {
                    return $row->kode_material;
                })
                ->addColumn('oleh', function ($row) {
                    return $row->created_by . "<p class='text-muted mb-0'>" . Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM Y') . "</p>";
                })
                ->addColumn('harga', function ($row) {
                    return "Rp. " . number_format($row->harga, 0, ",", ".");
                })
                ->addColumn('status', function ($row) {
                    // Validasi SOM
                    if ($row->status_validasi_som == "Tolak") {
                        $html = "<span class='badge bg-danger d-block w-100'>SOM | Tolak</span>";
                    }
                    if ($row->status_validasi_som == "ACC") {
                        $html = "<span class='badge bg-success d-block  w-100'>SOM | ACC</span>";
                    }

                    if ($row->status_validasi_som == "ACC Sebagian") {
                        $html = "<span class='badge bg-warning d-block w-100'>SOM | ACC Sebagian</span>";
                    }

                    if ($row->status_validasi_som == "Belum Validasi") {
                        $html = "<span class='badge bg-secondary d-block w-100'>SOM | Belum Validasi</span>";
                    }

                    // Validasi PM
                    if ($row->status_validasi_pm == "Tolak") {
                        $html = $html . "<span class='badge bg-danger w-100'>PM | Tolak</span>";
                    }
                    if ($row->status_validasi_pm == "ACC") {
                        $html = $html . "<span class='badge bg-success w-100'>PM | ACC</span>";
                    }

                    if ($row->status_validasi_pm == "ACC Sebagian") {
                        $html = $html . "<span class='badge bg-warning w-100'>PM | ACC Sebagian</span>";
                    }

                    if ($row->status_validasi_pm == "Belum Validasi") {
                        $html = $html . "<span class='badge bg-secondary w-100'>PM | Belum Validasi</span>";
                    }

                    if ($row->status_validasi_dir == 'ACC') {
                        return "<span class='badge bg-success w-100'>ACC</span>";
                    } else if ($row->status_validasi_dir == 'Tolak') {
                        return "<span class='badge bg-danger w-100'>Tolak</span>";
                    } else {
                        return $html;
                    }
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete.
                    $btn = '';

                    // Kondisi validasi SOM
                    if ($row->diterima_som == 1) {
                        $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>SOM</a>";
                    } else {
                        $btn = "<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>SOM</a>";
                    }

                    // Kondisi validasi PM
                    if ($row->diterima_pm == 1) {
                        $btn = $btn . "<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>PM</a>";
                    } else {
                        $btn = $btn . "<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>PM</a>";
                    }

                    // Kondisi validasi PM
                    if ($row->diterima_dir == 1) {
                        $btn = $btn . "<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>DIR</a>";
                    } else {
                        $btn = $btn . "<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>DIR</a>";
                    }

                    // Jika keduanya sudah divalidasi dan merupakan file history
                    if ($row->diterima_pm == 1 && $row->diterima_som == 1 && $row->diterima_dir == 1 && $row->history == 1) {
                        $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'>History</a>";
                    }

                    // Jika semua menolak
                    // if ($row->status_validasi_som == "Tolak" || $row->status_validasi_pm == "Tolak" || $row->status_validasi_dir == "Tolak") {
                    //     $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'>History</a>";
                    // }

                    // Tombol detail
                    $btn = $btn . "<a href=" . route('stok-material.pengajuan.detailPengajuan', $row->id) . " class='btn btn-info btn-sm'><i class='bx bx-detail'></i></a>";
                    // $btn = $btn . "<form action=" . route('stok-material.pengajuan.delete', $row->id) . " method='POST' class='d-inline'>" . csrf_field() . method_field('DELETE') . " <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                    return $btn;
                })
                ->rawColumns(['action', 'oleh', 'kode_material', 'status'])
                ->make(true);
        }
    }

    public function getHistoriStokMaterial(Request $request)
    {
        if ($request->ajax()) {
            $histori = HistoryStokMaterial::select('stok_material.nama_material', 'stok_material.kode_material', 'detail_jenis_kerusakan.total_harga', 'jenis_kerusakan.id', 'detail_jenis_kerusakan.nama', 'history_stok_material.volume', 'history_stok_material.satuan', 'history_stok_material.created_at')
                ->join('stok_material', 'history_stok_material.kode_material', '=', 'stok_material.kode_material')
                ->join('detail_jenis_kerusakan', 'history_stok_material.detail_jenis_kerusakan_id', '=', 'detail_jenis_kerusakan.id')
                ->join('jenis_kerusakan', 'detail_jenis_kerusakan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                ->orderBy('id', 'DESC')
                ->get();

            // Return datatables
            return DataTables::of($histori)
                ->addIndexColumn()
                ->addColumn('stok_material', function ($row) {
                    $html = "<div style='font-weight: bold;'>$row->kode_material</div><div>$row->nama_material</div>";
                    return $html;
                })
                ->addColumn('jenis_kerusakan', function ($row) {
                    return 'Perbaikan ' . $row->nama;
                })
                ->addColumn('volume', function ($row) {
                    return $row->volume . ' satuan';
                })
                ->addColumn('total_harga', function ($row) {
                    return "Rp. " . number_format($row->total_harga, 0, '', '.');
                })
                ->addColumn('tanggal', function ($row) {
                    return Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM Y');
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete.
                    return "<a class='btn btn-info btn-sm' href='" . route('jenis-kerusakan.detail', $row->id) . "'><i class='bx bx-detail'></i></a>";
                })
                ->rawColumns(['action', 'stok_material', 'jenis_kerusakan', 'volume', 'tanggal', 'total_harga'])
                ->make(true);
        }
    }

    public function getLogHistoriStokMaterial(Request $request)
    {
        if ($request->ajax()) {
            $logHistory = LogHistoryStokMaterial::select('users.name', 'jenis_kerusakan.id', 'jenis_kerusakan.nama_kerusakan', 'stok_material.nama_material', 'stok_material.kode_material', 'log_update_history_material.volume', 'log_update_history_material.satuan', 'log_update_history_material.tanggal')
                ->join('users', 'log_update_history_material.user_id', '=', 'users.id')
                ->join('stok_material', 'log_update_history_material.kode_material', '=', 'stok_material.kode_material')
                ->join('jenis_kerusakan', 'log_update_history_material.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
                ->orderBy('log_update_history_material.id', 'DESC')
                ->get();

            // $histori = LogHistoryStokMaterial::select('users.name', 'stok_material.nama_material', 'stok_material.kode_material', 'detail_jenis_kerusakan.total_harga', 'jenis_kerusakan.id', 'detail_jenis_kerusakan.nama', 'log_update_history_material.volume', 'log_update_history_material.satuan', 'log_update_history_material.tanggal')
            //     ->join('stok_material', 'log_update_history_material.kode_material', '=', 'stok_material.kode_material')
            //     ->join('detail_jenis_kerusakan', 'log_update_history_material.detail_jenis_kerusakan_id', '=', 'detail_jenis_kerusakan.id')
            //     ->join('jenis_kerusakan', 'detail_jenis_kerusakan.jenis_kerusakan_id', '=', 'jenis_kerusakan.id')
            //     ->join('users', 'log_update_history_material.user_id', '=', 'users.id')
            //     ->orderBy('id', 'DESC')
            //     ->get();

            // Return datatables
            return DataTables::of($logHistory)
                ->addIndexColumn()
                ->addColumn('stok_material', function ($row) {
                    $html = "<span style='color: red;'>Kembali</span><div style='font-weight: bold;'>$row->kode_material</div><div>$row->nama_material</div>";
                    return $html;
                })
                ->addColumn('jenis_kerusakan', function ($row) {
                    return 'Perbaikan ' . $row->nama_kerusakan;
                })
                ->addColumn('users', function ($row) {
                    return $row->name;
                })
                ->addColumn('volume', function ($row) {
                    return $row->volume . ' satuan';
                })
                ->addColumn('tanggal', function ($row) {
                    $html = Carbon::parse($row->tanggal)->isoFormat('dddd, D MMMM Y') . "<br/>" . Carbon::parse($row->tanggal)->isoFormat('LT') . " " . ucfirst(Carbon::parse($row->tanggal)->isoFormat('A'));
                    return $html;
                })
                ->addColumn('action', function ($row) { // Tambah kolom action untuk button edit dan delete.
                    return "<a class='btn btn-info btn-sm' href='" . route('jenis-kerusakan.detail', $row->id) . "'><i class='bx bx-detail'></i></a>";
                })
                ->rawColumns(['action', 'stok_material', 'jenis_kerusakan', 'volume', 'tanggal', 'users'])
                ->make(true);
        }
    }

    public function getListHtml(Request $request)
    {
        if ($request->ajax()) {
            $material = new NamaMaterialAPI();
            $namaMaterial = $material->getAllMaterial();

            $kode = bin2hex(random_bytes(10));

            $list = view('components.list.list-material', compact('material', 'namaMaterial', 'kode'))->render();

            return response()->json([
                'status' => 'success',
                'list' => $list,
                'kode' => $kode,
            ]);
        }
    }

    public function getListSaniterHtml(Request $request)
    {
        if ($request->ajax()) {
            $namaMaterial = NamaMaterial::all();

            $kode = bin2hex(random_bytes(10));

            $list = view('components.list.list-material-saniter', compact('namaMaterial', 'kode'))->render();

            return response()->json([
                'status' => 'success',
                'list' => $list,
                'kode' => $kode,
            ]);
        }
    }

    public function getNamaMaterialSaniter(Request $request)
    {
        if ($request->ajax()) {

            $namaMaterial = NamaMaterial::find($request->id);

            return response()->json([
                'status' => 'success',
                'data' => $namaMaterial
            ]);
        }
    }
}
