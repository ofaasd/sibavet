<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LabContohPakan extends pivot
{
    protected $table = 'lab_contoh_pakan';

    public function pengujianContoh()
    {
        return $this->belongsToMany('App\Models\MasterData\labPengujianPakan','lab_nilai','lab_contoh_id','lab_pengujian_id')
                    ->using('App\Models\MasterData\LabNilai')
                    ->as('pNilai')
                    ->withPivot([
                        'id',
                        'sni',
                        'nilai',
                        'lab_id'
                    ]);
    }
}
