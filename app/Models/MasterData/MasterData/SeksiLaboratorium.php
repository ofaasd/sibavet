<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class SeksiLaboratorium extends Model
{
    protected $table = 'seksi_laboratorium';
    protected $fillable = [
        'kode', 'seksi_laboratorium'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhere('seksi_laboratorium', 'like', '%'.$cari.'%');
    }
}
