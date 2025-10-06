<?php

namespace App\Http\Controllers\Laporan;

use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterData\SubSatuanKerja;
use App\Models\MasterData\Spesies;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\LaporanHelper;

class LaporanLaboratoriumController extends Controller
{
    private $bulan = [
        '1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni',
        '7'=>'Juli', '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember',
    ];

    function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function formCetakPengujian()
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Pengujian')) return view('errors.403');

        $var['listLaboratorium'] = [];
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['listLaboratorium'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listLaboratorium'] = SubSatuanKerja::where('satuan_kerja_id', '1')->pluck('sub_satuan_kerja','id')->all();
        }
        $var['bulan'] = $this->bulan;

        return view('laporan.laboratorium.form-keswan', compact('var'));
    }

    public function cetakPengujian(Request $request)
    {
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;

        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $subSatuanKerjaId = $subSatuanKerja->id;
        $var['namaLaboratorium'] = strtoupper($subSatuanKerja->sub_satuan_kerja);
        $var['periode'] = strtoupper(tanggal_format_indonesia($var['dari_tanggal']))." s/d ".strtoupper(tanggal_format_indonesia($var['sampai_tanggal']));
        $helper = new LaporanHelper();
        $kotaAsal = DB::table('laboratorium')->select('asal_contoh_id')->distinct()
                ->whereBetween('created_at', [$var['dari_tanggal'], $var['sampai_tanggal']])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->get();

        if($request->format == 'PDF'){
            $pdf = PDF::loadView('laporan.laboratorium.laporan-pengujian', compact('var', 'kotaAsal', 'helper'))->setPaper('a2', 'landscape');
            return $pdf->stream('laporan-pengujian.pdf');
        }else if($request->format == 'Excel'){
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=laporan-pengujian.xls");//ganti nama sesuai keperluan
            header("Pragma: no-cache");
            header("Expires: 0");
            return view('laporan.laboratorium.laporan-pengujian', compact('var', 'kotaAsal', 'helper'));
        }
    }
}
