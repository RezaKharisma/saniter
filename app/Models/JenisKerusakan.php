<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisKerusakan extends Model
{
    use HasFactory;

    protected $table = 'jenis_kerusakan';
    protected $guarded = ['id'];
}
