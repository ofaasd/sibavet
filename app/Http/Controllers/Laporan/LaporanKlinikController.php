<?php

namespace App\Http\Controllers\Laporan;

use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterData\SubSatuanKerja;
use App\Models\MasterData\Spesies;
use App\Models\Modul\Pembayaran;
use App\Models\Modul\Klinik;
use App\Models\Modul\KlinikTerapi;
use App\Models\Modul\KlinikDosis;
use App\Models\MasterData\Operasi;
use App\Models\MasterData\Obat;
use App\Models\MasterData\Penyakit;
use App\Models\MasterData\Pemeriksa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\LaporanHelper;

class LaporanKlinikController extends Controller
{
    private $bulan = [
        '1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni',
        '7'=>'Juli', '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember',
    ];

    function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function formCetak()
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Klinik')) return view('errors.403');

        $var['listKlinik'] = [];
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['listKlinik'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listKlinik'] = SubSatuanKerja::where('satuan_kerja_id', '3')->pluck('sub_satuan_kerja','id')->all();
        }
        $var['bulan'] = $this->bulan;

        return view('laporan.klinik.form2', compact('var'));
    }
	
	public function formCetak2()
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Klinik')) return view('errors.403');

        $var['listKlinik'] = [];
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['listKlinik'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listKlinik'] = SubSatuanKerja::where('satuan_kerja_id', '3')->pluck('sub_satuan_kerja','id')->all();
        }
        $var['bulan'] = $this->bulan;

        return view('laporan.klinik.form', compact('var'));
    }
	public function formCetakDinas()
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Klinik')) return view('errors.403');

        $var['listKlinik'] = [];
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['listKlinik'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listKlinik'] = SubSatuanKerja::where('satuan_kerja_id', '3')->pluck('sub_satuan_kerja','id')->all();
        }
        $var['bulan'] = $this->bulan;

        return view('laporan.klinik.formDinas', compact('var'));
    }

    public function preview(Request $request){
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['format'] = $request->format;        
        $var['jenis'] = $request->jenis;        
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $var['subSatuanKerja'] = $subSatuanKerja;
        $kode = $subSatuanKerja->kode_klinik;
		$spesies = "";
        if($var['jenis'] == 'Vaksinasi'){
            $helper = new LaporanHelper();        
			$var['vaksin'] = Obat::get()->where("klinik",2);
			$var['jumlah_hewan'] = 0;
			$var['jumlah_vaksin'] = array();
			foreach($var['vaksin'] as $vaksin){
				$var['jumlah_vaksin'][$vaksin->id] = 0;
				$var['jumlah_vaksin'][0] = 0;
			}
			return view('laporan.klinik.preview',compact('var','subSatuanKerja', 'spesies', 'helper'));
        }elseif($var['jenis'] == 'Operasi'){
            
            $var['opr'] = Operasi::orderBy('tindakan','asc')->where("kode","OPR")->get();
			$helper = new LaporanHelper();        
			$var['jumlah_hewan'] = 0;
			$var['jumlah_operasi'] = array();
			foreach($var['opr']  as $operasi){
				$var['jumlah_operasi'][$operasi->id] = 0;
				$var['jumlah_operasi'][0] = 0;
			}
			return view('laporan.klinik.preview',compact('var','subSatuanKerja', 'spesies', 'helper'));
        }elseif($var['jenis'] == 'Penyakit' || $var['jenis'] == 'penyakit'){
            $var['jenis'] = 'Penyakit';
            $var['penyakit'] = KlinikTerapi::whereBetween('klinik_terapi.tanggal_periksa',[$var['dari_tanggal'],$var['sampai_tanggal']])->whereNotIn("diagnosa",[367])->whereNotNull("diagnosa")->select('diagnosa')->distinct()->get();
			$helper = new LaporanHelper();        

			return view('laporan.klinik.preview',compact('var','subSatuanKerja', 'spesies', 'helper'));
        }elseif($var['jenis'] == 'pad'){
           /*  $begin = new DateTime($request->dari_tanggal);
			$end = new DateTime($request->sampai_tanggal); */
			$var['begin'] = strtotime( $var['dari_tanggal'] . " 12:00" );
			$var['end']	= strtotime( $var['sampai_tanggal'] . " 12:00" );
			//$interval = DateInterval::createFromDateString('1 day');
			//$var['period'] = new DatePeriod($begin, $interval, $end);
			$helper = new LaporanHelper();        
			$total = 0;
			return view('laporan.klinik.preview2',compact('var','total','subSatuanKerja', 'spesies', 'helper'));
        }elseif($var['jenis'] == 'Harian' || $var['jenis'] == 'utama'){
                
            $var['klinik'] = KlinikTerapi::select("klinik_terapi.*","klinik.sub_satuan_kerja_id","klinik.pemilik_id","klinik.spesies_id","klinik.nama_hewan","penyakit.penyakit")->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->join('pemilik','klinik.pemilik_id','=','pemilik.id')->join("penyakit","klinik_terapi.diagnosa","penyakit.id")->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->whereBetween('klinik_terapi.tanggal_periksa',[$var['dari_tanggal'],$var['sampai_tanggal']])->orderBy("tanggal_periksa")->get();
            $var['obat'] = Obat::get()->where("klinik",1);
            $var['operasi'] = Operasi::where("kode","OPR")->orWhere("kode","MEDIVET1")->get();
			$var['vaksin'] = Obat::get()->where("klinik",2);
			$var['tarif'] = array();
			$data_obat = array();
			$jumlah = array();
			$var['cols_obat'] = 0;
			$var['cols_vaksin'] = 0;
			$var['cols_operasi'] = 0;
			foreach($var['obat'] as $obat){
				$jumlah[$obat->id] = 0;
				$var['cols_obat'] += 1;
			}
			foreach($var['vaksin'] as $vaksin){
				$jumlah[$vaksin->id] = 0;
				$var['cols_vaksin'] += 1;
			}
			foreach($var['operasi'] as $operasi){
				$jumlah_operasi[$operasi->id] = 0;
				$var['cols_operasi'] += 1;
			}
			foreach($var['klinik'] as $klinik){
				/* foreach($var['obat'] as $obat){
					$data_obat[$klinik->id][$obat->id] = 0;
				} */
				$dosis = KlinikDosis::where("klinik_id",$klinik->id)->get();
				foreach($dosis as $dos){
					if($dos->tindakan == 5 && $dos->terapi_id < 8){
						$data_obat[$klinik->id][$dos->terapi_id][$dos->tindakan] = 1;
					}else{
						$data_obat[$klinik->id][$dos->terapi_id][$dos->tindakan] = $dos->dosis;
					}
				}
				$total = Pembayaran::get()->where('klinik_terapi_id',$klinik->id)->first();
				if(empty($total)){
					$var['tarif'][$klinik->id] = 0;
				}else{
					$var['tarif'][$klinik->id] = $total->total;
				}
				
			}
			$helper = new LaporanHelper();        
		
			return view('laporan.klinik.preview2',compact('var','jumlah','jumlah_operasi','subSatuanKerja', 'spesies', 'helper','data_obat')); 
        }elseif($var['jenis'] == 'utama2'){
                
            $var['klinik'] = KlinikTerapi::select("klinik_terapi.*","klinik.sub_satuan_kerja_id","klinik.pemilik_id","klinik.spesies_id","klinik.nama_hewan","penyakit.penyakit")->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->join('pemilik','klinik.pemilik_id','=','pemilik.id')->join("penyakit","klinik_terapi.diagnosa","penyakit.id")->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->whereBetween('klinik_terapi.tanggal_periksa',[$var['dari_tanggal'],$var['sampai_tanggal']])->orderBy("tanggal_periksa")->get();
            $var['obat'] = Obat::get();
            $var['operasi'] = Operasi::get();
			$var['vaksin'] = Obat::get();
			$var['tarif'] = array();
			$data_obat = array();
			$jumlah = array();
			
			$list_obat = array();
			$list_vaksin = array();
			$list_operasi = array();
			foreach($var['obat'] as $obat){
				$list_obat[$obat->id] = $obat->obat;
			}
			foreach($var['vaksin'] as $vaksin){
				
				$list_vaksin[$vaksin->id] = $vaksin->obat;
			}
			foreach($var['operasi'] as $operasi){
				 
				$list_operasi[$operasi->id] = $operasi->tindakan;
			}
			$pemeriksa = array();
			$list_pemeriksa = Pemeriksa::get();
			foreach($list_pemeriksa as $row){
				$pemeriksa[$row->id] = $row->nama;
			}
			
			$klinik_tindakan = array();
			$terapitindakan = array();
			$tindakan = array(1=>'Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi');
			$list_penyakit = Penyakit::get();
			$penyakit = array();
			foreach($list_penyakit as $row){
				$penyakit[$row->id] = $row->penyakit;
			}
			
			
			foreach($var['klinik'] as $klinik){
				$dosis = KlinikDosis::where("klinik_id",$klinik->id)->get();
				$dosis2 = KlinikDosis::where("klinik_id",$klinik->id)->groupBy('tindakan')->get();
				$i = 0;
				foreach($dosis2 as $dos2){
					if($i == 0){
						$klinik_tindakan[$klinik->id] = $tindakan[$dos2->tindakan];
					}else{
						$klinik_tindakan[$klinik->id] .= "," . $tindakan[$dos2->tindakan];
					}
					$i++;
				}
				
				$i = 0;
				$terapi = "";
				$terapitindakan[$klinik->id] = '';
				foreach($dosis as $dos){
					
					if($i > 0){
						$terapitindakan[$klinik->id] .= ",";
						if($dos->tindakan == 1){
							$terapitindakan[$klinik->id] .= $list_vaksin[$dos->terapi_id] . "-" . $dos->dosis;
						}elseif($dos->tindakan == 2){
							$terapitindakan[$klinik->id] .= $list_obat[$dos->terapi_id] . "-" . $dos->dosis;
						}elseif($dos->tindakan == 5){
							$terapitindakan[$klinik->id] .= $list_operasi[$dos->terapi_id];
						}else{
							$terapitindakan[$klinik->id] .= $tindakan[$dos->tindakan];
						}
					}else{
						if($dos->tindakan == 1){
							$terapitindakan[$klinik->id] = $list_vaksin[$dos->terapi_id] . "-" . $dos->dosis;
						}elseif($dos->tindakan == 2){
							$terapitindakan[$klinik->id] = $list_obat[$dos->terapi_id] . "-" . $dos->dosis;
						}elseif($dos->tindakan == 5){
							$terapitindakan[$klinik->id] = $list_operasi[$dos->terapi_id];
						}else{
							$terapitindakan[$klinik->id] = $tindakan[$dos->tindakan];
						}
					}
					$i++;
				}
				
					 
				$total = Pembayaran::get()->where('klinik_terapi_id',$klinik->id)->first();
				if(empty($total)){
					$var['tarif'][$klinik->id] = 0;
					$var['kwitansi'][$klinik->id] = (!empty($total->no_kwitansi))?$total->no_kwitansi:'-';
				}else{
					$var['tarif'][$klinik->id] = $total->total;
					$var['kwitansi'][$klinik->id] = (!empty($total->no_kwitansi))?$total->no_kwitansi:'-';
				}
				
			}
			$helper = new LaporanHelper();        
		
			return view('laporan.klinik.preview2',compact('var','jumlah','jumlah_operasi','subSatuanKerja', 'spesies', 'helper','data_obat','klinik_tindakan','penyakit','terapitindakan','pemeriksa')); 
        }elseif($var['jenis'] == "bulanan"){
			$var['bulan'] = $this->bulan;
			$var['obat'] = Obat::get()->where("klinik",1);
			$tahun = $request->input("tahun");
			$var['tahun'] = $tahun;
			//var_dump($tahun);
			//exit;
			$pengeluaran = array();
			$total = array();
			foreach($var['obat'] as $obat){
				$total[$obat->id] = 0;
			}
			foreach($var['bulan'] as $key=>$value){
				
				foreach($var['obat'] as $obat){
					$pengeluaran[$obat->id][$key] = 0;
				}
			}
			foreach($var['bulan'] as $key=>$value){
				foreach($var['obat'] as $obat){
					$klinik_terapi = KlinikTerapi::join("klinik_dosis","klinik_terapi.id","klinik_dosis.klinik_id")->where("klinik_dosis.tindakan",2)->where("klinik_dosis.terapi_id",$obat->id)->whereMonth("tanggal_periksa",$key)->whereYear("tanggal_periksa",$tahun)->get();
					foreach($klinik_terapi as $row){
						$dosis = explode(" ", $row->dosis);
						$new_dosis = str_replace(',', '.', $dosis[0]);
						$pengeluaran[$obat->id][$key] += (float)$new_dosis;
						$total[$obat->id] += (float)$new_dosis;
						//echo $row->signalement . "-" . $row->terapi_id . " - " . $new_dosis . "<br />";
					}
				}
			}
			
			$helper = new LaporanHelper();        
		
			return view('laporan.klinik.preview2',compact('var','subSatuanKerja', 'helper','pengeluaran','total')); 
			
		}            
        
    }

    public function cetakLaporanPasien(Request $request)
    {
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['format'] = $request->format;        
        $var['jenis'] = $request->jenis;        
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $kode = $subSatuanKerja->kode_klinik;
		$data_obat = array();
		$jumlah_operasi = array();
		$spesies = array();
		$jumlah = array();
		$klinik_tindakan = array();
		$terapitindakan = array();
		$penyakit = array();
		$pemeriksa = array();
        if($var['jenis'] == 'Vaksinasi'){
            $var['vaksin'] = Obat::get()->where("klinik",2);
			$var['jumlah_hewan'] = 0;
			$var['jumlah_vaksin'] = array();
			foreach($var['vaksin'] as $vaksin){
				$var['jumlah_vaksin'][$vaksin->id] = 0;
				$var['jumlah_vaksin'][0] = 0;
			}
        }elseif($var['jenis'] == 'Operasi'){
            
            $var['opr'] = Operasi::orderBy('tindakan','asc')->where("kode","OPR")->get();
			$var['jumlah_hewan'] = 0;
			$var['jumlah_operasi'] = array();
			foreach($var['opr']  as $operasi){
				$var['jumlah_operasi'][$operasi->id] = 0;
				$var['jumlah_operasi'][0] = 0;
			}
        }elseif($var['jenis'] == 'Penyakit' || $var['jenis'] == 'penyakit' ){
                
            //$var['penyakit'] = KlinikTerapi::whereBetween('klinik_terapi.tanggal_periksa',[$var['dari_tanggal'],$var['sampai_tanggal']])->select('diagnosa')->distinct()->get();
            $var['jenis'] = 'Penyakit';
            $var['penyakit'] = KlinikTerapi::whereBetween('klinik_terapi.tanggal_periksa',[$var['dari_tanggal'],$var['sampai_tanggal']])->whereNotIn("diagnosa",[367])->whereNotNull("diagnosa")->select('diagnosa')->distinct()->get();
			/* echo $var['penyakit']->toSql();
			echo $var['dari_tanggal'] . " - " . $var['sampai_tanggal'];
			exit; */
        }elseif($var['jenis'] == 'pad'){
                
            //$var['penyakit'] = KlinikTerapi::whereBetween('klinik_terapi.tanggal_periksa',[$var['dari_tanggal'],$var['sampai_tanggal']])->select('diagnosa')->distinct()->get();
            $var['begin'] = strtotime( $var['dari_tanggal'] . " 12:00" );
			$var['end']	= strtotime( $var['sampai_tanggal'] . " 12:00" );
			//$interval = DateInterval::createFromDateString('1 day');
			//$var['period'] = new DatePeriod($begin, $interval, $end);
			/* echo $var['penyakit']->toSql();
			echo $var['dari_tanggal'] . " - " . $var['sampai_tanggal'];
			exit; */
        }elseif($var['jenis'] == 'Harian' || $var['jenis'] == 'utama'){
                
            $var['klinik'] = KlinikTerapi::select("klinik_terapi.*","klinik.sub_satuan_kerja_id","klinik.pemilik_id","klinik.spesies_id","klinik.nama_hewan","penyakit.penyakit")->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->join('pemilik','klinik.pemilik_id','=','pemilik.id')->join("penyakit","klinik_terapi.diagnosa","penyakit.id")->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->whereBetween('klinik_terapi.tanggal_periksa',[$var['dari_tanggal'],$var['sampai_tanggal']])->get();
            $var['obat'] = Obat::get()->where("klinik",1);
            $var['operasi'] = Operasi::where("kode","OPR")->orWhere("kode","MEDIVET1")->get();
			$var['vaksin'] = Obat::get()->where("klinik",2);
			$var['tarif'] = array();
			$data_obat = array();
			
			$var['cols_obat'] = 0;
			$var['cols_vaksin'] = 0;
			$var['cols_operasi'] = 0;
			foreach($var['obat'] as $obat){
				$jumlah[$obat->id] = 0;
				$var['cols_obat'] += 1;
			}
			foreach($var['vaksin'] as $vaksin){
				$jumlah[$vaksin->id] = 0;
				$var['cols_vaksin'] += 1;
			}
			foreach($var['operasi'] as $operasi){
				$jumlah_operasi[$operasi->id] = 0;
				$var['cols_operasi'] += 1;
			}
			
			foreach($var['klinik'] as $klinik){
				/* foreach($var['obat'] as $obat){
					$data_obat[$klinik->id][$obat->id] = 0;
				} */
				$dosis = KlinikDosis::where("klinik_id",$klinik->id)->get();
				foreach($dosis as $dos){
					if($dos->tindakan == 5 && $dos->terapi_id < 8){
						$data_obat[$klinik->id][$dos->terapi_id][$dos->tindakan] = 1;
					}else{
						$data_obat[$klinik->id][$dos->terapi_id][$dos->tindakan] = $dos->dosis;
					}
				}
				$var['tarif'][$klinik->id] = Pembayaran::get()->where('klinik_terapi_id',$klinik->id)->first()->total ?? 0;
			}
			
        }elseif($var['jenis'] == 'utama2'){
                
            $var['klinik'] = KlinikTerapi::select("klinik_terapi.*","klinik.sub_satuan_kerja_id","klinik.pemilik_id","klinik.spesies_id","klinik.nama_hewan","penyakit.penyakit")->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->join('pemilik','klinik.pemilik_id','=','pemilik.id')->join("penyakit","klinik_terapi.diagnosa","penyakit.id")->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->whereBetween('klinik_terapi.tanggal_periksa',[$var['dari_tanggal'],$var['sampai_tanggal']])->orderBy("tanggal_periksa")->get();
            $var['obat'] = Obat::get();
            $var['operasi'] = Operasi::get();
			$var['vaksin'] = Obat::get();
			$var['tarif'] = array();
			$data_obat = array();
			$jumlah = array();
			
			$list_obat = array();
			$list_vaksin = array();
			$list_operasi = array();
			foreach($var['obat'] as $obat){
				
				$list_obat[$obat->id] = $obat->obat;
			}
			foreach($var['vaksin'] as $vaksin){
				
				$list_vaksin[$vaksin->id] = $vaksin->obat;
			}
			foreach($var['operasi'] as $operasi){
				
				$list_operasi[$operasi->id] = $operasi->tindakan;
			}
			
			$list_pemeriksa = Pemeriksa::get();
			foreach($list_pemeriksa as $row){
				$pemeriksa[$row->id] = $row->nama;
			}
			
			
			$tindakan = array(1=>'Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi');
			$list_penyakit = Penyakit::get();
			
			foreach($list_penyakit as $row){
				$penyakit[$row->id] = $row->penyakit;
			}
			
			
			foreach($var['klinik'] as $klinik){
				$dosis = KlinikDosis::where("klinik_id",$klinik->id)->get();
				$dosis2 = KlinikDosis::where("klinik_id",$klinik->id)->groupBy('tindakan')->get();
				$i = 0;
				foreach($dosis2 as $dos2){
					if($i == 0){
						$klinik_tindakan[$klinik->id] = $tindakan[$dos2->tindakan];
					}else{
						$klinik_tindakan[$klinik->id] .= "," . $tindakan[$dos2->tindakan];
					}
					$i++;
				}
				
				$i = 0;
				$terapi = "";
				$terapitindakan[$klinik->id] = '';
				foreach($dosis as $dos){
					
					if($i > 0){
						$terapitindakan[$klinik->id] .= ",";
						if($dos->tindakan == 1){
							$terapitindakan[$klinik->id] .= $list_vaksin[$dos->terapi_id] . "-" . $dos->dosis;
						}elseif($dos->tindakan == 2){
							$terapitindakan[$klinik->id] .= $list_obat[$dos->terapi_id] . "-" . $dos->dosis;
						}elseif($dos->tindakan == 5){
							$terapitindakan[$klinik->id] .= $list_operasi[$dos->terapi_id];
						}else{
							$terapitindakan[$klinik->id] .= $tindakan[$dos->tindakan];
						}
					}else{
						if($dos->tindakan == 1){
							$terapitindakan[$klinik->id] = $list_vaksin[$dos->terapi_id] . "-" . $dos->dosis;
						}elseif($dos->tindakan == 2){
							$terapitindakan[$klinik->id] = $list_obat[$dos->terapi_id] . "-" . $dos->dosis;
						}elseif($dos->tindakan == 5){
							$terapitindakan[$klinik->id] = $list_operasi[$dos->terapi_id];
						}else{
							$terapitindakan[$klinik->id] = $tindakan[$dos->tindakan];
						}
					}
					$i++;
				}
				
					 
				$total = Pembayaran::get()->where('klinik_terapi_id',$klinik->id)->first();
				if(empty($total)){
					$var['tarif'][$klinik->id] = 0;
					$var['kwitansi'][$klinik->id] = (!empty($total->no_kwitansi))?$total->no_kwitansi:'-';
				}else{
					$var['tarif'][$klinik->id] = $total->total;
					$var['kwitansi'][$klinik->id] = (!empty($total->no_kwitansi))?$total->no_kwitansi:'-';
				}
				
			}
			
        }elseif($var['jenis'] == "bulanan"){
			$var['bulan'] = $this->bulan;
			$var['obat'] = Obat::get()->where("klinik",1);
			$tahun = $request->input("tahun");
			$var['tahun'] = $tahun;
			//var_dump($tahun);
			//exit;
			$pengeluaran = array();
			$total = array();
			foreach($var['obat'] as $obat){
				$total[$obat->id] = 0;
			}
			foreach($var['bulan'] as $key=>$value){
				
				foreach($var['obat'] as $obat){
					$pengeluaran[$obat->id][$key] = 0;
					
					
				}
			}
			foreach($var['bulan'] as $key=>$value){
				foreach($var['obat'] as $obat){
					$klinik_terapi = KlinikTerapi::join("klinik_dosis","klinik_terapi.id","klinik_dosis.klinik_id")->where("klinik_dosis.tindakan",2)->where("klinik_dosis.terapi_id",$obat->id)->whereMonth("tanggal_periksa",$key)->whereYear("tanggal_periksa",$tahun)->get();
					foreach($klinik_terapi as $row){
						$dosis = explode(" ", $row->dosis);
						$new_dosis = str_replace(',', '.', $dosis[0]);
						$pengeluaran[$obat->id][$key] += (float)$new_dosis;
						$total[$obat->id] += (float)$new_dosis;
						//echo $row->signalement . "-" . $row->terapi_id . " - " . $new_dosis . "<br />";
					}
				}
			}
			$var['pengeluaran'] = $pengeluaran;
			$var['total'] = $total;
		}            
        $helper = new LaporanHelper();     
        if($request->format == 'PDF'){
            $pdf = PDF::loadView('laporan.klinik.laporan-klinik', compact('var','subSatuanKerja', 'spesies', 'helper','data_obat'))->setPaper([0,0,610,936], 'landscape');
            return $pdf->stream('laporan-klinik.pdf');
        }else if($request->format == 'Excel'){
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=laporan-klinik.xls");//ganti nama sesuai keperluan
            header("Pragma: no-cache");
            header("Expires: 0");
            return view('laporan.klinik.laporan-klinik', compact('var','jumlah','jumlah_operasi','subSatuanKerja', 'spesies', 'helper','data_obat','klinik_tindakan','penyakit','terapitindakan','pemeriksa'));
        }
    }
}
