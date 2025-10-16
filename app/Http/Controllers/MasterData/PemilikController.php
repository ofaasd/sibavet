<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\Pemilik;
use App\Models\MasterData\Spesies;
use App\Models\Modul\Klinik;
use App\Models\Modul\KlinikTerapi;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PemilikController extends Controller
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
    public function index()
    {
        if(!Auth::user()->hasPermissionTo('Read Pemilik')) return view('errors.403');

        $var['url'] = $this->url;
		
		$kode = Auth::user()->subSatuanKerja->kode_klinik;
		$queryPemilik = '';
		if(Auth::user()->role != 'Administrator'){
			$queryPemilik = Pemilik::where("kode","like","%" . $kode . "%")->orderBy('id', 'desc');
		}else{
			$queryPemilik = Pemilik::orderBy('id', 'desc');
		}
        
        (!empty($this->cari))?$queryPemilik->Cari($this->cari):'';
        $listPemilik = $queryPemilik->paginate($this->jumPerPage);
        (!empty($this->cari))?$listPemilik->setPath('pemilik'.$var['url']['cari']):'';

        return view('master-data.pemilik.pemilik-1', compact('var', 'listPemilik'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Pemilik')) return view('errors.403');

        $var['method'] =  'create';
        $lok = Auth::user()->nip;

        if($lok == 'NIP006' || $lok == 'SMG009' ){
            $jml = Pemilik::where('kode','like','%SMG%')->orderBy("id","desc")->first();
			$kode = explode("SMG",$jml->kode);
			$kode_akhir = ((int)$kode[1]);
			
            $jml = $kode_akhir+1;
            $var['kode'] = 'SMG'.$jml;
        }elseif($lok == 'NIP005'){
            $jml = Pemilik::where('kode','like','%BWN%')->count();
            $jml = $jml+1;
            $var['kode'] = 'BWN'.$jml;
        }elseif($lok == 'NIP017'){
            $jml = Pemilik::where('kode','like','%PML%')->count();
            $jml = $jml+1;
            $var['kode'] = 'PML'.$jml;
        }else{
            $var['kode'] = '';
        }
        
        $var['pronvice'] = Wilayah::where('id_induk_wilayah','000000')->get();
        $var['curr_province'] = '030000';
        $var['curr_city'] = '036300';
        $var['curr_region'] = '036305';
        $var['city'] = Wilayah::where('id_induk_wilayah',$var['curr_province'])->get();
        $var['region'] = Wilayah::where('id_induk_wilayah',$var['curr_city'])->get();
		$var['spesies'] = Spesies::where("klinik",1)->pluck('nama_spesies','id')->all();
		
        return view('master-data.pemilik.pemilik-2', compact('var'));
    }

    public function get_wilayah(Request $request){
        $id_provinsi = $request->input('id');
        $wilayah = Wilayah::where('id_induk_wilayah',$id_provinsi)->get();
        echo json_encode($wilayah);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //try {
            
            $input = $request->all();
            
                $nama = $request->nama;
                $telepon = $request->telepon;
			//echo $nama;
			$kode = substr($request->kode,0,3);
			echo $nama;
			echo "<br />" . $kode . "<br />" . $telepon;
			$query = DB::table('pemilik')->selectRaw('count(*) as jumlah')->whereRaw('nama = "?" and telepon = "?" and kode like "%?%"',array($nama,$telepon,$kode))->first();
			//echo "asdasdasd";
			if($query->jumlah > 0){
				Session::flash('pesanError', 'Data Pemilik Sudah Ada');
				return redirect('master-data/pemilik/create')->withInput();
			}else{
				$pemilik = Pemilik::create($input);
				$klinik = new Klinik();
                    if(!empty($request->nama_hewan)){
					$klinik->no_pasien = $pemilik->kode . "/01";
					$klinik->pemilik_id = $pemilik->id;
                        $klinik->nama_hewan = $request->nama_hewan;
                        $klinik->spesies_id = $request->spesies_id;
                        $klinik->jenis_kelamin = $request->jenis_kelamin;
					$klinik->input_by = Auth::user()->id;
					$klinik->sub_satuan_kerja_id = Auth::user()->sub_satuan_kerja_id;
					if($klinik->save()){
						Session::flash('pesanSukses', 'Data Pemilik Berhasil Disimpan');
					}else{
						Session::flash('pesanError', 'Data Pasien Gagal Disimpan');
					}
				}else{
					if($pemilik)
						Session::flash('pesanSukses', 'Data Pemilik Berhasil Disimpan');
					else
						Session::flash('pesanError', 'Data Pasien Gagal Disimpan');
				}
                    return redirect('master-data/pemilik/' . $pemilik->id . "/edit");
			}
			
			
			//$pemilik = Pemilik::create($input);
			
            
			
        /* } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Pemilik Gagal Disimpan'); */
            //return redirect('master-data/pemilik/create')->withInput();
        //}

        //return redirect('master-data/pemilik/create');
    }
	
	public function store_pasien(Request $request){
        $cari_pasien = Klinik::where("no_pasien","like","%".$request->kode_pemilik . "/%")->orderBy("id","desc")->first();
		if(!empty($cari_pasien)){
			$pecah = explode("/",$cari_pasien->no_pasien);
			$nomor = (int)$pecah[1];
			$nomor_baru = $nomor+1;
			$format_baru = sprintf("%02d", $nomor_baru);
		}else{
			$format_baru = 01;
		}
		$jml = Pemilik::where('kode','like','%SMG%')->orderBy("id","desc")->first();
		
		$klinik = new Klinik();
        $klinik->no_pasien = $request->kode_pemilik . "/" . $format_baru;
        $klinik->pemilik_id = $request->id_pemilik;
        $klinik->nama_hewan = $request->nama_hewan;
        $klinik->spesies_id = $request->spesies_id;
        $klinik->jenis_kelamin = $request->jenis_kelamin;
		$klinik->input_by = Auth::user()->id;
		$klinik->sub_satuan_kerja_id = Auth::user()->sub_satuan_kerja_id;
		if($klinik->save()){
			Session::flash('pesanSukses', 'Data Pemilik Berhasil Disimpan');
		}else{
			Session::flash('pesanError', 'Data Pasien Gagal Disimpan');
		}
        return redirect('master-data/pemilik/'. $request->id_pemilik . "/edit");
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
        $listPemilik = Pemilik::find($id);

        return view('master-data.pemilik.pemilik-2', compact('listPemilik', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Pemilik')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listPemilik = Pemilik::find($id);
		$var['klinik'] = Klinik::select("klinik.*","spesies.nama_spesies")->where("pemilik_id",$id)->join("spesies","klinik.spesies_id","spesies.id")->get();
		//echo $var['klinik']->count();
		$var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
		
        $var['pronvice'] = Wilayah::where('id_induk_wilayah','000000')->get();
        $var['curr_province'] = $listPemilik->province_id ?? '030000';
        $var['curr_city'] = $listPemilik->city_id ?? '036300';
        $var['curr_region'] = $listPemilik->region_id ?? '036305';
        $var['city'] = Wilayah::where('id_induk_wilayah',$var['curr_province'])->get();
        $var['region'] = Wilayah::where('id_induk_wilayah',$var['curr_city'])->get();

		//exit;
        return view('master-data.pemilik.pemilik-3', compact('listPemilik', 'var'));
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

        try {
            DB::beginTransaction();
            $input = $request->all();
            $pemilik = Pemilik::find($id);
            $pemilik->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Pemilik Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Pemilik Gagal Diupdate');
        }

            return redirect('master-data/pemilik' . $var['url']['all']);
    }
	
	public function update_pasien(Request $request){
		$var['url'] = $this->url;
    $klinik = Klinik::find($request->id);
		$input= $request->all();
		if($klinik->update($input)){
			Session::flash('pesanSukses', 'Data Pasien Berhasil Diupdate');
		}else{
			Session::flash('pesanError', 'Data Pemilik Gagal Diupdate');
		}
		return redirect('master-data/pemilik/'.$request->id_pemilik."/edit");
	}
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $var['url'] = $this->url;

        try {
            DB::beginTransaction();
			
			$klinik = Klinik::where("pemilik_id",$id)->delete();
			
            $pemilik = Pemilik::find($id);
            $pemilik->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Pemilik Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Pemilik Gagal Dihapus');
        }

        return redirect('master-data/pemilik'.$var['url']['all']);
    }
	public function delete_pasien(Request $request){
    $id = $request->id;
		$klinik_terapi = KlinikTerapi::where("klinik_id",$id)->delete();
		$klinik = Klinik::where("id",$id);
		$hasil = $klinik->delete();
		//echo $id;
		//exit;
		if($hasil){
			Session::flash('pesanSukses', 'Data Pasien Berhasil Dihapus');
            return redirect('master-data/pemilik/' . $request->id_pemilik . "/edit");
		}
	}
    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = Pemilik::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Pemilik::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Pemilik::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
}
