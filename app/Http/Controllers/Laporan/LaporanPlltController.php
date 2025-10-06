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

class LaporanPlltController extends Controller
{
    private $bulan = [
        '1'=>'Januari', '2'=>'Februari', '3'=>'Maret', '4'=>'April', '5'=>'Mei', '6'=>'Juni',
        '7'=>'Juli', '8'=>'Agustus', '9'=>'September', '10'=>'Oktober', '11'=>'Nopember', '12'=>'Desember',
    ];

    function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    public function formCetakTernakMasuk()
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Ternak Masuk')) return view('errors.403');

        $var['listPllt'] = [];
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['listPllt'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listPllt'] = SubSatuanKerja::where('satuan_kerja_id', '2')->pluck('sub_satuan_kerja','id')->all();
        }
        $var['dari_tanggal'] = $this->bulan;

        return view('laporan.pllt.form-ternak-masuk', compact('var'));
    }

    public function TernakMasukPrev(Request $request){
        set_time_limit(0);
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['jenisForm'] = 'Ternak Masuk';
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $subSatuanKerjaId = $subSatuanKerja->id;
        $spesies = Spesies::orderBy('id', 'desc')->get();
        $var['periode'] = strtoupper(tanggal_format_indonesia($var['dari_tanggal']))." s/d ".strtoupper(tanggal_format_indonesia($var['sampai_tanggal']));
        $helper = new LaporanHelper();

        if($request->jenis == 'kota'){
            $kotaAsal = DB::table('pllt')->select('kabupaten_asal_id')->distinct()->where('jenis_form', $var['jenisForm'])
                ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->get();

            return view('laporan.pllt.laporan-ternak-masuk-prev',compact('var','subSatuanKerja', 'spesies', 'kotaAsal', 'helper'));

        }else if($request->jenis == 'provinsi'){
            $provinsiAsal = DB::table('pllt')->select('provinsi_asal_id')->distinct()->where('jenis_form', $var['jenisForm'])
                ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->get();

                return view('laporan.pllt.laporan-ternak-masuk-provinsi-prev',compact('var','subSatuanKerja', 'spesies', 'provinsiAsal', 'helper'));
        }
    }

    public function cetakTernakMasuk(Request $request)
    {
        set_time_limit(0);
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['jenisForm'] = 'Ternak Masuk';
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $subSatuanKerjaId = $subSatuanKerja->id;
        $spesies = Spesies::orderBy('id', 'desc')->get();
        $var['periode'] = strtoupper(tanggal_format_indonesia($var['dari_tanggal']))." s/d ".strtoupper(tanggal_format_indonesia($var['sampai_tanggal']));
        $helper = new LaporanHelper();

        if($request->jenis == 'kota'){
            $kotaAsal = DB::table('pllt')->select('kabupaten_asal_id')->distinct()->where('jenis_form', $var['jenisForm'])
                ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->get();

            if($request->format == 'PDF'){
                $pdf = PDF::loadView('laporan.pllt.laporan-ternak-masuk', compact('var','subSatuanKerja', 'spesies', 'kotaAsal', 'helper'))->setPaper('a3', 'landscape');
                return $pdf->stream('laporan-ternak-masuk.pdf');
            }else if($request->format == 'Excel'){
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=laporan-ternak-masuk.xls");//ganti nama sesuai keperluan
                header("Pragma: no-cache");
                header("Expires: 0");
                return view('laporan.pllt.laporan-ternak-masuk', compact('var','subSatuanKerja', 'spesies', 'kotaAsal', 'helper'));
            }
        }else if($request->jenis == 'provinsi'){
            $provinsiAsal = DB::table('pllt')->select('provinsi_asal_id')->distinct()->where('jenis_form', $var['jenisForm'])
                ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->get();

            if($request->format == 'PDF'){
                $pdf = PDF::loadView('laporan.pllt.laporan-ternak-masuk-provinsi', compact('var','subSatuanKerja', 'spesies', 'provinsiAsal', 'helper'))->setPaper('a3', 'landscape');
                return $pdf->stream('laporan-ternak-masuk-provinsi.pdf');
            }else if($request->format == 'Excel'){
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=laporan-ternak-masuk-provinsi.xls");//ganti nama sesuai keperluan
                header("Pragma: no-cache");
                header("Expires: 0");
                return view('laporan.pllt.laporan-ternak-masuk-provinsi', compact('var','subSatuanKerja', 'spesies', 'provinsiAsal', 'helper'));
            }
        }
    }

    public function formCetakTernakLewat()
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Ternak Lewat')) return view('errors.403');

        $var['listPllt'] = [];
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['listPllt'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listPllt'] = SubSatuanKerja::where('satuan_kerja_id', '2')->pluck('sub_satuan_kerja','id')->all();
        }
        $var['dari_tanggal'] = $this->bulan;

        return view('laporan.pllt.form-ternak-lewat', compact('var'));
    }

    public function TernakLewatPrev(Request $request){
        set_time_limit(0);
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['jenisForm'] = 'Ternak Lewat';
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $subSatuanKerjaId = $subSatuanKerja->id;
        $spesies = Spesies::orderBy('id', 'desc')->get();
        $var['periode'] = strtoupper(tanggal_format_indonesia($var['dari_tanggal']))." s/d ".strtoupper(tanggal_format_indonesia($var['sampai_tanggal']));
        $helper = new LaporanHelper();

        if($request->jenis == 'kota'){
            $kotaAsal = DB::table('pllt')->select('kabupaten_asal_id')->distinct()->where('jenis_form', $var['jenisForm'])
                    ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                    ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                        $queryIn->select('id')
                            ->from('users')
                            ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                    })->get();

            return view('laporan.pllt.laporan-ternak-lewat-prev',compact('var','subSatuanKerja', 'spesies', 'kotaAsal', 'helper'));
        }else if($request->jenis == 'provinsi'){
            $provinsiTujuan = DB::table('pllt')->select('provinsi_tujuan_id')->distinct()->where('jenis_form', $var['jenisForm'])
                    ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                    ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                        $queryIn->select('id')
                            ->from('users')
                            ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                    })->get();

                    return view('laporan.pllt.laporan-ternak-lewat-provinsi-prev',compact('var','subSatuanKerja', 'spesies', 'provinsiAsal', 'helper'));
        }
    }

    public function cetakTernakLewat(Request $request)
    {
        set_time_limit(0);
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['jenisForm'] = 'Ternak Lewat';
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $subSatuanKerjaId = $subSatuanKerja->id;
        $spesies = Spesies::orderBy('id', 'desc')->get();
        $var['periode'] = strtoupper(tanggal_format_indonesia($var['dari_tanggal']))." s/d ".strtoupper(tanggal_format_indonesia($var['sampai_tanggal']));
        $helper = new LaporanHelper();

        if($request->jenis == 'kota'){
            $kotaAsal = DB::table('pllt')->select('kabupaten_asal_id')->distinct()->where('jenis_form', $var['jenisForm'])
                    ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                    ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                        $queryIn->select('id')
                            ->from('users')
                            ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                    })->get();

            if($request->format == 'PDF'){
                $pdf = PDF::loadView('laporan.pllt.laporan-ternak-lewat', compact('var','subSatuanKerja', 'spesies', 'kotaAsal', 'helper'))->setPaper('a3', 'landscape');
                return $pdf->stream('laporan-ternak-lewat.pdf');
            }else if($request->format == 'Excel'){
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=laporan-ternak-lewat.xls");//ganti nama sesuai keperluan
                header("Pragma: no-cache");
                header("Expires: 0");
                return view('laporan.pllt.laporan-ternak-lewat', compact('var','subSatuanKerja', 'spesies', 'kotaAsal', 'helper'));
            }
        }else if($request->jenis == 'provinsi'){
            $provinsiTujuan = DB::table('pllt')->select('provinsi_tujuan_id')->distinct()->where('jenis_form', $var['jenisForm'])
                    ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                    ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                        $queryIn->select('id')
                            ->from('users')
                            ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                    })->get();

            if($request->format == 'PDF'){
                $pdf = PDF::loadView('laporan.pllt.laporan-ternak-lewat-provinsi', compact('var','subSatuanKerja', 'spesies', 'provinsiTujuan', 'helper'))->setPaper('a3', 'landscape');
                return $pdf->stream('laporan-ternak-lewat-provinsi.pdf');
            }else if($request->format == 'Excel'){
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=laporan-ternak-lewat-provinsi.xls");//ganti nama sesuai keperluan
                header("Pragma: no-cache");
                header("Expires: 0");
                return view('laporan.pllt.laporan-ternak-lewat-provinsi', compact('var','subSatuanKerja', 'spesies', 'provinsiTujuan', 'helper'));
            }
        }
    }

    public function formCetakTernakKeluar()
    {
        if(!Auth::user()->hasPermissionTo('Read Laporan Ternak Keluar')) return view('errors.403');

        $var['listPllt'] = [];
        if(Auth::user()->view_data==3 || Auth::user()->view_data==4){
            $var['listPllt'] = SubSatuanKerja::where('id', Auth::user()->sub_satuan_kerja_id)->pluck('sub_satuan_kerja','id')->all();
        }else if(Auth::user()->view_data==1 || Auth::user()->view_data==2){
            $var['listPllt'] = SubSatuanKerja::where('satuan_kerja_id', '2')->pluck('sub_satuan_kerja','id')->all();
        }
        $var['dari_tanggal'] = $this->bulan;

        return view('laporan.pllt.form-ternak-keluar', compact('var'));
    }

    public function TernakKeluarPrev(Request $request){
        set_time_limit(0);
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['jenisForm'] = 'Ternak Keluar';
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $subSatuanKerjaId = $subSatuanKerja->id;
        $spesies = Spesies::orderBy('id', 'desc')->get();
        $var['periode'] = strtoupper(tanggal_format_indonesia($var['dari_tanggal']))." s/d ".strtoupper(tanggal_format_indonesia($var['sampai_tanggal']));
        $helper = new LaporanHelper();

        if($request->jenis == 'kota'){
            $kotaAsal = DB::table('pllt')->select('kabupaten_asal_id')->distinct()->where('jenis_form', $var['jenisForm'])
                    ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                    ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                        $queryIn->select('id')
                            ->from('users')
                            ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                    })->get();

            return view('laporan.pllt.laporan-ternak-keluar-prev',compact('var','subSatuanKerja', 'spesies', 'kotaAsal', 'helper'));
        }else if($request->jenis == 'provinsi'){
            $provinsiTujuan = DB::table('pllt')->select('provinsi_tujuan_id')->distinct()->where('jenis_form', $var['jenisForm'])
                    ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                    ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                        $queryIn->select('id')
                            ->from('users')
                            ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                    })->get();

                    return view('laporan.pllt.laporan-ternak-keluar-provinsi-prev',compact('var','subSatuanKerja', 'spesies', 'provinsiAsal', 'helper'));
        }
    }

    public function cetakTernakKeluar(Request $request)
    {
        set_time_limit(0);
        $var['dari_tanggal'] = Carbon::parse($request->dari_tanggal)->format('Y-m-d');
        $var['sampai_tanggal'] = Carbon::parse($request->sampai_tanggal)->format('Y-m-d');
        $var['subSatuanKerjaId'] = $request->sub_satuan_kerja_id;
        $var['jenisForm'] = 'Ternak Keluar';
        $subSatuanKerja = SubSatuanKerja::find($var['subSatuanKerjaId']);
        $subSatuanKerjaId = $subSatuanKerja->id;
        $spesies = Spesies::orderBy('id', 'desc')->get();
        $var['periode'] = strtoupper(tanggal_format_indonesia($var['dari_tanggal']))." s/d ".strtoupper(tanggal_format_indonesia($var['sampai_tanggal']));
        $helper = new LaporanHelper();

        if($request->jenis == 'kota'){
            $kotaAsal = DB::table('pllt')->select('kabupaten_asal_id')->distinct()->where('jenis_form', $var['jenisForm'])
                    ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                    ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                        $queryIn->select('id')
                            ->from('users')
                            ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                    })->get();

            if($request->format == 'PDF'){
                $pdf = PDF::loadView('laporan.pllt.laporan-ternak-keluar', compact('var','subSatuanKerja', 'spesies', 'kotaAsal', 'helper'))->setPaper('a3', 'landscape');
                return $pdf->stream('laporan-ternak-keluar.pdf');
            }else if($request->format == 'Excel'){
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=laporan-ternak-keluar.xls");//ganti nama sesuai keperluan
                header("Pragma: no-cache");
                header("Expires: 0");
                return view('laporan.pllt.laporan-ternak-keluar', compact('var','subSatuanKerja', 'spesies', 'kotaAsal', 'helper'));
            }
        }else if($request->jenis == 'provinsi'){
            $provinsiTujuan = DB::table('pllt')->select('provinsi_tujuan_id')->distinct()->where('jenis_form', $var['jenisForm'])
                    ->whereBetween('tanggal_dokumen', [$var['dari_tanggal'], $var['sampai_tanggal']])
                    ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                        $queryIn->select('id')
                            ->from('users')
                            ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                    })->get();

            if($request->format == 'PDF'){
                $pdf = PDF::loadView('laporan.pllt.laporan-ternak-keluar-provinsi', compact('var','subSatuanKerja', 'spesies', 'provinsiTujuan', 'helper'))->setPaper('a3', 'landscape');
                return $pdf->stream('laporan-ternak-keluar-provinsi.pdf');
            }else if($request->format == 'Excel'){
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=laporan-ternak-keluar-provinsi.xls");//ganti nama sesuai keperluan
                header("Pragma: no-cache");
                header("Expires: 0");
                return view('laporan.pllt.laporan-ternak-keluar-provinsi', compact('var','subSatuanKerja', 'spesies', 'provinsiTujuan', 'helper'));
            }
        }
    }
}
