<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryStokMaterial extends Model
{
    use HasFactory;

    protected $table = 'history_stok_material';
    protected $guarded = ['id'];
}
