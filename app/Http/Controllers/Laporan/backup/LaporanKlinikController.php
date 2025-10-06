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

class LaporanKlinikController extends Controller
{
    private $bulan = [
        '1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni',
        '7'=>'Juli', '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember',
    ];

    function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function formCetak()
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Klinik')) return view('errors.403');

        $var['listKlinik'] = [];
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['listKlinik'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listKlinik'] = SubSatuanKerja::where('satuan_kerja_id', '3')->pluck('sub_satuan_kerja','id')->all();
        }
        $var['bulan'] = $this->bulan;

        return view('laporan.klinik.form', compact('var'));
    }

    public function preview(Request $request){
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['format'] = $request->format;
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $spesies = Spesies::where('lab',1)->orderBy('id', 'desc')->get();
        $helper = new LaporanHelper();        

        return view('laporan.klinik.preview',compact('var','subSatuanKerja', 'spesies', 'helper'));
    }

    public function cetakLaporanPasien(Request $request)
    {
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['format'] = $request->format;
        $var['penanganan'] = ['Vaksinasi','Pengobatan','Rawat Inap','Rawat Sehat','Operasi'];
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $spesies = Spesies::where('lab',1)->orderBy('id', 'desc')->get();
        $helper = new LaporanHelper();  

        if($request->format == 'PDF'){
            $pdf = PDF::loadView('laporan.klinik.laporan-klinik', compact('var','subSatuanKerja', 'spesies', 'helper'))->setPaper([0,0,610,936], 'landscape');
            return $pdf->stream('laporan-klinik.pdf');
        }else if($request->format == 'Excel'){
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=laporan-klinik.xls");//ganti nama sesuai keperluan
            header("Pragma: no-cache");
            header("Expires: 0");
            return view('laporan.klinik.laporan-klinik', compact('var','subSatuanKerja', 'spesies', 'helper'));
        }
    }
}
