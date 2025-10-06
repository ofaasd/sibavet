<?php

namespace App\Models\Modul;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Scopes\ViewDataScope;

class LaboratoriumPakan extends Model
{
    protected $table = 'laboratorium_pakan';
    protected $fillable = [
        'lab',
        'status_epid', 'no_epid', 'sub_satuan_kerja_id', 'nama_pengirim_id', 'jenis_hewan_id', 'jenis_contoh_id', 'bentuk_contoh_id',
        'jumlah_contoh', 'seksi_laboratorium_id', 'permintaan_uji_id', 'kriteria_contoh', 'metode_uji', 'peralatan', 'bahan',
        'personil', 'catatan', 'jenis_kegiatan', 'pengirim', 'tanggal_penerimaan', 'penerima', 'nomor_asal', 'nomor_baru', 'asal_contoh_id',
        'manajer_teknis', 'penguji_ditunjuk', 'hasil_pengujian', 'hasil_pengujian2', 'pengujian_parasit', 'keterangan_hasil', 'input_by','penerima_02'
    ];

    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new ViewDataScope);
    }

    public function scopeCari($query, $cari) {
        return $query->where('no_epid', 'like', '%'.$cari.'%')
            ->orWhereHas('subSatuanKerja', function ($queryIn) use ($cari) {
                $queryIn->where('sub_satuan_kerja', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('customer', function ($queryIn) use ($cari) {
                $queryIn->where('nama_pelanggan', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('spesies', function ($queryIn) use ($cari) {
                $queryIn->where('nama_spesies', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('seksiLaboratorium', function ($queryIn) use ($cari) {
                $queryIn->where('seksi_laboratorium', 'like', '%'.$cari.'%');
            })
            ->orWhere('pengirim', 'like', '%'.$cari.'%');
    }

    public function setTanggalPenerimaanAttribute($tanggal) {
        if($tanggal != "") $this->attributes['tanggal_penerimaan'] = Carbon::parse($tanggal)->format('Y-m-d');
    }

    public function getTanggalPenerimaanAttribute($value){
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function setJumlahContohAttribute($value) {
        if($value == "") $this->attributes['jumlah_contoh'] = 0;
        else $this->attributes['jumlah_contoh'] = $value;
    }

    public function laboratoriumFile() {
        return $this->hasMany('App\Models\Modul\LaboratoriumFile', 'laboratorium_id');
    }

    public function subSatuanKerja() {
        return $this->belongsTo('App\Models\MasterData\SubSatuanKerja', 'sub_satuan_kerja_id');
    }

    public function customer() {
        return $this->belongsTo('App\Models\MasterData\Customer', 'nama_pengirim_id');
    }

    public function spesies() {
        return $this->belongsTo('App\Models\MasterData\Spesies', 'jenis_hewan_id');
    }

    public function jenisContoh() {
        return $this->belongsTo('App\Models\MasterData\JenisContoh', 'jenis_contoh_id');
    }

    public function bentukContoh() {
        return $this->belongsTo('App\Models\MasterData\BentukContoh', 'bentuk_contoh_id');
    }

    public function seksiLaboratorium() {
        return $this->belongsTo('App\Models\MasterData\SeksiLaboratorium', 'seksi_laboratorium_id');
    }

    public function jenisPengujian() {
        return $this->belongsTo('App\Models\MasterData\JenisPengujian', 'permintaan_uji_id');
    }

    public function kotaKabupaten() {
        return $this->belongsTo('App\Models\Indonesia\Kota', 'asal_contoh_id');
    }

    public function inputBy() {
        return $this->belongsTo('App\Models\Pengaturan\User', 'input_by');
    }

    public function labContoh()
    {
        return $this->belongsToMany('App\Models\MasterData\JenisContoh','lab_contoh_pakan','lab_id','contoh_id')
                    // ->using('App\Models\MasterData\LabContohPakan')
                    ->as('pcontoh')
                    ->withPivot([
                        'id',
                        'urut',
                        'nomor_asal',
                        'nomor_baru'
                        // 'nol',
                        // 'tinggi',
                        // 'rendah',
                        // 'positif',
                        // 'negatif'
                    ]);
    }

    // public function labPengujian()
    // {
    //     return $this->belongsToMany('App\Models\MasterData\JenisPengujian','lab_contoh_pakan','lab_id','pengujian_id')
    //                 ->as('pPengujian')
    //                 ->withPivot([
    //                     'id',
    //                     // 'nol',
    //                     // 'tinggi',
    //                     // 'rendah',
    //                     // 'positif',
    //                     // 'negatif',
    //                     // 'kelompok_uji',
    //                 ]);
    // }

    public function contohNilai()
    {
        return $this->hasMany('App\Models\MasterData\LabManyContoh', 'lab_id');
    }

    public function hasilPenilaian()
    {
        return $this->hasMany('App\Models\MasterData\labNilai', 'lab_id');
    }

    public function getJumlahContoh()
    {
        return $this->labContoh()->sum('pivot_jumlah');
    }

    public function pakanTr()
    {
        return $this->hasMany('App\Models\MasterData\LabManyContoh', 'lab_id');
    }
}
