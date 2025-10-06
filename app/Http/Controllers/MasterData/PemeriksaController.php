<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\Pemeriksa;
use App\Models\MasterData\SubSatuanKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PemeriksaController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Pemeriksa')) return view('errors.403');

        $var['url'] = $this->url;

        $queryPemeriksa = Pemeriksa::orderBy('id', 'desc');
        (!empty($this->cari))?$queryPemeriksa->Cari($this->cari):'';
        $listPemeriksa = $queryPemeriksa->paginate($this->jumPerPage);
        (!empty($this->cari))?$listPemeriksa->setPath('pemeriksa'.$var['url']['cari']):'';

        return view('master-data.pemeriksa.pemeriksa-1', compact('var', 'listPemeriksa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Pemeriksa')) return view('errors.403');

        $var['method'] =  'create';
        $var['subSatuanKerja'] = SubSatuanKerja::pluck('sub_satuan_kerja','id')->all();

        return view('master-data.pemeriksa.pemeriksa-2', compact('var'));
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
            $pemeriksa = Pemeriksa::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Pemeriksa Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Pemeriksa Gagal Disimpan');
            return redirect('master-data/pemeriksa/create')->withInput();
        }

        return redirect('master-data/pemeriksa/create');
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
        $var['subSatuanKerja'] = SubSatuanKerja::pluck('sub_satuan_kerja','id')->all();
        $listPemeriksa = Pemeriksa::find($id);

        return view('master-data.pemeriksa.pemeriksa-2', compact('listPemeriksa', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Pemeriksa')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['subSatuanKerja'] = SubSatuanKerja::pluck('sub_satuan_kerja','id')->all();
        $listPemeriksa = Pemeriksa::find($id);

        return view('master-data.pemeriksa.pemeriksa-2', compact('listPemeriksa', 'var'));
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
            $pemeriksa = Pemeriksa::find($id);
            $pemeriksa->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Pemeriksa Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Pemeriksa Gagal Diupdate');
        }

        return redirect('master-data/pemeriksa'.$var['url']['all']);
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
            $pemeriksa = Pemeriksa::find($id);
            $pemeriksa->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Pemeriksa Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Pemeriksa Gagal Dihapus');
        }

        return redirect('master-data/pemeriksa'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'nip'){
            $kriteria = $request->nip;
        }

        if($request->aksi == 'create'){
            $jumlah = Pemeriksa::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Pemeriksa::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Pemeriksa::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
