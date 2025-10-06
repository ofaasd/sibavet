<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\Spesies;
use App\Models\MasterData\Ras;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RasController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Ras')) return view('errors.403');

        $var['url'] = $this->url;

        $queryRas = Ras::orderBy('id', 'desc');
        (!empty($this->cari))?$queryRas->Cari($this->cari):'';
        $listRas = $queryRas->paginate($this->jumPerPage);
        (!empty($this->cari))?$listRas->setPath('ras'.$var['url']['cari']):'';

        return view('master-data.ras.ras-1', compact('var', 'listRas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Ras')) return view('errors.403');

        $var['method'] =  'create';
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();

        return view('master-data.ras.ras-2', compact('var'));
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
            $ras = Ras::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Ras Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Ras Gagal Disimpan');
            return redirect('master-data/ras/create')->withInput();
        }

        return redirect('master-data/ras/create');
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
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $listRas = Ras::find($id);

        return view('master-data.ras.ras-2', compact('listRas', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Ras')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['spesies'] = Spesies::pluck('nama_spesies','id')->all();
        $listRas = Ras::find($id);

        return view('master-data.ras.ras-2', compact('listRas', 'var'));
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
            $ras = Ras::find($id);
            $ras->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Ras Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Ras Gagal Diupdate');
        }

        return redirect('master-data/ras'.$var['url']['all']);
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
            $ras = Ras::find($id);
            $ras->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Ras Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Ras Gagal Dihapus');
        }

        return redirect('master-data/ras'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = Ras::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Ras::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Ras::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
