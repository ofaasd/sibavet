<?php

namespace App\Http\Controllers\Pengaturan;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Spatie\Permission\Models\Role;
use App\Models\Pengaturan\User;
use App\Models\MasterData\SatuanKerja;
use App\Models\MasterData\SubSatuanKerja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    private $url;
    private $cari;
    private $jumPerPage = 10;
    private $viewData = [
        '1' => 'Lihat Semua Data',
        '2' => 'Lihat Data Per Satuan Kerja',
        '3' => 'Lihat Data Per Sub Satuan Kerja',
        '4' => 'Lihat Data Sendiri'
    ];

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
        if(!Auth::user()->hasPermissionTo('Read Pengguna')) return view('errors.403');

        $var['url'] = $this->url;

        $queryUser = User::orderBy('id', 'desc');
        (!empty($this->cari))?$queryUser->Cari($this->cari):'';
        $listUser = $queryUser->paginate($this->jumPerPage);
        (!empty($this->cari))?$listUser->setPath('pengguna'.$var['url']['cari']):'';

        return view('pengaturan.user.user-1', compact('var', 'listUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Pengguna')) return view('errors.403');

        $var['method'] =  'create';
        $var['role'] = Role::pluck('name','name')->all();
        $var['satuanKerja'] = SatuanKerja::pluck('satuan_kerja','id')->all();
        $var['viewData'] = $this->viewData;

        return view('pengaturan.user.user-2', compact('var'));
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
            $input['password'] = $request->username;
            $user = User::create($input);

            $roles = $request->role ? $request->role : [];
            $user->assignRole($roles);

            DB::commit();
            Session::flash('pesanSukses', 'Data Pengguna Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Pengguna Gagal Disimpan');
            return redirect('pengaturan/pengguna/create')->withInput();
        }

        return redirect('pengaturan/pengguna/create');
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
        $var['role'] = Role::pluck('name','name')->all();
        $var['satuanKerja'] = SatuanKerja::pluck('satuan_kerja','id')->all();
        $var['viewData'] = $this->viewData;
        $listUser = User::find($id);

        return view('pengaturan.user.user-2', compact('listUser', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Pengguna')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['role'] = Role::pluck('name','name')->all();
        $var['satuanKerja'] = SatuanKerja::pluck('satuan_kerja','id')->all();
        $var['viewData'] = $this->viewData;
        $listUser = User::find($id);

        return view('pengaturan.user.user-2', compact('listUser', 'var'));
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
            $user = User::find($id);
            $user->update($input);

            $roles = $request->role ? $request->role : [];
            $user->syncRoles($roles);

            DB::commit();
            Session::flash('pesanSukses', 'Data Pengguna Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Pengguna Gagal Diupdate');
        }

        return redirect('pengaturan/pengguna'.$var['url']['all']);
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
            $user = User::find($id);
            $user->removeRole($user->role);
            $user->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Pengguna Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Pengguna Gagal Dihapus');
        }

        return redirect('pengaturan/pengguna'.$var['url']['all']);
    }

    public function cekValidasi(Request $request)
    {
        if($request->kolom == 'nip'){
            $kriteria = $request->nip;
        }else if($request->kolom == 'email'){
            $kriteria = $request->email;
        }else if($request->kolom == 'username'){
            $kriteria = $request->username;
        }

        if($request->aksi == 'create'){
            $jumlah = User::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                return response()->json(false);
            }else{
                return response()->json(true);
            }
        }else if($request->aksi == 'edit'){
            $jumlah = User::where($request->kolom, $kriteria)->count();

            if ($jumlah != 0) {
                $jumlah2 = User::where($request->kolom, $kriteria)->where('id', $request->pk)->count();

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

    public function formSubSatuanKerja(Request $request)
    {
        $var['satuanKerjaId'] = $request->satuanKerjaId;
        $var['subSatuanKerjaId'] = $request->subSatuanKerjaId;
        $listSubSatuanKerja = SubSatuanKerja::where('satuan_kerja_id', $var['satuanKerjaId'])->pluck('sub_satuan_kerja', 'id')->all();
        return view('pengaturan.user.form-satuan-kerja', compact('var', 'listSubSatuanKerja'));
    }
}
