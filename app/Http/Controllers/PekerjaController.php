<?php

namespace App\Http\Controllers;

use App\Models\Pekerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PekerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('pekerja')->get();

        return view('pekerjaan.jenis-pekerja.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pekerjaan.jenis-pekerja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi form
        $validator = Validator::make($request->all(), [
            'name' => 'required',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        toast('Mohon periksa form kembali!', 'error'); // Toast
        return Redirect::back()
            ->withErrors($validator)
            ->withInput(); // Return kembali membawa error dan old input
    }

    // Insert data lokasi baru dari input form
    Pekerja::create([
        'name' => $request->name,
    ]);

    toast('Data Jenis Pekerja berhasil tersimpan!', 'success');
    return Redirect::route('jenis-pekerja.index'); // Redirect kembali
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
