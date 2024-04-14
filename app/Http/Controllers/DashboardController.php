<?php

namespace App\Http\Controllers;

use App\Models\Api\KaryawanTetap;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use function App\Helpers\getUserRole;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }
}
