<?php

namespace App\Http\Controllers\Boyolali\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\JenisPengujian;
use App\Models\MasterData\SeksiLaboratorium;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JenisPengujianController extends Controller
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

        $queryJenisPengujian = JenisPengujian::orderBy('id', 'desc');
        (!empty($this->cari))?$queryJenisPengujian->Cari($this->cari):'';
        $listJenisPengujian = $queryJenisPengujian->paginate($this->jumPerPage);
        (!empty($this->cari))?$listJenisPengujian->setPath('jenis-pengujian'.$var['url']['cari']):'';

        return view('boyolali.master-data.jenis-pengujian.jenis-pengujian-1', compact('var', 'listJenisPengujian'));
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
        $var['seksiLaboratorium'] = SeksiLaboratorium::pluck('seksi_laboratorium','id')->all();

        return view('boyolali.master-data.jenis-pengujian.jenis-pengujian-2', compact('var'));
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
            $jenisPengujian = JenisPengujian::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Jenis Pengujian Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Jenis Pengujian Gagal Disimpan');
            return redirect('boyolali/master-data/jenis-pengujian/create')->withInput();
        }

        return redirect('boyolali/master-data/jenis-pengujian/create');
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
        $var['seksiLaboratorium'] = SeksiLaboratorium::pluck('seksi_laboratorium','id')->all();
        $listJenisPengujian = JenisPengujian::find($id);

        return view('boyolali.master-data.jenis-pengujian.jenis-pengujian-2', compact('listJenisPengujian', 'var'));
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
        $var['seksiLaboratorium'] = SeksiLaboratorium::pluck('seksi_laboratorium','id')->all();
        $listJenisPengujian = JenisPengujian::find($id);

        return view('boyolali.master-data.jenis-pengujian.jenis-pengujian-2', compact('listJenisPengujian', 'var'));
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
            $jenisPengujian = JenisPengujian::find($id);
            $jenisPengujian->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Jenis Pengujian Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Jenis Pengujian Gagal Diupdate');
        }

        return redirect('boyolali/master-data/jenis-pengujian'.$var['url']['all']);
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
            $jenisPengujian = JenisPengujian::find($id);
            $jenisPengujian->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Jenis Pengujian Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Jenis Pengujian Gagal Dihapus');
        }

        return redirect('boyolali/master-data/jenis-pengujian'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'kode'){
            $kriteria = $request->kode;
        }

        if($request->aksi == 'create'){
            $jumlah = JenisPengujian::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = JenisPengujian::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = JenisPengujian::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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
