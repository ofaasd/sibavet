<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// Input facade is deprecated; use Request->query() or the global request() helper instead
use App\Models\MasterData\SatuanKerja;
use App\Models\MasterData\SubSatuanKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SubSatuanKerjaController extends Controller
{
    private $url;
    private $cari;
    private $jumPerPage = 10;

    function __construct(Request $request)
    {
        $this->middleware('auth');
        // prefer request query() instead of the deprecated Input facade
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
        if(!Auth::user()->hasPermissionTo('Read Sub Satuan Kerja')) return view('errors.403');

        $var['url'] = $this->url;

        $querySubSatuanKerja = SubSatuanKerja::orderBy('id', 'desc');
        (!empty($this->cari))?$querySubSatuanKerja->Cari($this->cari):'';
        $listSubSatuanKerja = $querySubSatuanKerja->paginate($this->jumPerPage);
        (!empty($this->cari))?$listSubSatuanKerja->setPath('sub-satuan-kerja'.$var['url']['cari']):'';

        return view('master-data.sub-satuan-kerja.sub-satuan-kerja-1', compact('var', 'listSubSatuanKerja'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Sub Satuan Kerja')) return view('errors.403');

        $var['method'] =  'create';
        $var['satuanKerja'] = SatuanKerja::pluck('satuan_kerja','id')->all();

        return view('master-data.sub-satuan-kerja.sub-satuan-kerja-2', compact('var'));
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
            $subSatuanKerja = SubSatuanKerja::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Sub Satuan Kerja Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Sub Satuan Kerja Gagal Disimpan');
            return redirect('master-data/sub-satuan-kerja/create')->withInput();
        }

        return redirect('master-data/sub-satuan-kerja/create');
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
        $var['satuanKerja'] = SatuanKerja::pluck('satuan_kerja','id')->all();
        $listSubSatuanKerja = SubSatuanKerja::find($id);

        return view('master-data.sub-satuan-kerja.sub-satuan-kerja-2', compact('listSubSatuanKerja', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Sub Satuan Kerja')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['satuanKerja'] = SatuanKerja::pluck('satuan_kerja','id')->all();
        $listSubSatuanKerja = SubSatuanKerja::find($id);

        return view('master-data.sub-satuan-kerja.sub-satuan-kerja-2', compact('listSubSatuanKerja', 'var'));
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
            $subSatuanKerja = SubSatuanKerja::find($id);
            $subSatuanKerja->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Sub Satuan Kerja Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Sub Satuan Kerja Gagal Diupdate');
        }

        return redirect('master-data/sub-satuan-kerja'.$var['url']['all']);
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
            $subSatuanKerja = SubSatuanKerja::find($id);
            $subSatuanKerja->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Sub Satuan Kerja Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Sub Satuan Kerja Gagal Dihapus');
        }

        return redirect('master-data/sub-satuan-kerja'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }else if($request->kolom == 'sub_satuan_kerja'){
            $kriteria = $request->sub_satuan_kerja;
        }

        if($request->aksi == 'create'){
            $jumlah = SubSatuanKerja::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = SubSatuanKerja::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = SubSatuanKerja::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
