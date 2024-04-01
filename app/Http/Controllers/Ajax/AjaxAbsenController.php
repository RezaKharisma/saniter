<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Shift;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class AjaxAbsenController extends Controller
{
    // Ambil data regional untuk datatable
    public function getAbsenShift(Request $request){
        if ($request->ajax()) {
            $shift = Shift::select('id','nama','jam_masuk','jam_pulang')->find($request->id);

            $shift['jam_masuk'] = date('H:i', strtotime($shift['jam_masuk']));
            $shift['jam_pulang'] = date('H:i', strtotime($shift['jam_pulang']));

            $innerHtml = "
            <p class='mb-3'>Jadwal Anda :</p>
            <h4 class='mb-2'>Shift <b><u style='color: red;'>".$shift['nama']."</u></b></h4>
            <h2>".$shift['jam_masuk']." - ".$shift['jam_pulang']."</h2>
            <div class='row justify-content-center'>
                <div class='col-auto justify-content-center'>
                    <div id='my_camera' style='width: 100% !important;'></div>
                </div>
            </div>
            ";

            return response()->json([
                'status' => 'success',
                'data' => $shift,
                'html' => $innerHtml
            ],200);
        }
    }

    public function getAbsenLog(Request $request){
        if ($request->ajax()) {
            $absen = Absen::select('absen.*','absen.id','shift.nama as shift_nama','shift.jam_masuk as shiftMasuk','shift.jam_pulang as shiftPulang')
                ->where('user_id', auth()->user()->id)
                ->join('shift','absen.shift_id','=','shift.id')
                ->limit(7)
                ->orderBy('absen.id','DESC')
                ->get();

            // Return datatables
            return DataTables::of($absen)
                ->addIndexColumn()
                ->addColumn('tanggalAbsen', function($row){
                    return \Carbon\Carbon::parse($row->tgl_masuk)->isoFormat('dddd, D MMMM Y').' ('.$row->shift_nama.')';
                })
                ->addColumn('jamMasuk', function($row){
                    if($this->cekTerlambat($row->jam_masuk,$row->shiftMasuk)){
                        $waktuMasuk = "<span>".Carbon::parse($row->jam_masuk)->format('H:i')."</span>";
                    }else{
                        $waktuMasuk = "<span class='text-danger'>".Carbon::parse($row->jam_masuk)->format('H:i')."</span>";
                    }
                    return $waktuMasuk;
                })
                ->addColumn('jamPulang', function($row){
                    if(Carbon::parse($row->tgl_masuk)->diffInDays(Carbon::now()->format('Y-m-d')) && Carbon::parse($row->jam_pulang) == Carbon::parse("00:00:00")){
                        return "<span class='text-danger'>".Carbon::parse($row->jam_pulang)->format('H:i')."</span>";
                    }

                    return "<span>".Carbon::parse($row->jam_pulang)->format('H:i')."</span>";
                })
                ->rawColumns(['tanggalAbsen','jamMasuk','jamPulang'])
                ->make(true);
        }
    }

    // Fungsi cek lebih waktu keterlambatan
    private function cekTerlambat($jamUser, $jamShift){
        // Parse waktu user dengan waktu shift
        $waktuShift = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . $jamShift);
        $waktuMasuk = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . $jamUser);

        if ($waktuMasuk < $waktuShift) {
            return true;
        }else{
            return false;
        }
    }
}
