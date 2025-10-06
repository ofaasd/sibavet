<?php

namespace App\Models\Modul;

use Illuminate\Database\Eloquent\Model;

class KlinikDosis extends Model
{
    protected $table = 'klinik_dosis';
    protected $fillable = [
        'klinik_id', 'tindakan','terapi_id', 'dosis', 'input_by'
    ];

    public function klinik() {
        return $this->belongsTo('App\Models\Modul\Klinik', 'klinik_id');
    }

    public function terapi() {
        return $this->belongsTo('App\Models\MasterData\Obat', 'terapi_id');
    }

    public function inputBy() {
        return $this->belongsTo('App\Models\Pengaturan\User', 'input_by');
    }
}
