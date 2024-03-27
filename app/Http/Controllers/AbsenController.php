<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Lokasi;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class AbsenController extends Controller
{
    public function index()
    {
        $lokasiUser = User::select('lokasi.latitude','lokasi.longitude','lokasi.radius')
            ->join('lokasi','users.lokasi_id','=','lokasi.id')
            ->where('users.id', auth()->user()->id)
            ->first();
        $shift = Shift::all();
        return view('absen.index', compact('shift', 'lokasiUser'));
    }

    // Simpan absen
    public function store(Request $request){

        if ($request->image == null) {
            abort(500);
        }

        $fileName = $this->absenImageStore($request->image);

        dd('Image uploaded successfully: '.$fileName);

        $shiftYangDipilih = Shift::find($request->shiftChecked);
        $cekAbsen = Absen::where('user_id', auth()->user()->id)->where('tgl_masuk', Carbon::now()->format('Y-m-d'))->get();

        // dd($cekAbsen);

        if (count($cekAbsen) > 0) {
            dd('Sudah Absen');
        }else{
            dd('Belum Absen');
        }

        // dd($shiftYangDipilih);

        // Absen::create([

        // ]);
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
}
