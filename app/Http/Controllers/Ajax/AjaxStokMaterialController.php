<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Api\NamaMaterial;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxStokMaterialController extends Controller
{
    private $namaMaterial;

    public function getStokMaterial(Request $request){
        if ($request->ajax()) {
            $stokMaterial = StokMaterial::all();

            $namaMaterial = new NamaMaterial();
            $this->namaMaterial = $namaMaterial->getAllMaterial();

            // Return datatables
            return DataTables::of($stokMaterial)
            ->addIndexColumn()
            ->addColumn('nama_material', function($row){
                    foreach ($this->namaMaterial as $item) {
                        if ($item['id'] == $row->material_id) {
                            return $item['nama_material'];
                            break;
                        }
                    }
                })
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                    $btn = '';
                    if (auth()->user()->can('stok material_update')) {
                        $btn = "<button data-bs-toggle='modal' data-bs-target='#modalIzinEdit' class='btn btn-warning btn-sm d-inline me-1' data-id='".$row->id."' onclick='editData(this)'>Ubah</button>";
                    }
                    if (auth()->user()->can('stok material_delete')) {
                        $btn = $btn."<form action=".route('pengaturan.izin.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                    }
                    return $btn;
                })
                ->rawColumns(['action','nama_material'])
            ->make(true);
        }
    }
}
