<?php

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;

if (! function_exists('getUserRole')) {
    function getUserRole($id)
    {
        $query = UserRole::where('id', $id)->first();
        return $query->role;
    }
}
