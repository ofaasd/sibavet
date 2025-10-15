<?php

namespace App\Http\Controllers\MasterData;

use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\MasterData\Customer;
use App\Models\Indonesia\Kelurahan;
use App\Models\Indonesia\Kecamatan;
use App\Models\Indonesia\Kota;
use App\Models\Indonesia\Provinsi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Customer')) return view('errors.403');

        $var['url'] = $this->url;

        $queryCustomer = Customer::orderBy('id', 'desc');
        (!empty($this->cari))?$queryCustomer->Cari($this->cari):'';
        $listCustomer = $queryCustomer->paginate($this->jumPerPage);
        (!empty($this->cari))?$listCustomer->setPath('customer'.$var['url']['cari']):'';

        return view('master-data.customer.customer-1', compact('var', 'listCustomer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->hasPermissionTo('Create Customer')) return view('errors.403');

        $var['method'] =  'create';
        $var['provinsi'] = Provinsi::pluck('name','id')->all();

        return view('master-data.customer.customer-2', compact('var'));
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
            $customer = Customer::create($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Customer Berhasil Disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Customer Gagal Disimpan');
            return redirect('master-data/customer/create')->withInput();
        }

        return redirect('master-data/customer/create');
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
        $var['provinsi'] = Provinsi::pluck('name','id')->all();
        $listCustomer = Customer::find($id);

        return view('master-data.customer.customer-2', compact('listCustomer', 'var'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!Auth::user()->hasPermissionTo('Update Customer')) return view('errors.403');

        $var['url'] = $this->url;
        $var['method'] = 'edit';
        $var['provinsi'] = Provinsi::pluck('name','id')->all();
        $listCustomer = Customer::find($id);

        return view('master-data.customer.customer-2', compact('listCustomer', 'var'));
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
            $customer = Customer::find($id);
            $customer->update($input);

            DB::commit();
            Session::flash('pesanSukses', 'Data Customer Berhasil Diupdate');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Customer Gagal Diupdate');
        }

        return redirect('master-data/customer'.$var['url']['all']);
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
            $customer = Customer::find($id);
            $customer->delete();

            if($request->nomor == 1){
                $input = $request->query();
                $input['page'] = 1;
                $var['url'] = makeUrl($input);
            }

            DB::commit();
            Session::flash('pesanSukses', 'Data Customer Berhasil Dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('pesanError', 'Data Customer Gagal Dihapus');
        }

        return redirect('master-data/customer'.$var['url']['all']);
    }

    public function formAreaKota(Request $request)
    {
        $var['provinsiId'] = $request->provinsiId;
        $var['kotaId'] = $request->kotaId;
        $listKota = Kota::where('province_id', $var['provinsiId'])->pluck('name', 'id')->all();
        return view('master-data.customer.form-kota', compact('var', 'listKota'));
    }

    public function formAreaKecamatan(Request $request)
    {
        $var['kotaId'] = $request->kotaId;
        $var['kecamatanId'] = $request->kecamatanId;
        $listKecamatan = Kecamatan::where('regency_id', $var['kotaId'])->pluck('name', 'id')->all();
        return view('master-data.customer.form-kecamatan', compact('var', 'listKecamatan'));
    }

    public function formAreaKelurahan(Request $request)
    {
        $var['kecamatanId'] = $request->kecamatanId;
        $var['kelurahanId'] = $request->kelurahanId;
        $listKelurahan = Kelurahan::where('district_id', $var['kecamatanId'])->pluck('name', 'id')->all();
        return view('master-data.customer.form-kelurahan', compact('var', 'listKelurahan'));
    }
}
