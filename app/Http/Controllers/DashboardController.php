<?php

namespace App\Http\Controllers;

use App\Models\Api\KaryawanTetap;
use App\Models\Api\NamaMaterial;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use function App\Helpers\getUserRole;

class DashboardController extends Controller
{
    public function index(){
        // $nama = new NamaMaterial();
        // dd($nama->getAllMaterial());
        return view('dashboard');
    }
}
