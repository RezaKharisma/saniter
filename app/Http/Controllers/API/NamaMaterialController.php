<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Api\NamaMaterial;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;

class NamaMaterialController extends Controller
{
    public function index()
    {
        $materialAll = new NamaMaterial();
        $namaMaterial = $materialAll->getAllMaterial();
        return view('material.nama-material.index', compact('namaMaterial'));
    }

    // Ambil data submenu untuk datatable
    public function getNamaMaterial(Request $request)
    {
        if ($request->ajax()) {
            $materialAll = new NamaMaterial();
            $namaMaterial = $materialAll->getNamaMaterialById($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $namaMaterial
            ]);
        }
    }
}
