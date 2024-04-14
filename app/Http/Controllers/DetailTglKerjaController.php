<?php

namespace App\Http\Controllers;

use App\Models\DetailTglKerja;
use App\Models\TglKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DetailTglKerjaController extends Controller
{
    public function index($id){
        $tglKerja = TglKerja::select('id','tanggal')->find($id);
        return view('proyek.detail', compact('tglKerja'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'list_area_id' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('modalAdd', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $cek = DetailTglKerja::where('tgl_kerja_id', $request->tgl_kerja_id)->where('list_area_id',$request->list_area_id)->first();

        if ($cek != null) {
            toast('Area yang diinput sudah ada!', 'warning');
            return Redirect::route('detail-data-proyek.index',$request->tgl_kerja_id);
        }else{
            DetailTglKerja::create([
                'tgl_kerja_id' => $request->tgl_kerja_id,
                'list_area_id' => $request->list_area_id,
            ]);

            toast('Data berhasil tersimpan!', 'success');
            return Redirect::route('detail-data-proyek.index',$request->tgl_kerja_id);
        }
    }

    public function delete(Request $request,$id){
        $detail = DetailTglKerja::find($id);
        $detail->delete();
        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('detail-data-proyek.index', $request->tgl_kerja_id);
    }
}
