<?php

namespace App\Http\Controllers\Modul;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Modul\Pllt;
use App\Models\Modul\PlltFile;
use App\Models\Modul\PlltHewan;
use App\Models\Pengaturan\User;
use App\Models\MasterData\SubSatuanKerja;
use App\Models\MasterData\Spesies;
use App\Models\MasterData\Ras;
use App\Models\MasterData\Pemeriksa;
use App\Models\Indonesia\Provinsi;
use App\Models\Indonesia\Kota;
use App\Models\Indonesia\Kecamatan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Helpers\UserHelper;
use Illuminate\Support\Facades\Auth;

class PlltController2 extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read PLLT')) return view('errors.403');

        $var['url'] = $this->url;

        $queryPllt = Pllt::orderBy('id', 'desc');
        (!empty($this->cari))?$queryPllt->Cari($this->cari):'';
        $listPllt = $queryPllt->paginate($this->jumPerPage);
        (!empty($this->cari))?$listPllt->setPath('pllt'.$var['url']['cari']):'';

        return view('modul.pllt.pllt-1', compact('var', 'listPllt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Create PLLT')) return view('errors.403');

        $var['method'] =  'create';
        $var['currentUser'] = null;
        $var['namaPllt'] = null;
        $var['idPllt'] = null;
        $var['pemeriksa'] = [];

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['provinsiAsal'] = Provinsi::pluck('name','id')->all();
        $var['kotaKabupatenAsal'] = [];
        $var['kecamatanAsal'] = [];
        $var['provinsiTujuan'] = Provinsi::pluck('name','id')->all();
        $var['kotaKabupatenTujuan'] = [];
        $var['kecamatanTujuan'] = [];
        unset($_SESSION['filePllt']);
        unset($_SESSION['plltDataHewan']);

        if(sizeof($var['user'])==1){
            $var['currentUser'] = Auth::user()->id;
            $var['pemeriksa'] = Pemeriksa::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->pluck('nama','id')->all();
        }
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['namaPllt'] = Auth::user()->subSatuanKerja->sub_satuan_kerja;
            $var['idPllt'] = Auth::user()->sub_satuan_kerja_id;
        }

        return view('modul.pllt.pllt-2', compact('var'));
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
            $pllt = Pllt::create($input);

            $listDataHewan = (!empty($_SESSION['plltDataHewan'])?$_SESSION['plltDataHewan']:[]);
            foreach($listDataHewan as $item){
                $plltDataHewan = new PlltHewan();
                $plltDataHewan->jenis_spesies_id = $item['jenisSpesies'];
                $plltDataHewan->jenis_hewan_id = $item['jenisHewan'];
                $plltDataHewan->jumlah = $item['jumlah'];
                $plltDataHewan->satuan = $item['satuan'];
                $plltDataHewan->jumlah_jantan = $item['jumlahJantan'];
                $plltDataHewan->jumlah_betina = $item['jumlahBetina'];
                $plltDataHewan->input_by = $pllt->input_by;
                $pllt->plltHewan()->save($plltDataHewan);
            }

            if(!empty($request->upload_file)){
                $namaFolder = date("DdMY")."_".time();

                foreach($request->upload_file as $item){
                    $namaFile = time().'_'.$item->getClientOriginalName();
                    $direktori = "Data-Upload/PLLT/".$pllt->sub_satuan_kerja_id."/".$namaFolder."/".$namaFile;
                    $url = url('/')."/Data-Upload/PLLT/".$pllt->sub_satuan_kerja_id."/".$namaFolder."/".$namaFile;
                    $item->move("Data-Upload/PLLT/".$pllt->sub_satuan_kerja_id."/".$namaFolder, $namaFile);

                    $fileUpload = new PlltFile();
                    $fileUpload->nama_file = $namaFile;
                    $fileUpload->nama_folder = $namaFolder;
                    $fileUpload->direktori = $direktori;
                    $fileUpload->url = $url;
                    $fileUpload->input_by = $pllt->input_by;
                    $pllt->plltFile()->save($fileUpload);
                }
            }

            unset($_SESSION['plltDataHewan']);
            DB::commit();
            Session::flash('pesanSukses', 'Data PLLT Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data PLLT Gagal Disimpan');
            return redirect('pllt/create')->withInput();
        }

        return redirect('pllt/create');
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
        $var['namaPllt'] = null;
        $var['idPllt'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['provinsiAsal'] = Provinsi::pluck('name','id')->all();
        $var['kotaKabupatenAsal'] = [];
        $var['kecamatanAsal'] = [];
        $var['provinsiTujuan'] = Provinsi::pluck('name','id')->all();
        $var['kotaKabupatenTujuan'] = [];
        $var['kecamatanTujuan'] = [];

        $listPllt = Pllt::find($id);
        $var['pemeriksa'] = Pemeriksa::where('sub_satuan_kerja_id', $listPllt->inputBy->sub_satuan_kerja_id)->pluck('nama','id')->all();

        return view('modul.pllt.pllt-2', compact('listPllt', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update PLLT')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['currentUser'] = null;
        $var['namaPllt'] = null;
        $var['idPllt'] = null;

        $var['user'] = UserHelper::listUser();
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $var['ras'] = [];
        $var['provinsiAsal'] = Provinsi::pluck('name','id')->all();
        $var['kotaKabupatenAsal'] = [];
        $var['kecamatanAsal'] = [];
        $var['provinsiTujuan'] = Provinsi::pluck('name','id')->all();
        $var['kotaKabupatenTujuan'] = [];
        $var['kecamatanTujuan'] = [];

        $listPllt = Pllt::find($id);
        $var['pemeriksa'] = Pemeriksa::where('sub_satuan_kerja_id', $listPllt->inputBy->sub_satuan_kerja_id)->pluck('nama','id')->all();

        return view('modul.pllt.pllt-2', compact('listPllt', 'var'));
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
            $pllt = Pllt::find($id);
            $pllt->update($input);

            $deletePlltHewan = PlltHewan::where('pllt_id', $id)->delete();
            $listFile = (!empty($_SESSION['plltDataHewan'])?$_SESSION['plltDataHewan']:[]);
            foreach($listFile as $item){
                $plltDataHewan = new PlltHewan();
                $plltDataHewan->jenis_spesies_id = $item['jenisSpesies'];
                $plltDataHewan->jenis_hewan_id = $item['jenisHewan'];
                $plltDataHewan->jumlah = $item['jumlah'];
                $plltDataHewan->satuan = $item['satuan'];
                $plltDataHewan->jumlah_jantan = $item['jumlahJantan'];
                $plltDataHewan->jumlah_betina = $item['jumlahBetina'];
                $plltDataHewan->input_by = $pllt->input_by;
                $pllt->plltHewan()->save($plltDataHewan);
            }

            $namaFolderLama = "";
            $deleteFile = PlltFile::where('pllt_id', $id)->delete();
            $listFile = (!empty($_SESSION['filePllt'])?$_SESSION['filePllt']:[]);
            foreach($listFile as $item){
                $fileUpload = new PlltFile();
                $fileUpload->nama_file = $item['namaFile'];
                $fileUpload->nama_folder = $item['namaFolder'];
                $fileUpload->direktori = $item['direktori'];
                $fileUpload->url = $item['url'];
                $fileUpload->input_by = $pllt->input_by;
                $pllt->plltFile()->save($fileUpload);

                $namaFolderLama = $item['namaFolder'];
            }

            if(!empty($request->upload_file)){
                $namaFolder = ($namaFolderLama==""?date("DdMY")."_".time():$namaFolderLama);

                foreach($request->upload_file as $item){
                    $namaFile = time().'_'.$item->getClientOriginalName();
                    $direktori = "Data-Upload/PLLT/".$pllt->sub_satuan_kerja_id."/".$namaFolder."/".$namaFile;
                    $url = url('/')."/Data-Upload/PLLT/".$pllt->sub_satuan_kerja_id."/".$namaFolder."/".$namaFile;
                    $item->move("Data-Upload/PLLT/".$pllt->sub_satuan_kerja_id."/".$namaFolder, $namaFile);

                    $fileUpload = new PlltFile();
                    $fileUpload->nama_file = $namaFile;
                    $fileUpload->nama_folder = $namaFolder;
                    $fileUpload->direktori = $direktori;
                    $fileUpload->url = $url;
                    $fileUpload->input_by = $pllt->input_by;
                    $pllt->plltFile()->save($fileUpload);
                }
            }

            unset($_SESSION['filePllt']);
            unset($_SESSION['plltDataHewan']);
            DB::commit();
            Session::flash('pesanSukses', 'Data PLLT Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data PLLT Gagal Diupdate');
        }

        return redirect('pllt'.$var['url']['all']);
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
            $plltFile = PlltFile::where('pllt_id', $id)->delete();
            $plltDataHewan =  PlltHewan::where('pllt_id', $id)->delete();
            $pllt = Pllt::find($id)->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data PLLT Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data PLLT Gagal Dihapus');
        }

        return redirect('pllt'.$var['url']['all']);
    }

    public function getPllt(Request $request)
    {
        $var['userId'] = $request->userId;
        $user = User::find($var['userId']);
        $subSatuanKerja = SubSatuanKerja::find($user['sub_satuan_kerja_id']);
        return response()->json($subSatuanKerja);
    }

    public function formAreaJenisHewan(Request $request)
    {
        $var['spesiesId'] = $request->spesiesId;
        $var['jenisHewanId'] = $request->jenisHewanId;

        $listJenisHewan = Ras::where('spesies_id', $var['spesiesId'])->pluck('nama_ras', 'id')->all();
        return view('modul.pllt.form-jenis-hewan', compact('var', 'listJenisHewan'));
    }

    public function formAreaKotaAsal(Request $request)
    {
        $var['provinsiId'] = $request->provinsiId;
        $var['kotaId'] = $request->kotaId;
        $listKota = Kota::where('province_id', $var['provinsiId'])->pluck('name', 'id')->all();
        return view('modul.pllt.form-kota-asal', compact('var', 'listKota'));
    }

    public function formAreaKecamatanAsal(Request $request)
    {
        $var['kotaId'] = $request->kotaId;
        $var['kecamatanId'] = $request->kecamatanId;
        $listKecamatan = Kecamatan::where('regency_id', $var['kotaId'])->pluck('name', 'id')->all();
        return view('modul.pllt.form-kecamatan-asal', compact('var', 'listKecamatan'));
    }

    public function formAreaKotaTujuan(Request $request)
    {
        $var['provinsiId'] = $request->provinsiId;
        $var['kotaId'] = $request->kotaId;
        $listKota = Kota::where('province_id', $var['provinsiId'])->pluck('name', 'id')->all();
        return view('modul.pllt.form-kota-tujuan', compact('var', 'listKota'));
    }

    public function formAreaKecamatanTujuan(Request $request)
    {
        $var['kotaId'] = $request->kotaId;
        $var['kecamatanId'] = $request->kecamatanId;
        $listKecamatan = Kecamatan::where('regency_id', $var['kotaId'])->pluck('name', 'id')->all();
        return view('modul.pllt.form-kecamatan-tujuan', compact('var', 'listKecamatan'));
    }

    public function formPemeriksa(Request $request)
    {
        $var['userId'] = $request->userId;
        $var['pemeriksaId'] = $request->pemeriksaId;

        $user = User::find($var['userId']);
        $listPemeriksa = Pemeriksa::where('sub_satuan_kerja_id', $user['sub_satuan_kerja_id'])->pluck('nama', 'id')->all();
        return view('modul.pllt.form-pemeriksa', compact('var', 'listPemeriksa'));
    }

    public function getFile(Request $request)
    {
        $method = Input::get('method', '');
        $id = Input::get('id', '');
        $listBerkasAll = array();

        if($method == 'edit'){
            unset($_SESSION['filePllt']);
            $listPlltFile = PlltFile::where('pllt_id', $request->id)->get();
            foreach($listPlltFile as $item) {
                $_SESSION['filePllt'][] = ['id'=> $item->id, 'namaFile' => $item->nama_file, 'namaFolder' => $item->nama_folder,
                            'direktori'=> $item->direktori, 'url'=> $item->url];
            }
            $listPlltFileAll = $_SESSION['filePllt'];
        }else if($request->method == 'show'){
            $listPlltFile = PlltFile::where('pllt_id', $request->id)->get();
            foreach($listPlltFile as $item) {
                $listPlltFileAll[] = ['id'=> $item->id,
                    'namaFile' => $item->nama_file, 'namaFolder' => $item->nama_folder, 'direktori'=> $item->direktori,
                    'url'=> $item->url];
            }
        }

        return view('modul.pllt.tabel-file', compact('listPlltFileAll', 'method'));
    }

    public function hapusFile(Request $request)
    {
        $method = "edit";
        array_splice($_SESSION['filePllt'] ,$request->id,1);
        $listPlltFileAll = $_SESSION['filePllt'];

        return view('modul.pllt.tabel-file', compact('method', 'listPlltFileAll'));
    }

    public function tambahDataHewan(Request $request)
    {
        $spesies = Spesies::find($request->jenisSpesies);
        $jenisHewan = Ras::find($request->jenisHewan);

        $_SESSION['plltDataHewan'][] = ['jenisSpesies' => $request->jenisSpesies,
                                    'namaJenisSpesies' => @$spesies->nama_spesies,
                                    'jenisHewan'=> $request->jenisHewan,
                                    'namaJenisHewan' => @$jenisHewan->nama_ras,
                                    'jumlah' => $request->jumlah,
                                    'satuan' => $request->satuan,
                                    'jumlahJantan' => $request->jumlahJantan,
                                    'jumlahBetina' => $request->jumlahBetina];
        $listDataHewan = $_SESSION['plltDataHewan'];
        Session::put('newListDataHewan', $listDataHewan);
        return response()->json($listDataHewan);
    }

    public function getDataHewan(Request $request)
    {
        $method = $request->method;
        if($request->method == 'edit'){
            unset($_SESSION['plltDataHewan']);
            $listDataPlltHewan = PlltHewan::where('pllt_id', $request->id)->get();
            foreach($listDataPlltHewan as $item) {
                $_SESSION['plltDataHewan'][] = ['jenisSpesies' => $item->jenis_spesies_id,
                                                'namaJenisSpesies' => @$item->spesies->nama_spesies,
                                                'jenisHewan'=> $item->jenis_hewan_id,
                                                'namaJenisHewan' => @$item->ras->nama_ras,
                                                'jumlah' => $item->jumlah,
                                                'satuan' => $item->satuan,
                                                'jumlahJantan' => $item->jumlah_jantan,
                                                'jumlahBetina' => $item->jumlah_betina];
            }
            //$listPlltHewan = $_SESSION['plltDataHewan'];
            $listPlltHewan = Session::get('newListDataHewan');
        }else if($request->method == 'show'){
            $listDataPlltHewan = PlltHewan::where('pllt_id', $request->id)->get();
            foreach($listDataPlltHewan as $item) {
                $listPlltHewan[] = ['jenisSpesies' => $item->jenis_spesies_id,
                                    'namaJenisSpesies' => @$item->spesies->nama_spesies,
                                    'jenisHewan'=> $item->jenis_hewan_id,
                                    'namaJenisHewan' => @$item->ras->nama_ras,
                                    'jumlah' => $item->jumlah,
                                    'satuan' => $item->satuan,
                                    'jumlahJantan' => $item->jumlah_jantan,
                                    'jumlahBetina' => $item->jumlah_betina];
            }
        }else {
            $listPlltHewan = Session::get('newListDataHewan');
        }
        return view('modul.pllt.tabel-pllt-hewan', compact('listPlltHewan', 'method'));
    }

    public function hapusDataHewan(Request $request)
    {
        $method = "edit";
        array_splice($_SESSION['plltDataHewan'],$request->id,1);
        //$listPlltHewan = $_SESSION['plltDataHewan'];
        $listPlltHewan = Session::get('newListDataHewan');

        return view('modul.pllt.tabel-pllt-hewan', compact('listPlltHewan', 'method'));
    }
}
