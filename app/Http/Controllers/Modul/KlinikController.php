<?php

namespace App\Http\Controllers\Modul;

use PDF;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// Input facade deprecated; use Request->query() or request()->query()
use App\Models\Modul\Klinik;
use App\Models\Modul\KlinikDosis;
use App\Models\Modul\KlinikTerapi;
use App\Models\Modul\DaftarHarga;
use App\Models\Modul\Pembayaran;
use App\Models\Modul\DetailPembayaran;
use App\Models\Modul\Layanan;
use App\Models\Modul\Percobaan;
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

class KlinikController extends Controller
{
    private $url;
    private $cari;
    private $jumPerPage = 10;

	function __construct(Request $request)
	{
		$this->middleware('auth');
        $this->cari = $request->query('cari', '');
        $this->url = makeUrl($request->query());
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Read Klinik')) return view('errors.403');

        $var['url'] = $this->url;

        if(isset($request->order)){
            $_SESSION['order'] = $request->order;
            $_SESSION['urut'] = $request->urut;
        }

        if(!isset($_SESSION['order']) or $_SESSION['order'] == 'tgl'){
            if(!isset($_SESSION['order'])){
                $queryKlinik = Klinik::join('klinik_terapi','klinik.id','klinik_terapi.klinik_id')->orderBy('klinik_terapi.tanggal_periksa', 'desc');
                (!empty($this->cari))?$queryKlinik->Cari($this->cari):'';
                $listKlinik = $queryKlinik->paginate($this->jumPerPage);
                (!empty($this->cari))?$listKlinik->setPath('klinik'.$var['url']['cari']):'';
            }else{
                $queryKlinik = Klinik::join('klinik_terapi','klinik.id','klinik_terapi.klinik_id')->orderBy('klinik_terapi.tanggal_periksa', $_SESSION['urut']);
            (!empty($this->cari))?$queryKlinik->Cari($this->cari):'';
            $listKlinik = $queryKlinik->paginate($this->jumPerPage);
            (!empty($this->cari))?$listKlinik->setPath('klinik'.$var['url']['cari']):'';
            }            
        }elseif($_SESSION['order'] == 'nama'){
            $queryKlinik = Klinik::join('pemilik','klinik.pemilik_id','=','pemilik.id')->orderBy('pemilik.nama', $_SESSION['urut']);
            (!empty($this->cari))?$queryKlinik->Cari($this->cari):'';
            $listKlinik = $queryKlinik->paginate($this->jumPerPage);
            (!empty($this->cari))?$listKlinik->setPath('klinik'.$var['url']['cari']):'';
        }elseif($_SESSION['order'] == 'rm'){
            $queryKlinik = Klinik::orderBy('no_pasien', $_SESSION['urut']);
            (!empty($this->cari))?$queryKlinik->Cari($this->cari):'';
            $listKlinik = $queryKlinik->paginate($this->jumPerPage);
            (!empty($this->cari))?$listKlinik->setPath('klinik'.$var['url']['cari']):'';
        }        

        return view('modul.klinik.klinik-1', compact('var', 'listKlinik'));
    }
	public function rekap(Request $request){
		$url = $request->route()->getActionMethod();
		$var['url'] = $this->url;
		$var['helper'] = new KlinikHelper();
		if(!Auth::user()->hasPermissionTo('Read Klinik')) return view('errors.403');
		
		$bulan = date('m');
		$tahun = date('Y');
		if(!empty($request->bulan)){
			$bulan = $request->bulan;
			$tahun = $request->tahun;
			$_SESSION['bulan'] = $bulan;
			$_SESSION['tahun'] = $tahun;
			
		}elseif(!empty($_SESSION['bulan'])){
			$bulan = $_SESSION['bulan'];
			$tahun = $_SESSION['tahun'];
		}
		$kode = Auth::user()->subSatuanKerja->kode_klinik;
		
		$status = array("Pendaftaran","Pemeriksaan","Belum Bayar","Sudah Bayar");
		$queryKlinik = KlinikTerapi::select("klinik_terapi.*","klinik.sub_satuan_kerja_id","klinik.pemilik_id","klinik.spesies_id","klinik.nama_hewan")->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->join('pemilik','klinik.pemilik_id','=','pemilik.id')->whereMonth("klinik_terapi.tanggal_periksa","=",$bulan)->whereYear("klinik_terapi.tanggal_periksa","=",$tahun)->where("klinik_terapi.no_pasien","like","%" . $kode . "%");
		//print_r( $queryKlinik->toSql());
		//print_r( $queryKlinik->getBindings());
		//exit;
		//$listKlinik = $queryKlinik->paginate($this->jumPerPage);
		$listKlinik = $queryKlinik->get();
		$l_bulan = array(1=>"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
		$var['view_data'] = Auth::user()->view_data;
		//echo Auth::user()->view_data;
		//exit;
		return view('modul.klinik.klinik-all', compact('var','listKlinik','status','url','l_bulan','bulan','tahun'));
		
	}
	public function pendaftaran(Request $request){
		$url = $request->route()->getActionMethod();
		$var['helper'] = new KlinikHelper();
		//print_r($url);
		//echo $url;
		//exit;
		$kode = Auth::user()->subSatuanKerja->kode_klinik;
		$status = array("Pendaftaran","Pemeriksaan","Belum Bayar","Sudah Bayar");
		$queryKlinik = KlinikTerapi::select("klinik_terapi.*","klinik.sub_satuan_kerja_id","klinik.pemilik_id","klinik.spesies_id","klinik.nama_hewan")->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->join('pemilik','klinik.pemilik_id','=','pemilik.id')->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->where("klinik_terapi.status",1);
		//print_r( $queryKlinik->toSql());
		//print_r( $queryKlinik->getBindings());
		//exit;
		//$listKlinik = $queryKlinik->paginate($this->jumPerPage);
		$listKlinik = $queryKlinik->get();
		$var['view_data'] = Auth::user()->view_data;
		return view('modul.klinik.klinik-all2', compact('listKlinik','status','url','var'));
	}
	public function pemeriksaan(Request $request){
		$url = $request->route()->getActionMethod();
		$var['helper'] = new KlinikHelper();
		$status = array("Pendaftaran","Pemeriksaan","Belum Bayar","Sudah Bayar");
		$kode = Auth::user()->subSatuanKerja->kode_klinik;
		$queryKlinik = KlinikTerapi::select("klinik_terapi.*","klinik.sub_satuan_kerja_id","klinik.pemilik_id","klinik.spesies_id","klinik.nama_hewan")->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->join('pemilik','klinik.pemilik_id','=','pemilik.id')->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->where("klinik_terapi.status",1)->orWhere("klinik_terapi.status",2);
		//print_r( $queryKlinik->toSql());
		//print_r( $queryKlinik->getBindings());
		//exit;
		//$listKlinik = $queryKlinik->paginate($this->jumPerPage);
		$listKlinik = $queryKlinik->get();
		$var['view_data'] = Auth::user()->view_data;
		
		return view('modul.klinik.klinik-all2', compact('listKlinik','status','url','var'));
	}
	public function pembayaran(Request $request){
		$url = $request->route()->getActionMethod();
		$var['helper'] = new KlinikHelper();
		//sementara di filter per tahun sekarang supaya hasil data yang di tampilkan lebih cepat
		$year = date('Y');
		$bulan = date('m');
		$kode = Auth::user()->subSatuanKerja->kode_klinik;
		$status = array("Pendaftaran","Pemeriksaan","Belum Bayar","Sudah Bayar");
		$queryKlinik = KlinikTerapi::select("klinik_terapi.*","klinik.sub_satuan_kerja_id","klinik.pemilik_id","klinik.spesies_id","klinik.nama_hewan")->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->join('pemilik','klinik.pemilik_id','=','pemilik.id')->where("klinik_terapi.no_pasien","like","%" . $kode ."%")->whereYear('klinik_terapi.tanggal_periksa',$year)->whereIn("klinik_terapi.status",[2,3]);
		//print_r( $queryKlinik->toSql());
		//print_r( $queryKlinik->getBindings());
		//exit;
		//$listKlinik = $queryKlinik->paginate($this->jumPerPage);
		$listKlinik = $queryKlinik->get();
		$var['view_data'] = Auth::user()->view_data;
		
		return view('modul.klinik.klinik-all2', compact('listKlinik','status','url','var'));
	}
	public function rekap_buku(Request $request,$id){
		$url = $request->route()->getActionMethod();
		$var['helper'] = new KlinikHelper();
		$kode = Auth::user()->subSatuanKerja->kode_klinik;
		$queryKlinik = KlinikTerapi::select("klinik_terapi.*","klinik.sub_satuan_kerja_id","klinik.pemilik_id","klinik.spesies_id","klinik.nama_hewan")->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->join('pemilik','klinik.pemilik_id','=','pemilik.id')->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->whereDate("klinik_terapi.tanggal_periksa",$id);
		$listKlinik = $queryKlinik->get();
		$var['view_data'] = Auth::user()->view_data;
		
		return view('modul.klinik.klinik-buku', compact('listKlinik','url','var'));
	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Klinik')) return view('errors.403');

        unset($_SESSION['klinikTerapi']);
		//var_dump($_SESSION['klinikTerapi']);
        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;
		$var['listDetailklinik'] = null;
		

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::pluck('nama','id')->all();
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();
        $var['noPeriksa'] = 1;
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }
		$var['view_data'] = Auth::user()->view_data;
        return view('modul.klinik.klinik-2', compact('var'));
    }
	public function add_pendaftaran(Request $request){
        if(!Auth::user()->hasPermissionTo('Create Klinik')) return view('errors.403');
		$url = $request->route()->getActionMethod();
        unset($_SESSION['klinikTerapi']); 
		$kode = Auth::user()->subSatuanKerja->kode_klinik;
		//var_dump($_SESSION['klinikTerapi']);
        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;
		$var['listDetailklinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::where("klinik",1)->pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::where("kode","like","%" . $kode . "%")->select('nama','ktp','alamat','id')->get();
		
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();
        $var['noPeriksa'] = 1;
		$var['tanggal_now'] = date('d-m-Y');
		$var['hewan'] = [];
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }
		$var['view_data'] = Auth::user()->view_data;
        return view('modul.klinik.klinik-pendaftaran', compact('var','url'));
    }
	public function edit_pendaftaran(Request $request, $id, $from_url){
		if(!Auth::user()->hasPermissionTo('Create Klinik')) return view('errors.403');
		$url = $request->route()->getActionMethod();
		$var['from_url'] = $from_url;
		//var_dump($_SESSION['klinikTerapi']);
        $var['method'] =  'edit';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;
		$var['listDetailklinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::all(['nama','ktp','id']);
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::where("klinik",1)->pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();
        $var['noPeriksa'] = 1;
		$var['tanggal_now'] = date('d-m-Y');
		$var['hewan'] = [];
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
		
		$var['curr_klinik'] = KlinikTerapi::select("klinik_terapi.*","klinik.nama_hewan","klinik.pemilik_id","klinik.spesies_id","klinik.jenis_kelamin","pemilik.nama as nama_pemilik","pemilik.alamat as alamat_pemilik","pemilik.ktp as ktp_pemilik","pemilik.telepon as telepon_pemilik")->join("klinik","klinik_terapi.klinik_id","klinik.id")->join("pemilik","klinik.pemilik_id","pemilik.id")->where("klinik_terapi.id",$id)->first();
		$var['list_hewan'] = Klinik::where('pemilik_id',$var['curr_klinik']->pemilik_id)->get();
		$var['view_data'] = Auth::user()->view_data;
		$var['new_klinik_id'] = $id;
		
		//echo $var['curr_pemilik'];
		//exit;
		

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }

        return view('modul.klinik.klinik-pendaftaran', compact('var','url'));
	}
	public function add_pemeriksaan(Request $request, $id, $from_url){
		if(!Auth::user()->hasPermissionTo('Create Klinik')) return view('errors.403');
		$url = $request->route()->getActionMethod();
		
		//var_dump($_SESSION['klinikTerapi']);
		$var['from_url'] = $from_url;
        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;
		$var['listDetailklinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::all(['nama','ktp','id']);
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::where("klinik",1)->pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();
        $var['noPeriksa'] = 1;
		$var['tanggal_now'] = date('d-m-Y');
		$var['hewan'] = [];
        $var['penanganan'] = [1=>'Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
		$var['helper'] = new KlinikHelper();
		$var['curr_klinik'] = KlinikTerapi::select("klinik_terapi.*","klinik.nama_hewan","klinik.spesies_id","klinik.jenis_kelamin","pemilik.nama as nama_pemilik","pemilik.alamat as alamat_pemilik","pemilik.ktp as ktp_pemilik","pemilik.telepon as telepon_pemilik")->join("klinik","klinik_terapi.klinik_id","klinik.id")->join("pemilik","klinik.pemilik_id","pemilik.id")->where("klinik_terapi.id",$id)->first();
		$var['riwayat'] = KlinikTerapi::select("klinik_terapi.*","pemeriksa.nama as nmpemeriksa")->where("klinik_id",$var['curr_klinik']->klinik_id)->join('pemeriksa','klinik_terapi.pemeriksa','=','pemeriksa.id')->where("status",3)->get();
		$diagnosa = array();
		$dosis = array();
		foreach($var['riwayat'] as $dat){
			//echo $dat->id;
            $diagnosa[$dat->id] = Penyakit::select('id','penyakit')->where('id',$dat->diagnosa)->first();
			$dosis[$dat->id] = KlinikDosis::where('klinik_id',$dat->id)->join('obat','obat.id','=','klinik_dosis.terapi_id')->select('klinik_dosis.*','obat.id','obat.obat')->get();
        }
		
		$var['jml_klinik_dosis'] = 1;
		$klinikDosis = KlinikDosis::where("klinik_id",$id);
		//echo $id;
		//echo $klinikDosis->toSql();
		//exit;
		if($klinikDosis->count()>0){
			//echo "ada";
			//exit;
			$var['jml_klinik_dosis'] = $klinikDosis->count()+1;
			$var['klinik_dosis'] = $klinikDosis->get();
		}
		//echo $var['curr_pemilik'];
		//exit;

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }
		$var['view_data'] = Auth::user()->view_data;
        return view('modul.klinik.klinik-pemeriksaan2', compact('var','url','diagnosa','dosis'));
	}
	public function add_pembayaran(Request $request, $id, $from_url){
		if(!Auth::user()->hasPermissionTo('Create Klinik')) return view('errors.403');
		$url = $request->route()->getActionMethod();
		
		//var_dump($_SESSION['klinikTerapi']);
		$var['from_url'] = $from_url;
        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;
		$var['listDetailklinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::all(['nama','ktp','id']);
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();
        $var['noPeriksa'] = 1;
		$var['pembayaran'] = Pembayaran::where("klinik_terapi_id",$id);
		if($var['pembayaran']->count() > 0){
			$pembayaran_id = $var['pembayaran']->first()->id;
			$var['layan'] = LayananPembayaran::all()->where("pembayaran_id",$pembayaran_id);
			//$var['pembayaran'] = $var['pembayaran']->first();
			$var['detail_pembayaran'] = DetailPembayaran::where("pembayaran_id",$pembayaran_id)->get();
		}

		$var['tanggal_now'] = date('d-m-Y');
		$var['hewan'] = [];
        $var['penanganan'] = [1=>'Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
		$var['pelayanan'] = Layanan::all();
		$var['helper'] = new KlinikHelper();
		$var['curr_klinik'] = KlinikTerapi::select("klinik_terapi.*","klinik.nama_hewan","klinik.spesies_id","klinik.jenis_kelamin","klinik.umur","pemilik.nama as nama_pemilik","pemilik.alamat as alamat_pemilik","pemilik.ktp as ktp_pemilik","pemilik.telepon as telepon_pemilik","penyakit.penyakit")->join("klinik","klinik_terapi.klinik_id","klinik.id")->join("penyakit","klinik_terapi.diagnosa","penyakit.id")->join("pemilik","klinik.pemilik_id","pemilik.id")->where("klinik_terapi.id",$id)->first();
		$var['klinik_dosis'] = "";
		$var['jml_klinik_dosis'] = 1;
		$klinikDosis = KlinikDosis::where("klinik_id",$id);
		if($klinikDosis->count()>0){
			//echo "ada";
			//exit;
			$var['jml_klinik_dosis'] = $klinikDosis->count()+1;
			$var['klinik_dosis'] = $klinikDosis->get();
		}
		//echo $var['curr_pemilik'];
		//exit;

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }
		$var['view_data'] = Auth::user()->view_data;
        return view('modul.klinik.klinik-pembayaran', compact('var','url'));
	}
	public function edit_pembayaran(Request $request, $id, $from_url){
		if(!Auth::user()->hasPermissionTo('Create Klinik')) return view('errors.403');
		$url = $request->route()->getActionMethod();
		
		//var_dump($_SESSION['klinikTerapi']);
		$var['from_url'] = $from_url;
        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;
		$var['listDetailklinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::all(['nama','ktp','id']);
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();
        $var['noPeriksa'] = 1;

		$var['tanggal_now'] = date('d-m-Y');
		$var['hewan'] = [];
        $var['penanganan'] = [1=>'Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
		$var['pelayanan'] = Layanan::all();
		$var['helper'] = new KlinikHelper();
		$var['curr_klinik'] = KlinikTerapi::select("klinik_terapi.*","klinik.nama_hewan","klinik.spesies_id","klinik.jenis_kelamin","klinik.umur","pemilik.nama as nama_pemilik","pemilik.alamat as alamat_pemilik","pemilik.ktp as ktp_pemilik","pemilik.telepon as telepon_pemilik","penyakit.penyakit")->join("klinik","klinik_terapi.klinik_id","klinik.id")->join("penyakit","klinik_terapi.diagnosa","penyakit.id")->join("pemilik","klinik.pemilik_id","pemilik.id")->where("klinik_terapi.id",$id)->first();
		$var['klinik_dosis'] = "";
		$var['jml_klinik_dosis'] = 1;
		$klinikDosis = KlinikDosis::where("klinik_id",$id);
		if($klinikDosis->count()>0){
			//echo "ada";
			//exit;
			$var['jml_klinik_dosis'] = $klinikDosis->count()+1;
			$var['klinik_dosis'] = $klinikDosis->get();
		}
		//echo $var['curr_pemilik'];
		//exit;

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }
		$var['view_data'] = Auth::user()->view_data;
        return view('modul.klinik.klinik-pembayaran', compact('var','url'));
	}
	public function pendaftaran_pasien(Request $request,$id){
        if(!Auth::user()->hasPermissionTo('Create Klinik')) return view('errors.403');
		
		$url = $request->route()->getActionMethod();
		//var_dump($_SESSION['klinikTerapi']);
        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;
		$var['listDetailklinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::all(['nama','ktp','id']);
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();
        $var['noPeriksa'] = 1;
		$var['tanggal_now'] = date('d-m-Y');
		$var['hewan'] = [];
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
		
		$var['curr_klinik'] = Klinik::select("klinik.*","pemilik.nama as nama_pemilik","pemilik.alamat as alamat_pemilik","pemilik.ktp as ktp_pemilik","pemilik.telepon as telepon_pemilik")->join("pemilik","klinik.pemilik_id","pemilik.id")->find($id);
		$var['list_hewan'] = Klinik::where('pemilik_id',$var['curr_klinik']->pemilik_id)->get();
		$var['new_klinik_id'] = $id;
		
		//echo $var['curr_pemilik'];
		//exit;
		

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }
		$var['view_data'] = Auth::user()->view_data;
        return view('modul.klinik.klinik-pendaftaran', compact('var','url'));
    }
	
	public function cetak(Request $request,$id){
        if(!Auth::user()->hasPermissionTo('Create Klinik')) return view('errors.403');
		$url = $request->route()->getActionMethod();
		
		//var_dump($_SESSION['klinikTerapi']);
        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;
		$var['listDetailklinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::all(['nama','ktp','id']);
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();
        $var['noPeriksa'] = 1;
		$var['pembayaran'] = Pembayaran::where("klinik_terapi_id",$id);
		if($var['pembayaran']->count() > 0){
			$pembayaran_id = $var['pembayaran']->first()->id;
			$var['layan'] = LayananPembayaran::all()->where("pembayaran_id",$pembayaran_id);			
		}
		$var['jumlah_uang'] = Pembayaran::where("klinik_terapi_id",$id)->first()->total;
		$var['tanggal_now'] = date('d-m-Y');
		$var['hewan'] = [];
        $var['penanganan'] = [1=>'Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
		$var['pelayanan'] = Layanan::all();
		$var['helper'] = new KlinikHelper();
		$var['curr_klinik'] = KlinikTerapi::select("klinik_terapi.*","pembayaran.no_kwitansi","klinik.nama_hewan","klinik.spesies_id","klinik.jenis_kelamin","klinik.umur","pemilik.nama as nama_pemilik","pemilik.alamat as alamat_pemilik","pemilik.ktp as ktp_pemilik","pemilik.telepon as telepon_pemilik","penyakit.penyakit")->join("klinik","klinik_terapi.klinik_id","klinik.id")->join("pembayaran","klinik_terapi.id","pembayaran.klinik_terapi_id")->join("penyakit","klinik_terapi.diagnosa","penyakit.id")->join("pemilik","klinik.pemilik_id","pemilik.id")->where("klinik_terapi.id",$id)->first();
		$sub_id = Auth::user()->sub_satuan_kerja_id;
		$dataklinik = SubSatuanKerja::where('id','=',$sub_id)->first();	
		$var['klinik_dosis'] = "";
		$var['jml_klinik_dosis'] = 1;
		$klinikDosis = KlinikDosis::where("klinik_id",$id);
		if($klinikDosis->count()>0){
			//echo "ada";
			//exit;
			$var['jml_klinik_dosis'] = $klinikDosis->count()+1;
			$var['klinik_dosis'] = $klinikDosis->get();
		}
		//echo $var['curr_pemilik'];
		//exit;

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }
		$var['view_data'] = Auth::user()->view_data;
        return view('modul.klinik.klinik-pembayaran2', compact('var','url','dataklinik'));
    }
	
	
	
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        $view_data = Auth::user()->view_data;
		if($view_data == 5){
			//echo "masuk sini";
			$percobaan = new Percobaan();
			$percobaan->id_user = Auth::user()->id;
			$percobaan->action = "Simpan Klinik Lama";
			if($percobaan->save()){
				Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				return redirect('klinik/create');
			}
		}else{   
			$input = $request->all();
			$klinik = Klinik::create($input);

			//$listDataTerapi = (!empty($_SESSION['klinikTerapi'])?$_SESSION['klinikTerapi']:[]);
			$tindakan = $request->tindakan;
			$terapi_id = $request->terapi_id;
			$dosis = $request->dosis;
			foreach($tindakan as $key=>$item){
				$klinikTerapi = new KlinikDosis();
				$klinikTerapi->terapi_id = $terapi_id[$key];
				$klinikTerapi->dosis = $dosis[$key];
				$klinikTerapi->input_by = $klinik->input_by;
				$klinikTerapi->tindakan = $item;
				$klinik->klinikDosis()->save($klinikTerapi);
			}
			
			$terapi = new KlinikTerapi();
			foreach($tindakan as $key=>$item){
				$terapi->terapi_id = $terapi_id[$key];
				$terapi->pemeriksa = $request->pemeriksa;
				$paramedis = $request->paramedis;
				if(empty($paramedis)){
					$paramedis = "-";
				}else{
					$paramedis = $request->paramedis;
				}
				$terapi->paramedis = $paramedis;
				$terapi->tanggal_periksa = $request->tanggal_periksa;
				$terapi->signalement = $request->signalement;
				$terapi->anamnesia = $request->anamnesia;
				$terapi->diagnosa = $request->diagnosa;
				$terapi->keterangan = $request->keterangan;
				$terapi->tindakan = $item;          
				
				$klinik->klinikTerapi()->save($terapi);
			}
			
			//unset($_SESSION['klinikTerapi']);

			//DB::commit();
			Session::flash('pesanSukses', 'Data Klinik Berhasil Disimpan');

			return redirect('klinik/create');
		}
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $var['url'] = $this->url;
        $var['method'] = 'show';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();

        $listKlinik = KLinik::find($id);

        return view('modul.klinik.klinik-2', compact('listKlinik', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Klinik')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;

        $var['pemeriksa'] = [];
        $var['penanganan'] = [];
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();

        $listKlinik = Klinik::find($id);
		$var['view_data'] = Auth::user()->view_data;
        return view('modul.klinik.klinik-2', compact('listKlinik', 'var'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $var['url'] = $this->url;
		$view_data = Auth::user()->view_data;
		if($view_data == 5){
			//echo "masuk sini";
			$percobaan = new Percobaan();
			$percobaan->id_user = Auth::user()->id;
			$percobaan->action = "Update Klinik Lama";
			if($percobaan->save()){
				Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				return redirect('klinik'.$var['url']['all']);
			}
		}else{
			try {
				DB::beginTransaction();
				$input = $request->all();
				$klinik = KLinik::find($id);
				$klinik->update($input);

				$deleteKlinikDosis = KlinikDosis::where('klinik_id', $id)->delete();
				$listDataTerapi = (!empty($_SESSION['klinikTerapi'])?$_SESSION['klinikTerapi']:[]);
				foreach($listDataTerapi as $item){
					$klinikTerapi = new KlinikDosis();
					$klinikTerapi->terapi_id = $item['terapi'];
					$klinikTerapi->dosis = $item['dosis'];
					$klinikTerapi->input_by = $klinik->input_by;
					$klinikTerapi->tindakan = $request->tindakan;
					$klinik->klinikDosis()->save($klinikTerapi);
				}

				$delKlinikTerapi = KlinikTerapi::where('klinik_id',$id)->delete();
				$terapi = new KlinikTerapi();
				$terapi->pemeriksa = $request->pemeriksa;
				$terapi->tanggal_periksa = $request->tanggal_periksa;
				$terapi->signalement = $request->signalement;
				$terapi->anamnesia = $request->anamnesia;
				$terapi->diagnosa = $request->diagnosa;
				$terapi->keterangan = $request->keterangan;
				$terapi->tindakan = $request->tindakan;            
				$klinik->klinikTerapi()->save($terapi);
				unset($_SESSION['klinikTerapi']);

				DB::commit();
				Session::flash('pesanSukses', 'Data Klinik Berhasil Diupdate');
			} catch (\Exception $e) {
				DB::rollback();
				Session::flash('pesanError', 'Data Klinik Gagal Diupdate');
			}

			return redirect('klinik'.$var['url']['all']);
		}
    }
	
	public function simpan_pendaftaran(Request $request){
		$var['url'] = $this->url;
		$view_data = Auth::user()->view_data;
		if($view_data == 5){
			echo "masuk sini";
			$percobaan = new Percobaan();
			$percobaan->id_user = Auth::user()->id;
			$percobaan->action = "Tambah Pendaftaran";
			if($percobaan->save()){
				Session::flash('pesanError', 'Maaf user yang ada masukan tidak dapat menambahkan data');
				return redirect('klinik/pendaftaran'.$var['url']['all']);
			}
		}else{
			$input = $request->all();
			$klinik = Klinik::where("no_pasien",$request->no_pasien);
			if($klinik->count() > 0){
				$hasil = $klinik->first();
				$model_klinik = Klinik::find($hasil->id);
				//$model_klinik->
				//$model_klinik->update($input);
				//echo "ketemu";
				$klinikTerapi = new KlinikTerapi();
				$klinikTerapi->no_pasien = $request->no_pasien;
				$klinikTerapi->klinik_id = $hasil->id;
				$klinikTerapi->tanggal_periksa = $request->tanggal_periksa;
				$klinikTerapi->keluhan = $request->keluhan;
				$klinikTerapi->pemeriksa = $request->pemeriksa;
				$klinikTerapi->umur = $request->umur;
				$klinikTerapi->jam_pendaftaran = date("H:i:s");
				
				$klinikTerapi->status = 1;
				if($klinikTerapi->save()){
					Session::flash('pesanSukses', 'Data Klinik Berhasil Ditambahkan');
					echo "berhasil masuk";
					//return redirect('klinik'.$var['url']['all']);
				}else{
					Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
					echo "gagal masuk";
					//return redirect('klinik'.$var['url']['all']);
				}
			}else{
				//Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				if(!empty($request->no_pasien)){
					$klinik = new Klinik();
					$klinik->no_pasien = $request->no_pasien;
					$klinik->pemilik_id = $request->pemilik_id;
					$klinik->nama_hewan = $request->hewan_baru;
					$klinik->spesies_id = $request->spesies_id;
					$klinik->jenis_kelamin = $request->jenis_kelamin;
					$klinik->input_by = Auth::user()->id;
					$klinik->sub_satuan_kerja_id = Auth::user()->sub_satuan_kerja_id;
					if($klinik->save()){
						$model_klinik = Klinik::find($klinik->id);
						//$model_klinik->
						//$model_klinik->update($input);
						//echo "ketemu";
						$klinikTerapi = new KlinikTerapi();
						$klinikTerapi->no_pasien = $request->no_pasien;
						$klinikTerapi->klinik_id = $klinik->id;
						$klinikTerapi->tanggal_periksa = $request->tanggal_periksa;
						$klinikTerapi->keterangan = $request->keterangan;
						$klinikTerapi->pemeriksa = $request->pemeriksa;
						$klinikTerapi->jam_pendaftaran = date("H:i:s");
						$klinikTerapi->status = 1;
						if($klinikTerapi->save()){
							Session::flash('pesanSukses', 'Data Klinik Berhasil Ditambahkan');
							echo "klinik gagal masuk";
							//return redirect('klinik'.$var['url']['all']);
						}else{
						    echo "klinik gagal masuk";
							Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
							//return redirect('klinik'.$var['url']['all']);
						}
					}
				}else{
				    echo "klinik gagal masuk 2";
					Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				}
				
				
			}
			return redirect('klinik/pendaftaran'.$var['url']['all']);
			/* try {
				DB::beginTransaction();
				$input = $request->all();
				$klinik = KLinik::find($id);
				$klinik->update($input);

				$deleteKlinikDosis = KlinikDosis::where('klinik_id', $id)->delete();
				$listDataTerapi = (!empty($_SESSION['klinikTerapi'])?$_SESSION['klinikTerapi']:[]);
				foreach($listDataTerapi as $item){
					$klinikTerapi = new KlinikDosis();
					$klinikTerapi->terapi_id = $item['terapi'];
					$klinikTerapi->dosis = $item['dosis'];
					$klinikTerapi->input_by = $klinik->input_by;
					$klinikTerapi->tindakan = $request->tindakan;
					$klinik->klinikDosis()->save($klinikTerapi);
				}

				$delKlinikTerapi = KlinikTerapi::where('klinik_id',$id)->delete();
				$terapi = new KlinikTerapi();
				$terapi->pemeriksa = $request->pemeriksa;
				$terapi->tanggal_periksa = $request->tanggal_periksa;
				$terapi->signalement = $request->signalement;
				$terapi->anamnesia = $request->anamnesia;
				$terapi->diagnosa = $request->diagnosa;
				$terapi->keterangan = $request->keterangan;
				$terapi->tindakan = $request->tindakan;            
				$klinik->klinikTerapi()->save($terapi);
				unset($_SESSION['klinikTerapi']);

				DB::commit();
				Session::flash('pesanSukses', 'Data Klinik Berhasil Diupdate');
			} catch (\Exception $e) {
				DB::rollback();
				Session::flash('pesanError', 'Data Klinik Gagal Diupdate');
			} */

			//return redirect('klinik'.$var['url']['all']);
		}
	}
	public function update_pendaftaran(Request $request){
		$var['url'] = $this->url;
		$view_data = Auth::user()->view_data;
		if($view_data == 5){
			//echo "masuk sini";
			$percobaan = new Percobaan();
			$percobaan->id_user = Auth::user()->id;
			$percobaan->action = "Update Pendaftaran";
			if($percobaan->save()){
				Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				return redirect('klinik/pendaftaran'.$var['url']['all']);
			}
		}else{
			$input = $request->all();
			$klinik = Klinik::where("no_pasien",$request->no_pasien);
			echo $request->no_pasien;
			if($klinik->count() > 0){
				$hasil = $klinik->first();
				$model_klinik = Klinik::find($hasil->id);
				//echo $request->tanggal_periksa;
				//$model_klinik->
				//$model_klinik->update($input);
				//echo "ketemu";
				$klinikTerapi = KlinikTerapi::find($request->id_klinik_terapi);
			echo $request->id_klinik_terapi;
			$klinikTerapi->no_pasien = $request->no_pasien;
			//$klinikTerapi->klinik_id = $request->hewan;
			$klinikTerapi->tanggal_periksa = $request->tanggal_periksa;
			$klinikTerapi->keterangan = $request->keterangan;
			$klinikTerapi->pemeriksa = $request->pemeriksa;
			$klinikTerapi->umur = $request->umur;
				$klinikTerapi->jam_pendaftaran = date("H:i:s");
				//$klinikTerapi->status = 1;
				if($klinikTerapi->save()){
					Session::flash('pesanSukses', 'Data Klinik Berhasil Diupdate');
					//return redirect('klinik'.$var['url']['all']);
				}else{
					Session::flash('pesanError', 'Data Klinik Gagal Diupdate');
					//return redirect('klinik'.$var['url']['all']);
				}
			}else{
				Session::flash('pesanError', 'Data Klinik Gagal Diupdate');
				
			}
			//return redirect('klinik/pendaftaran'.$var['url']['all']);
			$url = $request->from_url;
			if($url == "awal")
				return redirect('klinik/pendaftaran'.$var['url']['all']);
			else
				return redirect('klinik/detailPeriksa/' . $request->hewan);
			
        }
	}
	public function simpan_pemeriksaan(Request $request){
		$view_data = Auth::user()->view_data;
		if($view_data == 5){
			//echo "masuk sini";
			$percobaan = new Percobaan();
			$percobaan->id_user = Auth::user()->id;
			$percobaan->action = "Simpan Pemeriksaan";
			if($percobaan->save()){
				Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				return redirect('klinik/pemeriksaan');
			}
		}else{
			$tindakan_id = $request->tindakan_id;
			$terapi_id = $request->terapi_id;
			$dosis = $request->dosis;
			$diagnosa = $request->diagnosa;
			$klinik_terapi_id = $request->id;
			//echo $klinik_terapi_id;
			//exit;
			$klinikTerapi = KlinikTerapi::find($klinik_terapi_id);
			$klinikTerapi->keterangan = $request->keterangan;
			$klinikTerapi->anamnesia = $request->anamnesia;
			$klinikTerapi->signalement = $request->signalement;
			$klinikTerapi->paramedis = $request->paramedis;
			$klinikTerapi->diagnosa = $diagnosa;
			$klinikTerapi->jam_pemeriksaan = date("H:i:s");
			$from_url = $request->from_url;
			if($from_url == "awal")
				$klinikTerapi->status = 2;
			$klinikTerapi->save();
			$berhasil = 0;
			$klinikDosis = KlinikDosis::where('klinik_id', $klinik_terapi_id)->delete();
			foreach($tindakan_id as $key=>$value){
				$klinikDosis = new KlinikDosis();
				$klinikDosis->klinik_id = $klinik_terapi_id;
				$klinikDosis->terapi_id = $terapi_id[$key];
				$klinikDosis->tindakan = $value;
				$klinikDosis->dosis = $dosis[$key];
				//$klinikDosis->inputBy
				$berhasil = $klinikDosis->save();
			}
			if($berhasil){
				if($from_url == "awal")
					return redirect('klinik/pemeriksaan');
				else
					return redirect('klinik/detailPeriksa/' . $request->hewan);
			}else{
				return redirect('klinik/add_pemeriksaan/'. $klinik_terapi_id);
			}
			
			print_r($tindakan_id);
		}
	}
	public function simpan_pembayaran(Request $request){
		$view_data = Auth::user()->view_data;
		if($view_data == 5){
			//echo "masuk sini";
			$percobaan = new Percobaan();
			$percobaan->id_user = Auth::user()->id;
			$percobaan->action = "Simpan Pembayaran";
			if($percobaan->save()){
				Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				return redirect('klinik/pembayaran');
			}
		}else{
			$kegiatan = $request->kegiatan;
			$klinik_terapi_id = $request->klinik_terapi_id;
			$cek_pembayaran = Pembayaran::where("klinik_terapi_id",$request->klinik_terapi_id);
			if($cek_pembayaran->count() == 0){
			
			
				$pembayaran = new Pembayaran();
				$pembayaran->klinik_terapi_id = $klinik_terapi_id;
				$pembayaran->total = $request->total;
				if($kegiatan == 2){
					$pembayaran->total = 0;
				}
				$pembayaran->tanggal = date('Y-m-d H:i:s');
				$pembayaran->no_kwitansi = $request->no_kwitansi;
				$pembayaran->save();
				
				$tindakan = $request->tindakan_id;
				
				foreach($tindakan as $key=>$value){
					$detailPembayaran = new DetailPembayaran();
					$detailPembayaran->pembayaran_id = $pembayaran->id;
					$detailPembayaran->tindakan = $value;
					$detailPembayaran->terapi_id = $request->terapi_id[$key];
					$detailPembayaran->tarif = $request->tarif[$key];
					if($kegiatan == 2){
						$detailPembayaran->tarif = 0;
					}
					$detailPembayaran->spesies_id = $request->spesies_id[$key];
					$detailPembayaran->save();
				}
				
				if(!empty($request->nama_layanan)){
					$nama_layanan = $request->nama_layanan;
					foreach($nama_layanan as $key=>$value){
						$layanan = new LayananPembayaran();
						$layanan->pembayaran_id = $pembayaran->id;
						$layanan->nama_layanan = $value;
						$layanan->tarif = $request->tarif_layanan[$key];
						$layanan->save();
					}
				}
			}else{
				$pembayaran = Pembayaran::find($cek_pembayaran->first()->id);
				$pembayaran->klinik_terapi_id = $klinik_terapi_id;
				$pembayaran->total = $request->total;
				if($kegiatan == 2){
					$pembayaran->total = 0;
				}
				$pembayaran->tanggal = date('Y-m-d H:i:s');
				$pembayaran->no_kwitansi = $request->no_kwitansi;
				$pembayaran->save();
				
				
				$hapusDetail1 = DetailPembayaran::where('pembayaran_id', $pembayaran->id)->delete();
				$tindakan = $request->tindakan_id;
				
				
				
				foreach($tindakan as $key=>$value){
					$detailPembayaran = new DetailPembayaran();
					$detailPembayaran->pembayaran_id = $pembayaran->id;
					$detailPembayaran->tindakan = $value;
					$detailPembayaran->terapi_id = $request->terapi_id[$key];
					$detailPembayaran->tarif = $request->tarif[$key];
					if($kegiatan == 2){
						$detailPembayaran->tarif = 0;
					}
					$detailPembayaran->spesies_id = $request->spesies_id[$key];
					$detailPembayaran->save();
				}
				
				if(!empty($request->nama_layanan)){
					$hapusDetail2 = LayananPembayaran::where('pembayaran_id', $pembayaran->id)->delete();
					$nama_layanan = $request->nama_layanan;
					foreach($nama_layanan as $key=>$value){
						$layanan = new LayananPembayaran();
						$layanan->pembayaran_id = $pembayaran->id;
						$layanan->nama_layanan = $value;
						$layanan->tarif = $request->tarif_layanan[$key];
						$layanan->save();
					}
				}
				
				
				
			}
			
			$klinikTerapi = KlinikTerapi::find($klinik_terapi_id);
			$klinikTerapi->jam_pembayaran = date("H:i:s");
			$klinikTerapi->kegiatan = $kegiatan;
			//$klinikTerapi->diagnosa = $diagnosa;
			$from_url = $request->from_url;
			if($from_url == "awal")
				$klinikTerapi->status = 3;
			
			if($klinikTerapi->save()){
				if($from_url == "awal")
					return redirect('klinik/pembayaran');
				else
					return redirect('klinik/detailPeriksa/' . $request->hewan);
			}else{
				return redirect('klinik/add_pembayaran/'. $klinik_terapi_id);
			}
		}
	}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
	public function hapus_pendaftaran(Request $request){
		$view_data = Auth::user()->view_data;
		if($view_data == 5){
			//echo "masuk sini";
			$percobaan = new Percobaan();
			$percobaan->id_user = Auth::user()->id;
			$percobaan->action = "Hapus Pendaftaran";
			if($percobaan->save()){
				Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				return redirect('klinik/pendaftaran');
			}
		}else{
			$id = $request->id;
			$klinikTerapi = KlinikTerapi::where('id',$id)->delete();
			if($klinikTerapi){
				Session::flash('pesanSukses', 'Data Klinik Berhasil Dihapus');
			}else{
				Session::flash('pesanError', 'Data Klinik Gagal Dihapus');
			}
			return redirect('klinik/pendaftaran');
		}
	}
    public function destroy($id, Request $request)
    {
        $var['url'] = $this->url;
		$view_data = Auth::user()->view_data;
		if($view_data == 5){
			//echo "masuk sini";
			$percobaan = new Percobaan();
			$percobaan->id_user = Auth::user()->id;
			$percobaan->action = "Hapus Data Klinik";
			if($percobaan->save()){
				Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				return redirect('klinik/rekap'.$var['url']['all']);
			}
		}else{
			try {
				DB::beginTransaction();
				$klinikDosis = KlinikDosis::where('klinik_id', $id)->delete();
				$klinikTerapi = KlinikTerapi::where('id',$id)->delete();
				//$klinik = Klinik::find($id);
				//$klinik->delete();

				if($request->nomor == 1){
					$input = $request->query();
					$input['page'] = 1;
					$var['url'] = makeUrl($input);
				}

				DB::commit();
				Session::flash('pesanSukses', 'Data Klinik Berhasil Dihapus');
			} catch (\Exception $e) {
				DB::rollback();
				Session::flash('pesanError', 'Data Klinik Gagal Dihapus');
			}

			return redirect('klinik/rekap'.$var['url']['all']);
		}
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'no_pasien'){
            $kriteria = $request->no_pasien;
        }

        if($request->aksi == 'create'){
            $jumlah = Klinik::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Klinik::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Klinik::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

                if($jumlah2 == 1){
                   return response()->json(true);
                }else{
                    return response()->json(false);
                }
            }else{
                return response()->json(true);
            }
        }
    }

    public function getKlinik(Request $request)
    {
        $var['userId'] = $request->userId;
        $user = User::find($var['userId']);
        $subSatuanKerja = SubSatuanKerja::find($user['sub_satuan_kerja_id']);
        return response()->json($subSatuanKerja);
    }

    public function getPemilik(Request $request)
    {
        $var['pemilikId'] = $request->pemilikId;
        $pemilik = Pemilik::find($var['pemilikId']);
        $jml = Klinik::where('pemilik_id','=',$var['pemilikId'])->count();
        $jml = $jml+1;
        if($jml < 10){
            $jml = '0'.$jml;
        }
        $cek = array();
        $has = array('jml'=>$jml);
        $cek[0] = $jml;
        $cek[1] = $pemilik;
        return response()->json($cek);
    }

    public function formAreaRas(Request $request)
    {
        $var['spesiesId'] = $request->spesiesId;
        $var['rasId'] = $request->rasId;
        $listRas = Ras::where('spesies_id', $var['spesiesId'])->pluck('nama_ras', 'id')->all();
        return view('modul.klinik.form-ras', compact('var', 'listRas'));
    }

    public function getHewan(Request $request)
    {
        $var['pemilikId'] = $request->pemilikId;
        //$listHewan = Klinik::where('pemilik_id', $var['pemilikId'])->pluck('nama_hewan', 'id')->all();
		$listHewan = Klinik::where('pemilik_id',$var['pemilikId'])->get();
        return view('modul.klinik.form-hewan', compact('var', 'listHewan'));
    }

    public function getDetailHewan(Request $request){
        $var['klinik_id'] = $request->klinikId;
        $det = Klinik::where('klinik.id','=',$var['klinik_id'])->join('spesies','klinik.spesies_id','=','spesies.id')->select('klinik.*','spesies.nama_spesies')->first();

        $arr = array();
        //$arr[0] = $det->nama_ras;
        $arr[1] = $det->nama_spesies;
        $arr[2] = $det->spesies_id;
        $arr[3] = $det->jenis_kelamin;
        $arr[4] = $det->umur;
		$arr[5] = $det->no_pasien;

        return response()->json($arr);
    }

    public function formAreaObat(Request $request)
    {
        $listObat = $var['obat'] = Obat::where("klinik",1)->pluck('obat','id')->all();;
        return view('modul.klinik.form-obat', compact('var', 'listObat'));
    }
	public function formAreaVaksin(Request $request)
    {
        $listObat = $var['obat'] = Obat::where("klinik",2)->pluck('obat','id')->all();;
        return view('modul.klinik.form-obat', compact('var', 'listObat'));
    }

    public function formAreaOperasi(Request $request)
    {
        $listOperasi = $var['operasi'] = Operasi::pluck('tindakan','id')->all();
        return view('modul.klinik.form-operasi', compact('var', 'listOperasi'));
    }

    public function getNoRm(Request $request){
        $noid = $request->no;
        $has = Klinik::where('id',$noid)->first();

        $arr = ['norm' => $has['no_pasien']];

        return response()->json($arr);
    }

    public function cetakKartu($id)
    {
        $klinik = Klinik::find($id);
        $pdf = PDF::loadView('modul.klinik.kartu-pasien', compact('klinik'))->setPaper([0,0,610,936], 'potrait');
        return $pdf->stream('kartu-pasien.pdf');
    }

    public function tambahDataTerapi(Request $request)
    {
        if($request->penanganan == 0 or $request->penanganan == 1 or $request->penanganan == 2  ){
            $obat = Obat::find($request->terapi);
            $_SESSION['klinikTerapi'][] = ['terapi' => $request->terapi, 'namaTerapi' => @$obat->obat, 'dosis'=> $request->dosis,'tindakan' => $request->tindakan];
        }else if($request->penanganan == 4){
            $obat = Operasi::find($request->terapi);
            $_SESSION['klinikTerapi'][] = ['terapi' => $request->terapi, 'namaTerapi' => @$obat->tindakan, 'dosis'=> $request->dosis,'tindakan' => $request->tindakan];
        }
        

        
        $listTerapi = $_SESSION['klinikTerapi'];    
        return response()->json($listTerapi);
    }

    public function getDataTerapi(Request $request)
    {
        $method = $request->method;
        if($request->method == 'edit'){
            unset($_SESSION['klinikTerapi']);
            $listDataTerapi = KLinikDosis::where('klinik_id', $request->id)->get();
            foreach($listDataTerapi as $item) {
                $_SESSION['klinikTerapi'][] = ['terapi' => $item->terapi_id, 'namaTerapi' => @$item->terapi->obat, 'dosis'=> $item->dosis,'tindakan' => $item->tindakan];
            }
            $listTerapi = $_SESSION['klinikTerapi'];
        }else if($request->method == 'show'){
            $listDataTerapi = KLinikDosis::where('klinik_id', $request->id)->get();
            foreach($listDataTerapi as $item) {
                $listTerapi[] = ['terapi' => $item->terapi_id,
                                    'namaTerapi' => @$item->terapi->obat,
                                    'dosis'=> $item->dosis,'tindakan' => $item->tindakan];
            }
        }else {
            $listTerapi = $_SESSION['klinikTerapi'];
        }
		
		exit;
		

        return view('modul.klinik.tabel-klinik-terapi', compact('listTerapi', 'method'));
    }

    public function getDataTerapi2(Request $request)
    {
        $method = $request->method;
        if($request->method == 'edit'){

            if($request->tindakan == 0 or $request->tindakan == 1 or $request->tindakan == 2){
                unset($_SESSION['klinikTerapi']);
            $listDataTerapi = KLinikTerapi::where('klinik_terapi.id', $request->id)->join('klinik_dosis',function ($join){
                $join->on('klinik_terapi.klinik_id','=','klinik_dosis.klinik_id');
                $join->on('klinik_terapi.created_at','=','klinik_dosis.created_at');
            })->join('obat','klinik_dosis.terapi_id','=','obat.id')->get();
            foreach($listDataTerapi as $item) {
                $_SESSION['klinikTerapi'][] = ['terapi' => $item->terapi_id, 'namaTerapi' => @$item->obat, 'dosis'=> $item->dosis,'tindakan' => $item->tindakan];
            }
            $listTerapi = $_SESSION['klinikTerapi'];
            }elseif($request->tindakan == 4){
                unset($_SESSION['klinikTerapi']);
            $listDataTerapi = KLinikTerapi::where('klinik_terapi.id', $request->id)->join('klinik_dosis',function ($join){
                $join->on('klinik_terapi.klinik_id','=','klinik_dosis.klinik_id');
                $join->on('klinik_terapi.created_at','=','klinik_dosis.created_at');
            })->join('operasi','klinik_dosis.terapi_id','=','operasi.id')->get();
            foreach($listDataTerapi as $item) {
                $_SESSION['klinikTerapi'][] = ['terapi' => $item->terapi_id, 'namaTerapi' => @$item->tindakan, 'dosis'=> $item->dosis,'tindakan' => $item->tindakan];
            }
            $listTerapi = $_SESSION['klinikTerapi'];
            }            
        }else if($request->method == 'show'){
            $listDataTerapi = KLinikTerapi::where('id', $request->id)->get();
            foreach($listDataTerapi as $item) {
                $listTerapi[] = ['terapi' => $item->terapi_id,
                                    'namaTerapi' => @$item->terapi->obat,
                                    'dosis'=> $item->dosis,'tindakan' => $item->tindakan];
            }
        }else {
            $listTerapi = $_SESSION['klinikTerapi'];
        }

        return view('modul.klinik.tabel-klinik-terapi', compact('listTerapi', 'method'));
    }

    function getJmlperiksa(Request $request){
        $klinikId = $request->klinikId;
        $jml = KlinikTerapi::where('klinik_id','=',$klinikId)->count();
        $jml = $jml+1;

        return response()->json($jml);
    }

    public function hapusDataTerapi(Request $request)
    {
        $method = "edit";
        array_splice($_SESSION['klinikTerapi'], $request->id,1);
        $listTerapi = $_SESSION['klinikTerapi'];

        return view('modul.klinik.tabel-klinik-terapi', compact('listTerapi', 'method'));
    }

    public function addKlinik(){
        $var['method'] =  'create';
        $var['url'] = $this->url;
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::pluck('nama','id')->all();
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['noPeriksa'] = 0;
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
        $var['hewan'] = [];
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }

        return view('modul.klinik.klinik-3', compact('var'));
    }

    public function tambahTerapi(Request $request){
        $var['url'] = $this->url;
		$id = $request->hewan;
    try {
        DB::beginTransaction();            
        $klinik = Klinik::find($id);
        $terapi = new KlinikTerapi();

        $listDataTerapi = (!empty($_SESSION['klinikTerapi'])?$_SESSION['klinikTerapi']:[]);
        foreach($listDataTerapi as $item){
            $klinikTerapi = new KlinikDosis();
            $klinikTerapi->terapi_id = $item['terapi'];
            $klinikTerapi->dosis = $item['dosis'];
            $klinikTerapi->input_by = $klinik->input_by;
			$klinikTerapi->tindakan = $request->tindakan;
            $klinik->klinikDosis()->save($klinikTerapi);
        }

        foreach($listDataTerapi as $item){
        $terapi->terapi_id = $item['terapi'];
	$terapi->pemeriksa = $request->pemeriksa;
	$terapi->paramedis = $request->paramedis;
	$terapi->tanggal_periksa = $request->tanggal_periksa;
	$terapi->signalement = $request->signalement;
	$terapi->anamnesia = $request->anamnesia;
	$terapi->diagnosa = $request->diagnosa;
	$terapi->keterangan = $request->keterangan;
	$terapi->tindakan = $request->tindakan;
        $klinik->klinikTerapi()->save($terapi);
        }
        unset($_SESSION['klinikTerapi']);

            DB::commit();
            Session::flash('pesanSukses', 'Data Klinik Berhasil Ditambah');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Klinik Gagal Ditambah');
        }

        return redirect('klinik'.$var['url']['all']);
    }

    public function detailPeriksa($id){
        $var['url'] = $this->url;
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
        $var['obat'] = Obat::pluck('obat','id')->all();
		$var['helper'] = new KlinikHelper();
        $listKlinik = Klinik::find($id);
        $var['penyakit'] = Penyakit::get();
        $klinikTerapi = KlinikTerapi::where('klinik_terapi.klinik_id',$id)->where("status",3)->join('pemeriksa','klinik_terapi.pemeriksa','=','pemeriksa.id')->select('klinik_terapi.*','pemeriksa.nama AS nmpemeriksa')->get();
        
        $operasi = KlinikTerapi::where('klinik_id',$id)->join('operasi','operasi.id','=','klinik_terapi.terapi_id')->select('klinik_terapi.*','operasi.id','operasi.tindakan')->get();
        $diagnosa = array();
        //$var['helper'] = new KlinikHelper();
        foreach($klinikTerapi as $dat){
			//echo $dat->id;
            $diagnosa[$dat->id] = Penyakit::select('id','penyakit')->where('id',$dat->diagnosa)->first();
			$dosis[$dat->id] = KlinikDosis::where('klinik_id',$dat->id)->join('obat','obat.id','=','klinik_dosis.terapi_id')->select('klinik_dosis.*','obat.id','obat.obat')->get();
        }
		/* foreach($dosis as $value){
			foreach($value as $dos){
				echo $dos->obat;
			}
		}
		exit; */
		$signalment = KlinikTerapi::select('klinik_terapi.*')->where('klinik_terapi.klinik_id',$id)->limit('1')->first();
		
		
        return view('modul.klinik.detailPeriksa', compact('listKlinik','signalment','klinikTerapi','dosis','operasi','diagnosa','var'));
    }

    public function cetakRM($id){
        $listKlinik = Klinik::find($id);
        $klinikTerapi = KlinikTerapi::where('klinik_terapi.klinik_id',$id)->where("status",3)->join('pemeriksa','klinik_terapi.pemeriksa','=','pemeriksa.id')->select('klinik_terapi.*','pemeriksa.nama AS nmpemeriksa')->get();
		$var['helper'] = new KlinikHelper();
        //$dosis = KlinikDosis::where('klinik_id',$id)->join('obat','obat.id','=','klinik_dosis.terapi_id')->select('klinik_dosis.*','obat.id','obat.obat')->get();

        $operasi = KlinikDosis::where('klinik_id',$id)->join('operasi','operasi.id','=','klinik_dosis.terapi_id')->select('klinik_dosis.*','operasi.id','operasi.tindakan')->get();

        $diagnosa = array();
        
        foreach($klinikTerapi as $dat){
            $diagnosa[$dat->id] = Penyakit::select('penyakit')->where('id',$dat->diagnosa)->first();
			$dosis[$dat->id] = KlinikDosis::where('klinik_id',$dat->id)->join('obat','obat.id','=','klinik_dosis.terapi_id')->select('klinik_dosis.*','obat.id','obat.obat')->get();
        }
		$signalment = KlinikTerapi::select('klinik_terapi.*')->where('klinik_terapi.klinik_id',$id)->limit('1')->first();
		

        $nip = Auth::user()->nip;
        $sub_id = Auth::user()->sub_satuan_kerja_id;
        $dataklinik = SubSatuanKerja::where('id','=',$sub_id)->first();	

        return view('modul.klinik.cetak_rm', compact('listKlinik','klinikTerapi','dosis','operasi','dataklinik','diagnosa','signalment','var'));
    }

    public function editRM(Request $request,$id){

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;

        $var['pemeriksa'] = [];
        $var['penanganan'] = [];
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::pluck('penyakit','id')->all();

        $listKlinik = KLinik::find($id);

        return view('modul.klinik.edit_rm',compact('listKlinik','var'));
    }

    public function updateRM(Request $request,$id){
        $var['url'] = $this->url;
		$view_data = Auth::user()->view_data;
		if($view_data == 5){
			//echo "";
			$percobaan = new Percobaan();
			$percobaan->id_user = Auth::user()->id;
			$percobaan->action = "Update RM";
			if($percobaan->save()){
				Session::flash('pesanError', 'Data Klinik Gagal Ditambahkan');
				return redirect('klinik'.$var['url']['all']);
			}
		}else{
			try {
				DB::beginTransaction();
				$input = $request->all();
				$klinik = KLinik::find($id);
				$klinik->update($input);

				DB::commit();
				Session::flash('pesanSukses', 'Data Klinik Berhasil Diupdate');
			} catch (\Exception $e) {
				DB::rollback();
				Session::flash('pesanError', 'Data Klinik Gagal Diupdate');
			}

			return redirect('klinik'.$var['url']['all']);
		}
    }

    public function editPeriksa(Request $request,$terapi_id,$klinik_id){

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;

        $var['pemeriksa'] = [];
        $var['penanganan'] = [];
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['penyakit'] = Penyakit::select('penyakit','id')->all();
        $var['list'] = KlinikTerapi::where('klinik_terapi.id','=',$terapi_id)->where('klinik_id','=',$klinik_id)->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->select('klinik_terapi.*','klinik.spesies_id')->get();

        $listKlinik = KlinikTerapi::find($terapi_id);

        return view('modul.klinik.edit_periksa', compact('listKlinik', 'var'));
    }

    public function updateTransaksi(Request $request){
        KlinikTerapi::where('id',$request->id_terapi)->update(['anamnesia'=>$request->anamnesa,'diagnosa'=>$request->diagnosa,'keterangan'=>$request->ket,'paramedis'=>$request->paramedis,'tanggal_periksa'=>$request->tgl_periksa]);

        return $this->detailPeriksa($request->klinik_id);
    }

    public function updateObat(Request $request){
        $tgl = date('Y-m-d H:i:s');

        if(!empty($request->klinik_id2) and !empty($request->created)){
            KlinikDosis::where('klinik_id',$request->klinik_id2)->where('created_at',$request->created)->delete();

        $listDataTerapi = (!empty($_SESSION['klinikTerapi'])?$_SESSION['klinikTerapi']:[]);
            foreach($listDataTerapi as $item){
                KlinikDosis::insert(['klinik_id'=>$request->klinik_id2,'tindakan'=>$item['tindakan'],'terapi_id'=>$item['terapi'],'dosis'=>$item['dosis'],'input_by'=>'35','created_at'=>$request->created,'updated_at'=>$tgl]);
            }
        }        

            return $this->detailPeriksa($request->klinik_id2);
    }
    
     public function hapusRiwayat(Request $request){
		
			KlinikDosis::where('klinik_id',$request->klinik_id3)->where('created_at',$request->created2)->delete();
			KlinikTerapi::where('id',$request->id)->delete();

			return $this->detailPeriksa($request->klinik_id3);
		
    }
	public function cari_layanan(Request $request){
	$layanan = Layanan::find($request->id);
		return json_encode($layanan);
	}
	public function get_obat_aktif(){
		$dosis = KlinikDosis::where("tindakan",2)->groupBy("terapi_id")->join("obat","klinik_dosis.terapi_id","=","obat.id")->select(["klinik_dosis.*","obat.obat"])->get();
		foreach($dosis as $row){
			//echo $row->obat;
			//echo "-";
			echo $row->terapi_id;
			echo "<br />";
		}
		exit;
	}

}