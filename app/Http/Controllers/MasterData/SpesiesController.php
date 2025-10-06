<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\Spesies;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SpesiesController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Spesies')) return view('errors.403');

        $var['url'] = $this->url;

        $querySpesies = Spesies::orderBy('id', 'desc');
        (!empty($this->cari))?$querySpesies->Cari($this->cari):'';
        $listSpesies = $querySpesies->paginate($this->jumPerPage);
        (!empty($this->cari))?$listSpesies->setPath('spesies'.$var['url']['cari']):'';

        return view('master-data.spesies.spesies-1', compact('var', 'listSpesies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Spesies')) return view('errors.403');

        $var['method'] =  'create';

        return view('master-data.spesies.spesies-2', compact('var'));
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
            $spesies = Spesies::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Spesies Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Spesies Gagal Disimpan');
            return redirect('master-data/spesies/create')->withInput();
        }

        return redirect('master-data/spesies/create');
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
        $listSpesies = Spesies::find($id);

        return view('master-data.spesies.spesies-2', compact('listSpesies', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Spesies')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listSpesies = Spesies::find($id);

        return view('master-data.spesies.spesies-2', compact('listSpesies', 'var'));
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
            $spesies = Spesies::find($id);
            $spesies->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Spesies Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Spesies Gagal Diupdate');
        }

        return redirect('master-data/spesies'.$var['url']['all']);
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
            $spesies = Spesies::find($id);
            $spesies->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Spesies Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Spesies Gagal Dihapus');
        }

        return redirect('master-data/spesies'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = Spesies::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Spesies::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Spesies::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
