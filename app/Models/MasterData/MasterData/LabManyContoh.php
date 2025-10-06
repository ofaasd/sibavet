<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class LabManyContoh extends Model
{
    protected $table = 'lab_contoh_pakan';

    protected $fillable = [
        'lab_id',
        'pengujian_id',
        'contoh_id',
        'urut',
        'nol',
        'tinggi',
        'rendah',
        'positif',
        'negatif',
        'sni_id',
        'nilai'
    ];

    public $timestamps = false;
    // public function labNilai()
    // {
    //     return $this->belongsToMany('App\Models\MasterData\JenisPengujian','lab_nilai','lab_contoh_id','pengujian_id')
    //                 ->using('App\Models\MasterData\LabNilai')
    //                 ->as('pNilai')
    //                 ->withPivot([
    //                     'id',
    //                     'sni',
    //                     'nilai',
    //                     'lab_id'
    //                 ]);
    // }

    public function pengujian()
    {
        return $this->belongsTo('App\Models\MasterData\JenisPengujian','pengujian_id');
    }

    public function contoh()
    {
        return $this->belongsTo('App\Models\MasterData\JenisContoh','contoh_id');
    }

    // public function pengujianContoh()
    // {
    //     return $this->belongsToMany('App\Models\MasterData\JenisPengujian','lab_nilai','lab_contoh_id','lab_pengujian_id')
    //                 ->using('App\Models\MasterData\labNilai')
    //                 ->as('pNilai')
    //                 ->withPivot([
    //                     'id',
    //                     'sni',
    //                     'nilai',
    //                     'lab_id'
    //                 ]);
    // }
}
