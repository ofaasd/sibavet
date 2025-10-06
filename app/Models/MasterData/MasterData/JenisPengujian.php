<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class JenisPengujian extends Model
{
    protected $table = 'jenis_pengujian';
    protected $fillable = [
        'kode', 'seksi_laboratorium_id', 'jenis_pengujian'
    ];

    public function seksiLaboratorium() {
        return $this->belongsTo('App\Models\MasterData\SeksiLaboratorium', 'seksi_laboratorium_id');
    }

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhereHas('seksiLaboratorium', function ($queryIn) use ($cari) {
                $queryIn->where('seksi_laboratorium', 'like', '%'.$cari.'%');
            })
            ->orWhere('jenis_pengujian', 'like', '%'.$cari.'%');
    }
}
