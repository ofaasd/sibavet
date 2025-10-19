<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Modul\Pllt;
use App\Models\Modul\PlltHewan;
use App\Models\Modul\Klinik;
use App\Models\Modul\KlinikTerapi;
use App\Models\Modul\KlinikDosis;

class HomeController extends Controller
{
    private $bulan =  ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'];
    private $bulan2 =  [1=>'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
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

            $jumlahKlinik = DB::table('klinik_terapi')->whereMonth('tanggal_periksa', $i)->whereYear('tanggal_periksa', $var['tahun'])->count();
            $listJumlahKlinik[] = $jumlahKlinik;
        }
		//script untuk ambil data grafik jumlah pasien
		$curr_bulan = date('m');
		$curr_tahun = date('Y');
		$role = Auth::user()->role;
		$kode = "";
		$nama = "";
		if($role != "Administrator"){
		    $kode = Auth::user()->subSatuanKerja->kode_klinik;
		    $nama = Auth::user()->nama;
		}
		$var['nama'] = $nama;
		$var['spesies'] = 	$results = DB::table('klinik_terapi')
											->select("spesies.*")
											->join("klinik", "klinik_terapi.klinik_id", "klinik.id")
											->join("spesies", "spesies.id", "klinik.spesies_id")
											->whereMonth("klinik_terapi.tanggal_periksa", $curr_bulan)
											->whereYear("klinik_terapi.tanggal_periksa", $curr_tahun)
											->where("klinik_terapi.no_pasien", "like", "%" . $kode . "%")
											->groupBy('spesies.id', 'spesies.nama_spesies','spesies.kode','spesies.lab', 'spesies.klinik', 'spesies.created_at', 'spesies.updated_at')
											->get();
		$var['jumlah_jenis_pasien'] = array();
		$var['list_spesies'] = array();
		foreach($var['spesies'] as $spesies){
			$jumlah = DB::table('klinik_terapi')->select("spesies.*")->join("klinik","klinik_terapi.klinik_id","klinik.id")->join("spesies","spesies.id","klinik.spesies_id")->whereMonth("klinik_terapi.tanggal_periksa",$curr_bulan)->whereYear("klinik_terapi.tanggal_periksa",$curr_tahun)->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->where("klinik.spesies_id",$spesies->id)->count();
			$var['jumlah_jenis_pasien'][] = $jumlah;
			$var['list_spesies'][] = $spesies->nama_spesies . " : " . $jumlah;
		}
		
		$var['curr_bulan'] = $curr_bulan;
		$var['curr_tahun'] = $curr_tahun; 
		$var['list_bulan'] = $this->bulan2;
		$var['jumlah_jenis_pasien'] = json_encode($var['jumlah_jenis_pasien']);
		$var['list_spesies'] = json_encode($var['list_spesies']);
		
		//script untuk ambil data jumlah pelayanan
		$var['pelayanan'] = array();
		$pelayanan = DB::table("detail_pembayaran")->select("detail_pembayaran.tindakan","detail_pembayaran.terapi_id")->join("pembayaran","pembayaran.id","detail_pembayaran.pembayaran_id")->join("klinik_terapi","klinik_terapi.id","pembayaran.klinik_terapi_id")->whereMonth("klinik_terapi.tanggal_periksa",$curr_bulan)->whereYear("klinik_terapi.tanggal_periksa",$curr_tahun)->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->groupBy("detail_pembayaran.tindakan","detail_pembayaran.terapi_id")->get();
		$var['nama_pelayanan'] = array();
		$var['jumlah_pelayanan'] = array();
		foreach($pelayanan as $row){
			$nama_pelayanan = DB::table("daftar_harga")->where("tindakan",$row->tindakan)->where("terapi_id",$row->terapi_id)->first()->nama_pelayanan;
			$jumlah_pelayanan = DB::table("detail_pembayaran")->join("pembayaran","pembayaran.id","detail_pembayaran.pembayaran_id")->join("klinik_terapi","klinik_terapi.id","pembayaran.klinik_terapi_id")->whereMonth("klinik_terapi.tanggal_periksa",$curr_bulan)->whereYear("klinik_terapi.tanggal_periksa",$curr_tahun)->where("detail_pembayaran.tindakan",$row->tindakan)->where("detail_pembayaran.terapi_id",$row->terapi_id)->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->count();
			$var['nama_pelayanan'][] = $nama_pelayanan . " : " . $jumlah_pelayanan;
			$var['jumlah_pelayanan'][] = $jumlah_pelayanan;
		}
		$var['nama_pelayanan'] = json_encode($var['nama_pelayanan']);
		$var['jumlah_pelayanan'] = json_encode($var['jumlah_pelayanan']);
		
		//untuk ambil data jumlah pasien harian
		$date = date('Y-m-d',strtotime($curr_tahun . '-' . $curr_bulan . '-01'));//Current Month Year
		$end = date('Y-m-t',strtotime($curr_tahun . '-' . $curr_bulan . '-01'));//Current Month Year
		$var['tanggal_periksa'] = array();
		$var['jumlah_periksa'] = array();
		while (strtotime($date) <= strtotime($end)) {
			$day1 = date('Y-m-d', strtotime($date));
			$day2 = date('d-m-Y', strtotime($date));
			
			$pasien = DB::table("klinik_terapi")->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->where("tanggal_periksa",$day1)->count();
			//echo $pasien;
			//echo "-";
			$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));//Adds 1 day onto current date
			$var['tanggal_periksa'][] = $day2;
			$var['jumlah_periksa'][] = $pasien;
			//echo $day1 . '<br>';
		}
		$var['tanggal_periksa'] = json_encode($var['tanggal_periksa']);
		$var['jumlah_periksa'] = json_encode($var['jumlah_periksa']);
		
		$bulan_pad = $this->bulan2;
		
		$var['pad_bulanan'] = array();
		$var['bulan_pad'] = array(); 
		foreach($bulan_pad as $key=>$bulan){
			$var['pad_bulanan'][] = DB::table("pembayaran")->join("klinik_terapi","pembayaran.klinik_terapi_id","klinik_terapi.id")->join("klinik","klinik.id","klinik_terapi.klinik_id")->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->whereMonth("klinik_terapi.tanggal_periksa",$key)->whereYear("klinik_terapi.tanggal_periksa",$curr_tahun)->sum("total");
			$var['bulan_pad'][] = $bulan;
		}
		$var['bulan_pad'] = json_encode($var['bulan_pad']);
		
		$var['pad_bulanan'] = json_encode($var['pad_bulanan']);
		//var_dump($var['pad_bulanan']);
		//echo $var['jumlah_jenis_pasien'];
		//var_dump($var['jumlah']);
		//$var['jumlah_jenis_pasien'] = DB::table("jumlah_jenis_pasien_bulanan")->get();
        $var['bulan'] = json_encode($this->bulan);
        $var['jumlahLaboratoriumGrafik'] = json_encode($listJumlahLaboratorium);
        $var['jumlahPlltGrafik'] = json_encode($listJumlahPllt);
        $var['jumlahKlinikGrafik'] = json_encode($listJumlahKlinik);
		
        return view('home', compact('var'));
    }
	public function get_jumlah_jenis_pasien(Request $request){
		$curr_bulan = $request->bulan;
		$curr_tahun = $request->tahun;
		//echo $bulan;
		//echo $tahun;
		$var['spesies'] = DB::table('klinik_terapi')->select("spesies.*")->join("klinik","klinik_terapi.klinik_id","klinik.id")->join("spesies","spesies.id","klinik.spesies_id")->whereMonth("klinik_terapi.tanggal_periksa",$curr_bulan)->whereYear("klinik_terapi.tanggal_periksa",$curr_tahun)->groupBy("spesies_id")->get();
		$var['jumlah_jenis_pasien'] = array();
		$var['list_spesies'] = array();
		foreach($var['spesies'] as $spesies){
			$jumlah = DB::table('klinik_terapi')->select("spesies.*")->join("klinik","klinik_terapi.klinik_id","klinik.id")->join("spesies","spesies.id","klinik.spesies_id")->whereMonth("klinik_terapi.tanggal_periksa",$curr_bulan)->whereYear("klinik_terapi.tanggal_periksa",$curr_tahun)->where("klinik.spesies_id",$spesies->id)->count();
			$var['jumlah_jenis_pasien'][] = $jumlah;
			$var['list_spesies'][] = $spesies->nama_spesies . " : " . $jumlah;
		}
		$var['curr_bulan'] = $curr_bulan;
		$var['curr_tahun'] = $curr_tahun; 
		$var['list_bulan'] = $this->bulan2;
		$var['jumlah_jenis_pasien'] = json_encode($var['jumlah_jenis_pasien']);
		$var['list_spesies'] = json_encode($var['list_spesies']);
		return view('home/grafik_jumlah_jenis_pasien', compact('var'));
	}
	public function get_jumlah_pelayanan(Request $request){
		$curr_bulan = $request->bulan;
		$curr_tahun = $request->tahun;
		//echo $bulan;
		//echo $tahun;
		$var['pelayanan'] = array();
		$pelayanan = DB::table("detail_pembayaran")->select("detail_pembayaran.tindakan","detail_pembayaran.terapi_id")->join("pembayaran","pembayaran.id","detail_pembayaran.pembayaran_id")->join("klinik_terapi","klinik_terapi.id","pembayaran.klinik_terapi_id")->whereMonth("klinik_terapi.tanggal_periksa",$curr_bulan)->whereYear("klinik_terapi.tanggal_periksa",$curr_tahun)->groupBy("detail_pembayaran.tindakan","detail_pembayaran.terapi_id")->get();
		$var['nama_pelayanan'] = array();
		$var['jumlah_pelayanan'] = array();
		$var['gagal'] = "";
		foreach($pelayanan as $row){
			if($row->terapi_id == '1469'){
				$row->terapi_id = '2593';
			}
			$pel = DB::table("daftar_harga")->where("tindakan",$row->tindakan)->where("terapi_id",$row->terapi_id);
			if($pel->count() > 0){
				$nama_pelayanan = $pel->first()->nama_pelayanan;
				$jumlah_pelayanan = DB::table("detail_pembayaran")->join("pembayaran","pembayaran.id","detail_pembayaran.pembayaran_id")->join("klinik_terapi","klinik_terapi.id","pembayaran.klinik_terapi_id")->whereMonth("klinik_terapi.tanggal_periksa",$curr_bulan)->whereYear("klinik_terapi.tanggal_periksa",$curr_tahun)->where("detail_pembayaran.tindakan",$row->tindakan)->where("detail_pembayaran.terapi_id",$row->terapi_id)->count();
				$var['nama_pelayanan'][] = $nama_pelayanan . " : " . $jumlah_pelayanan;
				$var['jumlah_pelayanan'][] = $jumlah_pelayanan;
			}else{
				$var['gagal'] .= $row->tindakan . "-" . $row->terapi_id . "<br />";
			}
		}
		$var['nama_pelayanan'] = json_encode($var['nama_pelayanan']);
		$var['jumlah_pelayanan'] = json_encode($var['jumlah_pelayanan']);
		$var['curr_bulan'] = $curr_bulan;
		$var['curr_tahun'] = $curr_tahun; 
		$var['list_bulan'] = $this->bulan2;
		return view('home/grafik_jumlah_pelayanan', compact('var'));
	}
	public function get_jumlah_pasien(Request $request){
		$curr_bulan = $request->bulan;
		$curr_tahun = $request->tahun;
		//echo $bulan;
		//echo $tahun;
		$date = date('Y-m-d',strtotime($curr_tahun . '-' . $curr_bulan . '-01'));//Current Month Year
		$end = date('Y-m-t',strtotime($curr_tahun . '-' . $curr_bulan . '-01'));//Current Month Year
		$var['tanggal_periksa'] = array();
		$var['jumlah_periksa'] = array();
		while (strtotime($date) <= strtotime($end)) {
			$day1 = date('Y-m-d', strtotime($date));
			$day2 = date('d-m-Y', strtotime($date));
			
			$pasien = DB::table("klinik_terapi")->where("tanggal_periksa",$day1)->count();
			//echo $pasien;
			//echo "-";
			$date = date("Y-m-d", strtotime("+1 day", strtotime($date)));//Adds 1 day onto current date
			$var['tanggal_periksa'][] = $day2;
			$var['jumlah_periksa'][] = $pasien;
			//echo $day1 . '<br>';
		}
		$var['tanggal_periksa'] = json_encode($var['tanggal_periksa']);
		$var['jumlah_periksa'] = json_encode($var['jumlah_periksa']);
		$var['curr_bulan'] = $curr_bulan;
		$var['curr_tahun'] = $curr_tahun; 
		$var['list_bulan'] = $this->bulan2;
		return view('home/grafik_jumlah_pasien', compact('var'));
	}
    public function convert()
    {
        // $pllt = PllT::orderBy('id', 'asc')->get();
        // foreach($pllt as $item){
        //     $plltHewan = new PlltHewan();
        //     $plltHewan->pllt_id = $item->id;
        //     $plltHewan->jenis_spesies_id = $item->jenis_spesies_id;
        //     $plltHewan->jenis_hewan_id = $item->jenis_hewan_id;
        //     if(in_array($item->jenis_spesies_id,['289','4','70','292','71'])){
        //         $jumlah = $item->jumlah_jantan + $item->jumlah_betina;
        //         $jumlahJantan = 0;
        //         $jumlahBetina = 0;
        //     }else{
        //         $jumlah = 0;
        //         $jumlahJantan = $item->jumlah_jantan;
        //         $jumlahBetina = $item->jumlah_betina;
        //     }
        //     $plltHewan->jumlah = $jumlah;
        //     $plltHewan->satuan = 'Ton';
        //     $plltHewan->jumlah_jantan = $jumlahJantan;
        //     $plltHewan->jumlah_betina = $jumlahBetina;
        //     $plltHewan->input_by = $item->input_by;
        //     $plltHewan->save();
        // }
        // dd("ok");

        // $klinik = Klinik::orderBy('id', 'asc')->get();
        // foreach($klinik as $item){
        //     $klinikDosis = new KlinikDosis();
        //     $klinikDosis->klinik_id = $item->id;
        //     $klinikDosis->terapi_id = $item->terapi_id;
        //     $klinikDosis->dosis = $item->dosis;
        //     $klinikDosis->input_by = $item->input_by;
        //     $klinikDosis->save();
        // }
        // dd("ok");
    }
}
