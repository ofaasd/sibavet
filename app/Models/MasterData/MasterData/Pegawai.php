<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $table = 'm_pegawai';
    protected $fillable = [
        'nipname',
        'email',
        'satuan_kerja_id',
        'sub_satuan_kerja',
        'role',
        'username',
    ];
}
