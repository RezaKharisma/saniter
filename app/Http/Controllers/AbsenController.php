<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function index()
    {
        $shift = Shift::all();
        return view('absen.index', compact('shift'));
    }
}
