<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailItemPekerjaan extends Model
{
    use HasFactory;
    protected $table = 'detail_item_pekerjaan';
    protected $guarded = ['id'];
}
