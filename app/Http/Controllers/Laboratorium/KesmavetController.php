<?php

namespace App\Http\Controllers\Laboratorium;

use PDF, Session, Request, Auth, DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

use App\Http\Controllers\Helpers\UserHelper;

use App\Models\Modul\LaboratoriumKesmavet;
use App\Models\MasterData\Customer;
// use App\Models\Modul\LaboratoriumFile;
// use App\Models\Pengaturan\User;
// use App\Models\MasterData\SubSatuanKerja;
// use App\Models\MasterData\Spesies;
// use App\Models\MasterData\JenisContoh;02
// use App\Models\MasterData\BentukContoh;
// use App\Models\MasterData\SeksiLaboratorium;
// use App\Models\MasterData\JenisPengujian;
// use App\Models\Indonesia\Kota;
// use Illuminate\Support\Facades\DB;


class KesmavetController extends Controller
{
    private $url;
    private $cari;
    private $jumPerPage = 10;

    function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->cari = Input::get('cari', '');
        $this->url = makeUrl($request::query());
    }

    public function index()
    {
        if(!Auth::user()->hasPermissionTo('Read Lab Kesmavet')) return view('errors.403');
        $var['url'] = $this->url;

        if(Auth::user()->view_data > 2){
            $queryLaboratorium = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->orderBy('id', 'desc');
        }else{
            $queryLaboratorium = LaboratoriumKesmavet::where('lab_id',3)->orderBy('id', 'desc');
        }
        (!empty($this->cari))?$queryLaboratorium->Cari($this->cari):'';
        $listLaboratorium = $queryLaboratorium->paginate($this->jumPerPage);
        (!empty($this->cari))?$listLaboratorium->setPath('laboratorium'.$var['url']['cari']):'';

        return view('laboratorium.kesmavet.kesmavet_index', compact('var', 'listLaboratorium'));
    }

// get1
    public function getForm01(Request $request,$id = false)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');
        if(!\Illuminate\Support\Facades\Request::ajax()) return view("layouts.admin_redirect");
        $kesmavet = null;
        if($id != false){
            if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian','customer'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian','customer'])->find($id);
        }
            $id = true;
            if(empty($kesmavet)){
                return view('errors.403');
            }
        }

        return view("laboratorium.kesmavet.kesmavet_form01", compact('id','kesmavet'));
    }
// get2
    public function getForm02($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian'])->find($id);
        }
            if (!empty($kesmavet)){
                return view('laboratorium.kesmavet.kesmavet_form02', compact('kesmavet'));
            }else{
                return view('errors.403');
            }
        }
        return 0;
    }

    public function getForm03($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');
        
        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian'])->find($id);
        }
            if (!empty($kesmavet)){
                if (is_null($kesmavet->time_02)) {
                    return view('errors.403');
                }else{
                    return view('laboratorium.kesmavet.kesmavet_form03', compact('kesmavet'));
                }
            }else{
                    return view('errors.403');
            }
        }
        return 0;
    }

    // get4
    public function getForm04($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');
        
        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian','seksiLaboratorium'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian','seksiLaboratorium'])->find($id);
        }
            if (!empty($kesmavet)){
                if (is_null($kesmavet->time_03)) {
                    return view('errors.403');
                }else{
                    return view('laboratorium.kesmavet.kesmavet_form04', compact('kesmavet'));
                }
            }else{
                return view('errors.403');
            }
        }
        return 0;
    }

    // gethasil
    public function getFormHasil($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');
        
        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh:jumlah','subSatuanKerja:sub_satuan_kerja','labPengujian','seksiLaboratorium'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh:jumlah','subSatuanKerja:sub_satuan_kerja','labPengujian','seksiLaboratorium'])->find($id);
        }
            if (!empty($kesmavet)){
                if (is_null($kesmavet->time_04)) {
                    return view('errors.403');
                }else{
                    $jumlah_contoh = $kesmavet->labContoh->sum('jumlah');
                    return view('laboratorium.kesmavet.kesmavet_formhasil', compact('kesmavet','jumlah_contoh'));
                }
            }else{
                return view('errors.403');
            }
        }
        return 0;
    }
   // post1
    public function postForm01(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');
        
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Input::has('id')){
                if(Input::get('id')== '0'){
                    $lab = new LaboratoriumKesmavet();
                    $lab->status_epid = Input::get('status_epid');
                    $lab->no_epid = Input::get('no_epid');    
                }else{
                    if(Auth::user()->view_data > 2){
            $lab = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->find(Input::get('id'));
        }else{
            $lab = LaboratoriumKesmavet::where('lab_id',3)->find(Input::get('id'));
        }
                    if(empty($lab)){
                        return view('errors.403');
                    }
                }
            }else{
                $lab = new LaboratoriumKesmavet();
                $lab->status_epid = Input::get('status_epid');
                $lab->no_epid = Input::get('no_epid');
            }

            $lab->lab_id = 3;
            $lab->sub_satuan_kerja_id = Input::get('sub_satuan_kerja_id');
            $lab->nama_pengirim_id = Input::get('nama_pengirim_id');
            $lab->jenis_hewan_id = Input::get('jenis_hewan_id');
            $lab->kriteria_contoh = Input::get('kriteria_contoh');
            $lab->catatan = Input::get('catatan');
            $lab->peralatan = Input::get('peralatan');
            $lab->bahan = Input::get('bahan');
            $lab->personil = Input::get('personil');
            $lab->tanggal_penerimaan = Input::get('tanggal_penerimaan');
            $lab->pengirim = Input::get('pengirim');
            $lab->penerima = Input::get('penerima');
            $lab->input_by = Auth::user()->id;

            foreach (Input::get('jenis_contoh') as $key => $value) {
                $jenis_contoh[$value] = array('jumlah' => Input::get('jumlah_contoh')[$key]);
            }

            $lab->save();
            $lab->labContoh()->sync($jenis_contoh);
            $lab->labPengujian()->sync(Input::get('permintaan_uji'));

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM01 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM01 Gagal Disimpan','e' => $e->getMessage()));
        }
    }
   
    public function postForm02(Request $request)
    {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
            $lab = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->find(Input::get('id'));
        }else{
            $lab = LaboratoriumKesmavet::where('lab_id',3)->find(Input::get('id'));
        }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->asal_contoh_id = Input::get('asal_contoh_id');
            $lab->penerima_02 = Input::get('penerima_02');
            $lab->catatan_02 = Input::get('catatan_02');
            $nomor_baru = Input::get('nomor_baru');

            if(empty($lab->time_02)){
                $lab->time_02 = date('Y-m-d H:i:s');
            }

            foreach (Input::get('nomor_asal') as $key => $value) {
                $lab->labContoh()->updateExistingPivot($key, ['nomor_asal'=>$value,'nomor_baru'=>$nomor_baru[$key]]);
            }

            $lab->save();

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM02 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM02 Gagal Disimpan','e' => $e->getMessage()));
        }
    }

    // post3
    public function postForm03(Request $request)
    {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
            $lab = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->find(Input::get('id'));
        }else{
            $lab = LaboratoriumKesmavet::where('lab_id',3)->find(Input::get('id'));
        }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->seksi_laboratorium_id = Input::get('seksi_laboratorium_id');
            $lab->manajer_teknis = Input::get('manajer_teknis');
            $lab->catatan_03 = Input::get('catatan_03');
            
            if(empty($lab->time_03)){
                $lab->time_03 = date('Y-m-d H:i:s');
            }

            $lab->save();

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM03 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM03 Gagal Disimpan','e' => $e->getMessage()));
        }
    }

    // post4
    public function postForm04(Request $request)
    {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
            $lab = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->find(Input::get('id'));
        }else{
            $lab = LaboratoriumKesmavet::where('lab_id',3)->find(Input::get('id'));
        }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->penguji_ditunjuk = Input::get('penguji_ditunjuk');
            $lab->catatan_04 = Input::get('catatan_04');
            
            if(empty($lab->time_04)){
                $lab->time_04 = date('Y-m-d H:i:s');
            }

            $lab->save();

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM04 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM04 Gagal Disimpan','e' => $e->getMessage()));
        }
    }

    // posthasil
    public function postFormHasil(Request $request)
    {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
            $lab = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->find(Input::get('id'));
        }else{
            $lab = LaboratoriumKesmavet::where('lab_id',3)->find(Input::get('id'));
        }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->catatan_hasil = Input::get('catatan_04');
            $hasil = Input::get('hasil');
            
            if(empty($lab->time_hasil)){
                $lab->time_hasil = date('Y-m-d H:i:s');
            }

            foreach ($hasil as $key => $h) {
                $lab->labPengujian()->updateExistingPivot($key, [
                    'negatif'=>@$h['negatif'],
                    'positif'=>@$h['positif'],
                    'nol'=>@$h['nol'],
                    'rendah'=>@$h['rendah'],
                    'tinggi'=>@$h['tinggi'],
                    'kelompok_uji'=>@$h['kelompok_uji']
                ]);
            }

            $lab->save();

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM04 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM04 Gagal Disimpan','e' => $e->getMessage()));
        }
    }

    public function getCustomer(Request $request)
    {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        
        $customer = Customer::find(Input::get('customerId'));
        return response()->json($customer);
    }

    public function checkNoEpid(Request $request)
    {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        if (Input::get('id') !=0) {
            return true;
        }else{
            if(Auth::user()->view_data > 2){
            $jumlah = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->where('no_epid', Input::get('no_epid'))->count();
        }else{
            $jumlah = LaboratoriumKesmavet::where('lab_id',3)->where('no_epid', Input::get('no_epid'))->count();
        }
            return response()->json($jumlah>0?false:true);
        }
    }

    public function getCetak01($id) {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }
        if (empty($kesmavet)) {
            return view('errors.403');
        }

        return view('laboratorium.kesmavet.kesmavet_cetak01',compact('kesmavet'));
    }

    public function getCetak02($id) {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh','subSatuanKerja','labPengujian:jenis_pengujian'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh','subSatuanKerja','labPengujian:jenis_pengujian'])->find($id);
        }
        if (empty($kesmavet)) {
            return view('errors.403');
        }

        return view('laboratorium.kesmavet.kesmavet_cetak02',compact('kesmavet'));
    }
    
    public function getCetak03($id) {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }
        if (empty($kesmavet)) {
            return view('errors.403');
        }

        return view('laboratorium.kesmavet.kesmavet_cetak03',compact('kesmavet'));
    }
    
    public function getCetak04($id) {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }
        if (empty($kesmavet)) {
            return view('errors.403');
        }

        return view('laboratorium.kesmavet.kesmavet_cetak04',compact('kesmavet'));
    }
    
    public function getCetakHasil($id) {
         if(!Auth::user()->hasPermissionTo('Create Lab Kesmavet')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $kesmavet = LaboratoriumKesmavet::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',3)->with(['labContoh:jumlah','subSatuanKerja','labPengujian','seksiLaboratorium'])->find($id);
        }else{
            $kesmavet = LaboratoriumKesmavet::where('lab_id',3)->with(['labContoh:jumlah','subSatuanKerja','labPengujian','seksiLaboratorium'])->find($id);
        }
        if (empty($kesmavet)) {
            return view('errors.403');
        }
         $jumlah_contoh = $kesmavet->labContoh->sum('jumlah');

        return view('laboratorium.kesmavet.kesmavet_cetakhasil',compact('kesmavet','jumlah_contoh'));
    }
}