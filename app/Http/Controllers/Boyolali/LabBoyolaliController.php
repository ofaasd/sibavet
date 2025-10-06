<?php

namespace App\Http\Controllers\Boyolali;

date_default_timezone_set('Asia/Jakarta');

use PDF;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Boyolali\MasterData\KelompokKerja;
use App\Models\Boyolali\MasterData\JenisHasilUji;
use App\Models\Boyolali\MasterData\Sampel;
use App\Models\Boyolali\LaboratoriumBoyolali;
use App\Models\Boyolali\DetailLabBoyolali;
use App\Models\Indonesia\Provinsi;
use App\Models\Indonesia\Kota;
use App\Models\Indonesia\Kelurahan;
use App\Models\Indonesia\Kecamatan;
use App\Models\MasterData\JenisPengujian;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\UserHelper;
use Illuminate\Support\Facades\Auth;

class LabBoyolaliController extends Controller
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
        

        $var['url'] = $this->url;

        $queryKlinik = LaboratoriumBoyolali::join('kelompok_kerja','kelompok_kerja.id','=','laboratorium_boyolali.kel_kerja_id')->leftJoin('districts','districts.id','=','laboratorium_boyolali.kecamatan_id')->select('laboratorium_boyolali.*','kelompok_kerja.kelompok','kelompok_kerja.jenis','districts.name AS kecamatan')->orderBy('id', 'desc');
        (!empty($this->cari))?$queryKlinik->Cari($this->cari):'';
        $listKlinik = $queryKlinik->paginate($this->jumPerPage);
        (!empty($this->cari))?$listKlinik->setPath('lab-boyolali'.$var['url']['cari']):'';

        return view('boyolali.laboratorium.lab-boyolali-1', compact('var', 'listKlinik'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        unset($_SESSION['listSampel']);
        $var['method'] =  'create';        
        $var['kelker'] = KelompokKerja::selectraw("CONCAT (kelompok,' - ',jenis) AS kel,id")->pluck('kel','id')->all();
        $var['provinsi'] = Provinsi::pluck('name','id')->all();
        $var['kota'] = [];
        $var['kecamatan'] = [];
        $var['kel'] = [];
        $var['sampel'] = Sampel::pluck('nm_sampel','id')->all();
        $var['jenhasil'] = JenisHasilUji::pluck('nama','id')->all();
        $var['pengujian'] = JenisPengujian::pluck('jenis_pengujian','id')->all();
		$var['hasil_pengujian'] = array('Positif'=>'Positif','Negatif'=>'Negatif');
		$listKlinik = [];
        $listDetailklinik = [];
		
        return view('boyolali.laboratorium.lab-boyolali-3', compact('listKlinik', 'var','listDetailklinik'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
			
            $labBoyolali = new LaboratoriumBoyolali();
            $labBoyolali->kel_kerja_id = $request->kel_kerja_id;
            $labBoyolali->provinsi = $request->provinsi;
            $labBoyolali->kota = $request->kota;
            $labBoyolali->kecamatan_id = $request->kecamatan_id;
            $labBoyolali->tanggal = $request->tanggal_input;
			$labBoyolali->save();
			//echo $request->get('pengujian')[0];
                
                foreach( $request->sampel as $key=>$value){
                    $detailLab = new DetailLabBoyolali();
                    $detailLab->id_sampel = $value;
                    $detailLab->id_pengujian = $request->pengujian[$key];
                    $detailLab->hasil_pengujian = $request->hasil_pengujian[$key];
                    $labBoyolali->DetailLabBoyolali()->save($detailLab);
                }
				
            DB::commit();
            Session::flash('pesanSukses', 'Data Laboratorium Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', $e);
            return redirect('boyolali/lab-boyolali')->withInput();
        }

        return redirect('boyolali/lab-boyolali');
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
       $var['method'] =  'show';        
        $var['kelker'] = KelompokKerja::selectraw("CONCAT (kelompok,' - ',jenis) AS kel,id")->pluck('kel','id')->all();
        $var['provinsi'] = Provinsi::pluck('name','id')->all();
        $var['kota'] = Kota::pluck('name','id')->all();
        $var['kecamatan'] = Kecamatan::pluck('name','id')->all();
        $var['kel'] = [];
        $var['sampel'] = Sampel::pluck('nm_sampel','id')->all();
        $var['jenhasil'] = JenisHasilUji::pluck('nama','id')->all();
        $var['pengujian'] = JenisPengujian::pluck('jenis_pengujian','id')->all();
		$var['hasil_pengujian'] = array('Positif'=>'Positif','Negatif'=>'Negatif');

        $listKlinik = LaboratoriumBoyolali::find($id);

        return view('boyolali.laboratorium.lab-boyolali-3', compact('listKlinik', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        
        $var['url'] = $this->url;
        $var['method'] =  'edit';        
        $var['kelker'] = KelompokKerja::selectraw("CONCAT (kelompok,' - ',jenis) AS kel,id")->pluck('kel','id')->all();
        $var['provinsi'] = Provinsi::pluck('name','id')->all();
        $var['kota'] = Kota::pluck('name','id')->all();
        $var['kecamatan'] = Kecamatan::pluck('name','id')->all();
        $var['kel'] = [];
        $var['sampel'] = Sampel::pluck('nm_sampel','id')->all();
        $var['jenhasil'] = JenisHasilUji::pluck('nama','id')->all();
        $var['pengujian'] = JenisPengujian::pluck('jenis_pengujian','id')->all();
		$var['hasil_pengujian'] = array('Positif'=>'Positif','Negatif'=>'Negatif');

        $listKlinik = LaboratoriumBoyolali::find($id);
        $listDetailklinik = DetailLabBoyolali::where('lab_id',$id)->get();

        return view('boyolali.laboratorium.lab-boyolali-3', compact('listKlinik', 'var','listDetailklinik'));
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
			
			$labBoyolali = LaboratoriumBoyolali::find($id);
            $labBoyolali->kel_kerja_id = $request->kel_kerja_id;
            $labBoyolali->provinsi = $request->provinsi;
            $labBoyolali->kota = $request->kota;
            $labBoyolali->kecamatan_id = $request->kecamatan_id;
            $labBoyolali->tanggal = $request->tanggal_input;
			$labBoyolali->update();
			//echo $request->get('pengujian')[0];
            //var_dump($request->get('id_detail'));
            foreach( $request->sampel as $key=>$value){
                if(empty($request->id_detail[$key])){
                    $detailLab = new DetailLabBoyolali();
                    $detailLab->id_sampel = $value;
                    $detailLab->id_pengujian = $request->pengujian[$key];
                    $detailLab->hasil_pengujian = $request->hasil_pengujian[$key];
                    $labBoyolali->DetailLabBoyolali()->save($detailLab);
                    echo "baru";
                    echo "<br />";
                }
            }
			
            /* $input = $request->all();
            
            $labBoyolali = LaboratoriumBoyolali::find($id);
            $labBoyolali->update($input);
            
            $delSampel = DetailLabBoyolali::where('lab_id',$id)->delete();

            $listDataSampel = (!empty($_SESSION['listSampel'])?$_SESSION['listSampel']:[]);

                foreach($listDataSampel as $item){
                    $detailLab = new DetailLabBoyolali();
                    $detailLab->id_sampel = $item['id_sampel'];
                    $detailLab->jml_sampel = $item['jml_sampel'];
                    $detailLab->id_pengujian = $item['pengujian_id'];
                    $detailLab->jumlah = $item['jumlah'];
                    $detailLab->positif = $item['positif'];
                    $detailLab->negatif = $item['negatif'];

                    $labBoyolali->DetailLabBoyolali()->save($detailLab);
                }
            
                unset($_SESSION['listSampel']); */

            DB::commit();
            Session::flash('pesanSukses', 'Data Laboratorium Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Laboratorium Gagal Diupdate');
        }

        return redirect('boyolali/lab-boyolali'.$var['url']['all']);
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
            $detailLab = DetailLabBoyolali::where('lab_id', $id)->delete();           
            $labBoyolali = LaboratoriumBoyolali::find($id);
            $labBoyolali->delete();

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

        return redirect('boyolali/lab-boyolali'.$var['url']['all']);
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

   public function getKota(Request $request){
       $provinsi = $request->provinsi;
       $var['kota'] = Kota::where('province_id',$provinsi)->pluck('name','id')->all();

       return view('boyolali.laboratorium.form-kota',compact('var'));
   }

   public function getKec(Request $request){
    $kota = $request->kota;
    $var['kecamatan'] = Kecamatan::where('regency_id',$kota)->pluck('name','id')->all();

    return view('boyolali.laboratorium.form-kecamatan',compact('var'));
    }

    public function tambahDataSampel(Request $request)
    {
        
        $sampel = Sampel::find($request->id_sampel);
        $pengujian = JenisPengujian::find($request->pengujian_id);
        $_SESSION['listSampel'][] = ['id_sampel'=>$request->id_sampel,'nm_sampel' => @$sampel->nm_sampel,'jml_sampel'=>$request->jml_sampel, 'pengujian_id' => $request->pengujian_id,'jenis_pengujian' => @$pengujian->jenis_pengujian, 'jumlah'=> $request->jumlah,'positif'=> $request->positif,'negatif'=> $request->negatif];
        

        
        $listSampel = $_SESSION['listSampel'];
        return response()->json($listSampel);
    }

    public function getDataSampel(Request $request)
    {
        $method = $request->method;
        if($request->method == 'create'){
            $listTerapi = $_SESSION['listSampel'];
            $method = $request->method;
        }else if($request->method == 'show'){
            $listDataTerapi = DetailLabBoyolali::where('lab_id', $request->id)->join('sampel','detail_lab_boyolali.id_sampel','=','sampel.id')->join('jenis_pengujian','detail_lab_boyolali.id_pengujian','=','jenis_pengujian.id')->get();
            foreach($listDataTerapi as $item) {
                $listTerapi[] = ['id_sampel'=>$item->id_sampel,'nm_sampel' => @$item->nm_sampel,'jml_sampel'=>$item->jml_sampel, 'pengujian_id' => $item->pengujian_id,'jenis_pengujian' => @$item->jenis_pengujian, 'jumlah'=> $item->jumlah,'positif'=> $item->positif,'negatif'=> $item->negatif];
            }
        }elseif($request->method == 'edit'){
            unset($_SESSION['listSampel']);
            $listDataTerapi = DetailLabBoyolali::where('lab_id', $request->id)->join('sampel','detail_lab_boyolali.id_sampel','=','sampel.id')->join('jenis_pengujian','detail_lab_boyolali.id_pengujian','=','jenis_pengujian.id')->get();
            foreach($listDataTerapi as $item) {                
                $_SESSION['listSampel'][] = ['id_sampel'=>$item->id_sampel,'nm_sampel' => @$item->nm_sampel,'jml_sampel'=>$item->jml_sampel, 'pengujian_id' => $item->pengujian_id,'jenis_pengujian' => @$item->jenis_pengujian, 'jumlah'=> $item->jumlah,'positif'=> $item->positif,'negatif'=> $item->negatif];
            }
            $listTerapi = $_SESSION['listSampel'];
        }                    

        return view('boyolali.Laboratorium.tabel-sampel', compact('listTerapi', 'method'));
    }

    public function hapusDataSampel(Request $request)
    {
        $method = "edit";
        array_splice($_SESSION['listSampel'], $request->id,1);
        $listTerapi = $_SESSION['listSampel'];

        return view('boyolali.Laboratorium.tabel-sampel', compact('listTerapi', 'method'));
    }
	public function hapusDetail(request $request){
		$id = $request->id;
		$delSampel = DetailLabBoyolali::where('id',$id)->delete();
		if($delSampel){
			return 1;
		}else{
			return 0;
		}
	}
}