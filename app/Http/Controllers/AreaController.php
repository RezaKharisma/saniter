<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function index(){
        $regional = Regional::all();
        return view('pengaturan.area.index', compact('regional'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'regional_id' => 'required',
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('modalAdd', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        Area::create([
            'regional_id' => $request->regional_id,
            'nama' => $request->nama
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('area.index');
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'regional_id' => 'required',
            'nama' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('modalAdd', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $area = Area::find($id);
        $area->update([
            'regional_id' => $request->regional_id,
            'nama' => $request->nama
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('area.index');
    }

    public function delete($id){
        $area = Area::find($id);
        $area->delete();
        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('area.index');
    }
}
