<?php

namespace App\Http\Controllers\Laporan;

use PDF, Excel, App;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MasterData\SubSatuanKerja;
use App\Models\Modul\LaboratoriumKeswan;
use App\Models\MasterData\Spesies;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\LaporanHelper;

class LaporanKeswanController extends Controller
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
        if(!Auth::user()->hasPermissionTo('Read Laporan Lab Keswan')) return view('errors.403');

        $var['listLaboratorium'] = [];
        if(Auth::user()->view_data > 2){
            $var['listLaboratorium'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listLaboratorium'] = SubSatuanKerja::where('satuan_kerja_id', '1')->pluck('sub_satuan_kerja','id')->all();
        }

        return view('laporan.laboratorium.keswan', compact('var'));
    }
// tampil
    public function cetakPengujian(Request $request)
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Lab Keswan')) return view('errors.403');

        $data['tanggal_awal'] = Input::get('tanggal_awal');
        $data['tanggal_akhir'] = Input::get('tanggal_akhir');
        
        if(Auth::user()->view_data > 2){
            $data['keswan'] = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','seksiLaboratorium','kotaKabupaten','spesies']);
        }else{
            $data['keswan'] = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','seksiLaboratorium','kotaKabupaten','spesies']);

            if (Input::get('sub_satuan_kerja_id') != "") {
                $data['keswan'] = $data['keswan']->where('sub_satuan_kerja_id', Input::get('sub_satuan_kerja_id'));
            }
        }

        if(Input::get('asal_contoh_id')!=""){
            $data['keswan'] = $data['keswan']->where('asal_contoh_id',Input::get('asal_contoh_id'));
        }

        if(!empty(Input::get('permintaan_uji'))){
                $data['keswan'] = $data['keswan']->whereHas('labPengujian',function ($query)
                {
                    $query->whereIn('pengujian_id',Input::get('permintaan_uji'));
                });
        }
        
        $data['keswan'] = $data['keswan']
                    ->whereBetween('time_hasil', [$data['tanggal_awal'], $data['tanggal_akhir']])
                    ->get();

        return view('laporan.laboratorium.keswan_tampil',compact('data'));
    }
// cetak
    public function postLaporanKeswan() {
        if(!Auth::user()->hasPermissionTo('Read Laporan Lab Keswan')) return view('errors.403');

        $data['tanggal_awal'] = Input::get('tanggal_awal');
        $data['tanggal_akhir'] = Input::get('tanggal_akhir');
        if(Auth::user()->view_data > 2){
            $data['keswan'] = LaboratoriumKeswan::where('sub_satuan_kerja_id', Auth::user()->sub_satuan_kerja_id)->where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','seksiLaboratorium','kotaKabupaten','spesies']);
        }else{
            $data['keswan'] = LaboratoriumKeswan::where('lab_id',1)->with(['labContoh','subSatuanKerja','labPengujian','seksiLaboratorium','kotaKabupaten','spesies']);

            if (Input::get('sub_satuan_kerja_id') != "") {
                $data['keswan'] = $data['keswan']->where('sub_satuan_kerja_id', Input::get('sub_satuan_kerja_id'));
            }
        }

        if(Input::get('asal_contoh_id')!=""){
            $data['keswan'] = $data['keswan']->where('asal_contoh_id',Input::get('asal_contoh_id'));
        }

        if(!empty(Input::get('permintaan_uji'))){
                $data['keswan'] = $data['keswan']->whereHas('labPengujian',function ($query)
                {
                    $query->whereIn('pengujian_id',Input::get('permintaan_uji'));
                });
        }
        
        $data['keswan'] = $data['keswan']
                    ->whereBetween('time_hasil', [$data['tanggal_awal'], $data['tanggal_akhir']])
                    ->get();

        if(Input::get('tipe') == 'PDF'){
            if (empty($data['keswan'])) {
                return view('errors.403');
            }

            $pdf = PDF::loadView('laporan.laboratorium.laporan_keswan_cetak', compact('data'))->setPaper('a3', 'landscape');
			//$pdf = PDF::loadHTML("asdasdasd");
            
            return $pdf->stream('laporan-pengujian.pdf');
			/* $pdf = App::make('dompdf.wrapper');
			$pdf->loadHTML('<h1>Test</h1>');
			return $pdf->stream(); */
		

        }else if(Input::get('tipe') == 'Excel'){

            if (empty($data['keswan'])) {
                return view('errors.403');
            }

            // return view('laporan.laboratorium.laporan_keswan_excel', array('data'=>($data)));
            return Excel::create('Export Excel',function($excel) use($data){
                    $excel->sheet('Sheet 1', function($sheet) use($data){
                        $sheet->loadView('laporan.laboratorium.laporan_keswan_excel', array('data'=>($data)));

                    });
                })->download('xlsx');

            return Excel::loadView('laporan.laboratorium.laporan_keswan_excel', array('data'=>($data)))->download();

            return Excel::export($xx,'text.xlsx');

        }else{
            if (empty($data['keswan'])) {
                return view('errors.403');
            }
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=laporan-pengujian.xls");//ganti nama sesuai keperluan
            header("Pragma: no-cache");
            header("Expires: 0");
            return view('laporan.laboratorium.laporan_keswan_cetak', compact('data'));
        }
    }
}