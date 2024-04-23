<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Api\NamaMaterial;
use App\Models\HistoryStokMaterial;
use App\Models\StokMaterial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AjaxStokMaterialController extends Controller
{
    private $namaMaterial;

    public function getListStokMaterial(Request $request){
        if ($request->ajax()) {
            $stokMaterial = StokMaterial::select('material_id','kode_material','nama_material','harga','stok_update','masuk','diterima_pm','tanggal_diterima_pm','diterima_spv','tanggal_diterima_spv')
                ->where('diterima_pm', 1)
                ->where('diterima_spv', 1)
                ->where('status_validasi_pm', 'ACC')
                ->whereNot('status_validasi_pm', 'Tolak')
                ->orderBy('id','DESC')
                ->groupBy('kode_material');

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $stokMaterial->whereBetween('tanggal_diterima_pm', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')]);
            }

            if(!empty($request->kode_material)){
                $stokMaterial->where('kode_material', 'LIKE', '%'.$request->kode_material.'%');
            }

            if(!empty($request->nama_material)){
                $stokMaterial->where('nama_material', 'LIKE', '%'.$request->nama_material.'%');
            }

            $data = $stokMaterial->get();

            // Return datatables
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal_diterima_pm', function($row){
                return Carbon::parse($row->tanggal_diterima_pm)->format('d F Y');
            })
            ->addColumn('harga', function($row){
                return "Rp. ".number_format($row->harga, 0, ",", ".");
            })
            ->addColumn('stok_update', function($row){
                $stokLatest = StokMaterial::where('kode_material', 'LIKE', '%'.$row->kode_material.'%')->where('status_validasi_pm', 'ACC')->latest()->first();
                return $stokLatest->stok_update;
            })
            ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                $btn = '';
                // if (auth()->user()->can('stok material list_update')) {
                //     $btn = "<button data-bs-toggle='modal' data-bs-target='#modalIzinEdit' class='btn btn-warning btn-sm d-inline me-1' data-id='".$row->id."' onclick='editData(this)'>Ubah</button>";
                // }
                // if (auth()->user()->can('stok material list_delete')) {
                //     $btn = $btn."<form action=".route('pengaturan.izin.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                // }
                // return $btn;
            })
            ->rawColumns(['action','harga','stok_update','tanggal_diterima_pm'])
            ->make(true);
        }
    }

    // Ambil data menu untuk datatable
    public function getValidIzin(Request $request){
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

    public function getPengajuanStokMaterial(Request $request){
        if ($request->ajax()) {
            // if (auth()->user()->can('validasi_pm_stok_material')) {

            // Select dimana data belum divalidasi PM
            $stokMaterial = StokMaterial::where('diterima_pm', 0)
                ->orWhere('history', 1)
                ->orderBy('history', 'ASC')
                ->orderBy('id', 'DESC')
                ->get();

            // }

            // if (auth()->user()->can('validasi_spv_stok_material')) {
            //     $stokMaterial = StokMaterial::where('diterima_pm', 1)
            //         ->where('diterima_spv', 0)
            //         ->orWhere('history', 1)
            //         ->orderBy('id','DESC')
            //         ->get();
            // }

            $namaMaterial = new NamaMaterial();
            $this->namaMaterial = $namaMaterial->getAllMaterial();

            // Return datatables
            return DataTables::of($stokMaterial)
            ->addIndexColumn()
            ->addColumn('kode_material', function($row){
                return $row->kode_material;
            })
            ->addColumn('oleh', function($row){
                return $row->created_by."<p class='text-muted mb-0'>".Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM Y')."</p>";
            })
            ->addColumn('harga', function($row){
                return "Rp. ".number_format($row->harga, 0, ",", ".");
            })
            ->addColumn('status', function($row){
                if ($row->status_validasi_pm == "Tolak") {
                    return "<span class='badge bg-danger'>Tolak</span>";
                }

                if ($row->status_validasi_pm == "ACC") {
                    return "<span class='badge bg-success'>ACC</span>";
                }

                if ($row->status_validasi_pm == "ACC Sebagian") {
                    return "<span class='badge bg-warning'>ACC Sebagian</span>";
                }

                if ($row->status_validasi_pm == "Belum Validasi") {
                    return "<span class='badge bg-secondary'>Belum Validasi</span>";
                }
            })
            ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                $btn = '';

                // Kondisi validasi SPV
                if ($row->diterima_spv == 1) {
                    $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>SPV</a>";
                }else{
                    $btn = "<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>SPV</a>";
                }

                // Kondisi validasi PM
                if ($row->diterima_pm == 1) {
                    $btn = $btn."<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>PM</a>";
                }else{
                    $btn = $btn."<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>PM</a>";
                }

                // Jika keduanya sudah divalidasi dan merupakan file history
                if ($row->diterima_pm == 1 && $row->diterima_spv == 1 && $row->history == 1) {
                    $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'>History</a>";
                }

                // Tombol detail
                $btn = $btn."<a href=".route('stok-material.pengajuan.detailPengajuan', $row->id)." class='btn btn-info btn-sm'><i class='bx bx-detail'></i></a>";
                return $btn;
            })
            ->rawColumns(['action','oleh','kode_material','status'])
            ->make(true);
        }
    }

    public function getHistoriStokMaterial(Request $request){
        if ($request->ajax()) {
            $histori = HistoryStokMaterial::select('stok_material.nama_material','stok_material.kode_material','jenis_kerusakan.id','detail_jenis_kerusakan.nama','history_stok_material.volume','history_stok_material.satuan','history_stok_material.created_at')
                ->join('stok_material','history_stok_material.stok_material_id','=','stok_material.id')
                ->join('detail_jenis_kerusakan','history_stok_material.detail_jenis_kerusakan_id','=','detail_jenis_kerusakan.id')
                ->join('jenis_kerusakan','detail_jenis_kerusakan.jenis_kerusakan_id','=','jenis_kerusakan.id')
                ->orderBy('id','DESC')
                ->get();

            // Return datatables
            return DataTables::of($histori)
            ->addIndexColumn()
            ->addColumn('stok_material', function($row){
                $html = "<div style='font-weight: bold;'>$row->kode_material</div><div>$row->nama_material</div>";
                return $html;
            })
            ->addColumn('jenis_kerusakan', function($row){
                return 'Perbaikan '.$row->nama;
            })
            ->addColumn('volume', function($row){
                return $row->volume.' satuan';
            })
            ->addColumn('tanggal', function($row){
                return Carbon::parse($row->created_at)->isoFormat('dddd, D MMMM Y');
            })
            ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                return "<a class='btn btn-info btn-sm' href='".route('jenis-kerusakan.detail',$row->id)."'><i class='bx bx-detail'></i></a>";
            })
            ->rawColumns(['action','stok_material','jenis_kerusakan','volume','tanggal'])
            ->make(true);
        }
    }
}
