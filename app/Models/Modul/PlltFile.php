<?php

namespace App\Models\Modul;

use Illuminate\Database\Eloquent\Model;

class PlltFile extends Model
{
    protected $table = 'pllt_file';
    protected $fillable = [
        'pllt_id', 'nama_file', 'nama_folder', 'direktori', 'url', 'input_by'
    ];

    public function pllt() {
        return $this->belongsTo('App\Models\Modul\Pllt', 'pllt_id');
    }

    public function inputBy() {
        return $this->belongsTo('App\Models\Pengaturan\User', 'input_by');
    }
}
