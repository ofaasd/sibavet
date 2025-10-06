<?php

namespace App\Http\Controllers\Boyolali\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Boyolali\MasterData\KelompokKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class KelompokKerjaController extends Controller
{
    private $url;
    private $cari;
    private $jumPerPage = 10;

    public function __construct(Request $request){
        $this->middleware('auth');
        $this->cari = Input::get('cari', '');
        $this->url = makeUrl($request->query());
    }

    public function create()
    {        

        $var['method'] =  'create';
        $var['kelompok'] = ['Kiriman Dinas' => 'Kiriman Dinas','Kiriman Perorangan' => 'Kiriman Perorangan','Kiriman Perusahaan' => 'Kiriman Perusahaan','Pelayanan Aktif'=>'Pelayanan Aktif','Surveilance'=>'Surveilance','Pengujian'=>'Pengujian'];

        return view('boyolali.master-data.kelompok-kerja.kelompok-kerja-2', compact('var'));
    }

    public function index(Request $request){
        $var['url'] = $this->url;
        $queryKel = KelompokKerja::orderBy('id', 'desc');
        (!empty($this->cari))?$queryKel->Cari($this->cari):'';
        $listKelompok = $queryKel->paginate($this->jumPerPage);
        (!empty($this->cari))?$listKelompok->setPath('boyolali/kelompok-kerja'.$var['url']['cari']):'';        

        return view('boyolali.master-data.kelompok-kerja.kelompok-kerja-1',compact('var','listKelompok'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $input = $request->all();
            $kel = KelompokKerja::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Kelompok Kerja Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Kelompok Kerja Gagal Disimpan');
            return redirect('boyolali/master-data/kelompok-kerja/create')->withInput();
        }

        return redirect('boyolali/master-data/kelompok-kerja/create');
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
        $var['kelompok'] = ['Kiriman Dinas' => 'Kiriman Dinas','Kiriman Perorangan' => 'Kiriman Perorangan','Kiriman Perusahaan' => 'Kiriman Perusahaan','Pelayanan Aktif'=>'Pelayanan Aktif','Surveilance'=>'Surveilance','Pengujian'=>'Pengujian'];
        $listKelompok = KelompokKerja::find($id);

        return view('boyolali.master-data.kelompok-kerja.kelompok-kerja-2', compact('listKelompok', 'var'));
    }

    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Operasi')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $listKelompok = KelompokKerja::find($id);

        return view('boyolali.master-data.kelompok-kerja.kelompok-kerja-2', compact('listKelompok', 'var'));
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
            $operasi = KelompokKerja::find($id);
            $operasi->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Kelompok Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Kelompok Gagal Diupdate');
        }

        return redirect('boyolali/master-data/kelompok-kerja'.$var['url']['all']);
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
            $operasi = KelompokKerja::find($id);
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

        return redirect('boyolali/master-data/kelompok-kerja'.$var['url']['all']);
    }

}
