<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaMaterial extends Model
{
    use HasFactory;

    protected $table = 'nama_material';
    protected $guarded = ['id'];
}
