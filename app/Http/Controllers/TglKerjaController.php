<?php

namespace App\Http\Controllers;

use App\Models\TglKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TglKerjaController extends Controller
{
    public function __construct()
    {
        $tglKerja = TglKerja::where('tanggal', Carbon::now()->format('Y-m-d'))->first();
        if ($tglKerja == null) {
            TglKerja::create([
                'tanggal' => Carbon::now()->format('Y-m-d')
            ]);
        }
    }

    public function index(){
        return view('proyek.index');
    }
}
