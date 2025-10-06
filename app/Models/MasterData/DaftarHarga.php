<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class DaftarHarga extends Model
{
    protected $table = 'daftar_harga';
    protected $fillable = [
        'spesies_id',
		'terapi_id',
		'tindakan',
		'tarif'
    ];
}
