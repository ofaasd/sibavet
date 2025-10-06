<?php

namespace App\Models\Modul;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class KlinikTerapi extends Model
{
    protected $table = 'klinik_terapi';
    protected $fillable = [
            'klinik_id','pemeriksa','tindakan','tanggal_periksa','signalement','anamnesia','diagnosa','keterangan'
    ];

    public function setTanggalPeriksaAttribute($tanggal) {
        if($tanggal != "") $this->attributes['tanggal_periksa'] = Carbon::parse($tanggal)->format('Y-m-d');
    }

    public function getTanggalPeriksaAttribute($value){
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function klinik(){
        return $this->belongsTo('App\Models\Modul\Klinik', 'klinik_id');
    }
}
