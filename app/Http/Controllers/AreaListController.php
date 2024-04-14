<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaList;
use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AreaListController extends Controller
{
    public function index(){
        $area = Area::all();
        $store = Area::select('area.*','area.nama as areaNama','regional.nama as regionalNama')->join('regional','area.regional_id','=','regional.id')->get();

        $regional = array();
        foreach($store as $key => $item){
            $regional[$key]['id'] = $item->regional_id;
            $regional[$key]['nama'] = $item->regionalNama;
        }
        $regional = $this->unique_multidim_array($regional,'nama');
        return view('pengaturan.area-list.index', compact('area','regional'));
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'area_id' => 'required',
            'nama' => 'required',
            'denah' => 'required|mimes:png,jpg,jpeg|max:2000'
        ]);

        if ($validator->fails()) {
            Session::flash('modalAdd', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        AreaList::create([
            'area_id' => $request->regional_id,
            'lantai' => $request->lantai,
            'nama' => $request->nama,
            'denah' => $this->imageStore($request->file('denah'))
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('list-area.index');
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'regional_id' => 'required',
            'denahEdit' => 'required',
            'denahEdit' => 'mimes:png,jpg,jpeg|max:2000'
        ]);

        if ($validator->fails()) {
            Session::flash('modalEdit', 'error');
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $area = AreaList::find($id);
        $area->update([
            'area_id' => $request->area_idEdit,
            'lantai' => $request->lantaiEdit,
            'nama' => $request->namaEdit,
            'denah' => $this->imageStore($request->file('denahEdit'), $area) ?? 'denah/default.png'
        ]);

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::route('list-area.index');
    }

    public function delete($id){
        $area = AreaList::find($id);
        Storage::disk('public')->delete($area->denah);
        $area->delete();
        toast('Data berhasil dihapus!', 'success');
        return Redirect::route('list-area.index');
    }

    function unique_multidim_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return array_values($temp_array);
    }

    // Fungsi simpan data ke folder
    private function imageStore($image, $listArea = null)
    {
        // Delete jika foto bukan default.jpg
        if (!empty($listArea)) {
            if ($listArea->denah != 'denah/default.png') {
                Storage::disk('public')->delete($listArea->denah);
            }
        }

        // Masukkan ke folder user-images dengan nama random dan extensi saat upload
        if (!empty($image)) {
            $image = Storage::disk('public')->put('denah', $image);
            return $image;
        }
    }
}
