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
use App\Models\Pengaturan\User;
use App\Models\MasterData\SubSatuanKerja;
use App\Models\MasterData\Spesies;
use App\Models\MasterData\Ras;
use App\Models\MasterData\Pemilik;
use App\Models\MasterData\Pemeriksa;
use App\Models\MasterData\Obat;
use App\Models\MasterData\Operasi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\UserHelper;
use Illuminate\Support\Facades\Auth;

class KlinikController extends Controller
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
    public function index()
    {
        if(!Auth::user()->hasPermissionTo('Read Klinik')) return view('errors.403');

        $var['url'] = $this->url;

        $queryKlinik = Klinik::orderBy('id', 'desc');
        (!empty($this->cari))?$queryKlinik->Cari($this->cari):'';
        $listKlinik = $queryKlinik->paginate($this->jumPerPage);
        (!empty($this->cari))?$listKlinik->setPath('klinik'.$var['url']['cari']):'';

        return view('modul.klinik.klinik-1', compact('var', 'listKlinik'));
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
        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::pluck('nama','id')->all();
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['noPeriksa'] = Klinik::max('no_periksa')+1;
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaKlinik'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idKlinik'] = Auth::user()->sub_satuan_kerja_id;
        }

        return view('modul.klinik.klinik-2', compact('var'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $klinik = KLinik::create($input);

            $listDataTerapi = (!empty($_SESSION['klinikTerapi'])?$_SESSION['klinikTerapi']:[]);
            foreach($listDataTerapi as $item){
                $klinikTerapi = new KlinikDosis();
                $klinikTerapi->terapi_id = $item['terapi'];
                $klinikTerapi->dosis = $item['dosis'];
                $klinikTerapi->input_by = $klinik->input_by;
                $klinikTerapi->tindakan = $request->input('tindakan');
                $klinik->klinikDosis()->save($klinikTerapi);
            }

            $terapi = new KlinikTerapi();
            $terapi->pemeriksa = $request->input('pemeriksa');
            $terapi->tanggal_periksa = $request->input('tanggal_periksa');
            $terapi->signalement = $request->input('signalement');
            $terapi->anamnesia = $request->input('anamnesia');
            $terapi->diagnosa = $request->input('diagnosa');
            $terapi->keterangan = $request->input('keterangan');
            $terapi->tindakan = $request->input('tindakan');            
            $klinik->klinikTerapi()->save($terapi);

            unset($_SESSION['klinikTerapi']);

            DB::commit();
            Session::flash('pesanSukses', 'Data Klinik Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', $e);
            return redirect('klinik/create')->withInput();
        }

        return redirect('klinik/create');
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

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();

        $listKlinik = KLinik::find($id);

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
                $klinikTerapi->tindakan = $request->input('tindakan');
                $klinik->klinikDosis()->save($klinikTerapi);
            }

            $delKlinikTerapi = KlinikTerapi::where('klinik_id',$id)->delete();
            $terapi = new KlinikTerapi();
            $terapi->pemeriksa = $request->input('pemeriksa');
            $terapi->tanggal_periksa = $request->input('tanggal_periksa');
            $terapi->signalement = $request->input('signalement');
            $terapi->anamnesia = $request->input('anamnesia');
            $terapi->diagnosa = $request->input('diagnosa');
            $terapi->keterangan = $request->input('keterangan');
            $terapi->tindakan = $request->input('tindakan');            
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
            $klinikDosis = KlinikDosis::where('klinik_id', $id)->delete();
            $klinikTerapi = KlinikTerapi::where('klinik_id',$id)->delete();
            $klinik = KLinik::find($id);
            $klinik->delete();

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

        return redirect('klinik'.$var['url']['all']);
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
        $jml = Klinik::where('pemilik_id','=','$request->pemilikId')->count();
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

    public function formAreaObat(Request $request)
    {
        $listObat = $var['obat'] = Obat::pluck('obat','id')->all();
        return view('modul.klinik.form-obat', compact('var', 'listObat'));
    }

    public function formAreaOperasi(Request $request)
    {
        $listOperasi = $var['operasi'] = Operasi::pluck('tindakan','id')->all();
        return view('modul.klinik.form-operasi', compact('var', 'listOperasi'));
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
            $_SESSION['klinikTerapi'][] = ['terapi' => $request->terapi, 'namaTerapi' => @$obat->obat, 'dosis'=> $request->dosis];
        }else if($request->penanganan == 4){
            $obat = Operasi::find($request->terapi);
            $_SESSION['klinikTerapi'][] = ['terapi' => $request->terapi, 'namaTerapi' => @$obat->tindakan, 'dosis'=> $request->dosis];
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
                $_SESSION['klinikTerapi'][] = ['terapi' => $item->terapi_id, 'namaTerapi' => @$item->terapi->obat, 'dosis'=> $item->dosis];
            }
            $listTerapi = $_SESSION['klinikTerapi'];
        }else if($request->method == 'show'){
            $listDataTerapi = KLinikDosis::where('klinik_id', $request->id)->get();
            foreach($listDataTerapi as $item) {
                $listTerapi[] = ['terapi' => $item->terapi_id,
                                    'namaTerapi' => @$item->terapi->obat,
                                    'dosis'=> $item->dosis];
            }
        }else {
            $listTerapi = $_SESSION['klinikTerapi'];
        }

        return view('modul.klinik.tabel-klinik-terapi', compact('listTerapi', 'method'));
    }

    public function hapusDataTerapi(Request $request)
    {
        $method = "edit";
        array_splice($_SESSION['klinikTerapi'], $request->id,1);
        $listTerapi = $_SESSION['klinikTerapi'];

        return view('modul.klinik.tabel-klinik-terapi', compact('listTerapi', 'method'));
    }

    public function addKlinik($id){
        $var['method'] =  'add';
        $var['url'] = $this->url;
        $var['currentUser'] = null;
        $var['namaKlinik'] = null;
        $var['idKlinik'] = null;

        unset($_SESSION['klinikTerapi']);
        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['pemilik'] = Pemilik::pluck('nama','id')->all();
        $var['pemeriksa'] = Pemeriksa::pluck('nama','id')->all();
        $var['obat'] = Obat::pluck('obat','id')->all();
        $var['noPeriksa'] = Klinik::max('no_periksa')+1;
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];

        $listKlinik = KLinik::find($id);
        return view('modul.klinik.klinik-3', compact('listKlinik','var'));
    }

    public function tambahTerapi(Request $request,$id){
        $var['url'] = $this->url;
    try {
        DB::beginTransaction();            
        $klinik = KLinik::find($id);
        $terapi = new KlinikTerapi();

        $listDataTerapi = (!empty($_SESSION['klinikTerapi'])?$_SESSION['klinikTerapi']:[]);
        foreach($listDataTerapi as $item){
            $klinikTerapi = new KlinikDosis();
            $klinikTerapi->terapi_id = $item['terapi'];
            $klinikTerapi->dosis = $item['dosis'];
            $klinikTerapi->input_by = $klinik->input_by;
            $klinikTerapi->tindakan = $request->input('tindakan');
            $klinik->klinikDosis()->save($klinikTerapi);
        }

        $terapi->pemeriksa = $request->input('pemeriksa');
        $terapi->tanggal_periksa = $request->input('tanggal_periksa');
        $terapi->signalement = $request->input('signalement');
        $terapi->anamnesia = $request->input('anamnesia');
        $terapi->diagnosa = $request->input('diagnosa');
        $terapi->keterangan = $request->input('keterangan');
        $terapi->tindakan = $request->input('tindakan');
        $klinik->klinikTerapi()->save($terapi);
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

        $listKlinik = Klinik::find($id);
        $klinikTerapi = KlinikTerapi::where('klinik_terapi.klinik_id',$id)->join('pemeriksa','klinik_terapi.pemeriksa','=','pemeriksa.id')->select('klinik_terapi.*','pemeriksa.nama AS nmpemeriksa')->get();
        $dosis = KlinikDosis::where('klinik_id',$id)->join('obat','obat.id','=','klinik_dosis.terapi_id')->select('klinik_dosis.*','obat.id','obat.obat')->get();
        $operasi = KlinikDosis::where('klinik_id',$id)->join('operasi','operasi.id','=','klinik_dosis.terapi_id')->select('klinik_dosis.*','operasi.id','operasi.tindakan')->get();

        return view('modul.klinik.detailPeriksa', compact('listKlinik','klinikTerapi','dosis','operasi'));
    }

    public function cetakRM($id){
        $listKlinik = Klinik::find($id);
        $klinikTerapi = KlinikTerapi::where('klinik_terapi.klinik_id',$id)->join('pemeriksa','klinik_terapi.pemeriksa','=','pemeriksa.id')->select('klinik_terapi.*','pemeriksa.nama AS nmpemeriksa')->get();

        $dosis = KlinikDosis::where('klinik_id',$id)->join('obat','obat.id','=','klinik_dosis.terapi_id')->select('klinik_dosis.*','obat.id','obat.obat')->get();

        $operasi = KlinikDosis::where('klinik_id',$id)->join('operasi','operasi.id','=','klinik_dosis.terapi_id')->select('klinik_dosis.*','operasi.id','operasi.tindakan')->get();

        $nip = Auth::user()->nip;
		$sub_id = Auth::user()->sub_satuan_kerja_id;
        $dataklinik = SubSatuanKerja::where('id','=',$sub_id)->first();	
        //$dataklinik = SubSatuanKerja::where('nip','=',$nip)->first();
		
        return view('modul.klinik.cetak_rm', compact('listKlinik','klinikTerapi','dosis','operasi','dataklinik'));
    }
}