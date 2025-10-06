<?php

namespace App\Models\Modul;

use Illuminate\Database\Eloquent\Model;

class PlltHewan extends Model
{
    protected $table = 'pllt_hewan';
    protected $fillable = [
        'pllt_id', 'jenis_spesies_id', 'jenis_hewan_id', 'jumlah', 'satuan', 'jumlah_jantan', 'jumlah_betina', 'input_by'
    ];

    public function pllt() {
        return $this->belongsTo('App\Models\Modul\Pllt', 'pllt_id');
    }

    public function spesies() {
        return $this->belongsTo('App\Models\MasterData\Spesies', 'jenis_spesies_id');
    }

    public function ras() {
        return $this->belongsTo('App\Models\MasterData\Ras', 'jenis_hewan_id');
    }

    public function inputBy() {
        return $this->belongsTo('App\Models\Pengaturan\User', 'input_by');
    }

    public function setJumlahAttribute($value) {
        if($value == "") $this->attributes['jumlah'] = 0;
        else $this->attributes['jumlah'] = $value;
    }

    public function setJumlahJantanAttribute($value) {
        if($value == "") $this->attributes['jumlah_jantan'] = 0;
        else $this->attributes['jumlah_jantan'] = $value;
    }

    public function setJumlahBetinaAttribute($value) {
        if($value == "") $this->attributes['jumlah_betina'] = 0;
        else $this->attributes['jumlah_betina'] = $value;
    }
}
