<?php

namespace App\Http\Controllers\Boyolali;

use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Modul\Pllt;
use App\Models\Modul\PlltHewan;
use App\Models\Modul\Klinik;
use App\Models\Modul\KlinikDosis;

class BoyolaliController 
{

    private $bulan =  ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'];
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    function __construct(Request $request){
        
    }
    

    public function index(Request $request){
        $var['jumlahLaboratorium'] = DB::table('laboratorium')->count('id');
        $var['jumlahPllt'] = DB::table('pllt')->count('id');
        $var['jumlahKlinik'] = DB::table('klinik')->count('id');
        $var['jumlahUsers'] = DB::table('users')->count('id');

        if(@$request->tahun == "") $var['tahun'] = Carbon::now()->format('Y');
        else $var['tahun'] = $request->tahun;

        for($i=1;$i<=count($this->bulan);$i++){
            $jumlahLaboratorium = DB::table('laboratorium')->whereMonth('created_at', $i)->whereYear('created_at', $var['tahun'])->count();
            $listJumlahLaboratorium[] = $jumlahLaboratorium;

            $jumlahPllt = DB::table('pllt')->whereMonth('created_at', $i)->whereYear('created_at', $var['tahun'])->count();
            $listJumlahPllt[] = $jumlahPllt;

            $jumlahKlinik = DB::table('klinik')->whereMonth('created_at', $i)->whereYear('created_at', $var['tahun'])->count();
            $listJumlahKlinik[] = $jumlahKlinik;
        }
        $var['bulan'] = json_encode($this->bulan);
        $var['jumlahLaboratoriumGrafik'] = json_encode($listJumlahLaboratorium);
        $var['jumlahPlltGrafik'] = json_encode($listJumlahPllt);
        $var['jumlahKlinikGrafik'] = json_encode($listJumlahKlinik);

        return view('boyolali/home', compact('var'));
    }
}
