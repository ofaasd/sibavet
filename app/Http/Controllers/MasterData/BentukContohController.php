<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\BentukContoh;
use App\Models\MasterData\JenisContoh;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BentukContohController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Bentuk Contoh')) return view('errors.403');

        $var['url'] = $this->url;

        $queryBentukContoh = BentukContoh::orderBy('id', 'desc');
        (!empty($this->cari))?$queryBentukContoh->Cari($this->cari):'';
        $listBentukContoh = $queryBentukContoh->paginate($this->jumPerPage);
        (!empty($this->cari))?$listBentukContoh->setPath('bentuk-contoh'.$var['url']['cari']):'';

        return view('master-data.bentuk-contoh.bentuk-contoh-1', compact('var', 'listBentukContoh'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Bentuk Contoh')) return view('errors.403');

        $var['method'] =  'create';
        $var['jenisContoh'] = JenisContoh::pluck('nama_sampel','id')->all();

        return view('master-data.bentuk-contoh.bentuk-contoh-2', compact('var'));
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
            $bentukContoh = BentukContoh::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Bentuk Contoh Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Bentuk Contoh Gagal Disimpan');
            return redirect('master-data/bentuk-contoh/create')->withInput();
        }

        return redirect('master-data/bentuk-contoh/create');
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
        $var['jenisContoh'] = JenisContoh::pluck('nama_sampel','id')->all();
        $listBentukContoh = BentukContoh::find($id);

        return view('master-data.bentuk-contoh.bentuk-contoh-2', compact('listBentukContoh', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Bentuk Contoh')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['jenisContoh'] = JenisContoh::pluck('nama_sampel','id')->all();
        $listBentukContoh = BentukContoh::find($id);

        return view('master-data.bentuk-contoh.bentuk-contoh-2', compact('listBentukContoh', 'var'));
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
            $bentukContoh = BentukContoh::find($id);
            $bentukContoh->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Bentuk Contoh Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Bentuk Contoh Gagal Diupdate');
        }

        return redirect('master-data/bentuk-contoh'.$var['url']['all']);
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
            $bentukContoh = BentukContoh::find($id);
            $bentukContoh->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Bentuk Contoh Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Bentuk Contoh Gagal Dihapus');
        }

        return redirect('master-data/bentuk-contoh'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = BentukContoh::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = BentukContoh::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = BentukContoh::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
