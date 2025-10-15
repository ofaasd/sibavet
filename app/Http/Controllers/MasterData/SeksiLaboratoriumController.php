<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\SeksiLaboratorium;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SeksiLaboratoriumController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Seksi Laboratorium')) return view('errors.403');

        $var['url'] = $this->url;

        $querySeksiLaboratorium = SeksiLaboratorium::orderBy('id', 'desc');
        (!empty($this->cari))?$querySeksiLaboratorium->Cari($this->cari):'';
        $listSeksiLaboratorium = $querySeksiLaboratorium->paginate($this->jumPerPage);
        (!empty($this->cari))?$listSeksiLaboratorium->setPath('ras'.$var['url']['cari']):'';

        return view('master-data.seksi-laboratorium.seksi-laboratorium-1', compact('var', 'listSeksiLaboratorium'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Seksi Laboratorium')) return view('errors.403');

        $var['method'] =  'create';

        return view('master-data.seksi-laboratorium.seksi-laboratorium-2', compact('var'));
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
            $seksiLaboratorium = SeksiLaboratorium::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Seksi Laboratorium Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Seksi Laboratorium Gagal Disimpan');
            return redirect('master-data/seksi-laboratorium/create')->withInput();
        }

        return redirect('master-data/seksi-laboratorium/create');
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
        $listSeksiLaboratorium = SeksiLaboratorium::find($id);

        return view('master-data.seksi-laboratorium.seksi-laboratorium-2', compact('listSeksiLaboratorium', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Seksi Laboratorium')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listSeksiLaboratorium = SeksiLaboratorium::find($id);

        return view('master-data.seksi-laboratorium.seksi-laboratorium-2', compact('listSeksiLaboratorium', 'var'));
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
            $seksiLaboratorium = SeksiLaboratorium::find($id);
            $seksiLaboratorium->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Seksi Laboratorium Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Seksi Laboratorium Gagal Diupdate');
        }

        return redirect('master-data/seksi-laboratorium'.$var['url']['all']);
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
            $seksiLaboratorium = SeksiLaboratorium::find($id);
            $seksiLaboratorium->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Seksi Laboratorium Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Seksi Laboratorium Gagal Dihapus');
        }

        return redirect('master-data/seksi-laboratorium'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = SeksiLaboratorium::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = SeksiLaboratorium::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = SeksiLaboratorium::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
