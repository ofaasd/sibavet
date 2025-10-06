<?php

namespace App\Http\Controllers\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pengaturan\User;
use Illuminate\Support\Facades\DB;
use App\Models\Indonesia\Kota;
use App\Models\Indonesia\Provinsi;
use App\Models\MasterData\Spesies;
use App\Models\MasterData\JenisContoh;
use App\Models\MasterData\JenisPengujian;
use App\Models\MasterData\SeksiLaboratorium;
use App\Models\MasterData\Ras;
use App\Models\Modul\Klinik;
use App\Models\Modul\KlinikTerapi;

class LaporanHelper
{
    public function jumlahPasienHewan($dariTanggal, $sampaiTanggal,$jenis ,$subSatuanKerjaId, $terapiId,$spesiesId)
    {        
            if($jenis == 'Vaksinasi'){
                if($spesiesId == 'ayam'){
                    $jumlah = Klinik::whereIn('klinik.spesies_id',[286,287,288])->join('klinik_terapi','klinik.id','=','klinik_terapi.klinik_id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.terapi_id', $terapiId)->where('klinik_terapi.tindakan',0)->groupBy('klinik.spesies_id')
					->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
						$queryIn->select('id')
							->from('users')
							->where('sub_satuan_kerja_id', $subSatuanKerjaId);
					})->count();
					return $jumlah;
                }elseif($spesiesId == 'lain'){
                    $jumlah = Klinik::whereNotIn('klinik.spesies_id',[5,193,291,9,6,286,287,288])->join('klinik_terapi','klinik.id','=','klinik_terapi.klinik_id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.terapi_id', $terapiId)->where('klinik_terapi.tindakan',0)->groupBy('klinik.spesies_id')
                    ->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
                        $queryIn->select('id')
                            ->from('users')
                            ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                    })->count();
					return $jumlah;
                }else{
                    //$jumlah = Klinik::where('klinik.spesies_id',$spesiesId)->join('klinik_terapi','klinik.id','=','klinik_terapi.klinik_id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.terapi_id', $terapiId)->where('klinik_terapi.tindakan',0)->groupBy('klinik.spesies_id')
                    /* $jumlah = Klinik::where('klinik.spesies_id',$spesiesId)
						->join('klinik_terapi','klinik.id','=','klinik_terapi.klinik_id')
						->join('klinik_dosis','klinik_terapi.id','=','klinik_dosis.klinik_id')
						->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.terapi_id', $terapiId)->where('klinik_dosis.tindakan',0)->where('klinik_dosis.terapi_id', $terapiId)->groupBy('klinik.spesies_id')
					->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
						$queryIn->select('id')
							->from('users')
							->where('sub_satuan_kerja_id', $subSatuanKerjaId);
					}) */
					$jumlah = KlinikTerapi::join('klinik_dosis','klinik_terapi.id','=','klinik_dosis.klinik_id')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->where('klinik.spesies_id',$spesiesId)->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_dosis.tindakan',1)->where('klinik_dosis.terapi_id', $terapiId)
					->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
						$queryIn->select('id')
							->from('users')
							->where('sub_satuan_kerja_id', $subSatuanKerjaId);
					})->count();
					return $jumlah;
                }                                
            }elseif($jenis == 'Operasi'){
                if($spesiesId == 'ayam'){
                    /* $jumlah = DB::table('klinik_terapi')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.terapi_id', $terapiId)->where('klinik_terapi.tindakan','4')->whereIn('klinik.spesies_id',[286,287,288])
					->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
						$queryIn->select('id')
							->from('users')
							->where('sub_satuan_kerja_id', $subSatuanKerjaId);
					})->count(); */
					$jumlah = KlinikTerapi::join('klinik_dosis','klinik_terapi.id','=','klinik_dosis.klinik_id')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->whereIn('klinik.spesies_id',[286,287,288])->where('klinik_dosis.tindakan',5)->where('klinik_dosis.terapi_id', $terapiId)->count();
					return $jumlah;
                }elseif($spesiesId == 'lain'){
                   /*  $jumlah = DB::table('klinik_terapi')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.terapi_id', $terapiId)->where('klinik_terapi.tindakan','4')->whereNotIn('klinik.spesies_id',[5,193,291,9,6,286,287,288])
					->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
						$queryIn->select('id')
							->from('users')
							->where('sub_satuan_kerja_id', $subSatuanKerjaId);
					})->count(); */
					$jumlah = KlinikTerapi::join('klinik_dosis','klinik_terapi.id','=','klinik_dosis.klinik_id')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->whereNotIn('klinik.spesies_id',[5,193,291,9,6,286,287,288])->where('klinik_dosis.tindakan',5)->where('klinik_dosis.terapi_id', $terapiId)->count();
					return $jumlah;
                }else{
                    /* $jumlah = DB::table('klinik_terapi')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.terapi_id', $terapiId)->where('klinik_terapi.tindakan','4')->where('klinik.spesies_id',$spesiesId)
					->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
						$queryIn->select('id')
							->from('users')
							->where('sub_satuan_kerja_id', $subSatuanKerjaId);
					})->count(); */
					$jumlah = KlinikTerapi::join('klinik_dosis','klinik_terapi.id','=','klinik_dosis.klinik_id')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->where('klinik.spesies_id',$spesiesId)->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_dosis.tindakan',5)->where('klinik_dosis.terapi_id', $terapiId)->count();
					return $jumlah;
                }
                
            }elseif($jenis == 'Penyakit'){

                if($spesiesId == 'ayam'){
                    $jumlah = DB::table('klinik_terapi')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.diagnosa',$terapiId)->whereIn('klinik.spesies_id',[286,287,288])
					->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
						$queryIn->select('id')
							->from('users')
							->where('sub_satuan_kerja_id', $subSatuanKerjaId);
					})->count();
					return $jumlah;
                }elseif($spesiesId == 'lain'){
                    $jumlah = DB::table('klinik_terapi')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.diagnosa',$terapiId)->whereNotIn('klinik.spesies_id',[5,193,291,9,6,286,287,288])
					->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
						$queryIn->select('id')
							->from('users')
							->where('sub_satuan_kerja_id', $subSatuanKerjaId);
					})->count();
					return $jumlah;
                }else{
                    $jumlah = DB::table('klinik_terapi')->join('klinik','klinik_terapi.klinik_id','=','klinik.id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik_terapi.diagnosa',$terapiId)->where('klinik.spesies_id',$spesiesId)
					->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
						$queryIn->select('id')
							->from('users')
							->where('sub_satuan_kerja_id', $subSatuanKerjaId);
					})->count();
					return $jumlah;
                }                
            }
    }

    public function kolomKota($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $kotaAsalId, $jenisForm)
    {
        $kotaAsal = Kota::find($kotaAsalId);
        $kotaTujuan = DB::table('regencies')->wherein('id',  function ($queryIn) use ($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $kotaAsalId, $jenisForm){
                        $queryIn->select('kabupaten_tujuan_id')->distinct()->from('pllt')->where('jenis_form', $jenisForm)
                        ->whereBetween('tanggal_dokumen', [$dariTanggal, $sampaiTanggal])
                        ->where('kabupaten_asal_id', $kotaAsalId)
                        ->whereIn('input_by', function ($queryIn2) use ($subSatuanKerjaId) {
                            $queryIn2->select('id')
                                ->from('users')
                                ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                        });
                    })->get();

        $var['kotaAsal'] = $kotaAsal;
        $var['kotaTujuan'] = $kotaTujuan;

        return $var;
    }

    public function jumlahPopulasi($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $jenisForm, $kotaAsalId, $kotaTujuanId, $spesies, $ras, $jenisKelamin)
    {
        if($jenisKelamin == 'Jantan'){
            $queryJenisKelamin = 'sum(jumlah_jantan) as jumlah';
        }else if($jenisKelamin == 'Betina'){
            $queryJenisKelamin = 'sum(jumlah_betina) as jumlah';
        }else if($jenisKelamin == 'JanBet'){
            $queryJenisKelamin = 'sum(jumlah) as jumlah';
        }

        $queryJumlah = DB::table('pllt_hewan')->selectRaw($queryJenisKelamin)
                    ->whereIn('pllt_id', function ($queryIn) use ($dariTanggal, $sampaiTanggal, $jenisForm, $subSatuanKerjaId, $kotaAsalId, $kotaTujuanId){
                        $queryIn->select('id')->from('pllt')->whereBetween('tanggal_dokumen', [$dariTanggal, $sampaiTanggal])
                            ->where('jenis_form', $jenisForm)->where('kabupaten_asal_id', $kotaAsalId)->where('kabupaten_tujuan_id', $kotaTujuanId)
                            ->whereIn('input_by', function ($queryIn2) use ($subSatuanKerjaId){
                                $queryIn2->select('id')
                                    ->from('users')
                                    ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                            });
                    });

        $dataSpesies = Spesies::where('nama_spesies', $spesies)->first();
        if($ras != ''){
            $dataRas = Ras::where('nama_ras', $ras)->where('spesies_id', @$dataSpesies->id)->first();
            $queryJumlah->where('jenis_hewan_id', @$dataRas->id);
        }
        $jumlah = $queryJumlah->where('jenis_spesies_id', @$dataSpesies->id)->first();

        $jumlahTernak =  $jumlah->jumlah;
        if($jumlahTernak=='') $jumlahTernak = 0;

        return $jumlahTernak;
    }
	
    public function jumlahDokumen($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $jenisForm, $kotaAsalId, $kotaTujuanId, $dokumen)
    {
        $queryJumlah = DB::table('pllt')->whereBetween('tanggal_dokumen', [$dariTanggal, $sampaiTanggal])->where('jenis_form', $jenisForm)
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->where('kabupaten_asal_id', $kotaAsalId)->where('kabupaten_tujuan_id', $kotaTujuanId);
        $jumlah = $queryJumlah->where('jenis_dokumen', $dokumen)->count();

        if($jumlah=='') $jumlah = 0;

        return $jumlah;
    }
	public function jumlahpad($tanggal){
		$kode = Auth::user()->subSatuanKerja->kode_klinik;
		$queryJumlah = DB::table("klinik_terapi")->join("klinik","klinik.id","klinik_terapi.klinik_id")->join("pembayaran","klinik_terapi.id","pembayaran.klinik_terapi_id")->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->where("tanggal_periksa",$tanggal)->sum("pembayaran.total");
		return $queryJumlah;
	}
	public function detailpad($tanggal){
		$kode = Auth::user()->subSatuanKerja->kode_klinik;
		$queryJumlah = DB::table("klinik_terapi")->join("pembayaran","klinik_terapi.id","pembayaran.klinik_terapi_id")->where("klinik_terapi.no_pasien","like","%" . $kode . "%")->where("tanggal_periksa",$tanggal)->get();
		return $queryJumlah;
	}
	
    //--------------------------------------------------------------------------------------------

    public function kolomProvinsiAsal($provinsiAsalId)
    {
        $provinsiAsal = Provinsi::find($provinsiAsalId);
        $var['provinsiAsal'] = $provinsiAsal;
        return $var;
    }

    public function jumlahPopulasiProvinsiAsal($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $jenisForm, $provinsiAsalId, $spesies, $ras, $jenisKelamin)
    {
        if($jenisKelamin == 'Jantan'){
            $queryJenisKelamin = 'sum(jumlah_jantan) as jumlah';
        }else if($jenisKelamin == 'Betina'){
            $queryJenisKelamin = 'sum(jumlah_betina) as jumlah';
        }else if($jenisKelamin == 'JanBet'){
            $queryJenisKelamin = 'sum(jumlah) as jumlah';
        }

        $queryJumlah = DB::table('pllt_hewan')->selectRaw($queryJenisKelamin)
                    ->whereIn('pllt_id', function ($queryIn) use ($dariTanggal, $sampaiTanggal, $jenisForm, $subSatuanKerjaId, $provinsiAsalId){
                        $queryIn->select('id')->from('pllt')->whereBetween('tanggal_dokumen', [$dariTanggal, $sampaiTanggal])
                            ->where('jenis_form', $jenisForm)->where('provinsi_asal_id', $provinsiAsalId)
                            ->whereIn('input_by', function ($queryIn2) use ($subSatuanKerjaId){
                                $queryIn2->select('id')
                                    ->from('users')
                                    ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                            });
                    });

        $dataSpesies = Spesies::where('nama_spesies', $spesies)->first();
        if($ras != ''){
            $dataRas = Ras::where('nama_ras', $ras)->where('spesies_id', @$dataSpesies->id)->first();
            $queryJumlah->where('jenis_hewan_id', @$dataRas->id);
        }
        $jumlah = $queryJumlah->where('jenis_spesies_id', @$dataSpesies->id)->first();

        $jumlahTernak =  $jumlah->jumlah;
        if($jumlahTernak=='') $jumlahTernak = 0;

        return $jumlahTernak;
    }
	public function showRaw($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $jenisForm, $provinsiAsalId, $spesies, $ras, $jenisKelamin)
    {
        if($jenisKelamin == 'Jantan'){
            $queryJenisKelamin = 'sum(jumlah_jantan) as jumlah';
        }else if($jenisKelamin == 'Betina'){
            $queryJenisKelamin = 'sum(jumlah_betina) as jumlah';
        }else if($jenisKelamin == 'JanBet'){
            $queryJenisKelamin = 'sum(jumlah) as jumlah';
        }

        $queryJumlah = DB::table('pllt_hewan')->selectRaw($queryJenisKelamin)
                    ->whereIn('pllt_id', function ($queryIn) use ($dariTanggal, $sampaiTanggal, $jenisForm, $subSatuanKerjaId, $provinsiAsalId){
                        $queryIn->select('id')->from('pllt')->whereBetween('tanggal_dokumen', [$dariTanggal, $sampaiTanggal])
                            ->where('jenis_form', $jenisForm)->where('provinsi_asal_id', $provinsiAsalId)
                            ->whereIn('input_by', function ($queryIn2) use ($subSatuanKerjaId){
                                $queryIn2->select('id')
                                    ->from('users')
                                    ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                            });
                    });

        $dataSpesies = Spesies::where('nama_spesies', $spesies)->first();
        if($ras != ''){
            $dataRas = Ras::where('nama_ras', $ras)->where('spesies_id', @$dataSpesies->id)->first();
            $queryJumlah->where('jenis_hewan_id', @$dataRas->id);
        }
        $jumlah = $queryJumlah->where('jenis_spesies_id', @$dataSpesies->id);
		
		
		$query = str_replace(array('?'), array('\'%s\''), $jumlah->toSql());
		$query = vsprintf($query, $jumlah->getBindings());
		dump($query);

		$result = $jumlah->get();
        //$jumlahTernak =  $jumlah->toSql();
        //if($jumlahTernak=='') $jumlahTernak = 0;

        return $result;
    }

    public function jumlahDokumenProvinsiAsal($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $jenisForm, $provinsiAsalId, $dokumen)
    {
        $queryJumlah = DB::table('pllt')->whereBetween('tanggal_dokumen', [$dariTanggal, $sampaiTanggal])->where('jenis_form', $jenisForm)
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->where('provinsi_asal_id', $provinsiAsalId);
        $jumlah = $queryJumlah->where('jenis_dokumen', $dokumen)->count();

        if($jumlah=='') $jumlah = 0;

        return $jumlah;
    }

    //----------------------------------------------------------------------------------------------

    public function kolomProvinsiTujuan($provinsiAsalId)
    {
        $provinsiTujuan = Provinsi::find($provinsiAsalId);
        $var['provinsiTujuan'] = $provinsiTujuan;
        return $var;
    }

    public function jumlahPopulasiProvinsiTujuan($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $jenisForm, $provinsiTujuanId, $spesies, $ras, $jenisKelamin)
    {
        if($jenisKelamin == 'Jantan'){
            $queryJenisKelamin = 'sum(jumlah_jantan) as jumlah';
        }else if($jenisKelamin == 'Betina'){
            $queryJenisKelamin = 'sum(jumlah_betina) as jumlah';
        }else if($jenisKelamin == 'JanBet'){
            $queryJenisKelamin = 'sum(jumlah) as jumlah';
        }

        $queryJumlah = DB::table('pllt_hewan')->selectRaw($queryJenisKelamin)
                    ->whereIn('pllt_id', function ($queryIn) use ($dariTanggal, $sampaiTanggal, $jenisForm, $subSatuanKerjaId, $provinsiTujuanId){
                        $queryIn->select('id')->from('pllt')->whereBetween('tanggal_dokumen', [$dariTanggal, $sampaiTanggal])
                            ->where('jenis_form', $jenisForm)->where('provinsi_tujuan_id', $provinsiTujuanId)
                            ->whereIn('input_by', function ($queryIn2) use ($subSatuanKerjaId){
                                $queryIn2->select('id')
                                    ->from('users')
                                    ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                            });
                    });

        $dataSpesies = Spesies::where('nama_spesies', $spesies)->first();
        if($ras != ''){
            $dataRas = Ras::where('nama_ras', $ras)->where('spesies_id', @$dataSpesies->id)->first();
            $queryJumlah->where('jenis_hewan_id', @$dataRas->id);
        }
        $jumlah = $queryJumlah->where('jenis_spesies_id', @$dataSpesies->id)->first();

        $jumlahTernak =  $jumlah->jumlah;
        if($jumlahTernak=='') $jumlahTernak = 0;

        return $jumlahTernak;
    }

    public function jumlahDokumenProvinsiTujuan($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $jenisForm, $provinsiTujuanId, $dokumen)
    {
        $queryJumlah = DB::table('pllt')->whereBetween('tanggal_dokumen', [$dariTanggal, $sampaiTanggal])->where('jenis_form', $jenisForm)
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->where('provinsi_tujuan_id', $provinsiTujuanId);
        $jumlah = $queryJumlah->where('jenis_dokumen', $dokumen)->count();

        if($jumlah=='') $jumlah = 0;

        return $jumlah;
    }

    //-----------------------------------------------------------------------------------------------------

    public function kolomHewan($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $kotaAsalId)
    {
        $kotaAsal = Kota::find($kotaAsalId);
        $jenisHewan = DB::table('spesies')->wherein('id',  function ($queryIn) use ($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $kotaAsalId){
                        $queryIn->select('jenis_hewan_id')->distinct()->from('laboratorium')
                        ->whereBetween('created_at', [$dariTanggal, $sampaiTanggal])->where('asal_contoh_id', $kotaAsalId)
                        ->whereIn('input_by', function ($queryIn2) use ($subSatuanKerjaId) {
                            $queryIn2->select('id')
                                ->from('users')
                                ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                        });
                    })->get();

        $var['kotaAsal'] = $kotaAsal;
        $var['jenisHewan'] = $jenisHewan;

        return $var;
    }

    public function jumlahJenis($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $kotaAsalId, $spesiesId, $jenisSampel)
    {
        $sampel = JenisContoh::where('nama_sampel', $jenisSampel)->first();

        $queryJumlah = DB::table('laboratorium')->whereBetween('created_at', [$dariTanggal, $sampaiTanggal])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->where('asal_contoh_id', $kotaAsalId)->where('jenis_hewan_id', $spesiesId);
        $jumlah = $queryJumlah->where('jenis_contoh_id', @$sampel->id)->count();

        if($jumlah=='') $jumlah = 0;
        return $jumlah;
    }

    public function jumlahKelompokUji($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $kotaAsalId, $spesiesId, $kelompokUji)
    {
        $seksi = SeksiLaboratorium::where('seksi_laboratorium', $kelompokUji)->first();

        $queryJumlah = DB::table('laboratorium')->whereBetween('created_at', [$dariTanggal, $sampaiTanggal])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->where('asal_contoh_id', $kotaAsalId)->where('jenis_hewan_id', $spesiesId);
        $jumlah = $queryJumlah->where('seksi_laboratorium_id', @$seksi->id)->count();

        if($jumlah=='') $jumlah = 0;
        return $jumlah;
    }

    public function jumlahJenisUji($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $kotaAsalId, $spesiesId, $jenisUji)
    {
        $jenis = JenisPengujian::where('jenis_pengujian', $jenisUji)->first();

        $queryJumlah = DB::table('laboratorium')->whereBetween('created_at', [$dariTanggal, $sampaiTanggal])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->where('asal_contoh_id', $kotaAsalId)->where('jenis_hewan_id', $spesiesId);
        $jumlah = $queryJumlah->where('permintaan_uji_id', @$jenis->id)->count();

        if($jumlah=='') $jumlah = 0;
        return $jumlah;
    }

    public function jumlahHasilUji($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $kotaAsalId, $spesiesId, $hasilUji)
    {
        $queryJumlah = DB::table('laboratorium')->whereBetween('created_at', [$dariTanggal, $sampaiTanggal])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->where('asal_contoh_id', $kotaAsalId)->where('jenis_hewan_id', $spesiesId);
        $jumlah = $queryJumlah->where('hasil_pengujian', $hasilUji)->count();

        if($jumlah=='') $jumlah = 0;
        return $jumlah;
    }

    public function jumlahKegiatan($dariTanggal, $sampaiTanggal, $subSatuanKerjaId, $kotaAsalId, $spesiesId, $kegiatan)
    {
        $queryJumlah = DB::table('laboratorium')->whereBetween('created_at', [$dariTanggal, $sampaiTanggal])
                ->whereIn('input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->where('asal_contoh_id', $kotaAsalId)->where('jenis_hewan_id', $spesiesId);
        $jumlah = $queryJumlah->where('jenis_kegiatan', $kegiatan)->count();

        if($jumlah=='') $jumlah = 0;
        return $jumlah;
    }
	
	public function getPenyakit($id){
		$query = DB::table('penyakit')->select('penyakit')->where('id',$id)->first();
		return $query->penyakit;
	}
	public function getDosis($klinik_id,$tindakan,$terapi_id){
		$jumlah = DB::table("klinik_dosis")->where("klinik_id",$klinik_id)->where("tindakan",$tindakan)->where("terapi_id",$terapi_id)->first();
		$total = 0;
		if($jumlah){
			$total = $jumlah->dosis;
		}
		return $total;
	}
}
