<?php

namespace App\Models\Boyolali\MasterData;

use Illuminate\Database\Eloquent\Model;

class Sampel extends Model
{
    protected $table = 'sampel';
    protected $fillable = [
         'nm_sampel'
    ];

    public function scopeCari($query, $cari) {
        return $query->where('nm_sampel', 'like', '%'.$cari.'%');
    }
}
