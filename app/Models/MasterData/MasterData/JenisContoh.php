<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class JenisContoh extends Model
{
    protected $table = 'jenis_contoh';
    protected $fillable = [
        'kode', 'sub_satuan_kerja_id', 'nama_sampel'
    ];

    public function subSatuanKerja() {
        return $this->belongsTo('App\Models\MasterData\SubSatuanKerja', 'sub_satuan_kerja_id');
    }

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhereHas('subSatuanKerja', function ($queryIn) use ($cari) {
                $queryIn->where('sub_satuan_kerja', 'like', '%'.$cari.'%');
            })
            ->orWhere('nama_sampel', 'like', '%'.$cari.'%');
    }

    public function labNilai()
    {
        return $this->belongsToMany('App\Models\MasterData\JenisPengujian','lab_pengujian','contoh_id','pengujian_id')
                    ->using('App\Models\MasterData\LabPengujian')
                    ->as('pNilai')
                    ->withPivot([
                        'id',
                        'sni',
                        'nilai',
                    ]);
    }
}
