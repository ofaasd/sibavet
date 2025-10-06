<?php

namespace App\Models\Indonesia;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'districts';
    protected $fillable = [
        'regency_id', 'name'
    ];
}
