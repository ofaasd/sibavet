<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class AsalHewan extends Model
{
    protected $table = 'asal_hewan';
    protected $fillable = [
        'kode', 'asal_hewan', 'satuan'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhere('asal_hewan', 'like', '%'.$cari.'%')
            ->orWhere('satuan', 'like', '%'.$cari.'%');
    }
}
