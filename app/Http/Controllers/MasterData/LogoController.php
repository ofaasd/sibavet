<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\Obat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LogoController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Obat')) return view('errors.403');

        $var['url'] = $this->url;

        $queryObat = Obat::orderBy('id', 'desc');
        (!empty($this->cari))?$queryObat->Cari($this->cari):'';
        $listObat = $queryObat->paginate($this->jumPerPage);
        (!empty($this->cari))?$listObat->setPath('obat'.$var['url']['cari']):'';

        return view('master-data.obat.obat-1', compact('var', 'listObat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Obat')) return view('errors.403');

        $var['method'] =  'create';

        return view('master-data.obat.obat-2', compact('var'));
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
            $obat = Obat::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Obat Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Obat Gagal Disimpan');
            return redirect('master-data/obat/create')->withInput();
        }

        return redirect('master-data/obat/create');
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
        $listObat = Obat::find($id);

        return view('master-data.obat.obat-2', compact('listObat', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Obat')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listObat = Obat::find($id);

        return view('master-data.obat.obat-2', compact('listObat', 'var'));
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
            $obat = Obat::find($id);
            $obat->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Obat Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Obat Gagal Diupdate');
        }

        return redirect('master-data/obat'.$var['url']['all']);
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
            $obat = Obat::find($id);
            $obat->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Obat Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Obat Gagal Dihapus');
        }

        return redirect('master-data/obat'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = Obat::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Obat::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Obat::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
