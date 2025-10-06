<?php

namespace App\Http\Controllers\Boyolali\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Boyolali\MasterData\Sampel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SampelController extends Controller
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

        $var['url'] = $this->url;

        $querySampel = Sampel::orderBy('id', 'desc');
        (!empty($this->cari))?$querySampel->Cari($this->cari):'';
        $listSampel = $querySampel->paginate($this->jumPerPage);
        (!empty($this->cari))?$listSampel->setPath('sampel'.$var['url']['cari']):'';

        return view('boyolali.master-data.sampel.sampel-1', compact('var', 'listSampel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Jenis Pengujian')) return view('errors.403');

        $var['method'] =  'create';

        return view('boyolali.master-data.sampel.sampel-2', compact('var'));
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
            $jenisSampel = Sampel::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Sampel Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Sampel Gagal Disimpan');
            return redirect('boyolali/master-data/sampel/create')->withInput();
        }

        return redirect('boyolali/master-data/sampel/create');
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
        $listSampel = Sampel::find($id);

        return view('boyolali.master-data.sampel.sampel-2', compact('listSampel', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Jenis Pengujian')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listSampel = Sampel::find($id);

        return view('boyolali.master-data.sampel.sampel-2', compact('listSampel', 'var'));
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
            $jenisPengujian = Sampel::find($id);
            $jenisPengujian->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Sampel Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Sampel Gagal Diupdate');
        }

        return redirect('boyolali/master-data/sampel'.$var['url']['all']);
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
            $jenisPengujian = Sampel::find($id);
            $jenisPengujian->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Sampel Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Sampel Gagal Dihapus');
        }

        return redirect('boyolali/master-data/sampel'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = Sampel::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = Sampel::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = Sampel::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
