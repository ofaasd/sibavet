<?php

namespace App\Http\Controllers\Boyolali\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Boyolali\MasterData\JenisHasilUji;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class JenisHasilUjiController extends Controller
{
    private $url;
    private $cari;
    private $jumPerPage = 10;
    function __construct(Request $request){
        $this->middleware('auth');
        $this->cari = $request->query('cari', '');
        $this->url = makeUrl($request->query());
    }

    public function index(Request $request){
        $var['url'] = $this->url;
        $queryJen = JenisHasilUji::orderBy('id', 'desc');
        (!empty($this->cari))?$queryJen->Cari($this->cari):'';
        $listHasil = $queryJen->paginate($this->jumPerPage);
        (!empty($this->cari))?$listHasil->setPath('boyolali/jenis-hasil-uji'.$var['url']['cari']):'';        

        return view('boyolali.master-data.jenis-hasil-uji.jenis-hasil-uji-1',compact('var','listHasil'));
    }

    public function create()
    {        

        $var['method'] =  'create';        

        return view('boyolali.master-data.jenis-hasil-uji.jenis-hasil-uji-2', compact('var'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $has = JenisHasilUji::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Hasil Jenis Uji Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Jenis Hasil Uji Gagal Disimpan');
            return redirect('boyolali/master-data/jenis-hasil-uji/create')->withInput();
        }

        return redirect('boyolali/master-data/jenis-hasil-uji/create');
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
        $listHasil = JenisHasilUji::find($id);

        return view('boyolali.master-data.jenis-hasil-uji.jenis-hasil-uji-2', compact('listHasil', 'var'));
    }

    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Operasi')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listHasil = JenisHasilUji::find($id);

        return view('boyolali.master-data.jenis-hasil-uji.jenis-hasil-uji-2', compact('listHasil', 'var'));
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
            $operasi = JenisHasilUji::find($id);
            $operasi->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Kelompok Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Kelompok Gagal Diupdate');
        }

        return redirect('boyolali/master-data/jenis-hasil-uji'.$var['url']['all']);
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
            $operasi = JenisHasilUji::find($id);
            $operasi->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Kelompok Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Kelompok Gagal Dihapus');
        }

        return redirect('boyolali/master-data/jenis-hasil-uji'.$var['url']['all']);
    }
}
