<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Pemeriksa extends Model
{
    protected $table = 'pemeriksa';
    protected $fillable = [
        'nip', 'nama', 'sub_satuan_kerja_id'
    ];

    public function subSatuanKerja() {
        return $this->belongsTo('App\Models\MasterData\SubSatuanKerja', 'sub_satuan_kerja_id');
    }

    public function scopeCari($query, $cari) {
        return $query->where('nip', 'like', '%'.$cari.'%')
            ->orWhereHas('subSatuanKerja', function ($queryIn) use ($cari) {
                $queryIn->where('sub_satuan_kerja', 'like', '%'.$cari.'%');
            })
            ->orWhere('nama', 'like', '%'.$cari.'%');
    }
}
