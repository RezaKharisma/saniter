<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\DetailTglKerja;
use App\Models\StokMaterial;
use Illuminate\Http\Request;

class AjaxJenisKerusakanController extends Controller
{
    public function getListHtml(Request $request){
        if ($request->ajax()) {
            $stokMaterial = StokMaterial::select('id','nama_material')
                ->where('diterima_pm', 1)
                ->where('diterima_spv', 1)
                ->where('status_validasi_pm', 'ACC')
                ->whereNot('status_validasi_pm', 'Tolak')
                ->get();

            $kode = bin2hex(random_bytes(10));

            $list = view('components.list-perbaikan', compact('stokMaterial','kode'))->render();

            return response()->json([
                'status' => 'success',
                'list' => $list,
                'kode' => $kode,
            ]);
        }
    }
}
