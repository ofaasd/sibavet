<?php

namespace App\Models\Boyolali;

use Illuminate\Database\Eloquent\Model;

class DetailLabBoyolali extends Model
{
    protected $table = 'detail_lab_boyolali';
    protected $fillable = [
        'lab_id','id_sampel','id_pengujian','hasil_pengujian'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('lab_id', 'like', '%'.$cari.'%');
    }

    public function LaboratoriumBoyolali(){
        return $this->belongsTo('App\Models\Boyolali\LaboratoriumBoyolali', 'lab_id');
    }
	public function Sampel(){
        return $this->hasOne('App\Models\Boyolali\MasterData\Sampel');
    }
}
