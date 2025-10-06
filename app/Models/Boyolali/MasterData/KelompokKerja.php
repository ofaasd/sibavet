<?php

namespace App\Models\Boyolali\MasterData;

use Illuminate\Database\Eloquent\Model;

class KelompokKerja extends Model
{
    protected $table = 'kelompok_kerja';
    protected $fillable = [
        'kelompok', 'jenis'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kelompok', 'like', '%'.$cari.'%')
            ->orWhere('jenis', 'like', '%'.$cari.'%');
    }
}
