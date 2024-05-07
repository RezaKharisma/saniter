<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\FotoKerusakan;
use App\Models\ItemPekerjaan;
use App\Models\Pekerja;
use App\Models\StokMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AjaxJenisKerusakanController extends Controller
{
    public function getListHtml(Request $request)
    {
        if ($request->ajax()) {
            $stokMaterial = StokMaterial::select('id', 'kode_material', 'nama_material', 'harga', 'stok_update')
                ->where('diterima_som', 1)
                ->where('diterima_pm', 1)
                ->where('diterima_dir', 1)
                ->where('status_validasi_dir', 'ACC')
                ->where('status_validasi_som', '<>', 'Tolak')
                ->where('status_validasi_pm', '<>', 'Tolak')
                ->groupBy('kode_material')
                ->get();

            $kode = bin2hex(random_bytes(10));

            $list = view('components.list.list-perbaikan', compact('stokMaterial', 'kode'))->render();

            return response()->json([
                'status' => 'success',
                'list' => $list,
                'kode' => $kode,
            ]);
        }
    }

    public function getListPekerjaHtml(Request $request)
    {
        if ($request->ajax()) {
            $pekerja = Pekerja::all();

            $kode = bin2hex(random_bytes(10));

            $list = view('components.list.list-pekerja', compact('pekerja', 'kode'))->render();

            return response()->json([
                'status' => 'success',
                'list' => $list,
                'kode' => $kode,
            ]);
        }
    }
    public function getListItemPekerjaanHtml(Request $request)
    {
        if ($request->ajax()) {
            $itemPekerjaan = ItemPekerjaan::all();

            $kode = bin2hex(random_bytes(10));

            $list = view('components.list.list-item-pekerjaan', compact('itemPekerjaan', 'kode'))->render();

            return response()->json([
                'status' => 'success',
                'list' => $list,
                'kode' => $kode,
            ]);
        }
    }

    public function getFotoJenisKerusakan(Request $request)
    {
        if ($request->ajax()) {
            $foto = FotoKerusakan::select('id', 'foto')->where('jenis_kerusakan_id', $request->id)->get();
            return response()->json([
                'status' => 'success',
                'data' => $foto
            ]);
        }
    }

    public function uploadFotoJenisKerusakan(Request $request)
    {
        if ($request->ajax()) {
            foreach ($request->file('file') as $value) {
                $file = $value;
                $extension = strrchr($file->getClientOriginalName(), '.');
                $fileName = 'jenis-kerusakan/' . $request->perbaikan . '/' . bin2hex(random_bytes(10)) . $extension;
                $compressedImage = Image::make($file)->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $compressedImage->save(public_path('storage/' . $fileName));

                $fotoKerusakan = FotoKerusakan::where('jenis_kerusakan_id', $request->jenis_kerusakan_id)->get();
                if (count($fotoKerusakan) < 12) {
                    FotoKerusakan::create([
                        'jenis_kerusakan_id' => $request->jenis_kerusakan_id,
                        'foto' => $fileName
                    ]);
                } else {
                    toast('Jumlah batas maksimal upload foto kerusakan!', 'warning');
                }
            }
        }
    }

    public function deleteFotoJenisKerusakan(Request $request)
    {
        if ($request->ajax()) {
            $foto = FotoKerusakan::where('jenis_kerusakan_id', $request->jenis_kerusakan_id)->find($request->id);
            Storage::disk('public')->delete('jenis_kerusakan/' . $request->perbaikan . '/' . $foto->foto);
            $foto->delete();
        }
    }
}
