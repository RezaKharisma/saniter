<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaList extends Model
{
    use HasFactory;

    protected $table = 'list_area';
    protected $guarded = ['id'];
}
