<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMaterial extends Model
{
    use HasFactory;

    protected $table = 'stok_material';
    protected $guarded = ['id'];
}
