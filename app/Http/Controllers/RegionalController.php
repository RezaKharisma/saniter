<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class RegionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regional = Regional::Select('*')
            ->get();

        return view('regional/index', compact('regional'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('regional/create');
    }

    // Untuk menambahkan data regional kedalam database
    public function regional_add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:nama',
            
    ]);
    
        // dd($request->all());
        $data = new Regional;
        $data->nama = $request->nama;
        $data->save();

        toast('Data berhasil tersimpan!', 'success');
        return Redirect()->to('/regional'); // Redirect kembali
    }
    // Untuk menghapus data regional
    public function delete($id)
    {
        $regional = Regional::findOrFail($id);

        $regional->delete();

        toast('Data berhasil dihapus!', 'success');
        return Redirect()->to('/regional'); // Redirect kembali
    }

    // Untuk proses update data Regional
    public function update(Request $request, $id)
    {
        // Mengambil request dari submit form
        $validator = Validator::make(
            $request->all(),
            [
                // Validasi & ambil semua request
                'nama' => 'required',
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            toast('Mohon periksa form kembali!', 'error'); // Toast
            return Redirect::back()
                ->withErrors($validator)
                ->withInput(); // Return kembali membawa error dan old input
        }

        $regional = Regional::find($id); // Where user = $id
        $data = [
            'nama' => $request->nama,
        ];
        // dd($regional);
        $regional->update($data); // Update data

        toast('Data berhasil tersimpan!', 'success');
        return Redirect::back(); // Redirect kembali
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
