<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class LokasiController extends Controller
{
    
    // fungsi dibawah digunakan untuk menampilkan halaman index dari data lokasi
    public function index()
    {
        $lokasi = Lokasi::Select('*','lokasi.id as lokasi_id', 'regional.nama as regional_name')
            ->leftjoin('regional', 'regional.id', '=', 'lokasi.regional_id')
            ->get();

        $regional = Regional::select('*')
        ->get();

        return view('lokasi/index', compact('lokasi', 'regional'));
    }

    // fungsi dibawah digunakan untuk menampilkan halaman form lokasi
    public function create()
    {
        $regional = Regional::select('*')
            ->get();

        return view('lokasi.create', compact('regional'));
    }

    // fungsi dibawah digunakan untuk menambahkan data Lokasi
    public function lokasi_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'regional_id' => 'required',
                'nama_bandara' => 'required',
                'lokasi_proyek' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'radius' => 'required',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }
        
        // dd($request->all());
        Lokasi::create([
            'regional_id' => $request->regional_id,
            'nama_bandara' => $request->nama_bandara,
            'lokasi_proyek' => $request->lokasi_proyek,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ]);

        toast('Data Lokasi berhasil tersimpan!', 'success');
        return Redirect()->to('/lokasi'); // Redirect kembali
    }

    // fungsi dibawah digunakan untuk menghapus data lokasi
    public function delete($id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $lokasi->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect()->to('/lokasi'); // Redirect kembali
    }

    // Fungsi dibawah berguna untuk mengupdate data lokasi
    public function update(Request $request, $id)
    {
        // Mengambil request dari submit form
        $validator = Validator::make(
            $request->all(),
            [
                // Validasi & ambil semua request
                'regional_id' => 'required',
                'nama_bandara' => 'required',
                'lokasi_proyek' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'radius' => 'required',
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $lokasi = Lokasi::find($id); // Where user = $id
        $data = [
            'regional_id' => $request->regional_id,
            'nama_bandara' => $request->nama_bandara,
            'lokasi_proyek' => $request->lokasi_proyek,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
        ];
        // dd($regional);
        $lokasi->update($data); // Update data

        toast('Data Lokasi berhasil tersimpan!', 'success');
        return Redirect::back(); // Redirect kembali
    }
}
