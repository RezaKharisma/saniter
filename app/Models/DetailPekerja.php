<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPekerja extends Model
{
    use HasFactory;
    protected $table = 'detail_pekerja';
    protected $guarded = ['id'];
}
