<?php

namespace App\Models\Indonesia;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'provinces';
    protected $fillable = [
        'name'
    ];
}
