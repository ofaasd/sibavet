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

class LaporanHelper
{
    public function jumlahPasienHewan($dariTanggal, $sampaiTanggal,$jenis ,$subSatuanKerjaId, $spesiesId)
    {
        if($jenis == 'Vaksinasi' or $jenis == 'Pengobatan' or $jenis == 'Rawat Inap' or $jenis == 'Rawat Sehat'){
            if($jenis == 'Vaksinasi'){
                $jumlah = DB::table('klinik')->join('klinik_terapi','klinik.id','=','klinik_terapi.klinik_id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik.spesies_id', $spesiesId)->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik.spesies_id', $spesiesId)->where('klinik_terapi.tindakan',0)
                ->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->count();
        return $jumlah;
            }elseif($jenis == 'Pengobatan'){
                $jumlah = DB::table('klinik')->join('klinik_terapi','klinik.id','=','klinik_terapi.klinik_id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik.spesies_id', $spesiesId)->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik.spesies_id', $spesiesId)->where('klinik_terapi.tindakan',1)
                ->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->count();
        return $jumlah;
            }elseif($jenis == 'Rawat Inap'){
                $jumlah = DB::table('klinik')->join('klinik_terapi','klinik.id','=','klinik_terapi.klinik_id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik.spesies_id', $spesiesId)->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik.spesies_id', $spesiesId)->where('klinik_terapi.tindakan',2)
                ->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->count();
        return $jumlah;
            }else{
                $jumlah = DB::table('klinik')->join('klinik_terapi','klinik.id','=','klinik_terapi.klinik_id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik.spesies_id', $spesiesId)->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik.spesies_id', $spesiesId)->where('klinik_terapi.tindakan',3)
                ->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->count();
        return $jumlah;
            }            
        }elseif($jenis == 'Operasi'){
            $jumlah = DB::table('klinik')->join('klinik_terapi','klinik.id','=','klinik_terapi.klinik_id')->whereBetween('klinik_terapi.tanggal_periksa',[$dariTanggal,$sampaiTanggal])->where('klinik.spesies_id', $spesiesId)->where('klinik_terapi.tindakan',4)
                ->whereIn('klinik.input_by', function ($queryIn) use ($subSatuanKerjaId) {
                    $queryIn->select('id')
                        ->from('users')
                        ->where('sub_satuan_kerja_id', $subSatuanKerjaId);
                })->count();
        return $jumlah;
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
}
