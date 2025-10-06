<?php

namespace App\Models\MasterData;

use Illuminate\Database\Eloquent\Model;

class Penyakit extends Model
{
    protected $table = 'penyakit';
    protected $fillable = [
        'kode', 'penyakit'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('kode', 'like', '%'.$cari.'%')
            ->orWhere('penyakit', 'like', '%'.$cari.'%');
    }
}
