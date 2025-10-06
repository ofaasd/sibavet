<?php

namespace App\Http\Controllers\Helpers;


use App\Models\MasterData\Obat;
use App\Models\MasterData\Operasi;
use App\Models\MasterData\DaftarHarga;
use App\Models\Modul\Pembayaran;

class KlinikHelper
{
	function testing(){
		return "asdasda berhasil";
	}
	function terapi($penang,$terapi_id){
		if($penang == 5){
			return Operasi::where("id",$terapi_id)->first()->tindakan;
		}else{
			return Obat::where("id",$terapi_id)->first()->obat;
		}
	}
	function getHarga($tindakan, $spesies_id, $terapi=0){
		if($tindakan == 2){
			$terapi = 2575;
		}
		$hasil = DaftarHarga::select("daftar_harga.*","spesies.nama_spesies")->join("spesies","daftar_harga.spesies_id","spesies.id")->where("spesies_id",$spesies_id)->where("tindakan",$tindakan)->where("terapi_id",$terapi)->first();
		
		return $hasil;
	}
	function getTotal($id){
		return pembayaran::where("klinik_terapi_id",$id)->first()->total;
	}
}