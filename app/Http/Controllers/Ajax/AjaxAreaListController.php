<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\AreaList;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxAreaListController extends Controller
{
    public function getAreaList(Request $request){
        if ($request->ajax()) {

            $area = AreaList::select('list_area.id','list_area.denah','list_area.lantai','list_area.nama','area.nama as namaArea','area.id as areaId')
                ->join('area','list_area.area_id','=','area.id')
                ->orderBy('id','DESC')
                ->get();

            // Return datatables
            return DataTables::of($area)
            ->addIndexColumn()
            ->addColumn('denah', function($row){
                $nama = "<h4 class='mb-3 mt-3'>".$row->lantai." | ".$row->nama."</h4>";
                $denah = "<a href='".asset('storage/'.$row->denah)."' class='avatar flex-shrink-0' target='_blank'>
                            <img src='".asset('storage/'.$row->denah)."' class='img-fluid mb-4' style='width: 400px;height: auto' />
                        </a>";
                return $nama.$denah;
            })
            ->addColumn('area', function($row){
                $area = Area::select('area.nama as areaNama','regional.nama as regionalNama')->where('area.id', $row->areaId)->join('regional','area.regional_id','=','regional.id')->first();
                return $area->regionalNama." | ".$area->areaNama;
            })
            ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                $btn = '';
                if (auth()->user()->can('area_update')) {
                    $btn = "<button data-bs-toggle='modal' data-bs-target='#modalEdit' class='btn btn-warning btn-sm d-inline me-1' data-id='".$row->id."' onclick='editData(this)'>Ubah</button>";
                }
                if (auth()->user()->can('area_delete')) {
                    $btn = $btn."<form action=".route('list-area.delete', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'>Hapus</button></form>";
                }
                return $btn;
            })
            ->rawColumns(['action','area','denah'])
            ->make(true);
        }
    }

    public function getAreaListEdit(Request $request){
        if ($request->ajax()) {
            $areaList = AreaList::select('list_area.nama','list_area.id','denah','lantai','area_id','area.id as areaID')->join('area','list_area.area_id','=','area.id')->where('list_area.id',$request->id)->first();
            $area = Area::select('regional.id')->join('regional','area.regional_id','=','regional.id')->where('area.id',$areaList->areaID)->first();
            return response()->json([
                'status' => 'success',
                'data' => $areaList,
                'regional' => $area->id
            ]);
        }
    }

    public function getAreaListRegional(Request $request){
        if ($request->ajax()) {
            $area = Area::select('id','nama')->where('regional_id', $request->regional_id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $area
            ]);
        }
    }
}
