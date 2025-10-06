<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $fillable = [
        'nama_pelanggan', 'alamat', 'kelurahan_id', 'kecamatan_id', 'kota_id', 'provinsi_id'
    ];

    public function kelurahan() {
        return $this->belongsTo('App\Models\Indonesia\Kelurahan', 'kelurahan_id');
    }

    public function kecamatan() {
        return $this->belongsTo('App\Models\Indonesia\Kecamatan', 'kecamatan_id');
    }

    public function kota() {
        return $this->belongsTo('App\Models\Indonesia\Kota', 'kota_id');
    }

    public function provinsi() {
        return $this->belongsTo('App\Models\Indonesia\Provinsi', 'provinsi_id');
    }

    public function scopeCari($query, $cari) {
        return $query->where('nama_pelanggan', 'like', '%'.$cari.'%')
            ->orWhere('alamat', 'like', '%'.$cari.'%')
            ->orWhereHas('kelurahan', function ($queryIn) use ($cari) {
                $queryIn->where('name', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('kecamatan', function ($queryIn) use ($cari) {
                $queryIn->where('name', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('kota', function ($queryIn) use ($cari) {
                $queryIn->where('name', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('provinsi', function ($queryIn) use ($cari) {
                $queryIn->where('name', 'like', '%'.$cari.'%');
            });
    }
}
