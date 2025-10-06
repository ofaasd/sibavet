<?php

namespace App\Http\Controllers\Pengaturan;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\UserHelper;
use Illuminate\Support\Facades\DB;

class HakAksesController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Hak Akses')) return view('errors.403');

        $var['url'] = $this->url;

        $queryRole = Role::orderBy('id', 'desc');
        if(!empty($this->cari)){
            $queryRole->where('name', 'like', '%'.$this->cari.'%')
                ->orWhere('keterangan', 'like', '%'.$this->cari.'%');
        }
        $listRole = $queryRole->paginate($this->jumPerPage);
        (!empty($this->cari))?$listRole->setPath('hak-akses'.$var['url']['cari']):'';

        return view('pengaturan.hak-akses.hak-akses-1', compact('var', 'listRole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Hak Akses')) return view('errors.403');

        $var['method'] =  'create';
        $var['role'] = Permission::selectRaw('distinct menu')->get();
        $userHelper = new UserHelper();
        $var['permission'] = [];

        return view('pengaturan.hak-akses.hak-akses-2', compact('var', 'userHelper'));
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
            $role = Role::create($request->except('permission'));
            $permissions = $request->permission ? $request->permission : [];
            $role->givePermissionTo($permissions);

            DB::commit();
            Session::flash('pesanSukses', 'Data Hak Akses Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Hak Akses Gagal Disimpan');
            return redirect('pengaturan/hak-akses/create')->withInput();
        }

        return redirect('pengaturan/hak-akses/create');
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
        $var['role'] = Permission::selectRaw('distinct menu')->get();
        $userHelper = new UserHelper();
        $listHakAkses = Role::find($id);
        $var['permission'] = [];
        foreach($listHakAkses->permissions as $item) {
            $var['permission'][] = $item->name;
        }

        return view('pengaturan.hak-akses.hak-akses-2', compact('var', 'userHelper', 'listHakAkses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Hak Akses')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['role'] = Permission::selectRaw('distinct menu')->get();
        $userHelper = new UserHelper();
        $listHakAkses = Role::find($id);
        $var['permission'] = [];
        foreach($listHakAkses->permissions as $item) {
            $var['permission'][] = $item->name;
        }

        return view('pengaturan.hak-akses.hak-akses-2', compact('var', 'userHelper', 'listHakAkses'));
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
            $role = Role::findOrFail($id);
            $role->update($request->except('permission', 'page', 'cari'));
            $permissions = $request->permission ? $request->permission : [];
            $role->syncPermissions($permissions);

            DB::commit();
            Session::flash('pesanSukses', 'Data Hak Akses Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Hak Akses Gagal Diupdate');
        }

        return redirect('pengaturan/hak-akses'.$var['url']['all']);
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
            $role = Role::find($id);
            $role->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Hak Akses Berhasil Dihapus');
        } catch (\Exception $e) {
            // dd($e);
            DB::rollback();
            Session::flash('pesanError', 'Data Hak Akses Gagal Dihapus');
        }

        return redirect('pengaturan/hak-akses'.$var['url']['all']);
    }
}
