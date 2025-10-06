<?php

namespace App\Http\Controllers\Modul;

use PDF;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Modul\Klinik;
use App\Models\Modul\KlinikDosis;
use App\Models\Modul\KlinikTerapi;
use App\Models\Modul\DaftarHarga;
use App\Models\Modul\Pembayaran;
use App\Models\Modul\StockOpname;
use App\Models\Modul\PenambahanStock;
use App\Models\Modul\DetailPembayaran;
use App\Models\Modul\Layanan;
use App\Models\Modul\LayananPembayaran;
use App\Models\Pengaturan\User;
use App\Models\MasterData\SubSatuanKerja;
use App\Models\MasterData\Spesies;
use App\Models\MasterData\Ras;
use App\Models\MasterData\Pemilik;
use App\Models\MasterData\Pemeriksa;
use App\Models\MasterData\Penyakit;
use App\Models\MasterData\Obat;
use App\Models\MasterData\Operasi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\UserHelper;
use App\Http\Controllers\Helpers\KlinikHelper;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    private $url;
    private $cari;
    private $jumPerPage = 10;

    function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->cari = Input::get('cari', '');
        $this->url = makeUrl($request->query());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if(!Auth::user()->hasPermissionTo('Read Klinik')) return view('errors.403');

        $var['url'] = $this->url;
		
		$bulan = date('m');
		$tahun = date('Y');
		$url = "stock";
		
		if(!empty($request->input("bulan"))){
			$bulan = $request->input("bulan");
			$tahun = $request->input("tahun");
		}
		$bulan_sebelumnya = $bulan-1;
		$tahun_sebelumnya = $tahun;
		if($bulan == 1){
			$bulan_sebelumnya = 12;
			$tahun_sebelumnya = $tahun-1;
		}
		$obat = Obat::all();
		$l_obat = array();
		$pengeluaran = array();
		$p_stock = array();
		foreach($obat as $row){
			$p_stock[$row->id] = 0;
			$l_obat[$row->id] = $row->obat;
			$pengeluaran[$row->id] = 0;
		}
		
		
		$stock_awal = StockOpname::where("bulan",$bulan_sebelumnya)->where("tahun",$tahun_sebelumnya)->get();
		$stock = array();
		foreach($stock_awal as $row){
			$stock[$row->obat_id] = $row->stock;
		}
		
		//exit;
		
		$penambahan_stock = PenambahanStock::select(DB::raw('sum(jumlah) as jumlah_tambah, obat_id'))->whereMonth("tanggal",$bulan)->whereYear("tanggal",$tahun)->groupBy("obat_id")->get();
		//echo $penambahan_stock;
		foreach($penambahan_stock as $row){
			$p_stock[$row->obat_id] = $row->jumlah_tambah;
		} 
		
		
		$klinik_terapi = KlinikTerapi::join("klinik_dosis","klinik_terapi.id","klinik_dosis.klinik_id")->where("klinik_dosis.tindakan",2)->whereMonth("tanggal_periksa",$bulan)->whereYear("tanggal_periksa",$tahun)->get();
		foreach($klinik_terapi as $row){
			$dosis = explode(" ", $row->dosis);
			$new_dosis = str_replace(',', '.', $dosis[0]);
			$pengeluaran[$row->terapi_id] += (float)$new_dosis;
			//echo $row->signalement . "-" . $row->terapi_id . " - " . $new_dosis . "<br />";
		}
		//echo $pengeluaran[6];
		//exit;
		$l_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        return view('modul.stock.index', compact('l_obat', 'stock', 'p_stock','pengeluaran','var','l_bulan','bulan','tahun','url'));
    }
	
	public function add_stock(){
		$url = "add_stock";
		$p_stock = PenambahanStock::select("penambahan_stock.*","obat.obat")->join("obat","penambahan_stock.obat_id","obat.id")->get();
		$obat = Obat::pluck('obat','id')->all();
		return view('modul.stock.index-2', compact('p_stock','obat','url'));
	}
	public function add_stock_awal(){
		$url = "add_stock_awal";
		$p_stock = StockOpname::select("stock_opname.*","obat.obat")->join("obat","stock_opname.obat_id","obat.id")->get();
		$obat = Obat::pluck('obat','id')->all();
		$l_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		return view('modul.stock.awal', compact('p_stock','obat','l_bulan','url'));
	}
	public function tambah_stock(){
		$url = "add_stock";
		$obat = Obat::pluck('obat','id')->all();
		return view('modul.stock.tambah_stock', compact('obat','url'));
	}
	public function tambah_stock_awal(){
		$url = "add_stock_awal";
		$obat = Obat::pluck('obat','id')->all();
		$bulan = date('m');
		$tahun = date('Y');
		$l_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		return view('modul.stock.tambah_stock_awal', compact('obat','l_bulan','bulan','tahun','url'));
	}
	
	public function edit_stock($id){
		$url = "add_stock";
		$obat = Obat::pluck('obat','id')->all();
		$item = PenambahanStock::find($id);
		return view('modul.stock.tambah_stock', compact('obat','item','url'));
	}
	public function edit_stock_awal($id){
		$url = "add_stock_awal";
		$obat = Obat::pluck('obat','id')->all();
		$item = StockOpname::find($id);
		$bulan = $item->bulan;
		$tahun = $item->tahun;
		$l_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		return view('modul.stock.tambah_stock_awal', compact('obat','item','l_bulan','bulan','tahun','url'));
	}
	public function simpan_stock(Request $request){
		$penambahan_stock = new PenambahanStock();
		$penambahan_stock->obat_id = $request->input("obat");
		$penambahan_stock->jumlah = $request->input("jumlah");
		$penambahan_stock->satuan = $request->input("satuan");
		$penambahan_stock->tanggal = date('Y-m-d', strtotime($request->input("tanggal")));
		if($penambahan_stock->save()){
			Session::flash('pesanSukses', 'Data Berhasil Disimpan');

			return redirect('stock/add_stock');
		}else{
			Session::flash('pesanSukses', 'Data Gagal Disimpan');

			return redirect('stock/tambah_stock');
		}
		
	}
	public function simpan_stock_awal(Request $request){
		$penambahan_stock = new StockOpname();
		$penambahan_stock->obat_id = $request->input("obat");
		$penambahan_stock->stock = $request->input("jumlah");
		$penambahan_stock->satuan = $request->input("satuan");
		$penambahan_stock->bulan = $request->input("bulan");
		$penambahan_stock->tahun = $request->input("tahun");
		if($penambahan_stock->save()){
			Session::flash('pesanSukses', 'Data Berhasil Disimpan');

			return redirect('stock/add_stock_awal');
		}else{
			Session::flash('pesanSukses', 'Data Gagal Disimpan');

			return redirect('stock/tambah_stock_awal');
		}
		
	}
	public function update_stock(Request $request){
		$penambahan_stock = PenambahanStock::find($request->input("id"));
		$penambahan_stock->obat_id = $request->input("obat");
		$penambahan_stock->jumlah = $request->input("jumlah");
		$penambahan_stock->satuan = $request->input("satuan");
		$penambahan_stock->tanggal = date('Y-m-d', strtotime($request->input("tanggal")));
		if($penambahan_stock->save()){
			Session::flash('pesanSukses', 'Data Berhasil Disimpan');

			return redirect('stock/add_stock');
		}else{
			Session::flash('pesanSukses', 'Data Gagal Disimpan');

			return redirect('stock/edit_stock/' . $request->input("id"));
		}
		
	}
	
	public function update_stock_awal(Request $request){
		$penambahan_stock = StockOpname::find($request->input("id"));
		$penambahan_stock->obat_id = $request->input("obat");
		$penambahan_stock->stock = $request->input("jumlah");
		$penambahan_stock->satuan = $request->input("satuan");
		$penambahan_stock->bulan = $request->input("bulan");
		$penambahan_stock->tahun = $request->input("tahun");
		if($penambahan_stock->save()){
			Session::flash('pesanSukses', 'Data Berhasil Disimpan');

			return redirect('stock/add_stock_awal');
		}else{
			Session::flash('pesanSukses', 'Data Gagal Disimpan');

			return redirect('stock/edit_stock_awal/' . $request->input("id"));
		}
		
	}
	public function update_stock_opname(Request $request){
		$bulan = $request->input("bulan");
		$tahun = $request->input("tahun");
		$obat = $request->input("obat");
		$stock = $request->input("stock");
		$stockOpname = StockOpname::where('bulan', $bulan)->where('tahun',$tahun)->delete();
		$berhasil = 0;
		$jum_array = count($obat);
		foreach($obat as $key=>$value){
			$penambahan_stock = new StockOpname();
			$penambahan_stock->obat_id = $value;
			$penambahan_stock->stock = $stock[$key];
			$penambahan_stock->bulan = $bulan;
			$penambahan_stock->tahun = $tahun;
			if($penambahan_stock->save()){
				$berhasil++;
			}
		}
		if($berhasil == $jum_array){
			Session::flash('pesanSukses', 'Data Berhasil Disimpan');

			return redirect('stock/index');
		}else{
			Session::flash('pesanSukses', 'Data Gagal Disimpan');

			return redirect('stock/index/');
		}
	}
	public function export($bulan,$tahun){
		$bulan_sebelumnya = $bulan-1;
		$tahun_sebelumnya = $tahun;
		if($bulan == 1){
			$bulan_sebelumnya = 12;
			$tahun_sebelumnya = $tahun-1;
		}
		$obat = Obat::all();
		$l_obat = array();
		$pengeluaran = array();
		$p_stock = array();
		foreach($obat as $row){
			$p_stock[$row->id] = 0;
			$l_obat[$row->id] = $row->obat;
			$pengeluaran[$row->id] = 0;
		}
		
		
		$stock_awal = StockOpname::where("bulan",$bulan_sebelumnya)->where("tahun",$tahun_sebelumnya)->get();
		$stock = array();
		foreach($stock_awal as $row){
			$stock[$row->obat_id] = $row->stock;
		}
		
		//exit;
		
		$penambahan_stock = PenambahanStock::select(DB::raw('sum(jumlah) as jumlah_tambah, obat_id'))->whereMonth("tanggal",$bulan)->whereYear("tanggal",$tahun)->groupBy("obat_id")->get();
		//echo $penambahan_stock;
		foreach($penambahan_stock as $row){
			$p_stock[$row->obat_id] = $row->jumlah_tambah;
		} 
		
		
		$klinik_terapi = KlinikTerapi::join("klinik_dosis","klinik_terapi.id","klinik_dosis.klinik_id")->where("klinik_dosis.tindakan",2)->whereMonth("tanggal_periksa",$bulan)->whereYear("tanggal_periksa",$tahun)->get();
		foreach($klinik_terapi as $row){
			$dosis = explode(" ", $row->dosis);
			$new_dosis = str_replace(',', '.', $dosis[0]);
			$pengeluaran[$row->terapi_id] += (float)$new_dosis;
			//echo $row->signalement . "-" . $row->terapi_id . " - " . $new_dosis . "<br />";
		}
		//echo $pengeluaran[6];
		//exit;
		$l_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=laporan-klinik.xls");//ganti nama sesuai keperluan
		header("Pragma: no-cache");
		header("Expires: 0");
        return view('modul.stock.tabel', compact('l_obat', 'stock', 'p_stock','pengeluaran','l_bulan','bulan','tahun'));
	}

}