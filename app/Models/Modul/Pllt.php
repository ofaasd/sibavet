<?php

namespace App\Models\Modul;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Scopes\ViewDataScope;

class Pllt extends Model
{
    protected $table = 'pllt';
    protected $fillable = [
        'jenis_form', 'sub_satuan_kerja_id', 'jam_masuk', 'nopol_kendaraaan', 'peruntukan', 'provinsi_asal_id', 'kabupaten_asal_id',
        'kecamatan_asal_id', 'provinsi_tujuan_id', 'kabupaten_tujuan_id', 'kecamatan_tujuan_id', 'jenis_dokumen', 'nomor_dokumen',
        'tanggal_dokumen', 'pengirim', 'penerima', 'pemeriksa_id', 'keterangan', 'input_by'
    ];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ViewDataScope);
    }

    public function scopeCari($query, $cari) {
        return $query->where('jenis_form', 'like', '%'.$cari.'%')
            ->orWhereHas('subSatuanKerja', function ($queryIn) use ($cari) {
                $queryIn->where('sub_satuan_kerja', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('kotaKabupatenAsal', function ($queryIn) use ($cari) {
                $queryIn->where('name', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('kotaKabupatenTujuan', function ($queryIn) use ($cari) {
                $queryIn->where('name', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('pemeriksa', function ($queryIn) use ($cari) {
                $queryIn->where('nama', 'like', '%'.$cari.'%');
            })
            ->orWhere('nopol_kendaraaan', 'like', '%'.$cari.'%')
            ->orWhere('tanggal_dokumen', 'like', '%'.date('Y-m-d', strtotime($cari)).'%');
    }

    public function setTanggalDokumenAttribute($tanggal) {
        if($tanggal != "") $this->attributes['tanggal_dokumen'] = Carbon::parse($tanggal)->format('Y-m-d');
    }

    public function getTanggalDokumenAttribute($value){
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function plltFile() {
        return $this->hasMany('App\Models\Modul\PlltFile', 'pllt_id');
    }

    public function plltHewan() {
        return $this->hasMany('App\Models\Modul\PlltHewan', 'pllt_id');
    }

    public function subSatuanKerja() {
        return $this->belongsTo('App\Models\MasterData\SubSatuanKerja', 'sub_satuan_kerja_id');
    }

    public function provinsiAsal() {
        return $this->belongsTo('App\Models\Indonesia\Provinsi', 'provinsi_asal_id');
    }

    public function kotaKabupatenAsal() {
        return $this->belongsTo('App\Models\Indonesia\Kota', 'kabupaten_asal_id');
    }

    public function kecamatanAsal() {
        return $this->belongsTo('App\Models\Indonesia\Kecamatan', 'kecamatan_asal_id');
    }

    public function provinsiTujuan() {
        return $this->belongsTo('App\Models\Indonesia\Provinsi', 'provinsi_tujuan_id');
    }

    public function kotaKabupatenTujuan() {
        return $this->belongsTo('App\Models\Indonesia\Kota', 'kabupaten_tujuan_id');
    }

    public function kecamatanTujuan() {
        return $this->belongsTo('App\Models\Indonesia\Kecamatan', 'kecamatan_tujuan_id');
    }

    public function pemeriksa() {
        return $this->belongsTo('App\Models\MasterData\Pemeriksa', 'pemeriksa_id');
    }

    public function inputBy() {
        return $this->belongsTo('App\Models\Pengaturan\User', 'input_by');
    }
}
