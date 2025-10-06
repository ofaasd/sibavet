<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class NilaiContoh extends Model
{
    protected $table = 'lab_contoh_pakan';

    public function pengujianContoh()
    {
        return $this->belongsToMany('App\Models\MasterData\JenisPengujian','lab_pengujian_pakan','contoh_id','pengujian_id')
                    ->using('App\Models\MasterData\LabPengujian')
                    ->as('pNilai')
                    ->withPivot([
                        'id',
                        'sni',
                        'nilai',
                    ]);
    }
}
