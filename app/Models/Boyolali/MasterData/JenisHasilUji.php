<?php

namespace App\Models\Boyolali\MasterData;

use Illuminate\Database\Eloquent\Model;

class JenisHasilUji extends Model
{
    protected $table = 'jenis_hasil_uji';
    protected $fillable = [
        'kode', 'nama'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhere('nama', 'like', '%'.$cari.'%');
    }
}
