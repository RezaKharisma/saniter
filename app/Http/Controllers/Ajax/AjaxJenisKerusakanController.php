<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\DetailTglKerja;
use App\Models\FotoKerusakan;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function getFotoJenisKerusakan(Request $request){
        if ($request->ajax()) {
            $foto = FotoKerusakan::select('id','foto')->where('jenis_kerusakan_id', $request->id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $foto
            ]);
        }
    }

    public function uploadFotoJenisKerusakan(Request $request){
        if ($request->ajax()) {
            foreach ($request->file('file') as $value) {
                $file = $value;
                $extension = strrchr($file->getClientOriginalName(), '.');
                $fileName = $value->storeAs('jenis-kerusakan/'.$request->perbaikan.'/', md5($file->getClientOriginalName()).$extension, 'public');
                $fotoKerusakan = FotoKerusakan::where('jenis_kerusakan_id', $request->jenis_kerusakan_id)->get();
                if (count($fotoKerusakan) < 12) {
                    FotoKerusakan::create([
                        'jenis_kerusakan_id' => $request->jenis_kerusakan_id,
                        'foto' => $fileName
                    ]);
                }else{
                    toast('Jumlah batas maksimal upload foto kerusakan!', 'warning');
                }
            }
        }
    }

    public function deleteFotoJenisKerusakan(Request $request){
        if ($request->ajax()) {
            $foto = FotoKerusakan::where('jenis_kerusakan_id', $request->jenis_kerusakan_id)->find($request->id);
            Storage::disk('public')->delete('jenis_kerusakan/'.$request->perbaikan.'/'.$foto->foto);
            $foto->delete();
        }
    }
}
