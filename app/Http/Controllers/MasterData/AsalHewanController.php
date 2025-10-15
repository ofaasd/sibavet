<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\AsalHewan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AsalHewanController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Asal Hewan')) return view('errors.403');

        $var['url'] = $this->url;

        $queryAsalHewan = AsalHewan::orderBy('id', 'desc');
        (!empty($this->cari))?$queryAsalHewan->Cari($this->cari):'';
        $listAsalHewan = $queryAsalHewan->paginate($this->jumPerPage);
        (!empty($this->cari))?$listAsalHewan->setPath('asal-hewan'.$var['url']['cari']):'';

        return view('master-data.asal-hewan.asal-hewan-1', compact('var', 'listAsalHewan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Asal Hewan')) return view('errors.403');

        $var['method'] =  'create';

        return view('master-data.asal-hewan.asal-hewan-2', compact('var'));
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
            $asalHewan = AsalHewan::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Asal Hewan Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Asal Hewan Gagal Disimpan');
            return redirect('master-data/asal-hewan/create')->withInput();
        }

        return redirect('master-data/asal-hewan/create');
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
        $listAsalHewan = AsalHewan::find($id);

        return view('master-data.asal-hewan.asal-hewan-2', compact('listAsalHewan', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Asal Hewan')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listAsalHewan = AsalHewan::find($id);

        return view('master-data.asal-hewan.asal-hewan-2', compact('listAsalHewan', 'var'));
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
            $asalHewan = AsalHewan::find($id);
            $asalHewan->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Asal Hewan Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Asal Hewan Gagal Diupdate');
        }

        return redirect('master-data/asal-hewan'.$var['url']['all']);
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
            $asalHewan = AsalHewan::find($id);
            $asalHewan->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Asal Hewan Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Asal Hewan Gagal Dihapus');
        }

        return redirect('master-data/asal-hewan'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = AsalHewan::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = AsalHewan::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = AsalHewan::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
