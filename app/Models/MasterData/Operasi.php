<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Operasi extends Model
{
    protected $table = 'operasi';
    protected $fillable = [
        'kode', 'tindakan'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhere('tindakan', 'like', '%'.$cari.'%');
    }
}
