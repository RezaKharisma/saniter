<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Api\NamaMaterial;
use App\Models\Retur;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxReturController extends Controller
{
    private $namaMaterial;

    public function getRetur(Request $request){
        if ($request->ajax()) {
            $retur = Retur::join('stok_material','retur_material.stok_material_id','=','stok_material.id')->orderBy('retur_material.id', 'DESC')->get();

            $namaMaterial = new NamaMaterial();
            $this->namaMaterial = $namaMaterial->getAllMaterial();

            // Return datatables
            return DataTables::of($retur)
            ->addIndexColumn()
            ->addColumn('kode_material', function($row){
                foreach ($this->namaMaterial as $item) {
                    if ($item['id'] == $row->material_id) {
                        return $item['kode_material'];
                        break;
                    }
                }
            })
            ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                $btn = '';
                // if (auth()->user()->can('stok material list_update')) {
                //     $btn = "<button data-bs-toggle='modal' data-bs-target='#modalIzinEdit' class='btn btn-warning btn-sm d-inline me-1' data-id='".$row->id."' onclick='editData(this)'>Ubah</button>";
                // }
                // if (auth()->user()->can('stok material list_delete')) {
                //     $btn = $btn."<form action=".route('pengaturan.izin.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                // }

                if($row->hasil_retur == "Menunggu Validasi"){
                    $btn = "<button class='btn btn-danger disabled btn-sm d-inline me-1'>Menunggu Validasi</button>";
                }

                if($row->hasil_retur == "Proses"){
                    $btn = "<button class='btn btn-primary disabled btn-sm d-inline me-1'>Proses</button>";
                }

                if($row->hasil_retur == "Diterima"){
                    $btn = "<button class='btn btn-success disabled btn-sm d-inline me-1'>Diterima</button>";
                }

                if($row->hasil_retur == "Pending"){
                    $btn = "<button class='btn btn-warning disabled btn-sm d-inline me-1'>Pending</button>";
                }

                $btn = $btn."<a href=".route('stok-material.retur.detail', $row->kode_material)." class='btn btn-info btn-sm'>Detail</a>";
                return $btn;
            })
            ->rawColumns(['action','kode_material'])
            ->make(true);
        }
    }
}
