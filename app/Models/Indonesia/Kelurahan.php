<?php

namespace App\Models\Indonesia;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'villages';
    protected $fillable = [
        'district_id', 'name'
    ];
}
