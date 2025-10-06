<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Modul\Pllt;
use App\Models\Modul\PlltHewan;
use App\Models\Modul\Klinik;
use App\Models\Modul\KlinikDosis;

class StatistikController extends Controller
{
	private $bulan =  ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'];
	public function index(){
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
		
		$tanggal = date("d");
		$bulan = date("m");
		$tahun = date("Y");
		
		for($i=1;$i<=$tanggal;$i++){
			$list_tanggal[] = $i . "-" . $bulan . "-" . $tahun;
			$jumlahLaboratorium = DB::table('laboratorium_keswan')->whereDate('created_at', $tahun . "-" . $bulan . "-" . $i)->count();
			$list_harian_lab_keswan[] = $jumlahLaboratorium;
			$jumlahLaboratorium = DB::table('laboratorium_kesmavet')->whereDate('created_at', $tahun . "-" . $bulan . "-" . $i)->count();
			$list_harian_lab_kesmavet[] = $jumlahLaboratorium;
			$jumlahLaboratorium = DB::table('laboratorium_pakan')->whereDate('created_at', $tahun . "-" . $bulan . "-" . $i)->count();
			$list_harian_lab_pakan[] = $jumlahLaboratorium;
			
			$jumlahLaboratorium = DB::table('klinik_terapi')->whereDate('tanggal_periksa', $tahun . "-" . $bulan . "-" . $i)->count();
			$list_klinik[] = $jumlahLaboratorium;
			
			$jumlahLaboratorium = DB::table('pllt')->whereDate('created_at', $tahun . "-" . $bulan . "-" . $i)->where('jenis_form',"=",'Ternak Masuk')->count();
			$list_pllt_masuk[] = $jumlahLaboratorium;
			
			$jumlahLaboratorium = DB::table('pllt')->whereDate('created_at', $tahun . "-" . $bulan . "-" . $i)->where('jenis_form',"=",'Ternak Keluar')->count();
			$list_pllt_keluar[] = $jumlahLaboratorium;
			
			$jumlahLaboratorium = DB::table('pllt')->whereDate('created_at', $tahun . "-" . $bulan . "-" . $i)->where('jenis_form',"=",'Ternak Lewat')->count();
			$list_pllt_lewat[] = $jumlahLaboratorium;
			
			
			
			
		}
		//exit;
		
        $var['bulan'] = json_encode($this->bulan);
        $var['jumlahLaboratoriumGrafik'] = json_encode($listJumlahLaboratorium);
        $var['jumlahPlltGrafik'] = json_encode($listJumlahPllt);
        $var['jumlahKlinikGrafik'] = json_encode($listJumlahKlinik);
		
        $var['list_tanggal'] = json_encode($list_tanggal);
        $var['list_harian_lab_keswan'] = json_encode($list_harian_lab_keswan);
        $var['list_harian_lab_kesmavet'] = json_encode($list_harian_lab_kesmavet);
        $var['list_harian_lab_pakan'] = json_encode($list_harian_lab_pakan);
		
        $var['list_klinik'] = json_encode($list_klinik);
		
        $var['list_pllt_masuk'] = json_encode($list_pllt_masuk);
        $var['list_pllt_keluar'] = json_encode($list_pllt_keluar);
        $var['list_pllt_lewat'] = json_encode($list_pllt_lewat);
		
		
		
        return view('statistik', compact('var'));
	}
	
}