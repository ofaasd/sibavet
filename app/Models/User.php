<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nip', 'name', 'no_handphone', 'email', 'satuan_kerja_id', 'sub_satuan_kerja_id', 'view_data', 'role', 'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function satuanKerja() {
        return $this->belongsTo('App\Models\MasterData\SatuanKerja', 'satuan_kerja_id');
    }

    public function subSatuanKerja() {
        return $this->belongsTo('App\Models\MasterData\SubSatuanKerja', 'sub_satuan_kerja_id');
    }

    public function scopeCari($query, $cari) {
        return $query->where('nip', 'like', '%'.$cari.'%')
            ->orWhere('name', 'like', '%'.$cari.'%')
            ->orWhere('no_handphone', 'like', '%'.$cari.'%')
            ->orWhereHas('satuanKerja', function ($queryIn) use ($cari) {
                $queryIn->where('satuan_kerja', 'like', '%'.$cari.'%');
            })
            ->orWhereHas('subSatuanKerja', function ($queryIn) use ($cari) {
                $queryIn->where('sub_satuan_kerja', 'like', '%'.$cari.'%');
            })
            ->orWhere('role', 'like', '%'.$cari.'%')
            ->orWhere('username', 'like', '%'.$cari.'%');
    }

    public function getJenis()
    {
        return $this->belongsTo('App\Models\MasterData\SubSatuanKerja','sub_satuan_kerja_id','id');
    }
}
