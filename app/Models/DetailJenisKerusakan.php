<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailJenisKerusakan extends Model
{
    use HasFactory;

    protected $table = 'detail_jenis_kerusakan';
    protected $guarded = ['id'];
}
