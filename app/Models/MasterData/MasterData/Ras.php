<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Ras extends Model
{
    protected $table = 'ras';
    protected $fillable = [
        'kode', 'spesies_id', 'nama_ras'
    ];

    public function spesies() {
        return $this->belongsTo('App\Models\MasterData\Spesies', 'spesies_id');
    }

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhereHas('spesies', function ($queryIn) use ($cari) {
                $queryIn->where('nama_spesies', 'like', '%'.$cari.'%');
            })
            ->orWhere('nama_ras', 'like', '%'.$cari.'%');
    }
}
