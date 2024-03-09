<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regional extends Model
{
    use HasFactory;

    protected $table = 'regional';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
