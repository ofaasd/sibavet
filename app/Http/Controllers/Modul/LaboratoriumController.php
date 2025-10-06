<?php

namespace App\Http\Controllers\Modul;

use PDF;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// Input facade deprecated; use Request->query() or request()->input()
use App\Models\Modul\Laboratorium;
use App\Models\Modul\LaboratoriumFile;
use App\Models\Pengaturan\User;
use App\Models\MasterData\SubSatuanKerja;
use App\Models\MasterData\Customer;
use App\Models\MasterData\Spesies;
use App\Models\MasterData\JenisContoh;
use App\Models\MasterData\BentukContoh;
use App\Models\MasterData\SeksiLaboratorium;
use App\Models\MasterData\JenisPengujian;
use App\Models\Indonesia\Kota;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\UserHelper;
use Illuminate\Support\Facades\Auth;

class LaboratoriumController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Laboratorium')) return view('errors.403');

        $var['url'] = $this->url;

        $queryLaboratorium = Laboratorium::orderBy('id', 'desc');
        (!empty($this->cari))?$queryLaboratorium->Cari($this->cari):'';
        $listLaboratorium = $queryLaboratorium->paginate($this->jumPerPage);
        (!empty($this->cari))?$listLaboratorium->setPath('laboratorium'.$var['url']['cari']):'';

        return view('modul.laboratorium.laboratorium-1', compact('var', 'listLaboratorium'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create Laboratorium')) return view('errors.403');

        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaLaboratorium'] = null;
        $var['idLaboratorium'] = null;

        $var['user'] = UserHelper::listUser();
        $var['customer'] = Customer::pluck('nama_pelanggan','id')->all();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['jenisContoh'] = [];
        $var['bentukContoh'] = [];
        $var['seksiLaboratorium'] = SeksiLaboratorium::pluck('seksi_laboratorium','id')->all();
        $var['jenisPengujian'] = [];
        $var['kotaKabupaten'] = Kota::pluck('name','id')->all();
        unset($_SESSION['fileLaboratorium']);

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
            $var['jenisContoh'] = JenisContoh::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->pluck('nama_sampel','id')->all();
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaLaboratorium'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idLaboratorium'] = Auth::user()->sub_satuan_kerja_id;
        }

        return view('modul.laboratorium.laboratorium-2', compact('var'));
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
            $laboratorium = Laboratorium::create($input);

            if(!empty($request->upload_file)){
                $namaFolder = date("DdMY")."_".time();

                foreach($request->upload_file as $item){
                    $namaFile = time().'_'.$item->getClientOriginalName();
                    $direktori = "Data-Upload/Laboratorium/".$laboratorium->sub_satuan_kerja_id."/".$namaFolder."/".$namaFile;
                    $url = url('/')."/Data-Upload/Laboratorium/".$laboratorium->sub_satuan_kerja_id."/".$namaFolder."/".$namaFile;
                    $item->move("Data-Upload/Laboratorium/".$laboratorium->sub_satuan_kerja_id."/".$namaFolder, $namaFile);

                    $fileUpload = new LaboratoriumFile();
                    $fileUpload->nama_file = $namaFile;
                    $fileUpload->nama_folder = $namaFolder;
                    $fileUpload->direktori = $direktori;
                    $fileUpload->url = $url;
                    $fileUpload->input_by = $laboratorium->input_by;
                    $laboratorium->laboratoriumFile()->save($fileUpload);
                }
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Laboratorium Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Laboratorium Gagal Disimpan');
            return redirect('laboratorium/create')->withInput();
        }

        return redirect('laboratorium/create');
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
        $var['namaLaboratorium'] = null;
        $var['idLaboratorium'] = null;

        $var['user'] = UserHelper::listUser();
        $var['customer'] = Customer::pluck('nama_pelanggan','id')->all();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['jenisContoh'] = [];
        $var['bentukContoh'] = [];
        $var['seksiLaboratorium'] = SeksiLaboratorium::pluck('seksi_laboratorium','id')->all();
        $var['jenisPengujian'] = [];
        $var['kotaKabupaten'] = Kota::pluck('name','id')->all();

        $listLaboratorium = Laboratorium::find($id);

        return view('modul.laboratorium.laboratorium-2', compact('listLaboratorium', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Laboratorium')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['currentUser'] = null;
        $var['namaLaboratorium'] = null;
        $var['idLaboratorium'] = null;

        $var['user'] = UserHelper::listUser();
        $var['customer'] = Customer::pluck('nama_pelanggan','id')->all();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['jenisContoh'] = [];
        $var['bentukContoh'] = [];
        $var['seksiLaboratorium'] = SeksiLaboratorium::pluck('seksi_laboratorium','id')->all();
        $var['jenisPengujian'] = [];
        $var['kotaKabupaten'] = Kota::pluck('name','id')->all();

        $listLaboratorium = Laboratorium::find($id);

        return view('modul.laboratorium.laboratorium-2', compact('listLaboratorium', 'var'));
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
            $laboratorium = Laboratorium::find($id);
            $laboratorium->update($input);

            $namaFolderLama = "";
            $deleteFile = LaboratoriumFile::where('laboratorium_id', $id)->delete();
            $listFile = (!empty($_SESSION['fileLaboratorium'])?$_SESSION['fileLaboratorium']:[]);
            foreach($listFile as $item){
                $fileUpload = new LaboratoriumFile();
                $fileUpload->nama_file = $item['namaFile'];
                $fileUpload->nama_folder = $item['namaFolder'];
                $fileUpload->direktori = $item['direktori'];
                $fileUpload->url = $item['url'];
                $fileUpload->input_by = $laboratorium->input_by;
                $laboratorium->laboratoriumFile()->save($fileUpload);

                $namaFolderLama = $item['namaFolder'];
            }

            if(!empty($request->upload_file)){
                $namaFolder = ($namaFolderLama==""?date("DdMY")."_".time():$namaFolderLama);

                foreach($request->upload_file as $item){
                    $namaFile = time().'_'.$item->getClientOriginalName();
                    $direktori = "Data-Upload/Laboratorium/".$laboratorium->sub_satuan_kerja_id."/".$namaFolder."/".$namaFile;
                    $url = url('/')."/Data-Upload/Laboratorium/".$laboratorium->sub_satuan_kerja_id."/".$namaFolder."/".$namaFile;
                    $item->move("Data-Upload/Laboratorium/".$laboratorium->sub_satuan_kerja_id."/".$namaFolder, $namaFile);

                    $fileUpload2 = new LaboratoriumFile();
                    $fileUpload2->nama_file = $namaFile;
                    $fileUpload2->nama_folder = $namaFolder;
                    $fileUpload2->direktori = $direktori;
                    $fileUpload2->url = $url;
                    $fileUpload2->input_by = $laboratorium->input_by;
                    $laboratorium->laboratoriumFile()->save($fileUpload2);
                }
            }

            unset($_SESSION['fileLaboratorium']);
            DB::commit();
            Session::flash('pesanSukses', 'Data Laboratorium Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Laboratorium Gagal Diupdate');
        }

        return redirect('laboratorium'.$var['url']['all']);
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
            $laboratoriumFile = LaboratoriumFile::where('laboratorium_id', $id);
            $laboratoriumFile->delete();
            $laboratorium = Laboratorium::find($id)->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Laboratorium Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Laboratorium Gagal Dihapus');
        }

        return redirect('laboratorium'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'no_epid'){
            $kriteria = $request->no_epid;
        }

        if($request->aksi == 'create'){
            $jumlah = Laboratorium::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Laboratorium::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Laboratorium::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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

    public function getCustomer(Request $request)
    {
        $customer = Customer::find($request->customerId);
        return response()->json($customer);
    }

    public function getLaboratorium(Request $request)
    {
        $var['userId'] = $request->userId;
        $user = User::find($var['userId']);
        $subSatuanKerja = SubSatuanKerja::find($user['sub_satuan_kerja_id']);
        return response()->json($subSatuanKerja);
    }

    public function getFile(Request $request)
    {
        $method = Input::get('method', '');
        $id = Input::get('id', '');
        $listBerkasAll = array();

        if($method == 'edit'){
            unset($_SESSION['fileLaboratorium']);
            $listLaboratoriumFile = LaboratoriumFile::where('laboratorium_id', $request->id)->get();
            foreach($listLaboratoriumFile as $item) {
                $_SESSION['fileLaboratorium'][] = ['id'=> $item->id, 'namaFile' => $item->nama_file, 'namaFolder' => $item->nama_folder,
                                    'direktori'=> $item->direktori, 'url'=> $item->url];
            }
            $listLaboratoriumFileAll = $_SESSION['fileLaboratorium'];
        }else if($request->method == 'show'){
            $listLaboratoriumFile = LaboratoriumFile::where('laboratorium_id', $request->id)->get();
            foreach($listLaboratoriumFile as $item) {
                $listLaboratoriumFileAll[] = ['id'=> $item->id,
                    'namaFile' => $item->nama_file, 'namaFolder' => $item->nama_folder, 'direktori'=> $item->direktori,
                    'url'=> $item->url];
            }
        }

        return view('modul.laboratorium.tabel-file', compact('listLaboratoriumFileAll', 'method'));
    }

    public function hapusFile(Request $request)
    {
        $method = "edit";
        array_splice($_SESSION['fileLaboratorium'],$request->id,1);
        $listLaboratoriumFileAll = $_SESSION['fileLaboratorium'];

        return view('modul.laboratorium.tabel-file', compact('method', 'listLaboratoriumFileAll'));
    }

    public function formAreaJenisContoh(Request $request)
    {
        $var['userId'] = $request->userId;
        $var['jenisContohId'] = $request->jenisContohId;

        $user = User::find($var['userId']);
        $listJenisContoh = JenisContoh::where('sub_satuan_kerja_id', $user['sub_satuan_kerja_id'])->pluck('nama_sampel', 'id')->all();
        return view('modul.laboratorium.form-jenis-contoh', compact('var', 'listJenisContoh'));
    }

    public function formAreaBentukContoh(Request $request)
    {
        $var['jenisContohId'] = $request->jenisContohId;
        $var['bentukContohId'] = $request->bentukContohId;
        $listBentukContoh = BentukContoh::where('jenis_contoh_id', $var['jenisContohId'])->pluck('bentuk_sampel', 'id')->all();
        return view('modul.laboratorium.form-bentuk-contoh', compact('var', 'listBentukContoh'));
    }

    public function formAreaJenisPengujian(Request $request)
    {
        $var['seksiLaboratoriumId'] = $request->seksiLaboratoriumId;
        $var['jenisPengujianId'] = $request->jenisPengujianId;
        $listJenisPengujian = JenisPengujian::where('seksi_laboratorium_id', $var['seksiLaboratoriumId'])->pluck('jenis_pengujian', 'id')->all();
        return view('modul.laboratorium.form-jenis-pengujian', compact('var', 'listJenisPengujian'));
    }

    public function cetakKartu($id)
    {
        $laboratorium = Laboratorium::find($id);
        $pdf = PDF::loadView('modul.laboratorium.kartu-laboratorium', compact('laboratorium'))->setPaper([0,0,610,936], 'potrait');
        return $pdf->stream('laboratorium.pdf');
    }
}
