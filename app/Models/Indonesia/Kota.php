<?php

namespace App\Models\Indonesia;

use Illuminate\Database\Eloquent\Model;

class Kota extends Model
{
    protected $table = 'regencies';
    protected $fillable = [
        'province_id', 'name'
    ];
}
