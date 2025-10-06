<?php

namespace App\Models\Boyolali;

use Illuminate\Database\Eloquent\Model;

class LaboratoriumBoyolali extends Model
{
    protected $table = 'laboratorium_boyolali';
    protected $fillable = [
        'kel_kerja_id','provinsi','kota','kecamatan_id','tanggal'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kel_kerja_id', 'like', '%'.$cari.'%')
            ->orWhere('kecamatan_id', 'like', '%'.$cari.'%');
    }
    public function DetailLabBoyolali(){
        return $this->hasMany('App\Models\Boyolali\DetailLabBoyolali', 'lab_id');
    }
}
