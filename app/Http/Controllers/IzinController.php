<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        return view('izin/index');
    }

    public function create()
    {
        return view('izin/create');
    }

    public function setting_index()
    {
       
        return view('pengaturan.izin.index');
    }

    public function setting_create()
    {
        $user = User::select('*','users.name as user_name', 'roles.name as role_name')
            ->from('users')->where('users.role_id', '=', '2')
            ->leftjoin('roles', 'roles.id', '=', 'users.role_id')
            ->get();
        return view('pengaturan.izin.create', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    

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
