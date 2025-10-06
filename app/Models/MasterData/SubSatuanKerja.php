<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class SubSatuanKerja extends Model
{
    protected $table = 'sub_satuan_kerja';
    protected $fillable = [
        'kode', 'satuan_kerja_id', 'sub_satuan_kerja', 'nama_kepala', 'nip', 'telp', 'alamat', 'jenis_lab'
    ];

    public function satuanKerja() {
        return $this->belongsTo('App\Models\MasterData\SatuanKerja', 'satuan_kerja_id');
    }

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhereHas('satuanKerja', function ($queryIn) use ($cari) {
                $queryIn->where('satuan_kerja', 'like', '%'.$cari.'%');
            })
            ->orWhere('sub_satuan_kerja', 'like', '%'.$cari.'%')
            ->orWhere('nama_kepala', 'like', '%'.$cari.'%')
            ->orWhere('nip', 'like', '%'.$cari.'%');
    }
}
