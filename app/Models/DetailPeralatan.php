<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeralatan extends Model
{
    use HasFactory;

    protected $table = 'detail_peralatan';
    protected $guarded = ['id'];
}
