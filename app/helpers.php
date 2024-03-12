<?php

use App\Models\Regional;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;

if (! function_exists('getRegional')) {
    function getRegional($id)
    {
        $query = Regional::where('id', $id)->first();
        return $query->nama;
    }
}
