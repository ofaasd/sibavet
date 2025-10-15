<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\DaftarHarga;
use App\Models\MasterData\Spesies;
use App\Models\MasterData\Obat;
use App\Models\MasterData\Operasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DaftarHargaController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Obat')) return view('errors.403');

        $var['url'] = $this->url;

        $queryHarga = DaftarHarga::select("daftar_harga.*","spesies.nama_spesies")->join("spesies","daftar_harga.spesies_id","spesies.id")->orderBy('id', 'desc');
		$obat = Obat::get();
		$listObat = array();
		foreach($obat as $row){
			$listObat[$row->id] = $row->obat;
		}
		$operasi = Operasi::get();
		$listOperasi = array();
		foreach($operasi as $row){
			$listOperasi[$row->id] = $row->tindakan;
		}
		
		$harga = $queryHarga->get();
		//$obat = Obat::all();
		$tindakan = [1=>'Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];


        return view('master-data.daftar_harga.index-1', compact('var', 'harga','listObat','listOperasi','tindakan'));
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

        return view('master-data.daftar_harga.index-2', compact('var'));
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
            $pad = DaftarHarga::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data PAD Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data PAD Gagal Disimpan');
            return redirect('master-data/daftar_harga/create')->withInput();
        }

        return redirect('master-data/daftar_harga/create');
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
        $listHarga = DaftarHarga::find($id);

        return view('master-data.daftar_harga.index-2', compact('listHarga', 'var'));
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
        $listHarga = DaftarHarga::find($id);

        return view('master-data.daftar_harga.index-2', compact('listHarga', 'var'));
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
            $pad = DaftarHarga::find($id);
            $pad->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data PAD Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data PAD Gagal Diupdate');
        }

        return redirect('master-data/daftar_harga'.$var['url']['all']);
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
            $pad = DaftarHarga::find($id);
            $pad->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data PAD Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data PAD Gagal Dihapus');
        }

         return redirect('master-data/daftar_harga'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        
        return response()->json(true);
        
    }
}
