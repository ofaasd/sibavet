<?php

namespace App\Models\Modul;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Scopes\ViewDataScope;

class Klinik extends Model
{
    protected $table = 'klinik';
    protected $fillable = [
        'no_pasien', 'sub_satuan_kerja_id', 'pemilik_id', 'spesies_id', 'ras_id', 'jenis_kelamin', 'nama_hewan', 'umur',
        'ciri_ciri', 'no_periksa', 'tanggal_periksa', 'signalement', 'anamnesia', 'diagnosa', 'keterangan', 'input_by'
    ];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ViewDataScope);
    }

    public function scopeCari($query, $cari) {
        return $query->where('no_pasien', 'like', '%'.$cari.'%')
            ->orWhereHas('subSatuanKerja', function ($queryIn) use ($cari) {
                $queryIn->where('sub_satuan_kerja', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('pemilik', function ($queryIn) use ($cari) {
                $queryIn->where('nama', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('spesies', function ($queryIn) use ($cari) {
                $queryIn->where('nama_spesies', 'like', '%'.$cari.'%');
            })
            ->orWhere('nama_hewan', 'like', '%'.$cari.'%')
            ->orWhere('no_periksa', 'like', '%'.$cari.'%');
    }

    public function setTanggalPeriksaAttribute($tanggal) {
        if($tanggal != "") $this->attributes['tanggal_periksa'] = Carbon::parse($tanggal)->format('Y-m-d');
    }

    public function getTanggalPeriksaAttribute($value){
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function klinikDosis() {
        return $this->hasMany('App\Models\Modul\KlinikDosis', 'klinik_id');
    }

    public function klinikTerapi(){
        return $this->hasMany('App\Models\Modul\KlinikTerapi', 'klinik_id');
    }

    public function subSatuanKerja() {
        return $this->belongsTo('App\Models\MasterData\SubSatuanKerja', 'sub_satuan_kerja_id');
    }

    public function pemilik() {
        return $this->belongsTo('App\Models\MasterData\Pemilik', 'pemilik_id');
    }

    public function spesies() {
        return $this->belongsTo('App\Models\MasterData\Spesies', 'spesies_id');
    }

    public function ras() {
        return $this->belongsTo('App\Models\MasterData\Ras', 'ras_id');
    }

    public function inputBy() {
        return $this->belongsTo('App\Models\Pengaturan\User', 'input_by');
    }
}
