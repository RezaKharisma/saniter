<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPeralatan extends Model
{
    use HasFactory;

    protected $table = 'history_peralatan';
    protected $guarded = ['id'];
}
