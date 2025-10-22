<?php

namespace App\Http\Controllers\Laboratorium;

use PDF, Session, Auth, DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Input; // Dihapus

use App\Http\Controllers\Helpers\UserHelper;

use App\Models\Modul\LaboratoriumKeswan;
use App\Models\MasterData\Customer;
// use App\Models\Modul\LaboratoriumFile;
// use App\Models\Pengaturan\User;
// use App\Models\MasterData\SubSatuanKerja;
// use App\Models\MasterData\Spesies;
use App\Models\MasterData\JenisContoh;
// use App\Models\MasterData\BentukContoh;
// use App\Models\MasterData\SeksiLaboratorium;
// use App\Models\MasterData\JenisPengujian;
// use App\Models\Indonesia\Kota;
// use Illuminate\Support\Facades\DB;


class KeswanController extends Controller
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

    public function index()
    {
        if(!Auth::user()->hasPermissionTo('Read Lab Keswan')) return view('errors.403');
        $var['url'] = $this->url;

        if(Auth::user()->view_data > 2){
            $queryLaboratorium = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->orderBy('id', 'desc');
        }else{
            $queryLaboratorium = LaboratoriumKeswan::where('lab_id',1)->orderBy('id', 'desc');
        }

        (!empty($this->cari))?$queryLaboratorium->Cari($this->cari):'';
        $listLaboratorium = $queryLaboratorium->paginate($this->jumPerPage);
        (!empty($this->cari))?$listLaboratorium->setPath('laboratorium'.$var['url']['cari']):'';

        return view('laboratorium.keswan.index', compact('var', 'listLaboratorium'));
    }
//get input
    public function input($id = false)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');
        $keswan = null;
        if($id != false){
            if(Auth::user()->view_data > 2){
                $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian','customer'])->find($id);
            }else{
                $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian','customer'])->find($id);
            }
            $id = true;
            if(empty($keswan)){
                return view('errors.403');
            }
        }
        $jenisContoh = JenisContoh::get();
        return view("laboratorium.keswan.input", compact('id','keswan','jenisContoh'));
    }
// get1
    public function getForm01(Request $request,$id = false)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(!\Illuminate\Support\Facades\Request::ajax()) return view("layouts.admin_redirect");
        $keswan = null;
        if($id != false){
            if(Auth::user()->view_data > 2){
                $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian','customer'])->find($id);
            }else{
                $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian','customer'])->find($id);
            }
            $id = true;
            if(empty($keswan)){
                return view('errors.403');
            }
        }
        $jenisContoh = JenisContoh::get();
        return view("laboratorium.keswan.form01", compact('id','keswan','jenisContoh'));
    }
// get2
    public function getForm02($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
                $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian'])->find($id);
            }else{
                $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian'])->find($id);
            }
            if (!empty($keswan)){
                return view('laboratorium.keswan.form02', compact('keswan'));
            }else{
                return view('errors.403');
            }
        }
        return 0;
    }

    public function getForm03($id)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
                $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian'])->find($id);
            }else{
                $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian'])->find($id);
            }
            if (!empty($keswan)){
                if (is_null($keswan->time_02)) {
                    return view('errors.403');
                }else{
                    return view('laboratorium.keswan.form03', compact('keswan'));
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
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
                $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian','seksiLaboratorium'])->find($id);
            }else{
                $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja:sub_satuan_kerja','labPengujian:jenis_pengujian','seksiLaboratorium'])->find($id);
            }
            if (!empty($keswan)){
                if (is_null($keswan->time_03)) {
                    return view('errors.403');
                }else{
                    return view('laboratorium.keswan.form04', compact('keswan'));
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
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(is_numeric($id)){
            if(Auth::user()->view_data > 2){
                $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh:jumlah','subSatuanKerja:sub_satuan_kerja','labPengujian','seksiLaboratorium'])->find($id);
            }else{
                $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh:jumlah','subSatuanKerja:sub_satuan_kerja','labPengujian','seksiLaboratorium'])->find($id);
            }
            if (!empty($keswan)){
                if (is_null($keswan->time_04)) {
                    return view('errors.403');
                }else{
                    $jumlah_contoh = $keswan->labContoh->sum('jumlah');
                    return view('laboratorium.keswan.formhasil', compact('keswan','jumlah_contoh'));
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
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        try {
            DB::beginTransaction();

            if($request->id){
                if($request->input('id') == '0'){
                    $lab = new LaboratoriumKeswan();
                    $lab->status_epid = $request->input('status_epid');
                    $lab->no_epid = $request->input('no_epid');
                }else{
                    if(Auth::user()->view_data > 2){
                        $lab = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->find($request->input('id'));
                    }else{
                        $lab = LaboratoriumKeswan::where('lab_id',1)->find($request->input('id'));
                    }
                    if(empty($lab)){
                        return view('errors.403');
                    }
                }
            }else{
                $lab = new LaboratoriumKeswan();
                $lab->status_epid = $request->input('status_epid');
                $lab->no_epid = $request->input('no_epid');
            }

            $lab->lab_id = 1;
            $lab->sub_satuan_kerja_id = $request->input('sub_satuan_kerja_id');
            $lab->nama_pengirim_id = $request->input('nama_pengirim_id');
            $lab->jenis_hewan_id = $request->input('jenis_hewan_id');
            $lab->kriteria_contoh = $request->input('kriteria_contoh');
            $lab->catatan = $request->input('catatan');
            $lab->peralatan = $request->input('peralatan');
            $lab->bahan = $request->input('bahan');
            $lab->personil = $request->input('personil');
            $lab->tanggal_penerimaan = $request->input('tanggal_penerimaan');
            $lab->pengirim = $request->input('pengirim');
            $lab->penerima = $request->input('penerima');
            $lab->input_by = Auth::user()->id;

            foreach ($request->input('jenis_contoh') as $key => $value) {
                $jenis_contoh[$value] = array('jumlah' => $request->input('jumlah_contoh')[$key]);
            }

            $lab->save();
            $lab->labContoh()->sync($jenis_contoh);
            $lab->labPengujian()->sync($request->input('permintaan_uji'));

            DB::commit();

            return response()->json(array('kode' => '1','id'=> $lab->id, 'pesan' => 'FORM01 Berhasil Disimpan'));
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json(array('kode' => '0', 'pesan' => 'FORM01 Gagal Disimpan','e' => $e->getMessage()));
        }
    }
   
    public function postForm02(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
                $lab = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->find($request->input('id'));
            }else{
                $lab = LaboratoriumKeswan::where('lab_id',1)->find($request->input('id'));
            }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->asal_contoh_id = $request->input('asal_contoh_id');
            $lab->penerima_02 = $request->input('penerima_02');
            $lab->catatan_02 = $request->input('catatan_02');
            $nomor_baru = $request->input('nomor_baru');

            if(empty($lab->time_02)){
                $lab->time_02 = date('Y-m-d H:i:s');
            }

            foreach ($request->input('nomor_asal') as $key => $value) {
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
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
                $lab = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->find($request->input('id'));
            }else{
                $lab = LaboratoriumKeswan::where('lab_id',1)->find($request->input('id'));
            }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->seksi_laboratorium_id = $request->input('seksi_laboratorium_id');
            $lab->manajer_teknis = $request->input('manajer_teknis');
            $lab->catatan_03 = $request->input('catatan_03');
            
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
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
                $lab = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->find($request->input('id'));
            }else{
                $lab = LaboratoriumKeswan::where('lab_id',1)->find($request->input('id'));
            }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->penguji_ditunjuk = $request->input('penguji_ditunjuk');
            $lab->catatan_04 = $request->input('catatan_04');
            
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
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        try {
            DB::beginTransaction();

            if(Auth::user()->view_data > 2){
                $lab = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->find($request->input('id'));
            }else{
                $lab = LaboratoriumKeswan::where('lab_id',1)->find($request->input('id'));
            }
            if(empty($lab)){
                return view('errors.403');
            }

            $lab->catatan_hasil = $request->input('catatan_04');
            $hasil = $request->input('hasil');
            
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
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        $customer = Customer::find($request->input('customerId'));
        return response()->json($customer);
    }

    public function checkNoEpid(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if ($request->id !=0) {
            return true;
        }else{
            if(Auth::user()->view_data > 2){
                $jumlah = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->where('no_epid', $request->no_epid)->count();
            }else{
                $jumlah = LaboratoriumKeswan::where('lab_id',1)->where('no_epid', $request->no_epid)->count();
            }
            return response()->json($jumlah>0?false:true);
        }
    }

    public function getCetak01($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }else{
            $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }
        if (empty($keswan)) {
            return view('errors.403');
        }

        return view('laboratorium.keswan.cetak01',compact('keswan'));
    }

    public function getCetak02($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian:jenis_pengujian'])->find($id);
        }else{
            $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian:jenis_pengujian'])->find($id);
        }
        if (empty($keswan)) {
            return view('errors.403');
        }

        return view('laboratorium.keswan.cetak02',compact('keswan'));
    }
    
    public function getCetak03($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }else{
            $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }
        if (empty($keswan)) {
            return view('errors.403');
        }

        return view('laboratorium.keswan.cetak03',compact('keswan'));
    }
    
    public function getCetak04($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }else{
            $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','customer'])->find($id);
        }
        if (empty($keswan)) {
            return view('errors.4Gagal Disimpan03');
        }

        return view('laboratorium.keswan.cetak04',compact('keswan'));
    }
    
    public function getCetakHasil($id) {
        if(!Auth::user()->hasPermissionTo('Create Lab Keswan')) return view('errors.403');

        if(Auth::user()->view_data > 2){
            $keswan = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh:jumlah','subSatuanKerja','labPengujian','seksiLaboratorium'])->find($id);
        }else{
            $keswan = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh:jumlah','subSatuanKerja','labPengujian','seksiLaboratorium'])->find($id);
        }
        if (empty($keswan)) {
            return view('errors.403');
        }
         $jumlah_contoh = $keswan->labContoh->sum('jumlah');

        return view('laboratorium.keswan.cetakhasil',compact('keswan','jumlah_contoh'));
    }
}