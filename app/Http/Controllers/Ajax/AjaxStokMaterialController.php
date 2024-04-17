<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Api\NamaMaterial;
use App\Models\StokMaterial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxStokMaterialController extends Controller
{
    private $namaMaterial;

    public function getListStokMaterial(Request $request){
        if ($request->ajax()) {
            $stokMaterial = StokMaterial::select('material_id','kode_material','nama_material','harga','masuk','diterima_pm','tanggal_diterima_pm','diterima_spv','tanggal_diterima_spv')
                ->where('diterima_pm', 1)
                ->where('diterima_spv', 1)
                ->where('status_validasi_pm', 'ACC')
                ->whereNot('status_validasi_pm', 'Tolak')
                ->orderBy('id','DESC')
                ->get();

            // Return datatables
            return DataTables::of($stokMaterial)
            ->addIndexColumn()
            ->addColumn('tgl_input', function($row){
                return Carbon::parse($row->created_at)->format('d F Y');
            })
            ->addColumn('harga', function($row){
                return "Rp. ".number_format($row->harga, 0, ",", ".");
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
            ->rawColumns(['action','harga'])
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
                $stokMaterial = StokMaterial::where('diterima_spv', 0)
                    ->orWhere('history', 1)
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
                foreach ($this->namaMaterial as $item) {
                    if ($item['id'] == $row->material_id) {
                        return $item['kode_material'];
                        break;
                    }
                }
            })
            ->addColumn('oleh', function($row){
                return $row->created_by."<p class='text-muted mb-0'>".Carbon::parse($row->created_at)->diffForHumans()."</p>";
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

                if ($row->diterima_pm == 1) {
                    $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>PM</a>";
                }else{
                    $btn = "<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>PM</a>";
                }

                if ($row->diterima_spv == 1) {
                    $btn = $btn."<a href='#' class='btn btn-success btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-check-square'></i>SPV</a>";
                }else{
                    $btn = $btn."<a href='#' class='btn btn-danger btn-sm disabled me-1'><i class='menu-icon tf-icons bx bx-checkbox'></i>SPV</a>";
                }

                if ($row->diterima_pm == 1 && $row->diterima_spv == 1 && $row->history == 1) {
                    $btn = "<a href='#' class='btn btn-success btn-sm disabled me-1'>History</a>";
                }


                $btn = $btn."<a href=".route('stok-material.pengajuan.detailPengajuan', $row->id)." class='btn btn-info btn-sm'>Detail</a>";
                return $btn;
            })
            ->rawColumns(['action','oleh','kode_material','status'])
            ->make(true);
        }
    }
}
