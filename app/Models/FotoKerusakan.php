<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoKerusakan extends Model
{
    use HasFactory;

    protected $table = 'foto_kerusakan';
    protected $guarded = ['id'];
}
