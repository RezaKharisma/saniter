<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxLokasiController extends Controller
{
    // Ambil data menu untuk datatable
    public function getLokasi(Request $request){
        if ($request->ajax()) {

            // Query menu join kategori
            $lokasi = Lokasi::select('*','lokasi.id as lokasi_id','regional.nama as regional_name')
            ->leftjoin('regional', 'regional.id', '=', 'lokasi.regional_id')
            ->orderBy('lokasi.id','DESC')
            ->get();

            // Return datatables
            return DataTables::of($lokasi)
                ->addIndexColumn()
                ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                    $btn = '';
                    if (auth()->user()->can('lokasi_update')) {
                        $btn = "<a class='btn btn-warning btn-sm me-1' href='".route('lokasi.edit', $row->lokasi_id)."' ><i class='bx bx-detail'></i></a>";
                    }
                    if (auth()->user()->can('lokasi_delete')) {
                        $btn = $btn."<form action=".route('lokasi.delete', $row->lokasi_id)." method='POST' class='d-inline'>".csrf_field().method_field('DELETE')." <button type='submit' class='btn btn-danger btn-sm confirm-delete'><i class='bx bx-trash'></i></button></form>";
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // Ambil data map regional untuk datatable
    public function getAllLokasiMap(Request $request){
        if ($request->ajax()) {
            $lokasi = Lokasi::select('nama_bandara','lokasi_proyek','latitude','longitude','radius')->get();
            return response()->json([
                'status' => 'success',
                'data' => $lokasi
            ],200);
        }
    }
}
