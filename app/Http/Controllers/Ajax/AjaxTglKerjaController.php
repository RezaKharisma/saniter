<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\DetailTglKerja;
use App\Models\TglKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AjaxTglKerjaController extends Controller
{
    public function getTglKerja(Request $request){
        if ($request->ajax()) {
            $tgl = TglKerja::orderBy('tanggal', 'DESC')->get();

            // Return datatables
            return DataTables::of($tgl)
            ->addIndexColumn()
            ->addColumn('total', function($row){
                $detail = DetailTglKerja::where('tgl_kerja_id', $row->id)->get();
                return count($detail);
            })
            ->addColumn('tanggal', function($row){
                return Carbon::parse($row->tanggal)->isoFormat('dddd, D MMMM Y');
            })
            ->addColumn('action', function($row){ // Tambah kolom action untuk button edit dan delete.
                $btn = '';
                $btn = "<a class='btn btn-info btn-sm me-1' href='".route('detail-data-proyek.index',$row->id)."'>Detail Pekerjaan</a>";
                // if (auth()->user()->can('lokasi_update')) {
                //     $btn = $btn."<a class='btn btn-warning btn-sm  me-1' href='".route('lokasi.edit', $row->id)."' >Ubah</a>";
                // }
                return $btn;
            })
            ->rawColumns(['action','total','tanggal'])
            ->make(true);
        }
    }
}
