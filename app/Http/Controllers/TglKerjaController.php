<?php

namespace App\Http\Controllers;

use App\Models\TglKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TglKerjaController extends Controller
{
    public function index(){
        $this->setTglKerja();
        return view('proyek.index');
    }

    // Fungsi set tgl kerja baru di hari yang belum ada
    // Tidak menggunakan __construct karna tidak bisa membaca middleware timezone
    // Sehingga waktu dinamis timezone sesuai user tidak berganti
    private function setTglKerja(){
        $tglKerja = TglKerja::where('tanggal', Carbon::now()->format('Y-m-d'))->first();
        if ($tglKerja == null) {
            TglKerja::create([
                'tanggal' => Carbon::now()->format('Y-m-d')
            ]);
        }
    }
}
