<?php

namespace App\Models\Modul;

use Illuminate\Database\Eloquent\Model;

class LaboratoriumFile extends Model
{
    protected $table = 'laboratorium_file';
    protected $fillable = [
        'laboratorium_id', 'nama_file', 'nama_folder', 'direktori', 'url', 'input_by'
    ];

    public function laboratorium() {
        return $this->belongsTo('App\Models\Modul\Laboratorium', 'laboratorium_id');
    }

    public function inputBy() {
        return $this->belongsTo('App\Models\Pengaturan\User', 'input_by');
    }
}
