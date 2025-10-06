<?php

namespace App\Http\Controllers\Pengaturan;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LainLainController extends Controller
{
    private $viewData = [
        '1' => 'Lihat Semua Data',
        '2' => 'Lihat Data Per Satuan Kerja',
        '3' => 'Lihat Data Per Sub Satuan Kerja',
        '4' => 'Lihat Data Sendiri'
    ];

    function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function getInformasiPengguna()
    {
        $var['viewData'] = $this->viewData;
        $listUser = User::find(Auth::user()->id);
        return view('lain-lain.informasi-pengguna', compact('var', 'listUser'));
    }

    public function formGantiPassword()
    {
        return view('lain-lain.ganti-password');
    }

    public function updatePassword(Request $request)
    {
        try {
            DB::beginTransaction();
            $password = User::find(Auth::user()->id);
            $password->password = $request->password;
            $password->save();

            DB::commit();
            Session::flash('pesanSukses', 'Password Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Password Gagal Diupdate');
        }

        return redirect('ganti-password');
    }
}
