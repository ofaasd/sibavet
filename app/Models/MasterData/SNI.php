<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class SNI extends Model
{
    protected $table = 'm_sni';
    protected $fillable = [
        'nama',
        'umur',
        'no_sni',
        'kode_etiket',
        'warna_etiket',
        'nama_inggris',
        'tahun',
        'status'
    ];
}
