<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\JenisContoh;
use App\Models\MasterData\SubSatuanKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JenisContohController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Jenis Contoh')) return view('errors.403');

        $var['url'] = $this->url;

        $queryJenisContoh = JenisContoh::orderBy('id', 'desc');
        (!empty($this->cari))?$queryJenisContoh->Cari($this->cari):'';
        $listJenisContoh = $queryJenisContoh->paginate($this->jumPerPage);
        (!empty($this->cari))?$listJenisContoh->setPath('jenis-contoh'.$var['url']['cari']):'';

        return view('master-data.jenis-contoh.jenis-contoh-1', compact('var', 'listJenisContoh'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Jenis Contoh')) return view('errors.403');

        $var['method'] =  'create';
        $var['subSatuanKerja'] = SubSatuanKerja::where('satuan_kerja_id', '1')->pluck('sub_satuan_kerja','id')->all();

        return view('master-data.jenis-contoh.jenis-contoh-2', compact('var'));
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
            $jenisContoh = JenisContoh::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Jenis Contoh Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Jenis Contoh Gagal Disimpan');
            return redirect('master-data/jenis-contoh/create')->withInput();
        }

        return redirect('master-data/jenis-contoh/create');
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
        $var['subSatuanKerja'] = SubSatuanKerja::where('satuan_kerja_id', '1')->pluck('sub_satuan_kerja','id')->all();
        $listJenisContoh = JenisContoh::find($id);

        return view('master-data.jenis-contoh.jenis-contoh-2', compact('listJenisContoh', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Jenis Contoh')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['subSatuanKerja'] = SubSatuanKerja::where('satuan_kerja_id', '1')->pluck('sub_satuan_kerja','id')->all();
        $listJenisContoh = JenisContoh::find($id);

        return view('master-data.jenis-contoh.jenis-contoh-2', compact('listJenisContoh', 'var'));
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
            $jenisContoh = JenisContoh::find($id);
            $jenisContoh->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Jenis Contoh Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Jenis Contoh Gagal Diupdate');
        }

        return redirect('master-data/jenis-contoh'.$var['url']['all']);
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
            $jenisContoh = JenisContoh::find($id);
            $jenisContoh->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Jenis Contoh Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Jenis Contoh Gagal Dihapus');
        }

        return redirect('master-data/jenis-contoh'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = JenisContoh::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = JenisContoh::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = JenisContoh::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
