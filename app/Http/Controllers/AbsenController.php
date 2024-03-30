<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Izin;
use App\Models\Lokasi;
use App\Models\Shift;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    public function index()
    {
        // Ambil semua izin berdasarkan user id, tahun dan bulan sekarang
        $cekUserIzin = Izin::select('tgl_mulai_izin','tgl_akhir_izin')
            ->where('user_id', auth()->user()->id)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();

            dd($cekUserIzin);

        // Perulangan user izin
        foreach ($cekUserIzin as $item) {

            if (Carbon::parse($item->tgl_mulai_izin)->format('m') == Carbon::now()->format('m')) {
                $periodeTanggal = CarbonPeriod::create(Carbon::parse($item->tgl_mulai_izin), Carbon::parse($item->tgl_akhir_izin));

                $periode = array();

                foreach ($periodeTanggal as $tgl) {
                    array_push($periode, $tgl->format('Y-m-d'));
                }

                dd($periode);

            }
        }

        // Ambil lokasi user berdasarkan id user, join tabel lokasi
        $lokasiUser = User::select('lokasi.latitude','lokasi.longitude','lokasi.radius')
            ->join('lokasi','users.lokasi_id','=','lokasi.id')
            ->where('users.id', auth()->user()->id)
            ->first();

        // Ambil shift
        $shift = Shift::all();

        return view('absen.index', compact('shift', 'lokasiUser'));
    }

    // Simpan absen
    public function store(Request $request){
        // Jika tidak terdapat request foto
        if ($request->image == null) {
            toast('Oppss, terjadi kesalahan!', 'error');
            return Redirect::back();
        }

        // Panggil fungsi dibawah
        // Kondisi jika didalam radius
        if ($this->radiusLokasi($request->latitude, $request->longitude)) {

             // Pilih shift yang di checked pada form
            $shiftYangDipilih = Shift::find($request->shiftChecked);

            // Cek apakah user sudah absen pada hari itu dengan shiftnya
            $cekAbsen = Absen::where('user_id', auth()->user()->id)
                ->where('shift_id', $shiftYangDipilih->id)
                ->where('tgl_masuk', Carbon::now()->format('Y-m-d'))
                ->get();

            // Jika belum absen pada hari itu (Jika row data = 0 atau berarti tidak ada)
            if (count($cekAbsen) == 0) {

                // Ambil nama foto dari fungsi absenImageStore dibawah
                $namaFoto = $this->absenImageStore($request->image);




            }else{ // Kondisi jika diluar radius
                dd('Sudah Absen');
            }

        }else{

        }
    }

    // Fungsi simpan data ke folder
    private function absenImageStore($imageRequest)
    {
        $img = $imageRequest;
        $folderPath = "user-absen/";
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        Storage::disk('public')->put($file, $image_base64);
        return $fileName;
    }

    // Fungsi radius lokasi, apakah didalam atau diluar radius || Output true false
    private function radiusLokasi($latitudeRequest, $longitudeRequest) {

        // Ambil lokasi user berdasarkan id user, join tabel lokasi
        $lokasiUser = User::select('lokasi.latitude','lokasi.longitude','lokasi.radius')
        ->join('lokasi','users.lokasi_id','=','lokasi.id')
        ->where('users.id', auth()->user()->id)
        ->first();

        // Koordinat user saat ini
        $latitudeFrom = $latitudeRequest;
        $longitudeFrom = $longitudeRequest;

        // Koordinat user ditempatkan
        $latitudeTo = $lokasiUser->latitude;
        $longitudeTo = $lokasiUser->longitude;

        // Radius planet bumi pada tatasurya ini
        $earthRadius = 6371000;

        // Konversi dari degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        // Kurangin dulu
        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        // Rumus yang tidak dimengerti
        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        $radius = $angle * $earthRadius;

        // Kondisi jika radius lebih kecil daripada perhitungan diatas
        if ($radius <= $lokasiUser->radius) {
            return true;
        }

        // Sebaliknya
        return false;
    }
}
