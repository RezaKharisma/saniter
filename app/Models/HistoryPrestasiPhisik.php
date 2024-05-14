<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPrestasiPhisik extends Model
{
    use HasFactory;

    protected $table = 'history_prestasi_phisik';
    protected $guarded = ['id'];
}
