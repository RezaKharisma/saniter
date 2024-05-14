<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPekerja extends Model
{
    use HasFactory;

    protected $table = 'history_pekerja';
    protected $guarded = ['id'];
}
