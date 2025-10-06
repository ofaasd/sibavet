<?php

namespace App\Http\Controllers\Laporan;

use PDF, Excel;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterData\SubSatuanKerja;
use App\Models\Modul\LaboratoriumPakan;
use App\Models\MasterData\Spesies;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use App\Http\Controllers\Helpers\LaporanHelper;

use App\Models\MasterData\LabManyContoh;

class LaporanPakanController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Laporan Lab Pakan')) return view('errors.403');

        $var['listLaboratorium'] = [];
        if(Auth::user()->view_data > 2){
            $var['listLaboratorium'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listLaboratorium'] = SubSatuanKerja::where('satuan_kerja_id', '1')->pluck('sub_satuan_kerja','id')->all();
        }

        return view('laporan.laboratorium.pakan', compact('var'));
    }
// tampil
    public function cetakPengujian(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Lab Pakan')) return view('errors.403');

        $data['tanggal_awal'] = Carbon::parse(Input::get('tanggal_awal'))->format('Y-m-d');
        $data['tanggal_akhir'] = Carbon::parse(Input::get('tanggal_akhir'))->format('Y-m-d');

        if(Auth::user()->view_data > 2){
            $data['pakan'] = LaboratoriumPakan::with(['pakanTr','subSatuanKerja','seksiLaboratorium','customer'])
                    ->where('lab_id',2)
                    ->where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id);
        }else{
            $data['pakan'] = LaboratoriumPakan::with(['pakanTr','subSatuanKerja','seksiLaboratorium','customer'])
                    ->where('lab_id',2);

            if (Input::get('sub_satuan_kerja_id') != "") {
                $data['pakan'] = $data['pakan']->where('sub_satuan_kerja_id', Input::get('sub_satuan_kerja_id'));
            }
        }

        if(Input::get('asal_contoh_id')!=""){
            $data['pakan'] = $data['pakan']->where('asal_contoh_id',Input::get('asal_contoh_id'));
        }

        if(!empty(Input::get('permintaan_uji'))){
                $data['pakan'] = $data['pakan']->whereHas('labPengujian',function ($query)
                {
                    $query->whereIn('pengujian_id',Input::get('permintaan_uji'));
                });
        }
        $data['pakan'] = $data['pakan']
                    ->whereBetween('time_hasil', [$data['tanggal_awal'], $data['tanggal_akhir']])
                    ->get();
        return view('laporan.laboratorium.pakan_tampil',compact('data'));
    }

    public function postLaporanPakan() {
        if(!Auth::user()->hasPermissionTo('Read Laporan Lab Pakan')) return view('errors.403');

        $data['tanggal_awal'] = Input::get('tanggal_awal');
        $data['tanggal_akhir'] = Input::get('tanggal_akhir');

        if(Auth::user()->view_data > 2){
            $data['pakan'] = LaboratoriumPakan::with(['labContoh','subSatuanKerja','labPengujian','seksiLaboratorium','customer','hasilPenilaian'])
                    ->where('lab_id',2)
                    ->where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id);
        }else{
            $data['pakan'] = LaboratoriumPakan::with(['labContoh','subSatuanKerja','labPengujian','seksiLaboratorium','customer','hasilPenilaian'])
                    ->where('lab_id',2);

            if (Input::get('sub_satuan_kerja_id') != "") {
                $data['pakan'] = $data['pakan']->where('sub_satuan_kerja_id', Input::get('sub_satuan_kerja_id'));
            }
        }

        if(Input::get('asal_contoh_id')!=""){
            $data['pakan'] = $data['pakan']->where('asal_contoh_id',Input::get('asal_contoh_id'));
        }

        if(!empty(Input::get('permintaan_uji'))){
                $data['pakan'] = $data['pakan']->whereHas('labPengujian',function ($query)
                {
                    $query->whereIn('pengujian_id',Input::get('permintaan_uji'));
                });
        }

        $data['pakan'] = $data['pakan']
                    ->whereBetween('time_hasil', [$data['tanggal_awal'], $data['tanggal_akhir']])
                    ->get();

        if(Input::get('tipe') == 'PDF'){
            if (empty($data['pakan'])) {
                return view('errors.403');
            }

            // return view('laporan.laboratorium.laporan_pakan_cetak', array('data'=>($data)));
            $pdf = PDF::loadView('laporan.laboratorium.laporan_pakan_cetak', compact('data'))->setPaper('a3', 'landscape');
            
            return $pdf->stream('laporan-pengujian.pdf');

        }else if(Input::get('tipe') == 'Excel'){

            if (empty($data['pakan'])) {
                return view('errors.403');
            }

            // return view('laporan.laboratorium.laporan_pakan_excel', array('data'=>($data)));
            return Excel::create('Export Excel',function($excel) use($data){
                    $excel->sheet('Sheet 1', function($sheet) use($data){
                        $sheet->loadView('laporan.laboratorium.laporan_pakan_excel', array('data'=>($data)));

                    });
                })->download('xlsx');

            return Excel::loadView('laporan.laboratorium.laporan_pakan_excel', array('data'=>($data)))->download();

            return Excel::export($xx,'text.xlsx');

        }else{
            if (empty($data['pakan'])) {
                return view('errors.403');
            }
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=laporan-pengujian.xls");//ganti nama sesuai keperluan
            header("Pragma: no-cache");
            header("Expires: 0");
            return view('laporan.laboratorium.laporan_pakan_cetak', compact('data'));
        }
    }
}