<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class UserHelper
{
    static public function listUser()
    {
        $listUser = array();
        if(Auth::user()->view_data == '1'){
            $queryUser = User::get();
        }else if(Auth::user()->view_data == '2'){
            $queryUser = User::where('satuan_kerja_id', Auth::user()->satuan_kerja_id)->get();
        }else if(Auth::user()->view_data == '3'){
            $queryUser = User::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->get();
        }else if(Auth::user()->view_data == '4'){
            $queryUser = User::where('id', Auth::user()->id)->get();
        }else if(Auth::user()->view_data == '5'){
            $queryUser = User::where('id', Auth::user()->id)->get();
        }

        foreach($queryUser as $item){
            $listUser[$item->id] = $item->nip.' | '.$item->name;
        }

        return $listUser;
    }

    function hakAkses($menu, $action){
        $akses = Permission::where('menu', $menu)->where('action', $action)->where('status', '1')->first();
        return $akses;
    }
	
}
