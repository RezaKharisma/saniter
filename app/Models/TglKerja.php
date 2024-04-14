<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TglKerja extends Model
{
    use HasFactory;
    protected $table = 'tgl_kerja';
    protected $guarded = ['id'];
}
