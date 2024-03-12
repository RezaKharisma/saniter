<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    // Fungsi Simpan Data
    public function store(Request $request)
    {
        //
    }

    // Fungsi View Edit Data
    public function edit($id)
    {
        //
    }

    // Fungsi Update Data
    public function update(Request $request, $id)
    {
        //
    }

    // Fungsi Delete Data
    public function delete($id)
    {
        //
    }
}
