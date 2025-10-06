<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class BentukContoh extends Model
{
    protected $table = 'bentuk_contoh';
    protected $fillable = [
        'kode', 'jenis_contoh_id', 'bentuk_sampel'
    ];

    public function jenisContoh() {
        return $this->belongsTo('App\Models\MasterData\JenisContoh', 'jenis_contoh_id');
    }

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhereHas('jenisContoh', function ($queryIn) use ($cari) {
                $queryIn->where('nama_sampel', 'like', '%'.$cari.'%');
            })
            ->orWhere('bentuk_sampel', 'like', '%'.$cari.'%');
    }
}
