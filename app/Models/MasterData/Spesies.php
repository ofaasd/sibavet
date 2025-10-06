<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Spesies extends Model
{
    protected $table = 'spesies';
    protected $fillable = [
        'kode', 'nama_spesies'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhere('nama_spesies', 'like', '%'.$cari.'%');
    }
}
