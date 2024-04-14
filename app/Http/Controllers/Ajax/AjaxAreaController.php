<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxAreaController extends Controller
{
    public function getArea(Request $request){
        if ($request->ajax()) {

            $area = Area::select('area.*','area.id as areaId','regional.nama as regionalNama')
                ->join('regional', 'area.regional_id','=','regional.id')
                ->get();

            // Return datatables
            return DataTables::of($area)
            ->addIndexColumn()
            ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                $btn = '';
                if (auth()->user()->can('area_update')) {
                    $btn = "<button data-bs-toggle='modal' data-bs-target='#modalEdit' class='btn btn-warning btn-sm d-inline me-1' data-id='".$row->areaId."' onclick='editData(this)'>Ubah</button>";
                }
                if (auth()->user()->can('area_delete')) {
                    $btn = $btn."<form action=".route('area.delete', $row->areaId)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function getAreaEdit(Request $request){
        if ($request->ajax()) {
            $area = Area::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $area
            ]);
        }
    }
}
