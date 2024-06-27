<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class AjaxAbsenController extends Controller
{
    public function getAbsenShift(Request $request)
    {
        if ($request->ajax()) {
            $shift = Shift::select('id', 'nama', 'jam_masuk', 'jam_pulang')->find($request->id);

            $shift['jam_masuk'] = date('H:i', strtotime($shift['jam_masuk']));
            $shift['jam_pulang'] = date('H:i', strtotime($shift['jam_pulang']));

            $innerHtml = "
            <p class='mb-3'>Jadwal Anda :</p>
            <h4 class='mb-2'>Shift <b><u style='color: red;'>" . $shift['nama'] . "</u></b></h4>
            <h2>" . $shift['jam_masuk'] . " - " . $shift['jam_pulang'] . "</h2>
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
            ], 200);
        }
    }

    public function getAbsenLog(Request $request)
    {
        if ($request->ajax()) {
            $absen = Absen::select('absen.*', 'absen.id', 'shift.nama as shift_nama', 'shift.jam_masuk as shiftMasuk', 'shift.jam_pulang as shiftPulang')
                ->where('user_id', auth()->user()->id)
                ->whereNot('status', 'Cuti')
                ->whereNot('status', 'Izin')
                ->join('shift', 'absen.shift_id', '=', 'shift.id')
                ->limit(7)
                ->orderBy('tgl_masuk', 'DESC')
                ->get();

            // Return datatables
            return DataTables::of($absen)
                ->addIndexColumn()
                ->addColumn('shift', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    }
                    return $row->shift_nama . "<p class='text-muted mb-0'>(" . Carbon::parse($row->shiftMasuk)->format('H:i') . " - " . Carbon::parse($row->shiftPulang)->format('H:i') . ")</p>";
                })
                ->addColumn('tanggalAbsen', function ($row) {
                    return \Carbon\Carbon::parse($row->tgl_masuk)->isoFormat('dddd, D MMMM Y');
                })
                ->addColumn('jamMasuk', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    }

                    if ($this->cekTerlambat($row->jam_masuk, $row->shiftMasuk)) {
                        return "<span>" . Carbon::parse($row->jam_masuk)->format('H:i') . "</span>";
                    } else {
                        return "<span class='text-danger'>" . Carbon::parse($row->jam_masuk)->format('H:i') . "</span>";
                    }
                })
                ->addColumn('jamPulang', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    }
                    if (Carbon::parse($row->tgl_masuk)->diffInDays(Carbon::now()->format('Y-m-d')) && Carbon::parse($row->jam_pulang) == Carbon::parse("00:00:00")) {
                        return "<span class='text-danger'>" . Carbon::parse($row->jam_pulang)->format('H:i') . "</span>";
                    }
                    return "<span>" . Carbon::parse($row->jam_pulang)->format('H:i') . "</span>";
                })
                ->addColumn('selisihTerlambat', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    } else {
                        if (Carbon::parse($row->jam_masuk) >= Carbon::parse($row->shiftMasuk)) {
                            // $selisih = Carbon::parse($row->shiftMasuk)->diffInHours($row->jam_masuk) != 0 ? Carbon::parse($row->shiftMasuk)->diffInHours($row->jam_masuk)." Jam" : (Carbon::parse($row->shiftMasuk)->diffInMinutes($row->jam_masuk) != 0 ? Carbon::parse($row->shiftMasuk)->diffInMinutes($row->jam_masuk)." Menit" : (Carbon::parse($row->shiftMasuk)->diffInSeconds($row->jam_masuk) != 0 ? Carbon::parse($row->shiftMasuk)->diffInSeconds($row->jam_masuk)." Detik" : "-"));
                            return Carbon::parse($row->shiftMasuk)->diff($row->jam_masuk)->format('%H:%I:%S');
                        }
                    }
                    return "-";
                })
                ->rawColumns(['tanggalAbsen', 'jamMasuk', 'jamPulang', 'shift', 'selisihTerlambat'])
                ->make(true);
        }
    }

    public function getAbsenDetail(Request $request)
    {
        if ($request->ajax()) {
            $absen = Absen::select('absen.*', 'absen.id', 'shift.nama as shift_nama', 'shift.jam_masuk as shiftMasuk', 'shift.jam_pulang as shiftPulang')
                ->where('user_id', auth()->user()->id)
                ->join('shift', 'absen.shift_id', '=', 'shift.id')
                ->orderBy('tgl_masuk', 'DESC');

            if (!empty($request->bulan)) {
                $absen->whereMonth('absen.tgl_masuk', $request->bulan);
            }

            if (!empty($request->tahun)) {
                $absen->whereYear('absen.tgl_masuk', $request->tahun);
            }

            $data = $absen->get();

            // Return datatables
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('foto', function ($row) {
                    $fotoMasuk = "
                    <div class='col-auto p-0 me-1'><a href='" . asset('storage/' . $row->foto_masuk) . "' class='avatar flex-shrink-0' target='_blank'>
                        <img src='" . asset('storage/' . $row->foto_masuk) . "' class='img-fluid' style='width: 100px;height: auto;' />
                    </a></div>";

                    $foto = $row->foto_pulang != "Belum Dilakukan" ? $row->foto_pulang : "user-absen/default.jpg";

                    $fotoPulang = "
                    <div class='col-auto p-0'><a href='" . asset('storage/' . $foto) . "' class='avatar flex-shrink-0' target='_blank'>
                        <img src='" . asset('storage/' . $foto) . "' class='img-fluid' style='width: 100px;height: auto'/>
                    </a></div>";

                    return "<div class='row p-0 justify-content-center' style='width: 250px'>" . $fotoMasuk . $fotoPulang . "</div>";
                })
                ->addColumn('selisihTerlambat', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    } else {
                        if (Carbon::parse($row->jam_masuk) >= Carbon::parse($row->shiftMasuk)) {
                            $result = "";
                            if (Carbon::parse($row->shiftMasuk)->diffInHours($row->jam_masuk) != 0) {
                                $result = Carbon::parse($row->shiftMasuk)->diffInHours($row->jam_masuk) . " Jam";
                            }

                            if (Carbon::parse($row->shiftMasuk)->diffInMinutes($row->jam_masuk) != 0) {
                                $result = $result . " " . Carbon::parse($row->shiftMasuk)->diff($row->jam_masuk)->format('%i') . " Menit";
                            }

                            if (Carbon::parse($row->shiftMasuk)->diffInSeconds($row->jam_masuk) != 0) {
                                $result = $result . " " . Carbon::parse($row->shiftMasuk)->diff($row->jam_masuk)->format('%S') . " Detik";
                            }

                            // $selisih = Carbon::parse($row->shiftMasuk)->diffInHours($row->jam_masuk) != 0 ? Carbon::parse($row->shiftMasuk)->diffInHours($row->jam_masuk) : (Carbon::parse($row->shiftMasuk)->diffInMinutes($row->jam_masuk) != 0 ? Carbon::parse($row->shiftMasuk)->diffInMinutes($row->jam_masuk)." Menit" : (Carbon::parse($row->shiftMasuk)->diffInSeconds($row->jam_masuk) != 0 ? Carbon::parse($row->shiftMasuk)->diffInSeconds($row->jam_masuk)." Detik" : "-"));
                            // return Carbon::parse($row->shiftMasuk)->diff($row->jam_masuk)->format('%H:%I:%S');
                            return $result;
                        }
                    }
                    return "-";
                })
                ->addColumn('shift', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    }

                    $shift = "
                    $row->shift_nama
                    <p class='text-muted mb-0'>(" . Carbon::parse($row->shiftMasuk)->format('H:i') . " - " . Carbon::parse($row->shiftPulang)->format('H:i') . ")</p>
                    ";
                    return $shift;
                })
                ->addColumn('tanggalAbsen', function ($row) {
                    return \Carbon\Carbon::parse($row->tgl_masuk)->isoFormat('dddd, D MMMM Y');
                })
                ->addColumn('jamMasuk', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    }

                    if ($this->cekTerlambat($row->jam_masuk, $row->shiftMasuk)) {
                        $waktuMasuk = "<span>" . Carbon::parse($row->jam_masuk)->format('H:i') . "</span>";
                    } else {
                        $waktuMasuk = "<span class='text-danger'>" . Carbon::parse($row->jam_masuk)->format('H:i') . "</span>";
                    }
                    return $waktuMasuk;
                })
                ->addColumn('jamPulang', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    }

                    if (Carbon::parse($row->tgl_masuk)->diffInDays(Carbon::now()->format('Y-m-d')) && Carbon::parse($row->jam_pulang) == Carbon::parse("00:00:00")) {
                        return "<span class='text-danger'>" . Carbon::parse($row->jam_pulang)->format('H:i') . "</span>";
                    }
                    return "<span>" . Carbon::parse($row->jam_pulang)->format('H:i') . "</span>";
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "Terlambat") {
                        return "<span class='badge bg-danger'>Terlambat</span>";
                    }

                    if ($row->status == "Izin") {
                        return "<span class='badge bg-warning'>Izin</span>";
                    }

                    if ($row->status == "Cuti") {
                        return "<span class='badge bg-warning'>Cuti</span>";
                    }

                    if ($row->status == "Sakit") {
                        return "<span class='badge bg-warning'>Sakit</span>";
                    }

                    if ($row->status == "Alfa") {
                        return "<span class='badge bg-secondary'>Alfa</span>";
                    }

                    return "<span class='badge bg-success'>Normal</span>";
                })
                ->rawColumns(['tanggalAbsen', 'jamMasuk', 'jamPulang', 'status', 'shift', 'foto', 'selisihTerlambat'])
                ->make(true);
        }
    }

    // Fungsi cek lebih waktu keterlambatan
    private function cekTerlambat($jamUser, $jamShift)
    {
        // Parse waktu user dengan waktu shift
        $waktuShift = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . $jamShift)->format('Y-m-d H:i:s');
        $waktuMasuk = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . " " . $jamUser)->format('Y-m-d H:i:s');

        if ($waktuMasuk <= $waktuShift) {
            return true;
        } else {
            return false;
        }
    }

    public function getAbsenAllDetail(Request $request)
    {
        if ($request->ajax()) {
            $absen = Absen::select('absen.*', 'absen.id', 'shift.nama as shift_nama', 'shift.jam_masuk as shiftMasuk', 'shift.jam_pulang as shiftPulang', 'users.name')
                ->join('shift', 'absen.shift_id', '=', 'shift.id')
                ->join('users', 'absen.user_id', '=', 'users.id');

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $absen->whereBetween('tgl_masuk', [Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'), Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')])
                    ->orderBy('tgl_masuk', 'ASC');
            } else {
                $absen->orderBy('tgl_masuk', 'DESC');
            }

            if (!empty($request->user_id)) {
                $absen->where('users.id', $request->user_id);
            }

            if (!empty($request->status)) {
                $absen->where('absen.status', $request->status);
            }

            $data = $absen->get();

            // Return datatables
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    return "<div class='text-nowrap'>$row->name</div>";
                })
                ->addColumn('foto', function ($row) {
                    $fotoMasuk = "
                    <div class='col-auto p-0 me-1'><a href='" . asset('storage/' . $row->foto_masuk) . "' class='avatar flex-shrink-0' target='_blank'>
                        <img src='" . asset('storage/' . $row->foto_masuk) . "' class='img-fluid' style='width: 100px;height: auto' />
                    </a></div>";

                    $foto = $row->foto_pulang != "Belum Dilakukan" ? $row->foto_pulang : "user-absen/default.jpg";

                    $fotoPulang = "
                    <div class='col-auto p-0'><a href='" . asset('storage/' . $foto) . "' class='avatar flex-shrink-0' target='_blank'>
                        <img src='" . asset('storage/' . $foto) . "' class='img-fluid' style='width: 100px;height: auto'/>
                    </a></div>";

                    return "<div class='row p-0 justify-content-center' style='width: 250px'>" . $fotoMasuk . $fotoPulang . "</div>";
                })
                ->addColumn('shift', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    }

                    $shift = "
                    $row->shift_nama
                    <p class='text-muted mb-0 text-nowrap'>(" . Carbon::parse($row->shiftMasuk)->format('H:i') . " - " . Carbon::parse($row->shiftPulang)->format('H:i') . ")</p>
                    ";
                    return $shift;
                })
                ->addColumn('tanggalAbsen', function ($row) {
                    return "<div class='text-nowrap'>" . \Carbon\Carbon::parse($row->tgl_masuk)->isoFormat('dddd, D MMMM Y') . "</div>";
                })
                ->addColumn('jamMasuk', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    }

                    if ($this->cekTerlambat($row->jam_masuk, $row->shiftMasuk)) {
                        $waktuMasuk = "<span>" . Carbon::parse($row->jam_masuk)->format('H:i') . "</span>";
                    } else {
                        $waktuMasuk = "<span class='text-danger'>" . Carbon::parse($row->jam_masuk)->format('H:i') . "</span>";
                    }
                    return $waktuMasuk;
                })
                ->addColumn('jamPulang', function ($row) {
                    if ($row->status == "Cuti" || $row->status == "Izin" || $row->status == "Sakit") {
                        return "-";
                    }

                    if (Carbon::parse($row->tgl_masuk)->diffInDays(Carbon::now()->format('Y-m-d')) && Carbon::parse($row->jam_pulang) == Carbon::parse("00:00:00")) {
                        return "<span class='text-danger'>" . Carbon::parse($row->jam_pulang)->format('H:i') . "</span>";
                    }
                    return "<span>" . Carbon::parse($row->jam_pulang)->format('H:i') . "</span>";
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == "Terlambat") {
                        return "<span class='badge bg-danger'>Terlambat</span>";
                    }

                    if ($row->status == "Izin") {
                        return "<span class='badge bg-warning'>Izin</span>";
                    }

                    if ($row->status == "Cuti") {
                        return "<span class='badge bg-warning'>Cuti</span>";
                    }

                    if ($row->status == "Sakit") {
                        return "<span class='badge bg-warning'>Sakit</span>";
                    }

                    if ($row->status == "Alfa") {
                        return "<span class='badge bg-secondary'>Alfa</span>";
                    }


                    return "<span class='badge bg-success'>Normal</span>";
                })
                ->rawColumns(['tanggalAbsen', 'jamMasuk', 'jamPulang', 'status', 'shift', 'foto', 'nama'])
                ->make(true);
        }
    }
}
