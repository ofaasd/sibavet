<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\Penyakit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenyakitController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Penyakit')) return view('errors.403');

        $var['url'] = $this->url;

        $queryPenyakit = Penyakit::orderBy('id', 'desc');
        (!empty($this->cari))?$queryPenyakit->Cari($this->cari):'';
        $listPenyakit = $queryPenyakit->paginate($this->jumPerPage);
        (!empty($this->cari))?$listPenyakit->setPath('penyakit'.$var['url']['cari']):'';

        return view('master-data.penyakit.penyakit-1', compact('var', 'listPenyakit'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Penyakit')) return view('errors.403');

        $var['method'] =  'create';

        return view('master-data.penyakit.penyakit-2', compact('var'));
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
            $penyakit = Penyakit::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Penyakit Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Penyakit Gagal Disimpan');
            return redirect('master-data/penyakit/create')->withInput();
        }

        return redirect('master-data/penyakit/create');
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
        $listPenyakit = Penyakit::find($id);

        return view('master-data.penyakit.penyakit-2', compact('listPenyakit', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Penyakit')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listPenyakit = Penyakit::find($id);

        return view('master-data.penyakit.penyakit-2', compact('listPenyakit', 'var'));
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
            $penyakit = Penyakit::find($id);
            $penyakit->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Penyakit Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Penyakit Gagal Diupdate');
        }

        return redirect('master-data/penyakit'.$var['url']['all']);
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
            $penyakit = Penyakit::find($id);
            $penyakit->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Penyakit Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Penyakit Gagal Dihapus');
        }

        return redirect('master-data/penyakit'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = Penyakit::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Penyakit::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Penyakit::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
