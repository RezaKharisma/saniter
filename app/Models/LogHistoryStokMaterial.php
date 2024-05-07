<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogHistoryStokMaterial extends Model
{
    use HasFactory;

    protected $table = 'log_update_history_material';
    protected $guarded = ['id'];
}
