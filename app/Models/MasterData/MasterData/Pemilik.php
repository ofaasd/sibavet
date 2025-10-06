<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Pemilik extends Model
{
    protected $table = 'pemilik';
    protected $fillable = [
        'kode', 'nama', 'alamat', 'telepon','ktp'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhere('nama', 'like', '%'.$cari.'%')
            ->orWhere('alamat', 'like', '%'.$cari.'%')
            ->orWhere('telepon', 'like', '%'.$cari.'%')
            ->orWhere('ktp', 'like', '%'.$cari.'%');
    }
}
