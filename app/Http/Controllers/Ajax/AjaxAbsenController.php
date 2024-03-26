<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class AjaxAbsenController extends Controller
{
    // Ambil data regional untuk datatable
    public function getAbsenShift(Request $request){
        if ($request->ajax()) {
            $shift = Shift::find($request->id);
            return response()->json([
                'status' => 'success',
                'data' => $shift
            ],200);
        }
    }
}
