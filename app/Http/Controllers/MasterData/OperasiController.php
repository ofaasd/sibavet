<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\Operasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OperasiController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Operasi')) return view('errors.403');

        $var['url'] = $this->url;

        $queryOperasi = Operasi::orderBy('id', 'desc');
        (!empty($this->cari))?$queryOperasi->Cari($this->cari):'';
        $listOperasi = $queryOperasi->paginate($this->jumPerPage);
        (!empty($this->cari))?$listOperasi->setPath('operasi'.$var['url']['cari']):'';

        return view('master-data.operasi.operasi-1', compact('var', 'listOperasi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Operasi')) return view('errors.403');

        $var['method'] =  'create';

        return view('master-data.operasi.operasi-2', compact('var'));
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
            $obat = Operasi::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Operasi Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Operasi Gagal Disimpan');
            return redirect('master-data/obat/create')->withInput();
        }

        return redirect('master-data/operasi/create');
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
        $listOPerasi = Operasi::find($id);

        return view('master-data.operasi.operasi-2', compact('listOperasi', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Operasi')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listOperasi = Operasi::find($id);

        return view('master-data.operasi.operasi-2', compact('listOperasi', 'var'));
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
            $operasi = Operasi::find($id);
            $operasi->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Operasi Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Operasi Gagal Diupdate');
        }

        return redirect('master-data/operasi'.$var['url']['all']);
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
            $operasi = Operasi::find($id);
            $operasi->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Operasi Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Operasi Gagal Dihapus');
        }

        return redirect('master-data/operasi'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = Operasi::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Operasi::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Operasi::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
