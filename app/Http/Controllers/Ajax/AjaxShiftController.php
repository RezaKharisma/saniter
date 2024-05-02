<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxShiftController extends Controller
{
    // Ambil data menu untuk datatable
    public function getShift(Request $request){
        if ($request->ajax()) {

            // Query menu join kategori
            $shift = Shift::select('shift.*','regional.nama as regionalNama')
                ->join('regional','shift.regional_id','=','regional.id')
                ->get();

            // Return datatables
            return DataTables::of($shift)
                ->addIndexColumn()
                ->addColumn('regional_id', function($row){
                    return $row->regionalNama;
                })
                ->addColumn('potongan', function($row){
                    $html1 = "<div class='d-block'>Terlambat 1 (".$row->terlambat_1." Menit, Rp. ".number_format($row->potongan_1,0,'','.').")</div>";
                    $html2 = "<div class='d-block'>Terlambat 2 (".$row->terlambat_2." Menit, Rp. ".number_format($row->potongan_2,0,'','.').")</div>";
                    $html3 = "<div class='d-block'>Terlambat 3 (".$row->terlambat_3." Menit, Rp. ".number_format($row->potongan_3,0,'','.').")</div>";

                    return $html1.$html2.$html3;
                })
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                    $btn = '';
                    if (auth()->user()->can('shift_update')) {
                        $btn = "<a href='".route('shift.edit', $row->id)."' class='btn btn-warning btn-sm me-1'><i class='bx bx-edit'></i></a>";
                    }
                    if (auth()->user()->can('shift_delete')) {
                        $btn = $btn."<form action=".route('shift.destroy', $row->id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                    }
                    return $btn;
                })
                ->rawColumns(['action','potongan'])
                ->make(true);
        }
    }

    // Ambil data regional untuk datatable
    public function getShiftEdit(Request $request){
        if ($request->ajax()) {
            $shift = Shift::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $shift
            ],200);
        }
    }
}
