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
                ->orderBy('tgl_masuk','DESC')
                ->get();

            // Return datatables
            return DataTables::of($absen)
                ->addIndexColumn()
                ->addColumn('shift', function($row){
                    $shift = "
                    $row->shift_nama
                    <p class='text-muted mb-0'>(".Carbon::parse($row->shiftMasuk)->format('H:i')." - ".Carbon::parse($row->shiftPulang)->format('H:i').")</p>
                    ";
                    return $shift;
                })
                ->addColumn('tanggalAbsen', function($row){
                    return \Carbon\Carbon::parse($row->tgl_masuk)->isoFormat('dddd, D MMMM Y');
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
                ->rawColumns(['tanggalAbsen','jamMasuk','jamPulang','shift'])
                ->make(true);
        }
    }

    public function getAbsenDetail(Request $request){
        if ($request->ajax()) {
            $absen = Absen::select('absen.*','absen.id','shift.nama as shift_nama','shift.jam_masuk as shiftMasuk','shift.jam_pulang as shiftPulang')
                ->where('user_id', auth()->user()->id)
                ->join('shift','absen.shift_id','=','shift.id')
                ->orderBy('tgl_masuk','DESC')
                ->get();

            // Return datatables
            return DataTables::of($absen)
                ->addIndexColumn()
                ->addColumn('foto', function($row){
                    $fotoMasuk = "
                    <div class='col-auto p-0 me-1'><a href='".asset('storage/'.$row->foto_masuk)."' class='avatar flex-shrink-0' target='_blank'>
                        <img src='".asset('storage/'.$row->foto_masuk)."' class='img-fluid' style='width: 100px;height: auto' />
                    </a></div>";

                    $foto = $row->foto_pulang != "Belum Dilakukan" ? $row->foto_pulang : "user-absen/default.jpg";

                    $fotoPulang = "
                    <div class='col-auto p-0'><a href='".asset('storage/'.$foto)."' class='avatar flex-shrink-0' target='_blank'>
                        <img src='".asset('storage/'.$foto)."' class='img-fluid' style='width: 100px;height: auto'/>
                    </a></div>";

                    return "<div class='row p-0 justify-content-center'>".$fotoMasuk.$fotoPulang."</div>";
                })
                ->addColumn('shift', function($row){
                    $shift = "
                    $row->shift_nama
                    <p class='text-muted mb-0'>(".Carbon::parse($row->shiftMasuk)->format('H:i')." - ".Carbon::parse($row->shiftPulang)->format('H:i').")</p>
                    ";
                    return $shift;
                })
                ->addColumn('tanggalAbsen', function($row){
                    return \Carbon\Carbon::parse($row->tgl_masuk)->isoFormat('dddd, D MMMM Y');
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
                ->addColumn('status', function($row){
                    if ($row->status == "Terlambat") {
                        return "<span class='badge bg-danger'>Terlambat</span>";
                    }

                    if ($row->status == "Izin") {
                        return "<span class='badge bg-warning'>Izin</span>";
                    }

                    if ($row->status == "Cuti") {
                        return "<span class='badge bg-warning'>Cuti</span>";
                    }

                    if ($row->status == "Alfa") {
                        return "<span class='badge bg-secondary'>Alfa</span>";
                    }

                    return "<span class='badge bg-success'>Normal</span>";
                })
                ->rawColumns(['tanggalAbsen','jamMasuk','jamPulang','status','shift','foto'])
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
