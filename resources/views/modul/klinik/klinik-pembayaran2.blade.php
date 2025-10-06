<html>
	<head>
	    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Sibavet">
        <meta name="author" content="Visualmedia Semarang">
        <link rel="icon" href="{{ asset('fabadmin/images/favicon.ico') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ env('APP_NAME', 'Laravel') }}</title>

        <style>
            @page{
			size:auto;
			margin:5mm;
		}
		body{
			background-color:#ffffff;
			
			margin:0px;
		}
		
        </style>
	</head>
	<body>
        <div style="float:left;">
			<img src="{{asset('fabadmin/images/logo-laporan.png')}}" width="120" height="120">
		</div>
		<div style="margin:auto;padding-left:-30px;">
		<center>
		   <b> 
		   <h4>
			DINAS PETERNAKAN DAN KESEHATAN HEWAN<br>
			PROVINSI JAWA TENGAH<BR>
			BALAI VETERINER SEMARANG<BR>
			</h4>
			<h3 style="margin-top:-10px">KLINIK HEWAN</h3>
			<h5 style="margin-top:-10px">
				{{$dataklinik->alamat}} Telepon {{$dataklinik->telp}}
			</h5>
		   </b> 
		</center>
		<hr style="border:1.5px solid black"><hr style="border:1.5px solid black; margin-top:-7px;">
		</div>
		
		<div>
			<center>
			<h3>
			<b><u>Kwitansi Pembayaran</u></b>
			</h3>
			</center>
		</div>
		<div align="left">
			<table width="100%">
				<tr>
					<td><p>Diterima Dari</p></td><td>: {{$var['curr_klinik']->nama_pemilik}}</td>
					<td align="right">No Kwitansi : {{$var['curr_klinik']->no_kwitansi}}</td>
				</tr>
				
				<tr>
					<td><p>Uang Sejumlah</p></td><td>: Rp. {{number_format($var['jumlah_uang'],"0","",".")}}</td>
				</tr>
				<tr>
					<td><p>Guna Pembayaran</p></td><td>: </td>
				</tr>
			</table>
		</div>
		<br />
		<table style="border-collapse:collapse;border:1px solid gray;" width="90%" align="center">
			<thead>
				<tr class="bg-info" style="border-collapse:collapse;border:1px solid gray;">
					<td style="border-collapse:collapse;border:1px solid gray;">No. </td>
					<td style="border-collapse:collapse;border:1px solid gray;">Pelayanan</td>
					<td style="border-collapse:collapse;border:1px solid gray;">Tarif</td>
					
				</tr>
			</thead>
			<input type="hidden" name="klinik_terapi_id" value={{$var['curr_klinik']->id}}>
			<tbody id="tbl-pembayaran">
				@if(!empty($var['klinik_dosis']))
					@php 
						$i = 1; 
						$pengobatan = 0;
						$total = 0;
					@endphp
					@foreach($var['klinik_dosis'] as $dosis)
						
						@if($pengobatan == 0 && $dosis->tindakan == 2)
							@php $pad = $var['helper']->getHarga($dosis->tindakan,$var['curr_klinik']->klinik->spesies_id) @endphp
							<tr class="tbl{{$i}}" style="border-collapse:collapse;border:1px solid gray;">
								<td style="border-collapse:collapse;border:1px solid gray;">{{$i}} <input type="hidden" class="counter" value="{{$i}}"></td>
								<td style="border-collapse:collapse;border:1px solid gray;">
									<input type="hidden" name="tindakan_id[]" value="{{$dosis->tindakan}}">
									{{$pad->nama_pelayanan}}
									
									<input type="hidden" name="spesies_id[]" value={{$var['curr_klinik']->klinik->spesies_id}}>
								</td>
								<td style="border-collapse:collapse;border:1px solid gray;align:right" align="right" >
									<input type="hidden" name="terapi_id[]" value="2575">
									<input type="hidden" name="tarif[]" id="tarif{{$i}}" value="{{$pad->tarif}}">
									Rp. {{number_format($pad->tarif,0,",",".")}}
								</td>
								
							</tr>
							@php 
								$total += $pad->tarif;
								$pengobatan = 1; 
								$i++; 
							@endphp
						@elseif($pengobatan == 1 && $dosis->tindakan == 2)
						
						@else
							@php $pad = $var['helper']->getHarga($dosis->tindakan,$var['curr_klinik']->klinik->spesies_id,$dosis->terapi_id) @endphp
							@if(!empty($pad))
								<tr class="tbl{{$i}}" style="border-collapse:collapse;border:1px solid gray;">
									<td style="border-collapse:collapse;border:1px solid gray;">{{$i}} <input type="hidden" class="counter" value="{{$i}}"></td>
									<td style="border-collapse:collapse;border:1px solid gray;">
										<input type="hidden" name="tindakan_id[]" value="{{$dosis->tindakan}}">
										{{$pad->nama_pelayanan}}
										<input type="hidden" name="spesies_id[]" value={{$var['curr_klinik']->klinik->spesies_id}}>
										
									</td>
									<td align="right" style="text-align:right" style="border-collapse:collapse;border:1px solid gray;">
										<input type="hidden" name="terapi_id[]" value="{{$dosis->terapi_id}}">
										<input type="hidden" name="tarif[]" id="tarif{{$i}}" value="{{$pad->tarif}}">
										Rp. {{number_format($pad->tarif,0,",",".")}}
									</td>
									
								</tr>
								@php 
									$total += $pad->tarif;
									$i++; 
								@endphp
							@else
								@php continue; @endphp
							@endif
						@endif
						
						
						
					@endforeach
				@endif
				@if(!empty($var['layan']))
					@foreach($var['layan'] as $layan)
						
						
							
							<tr class="tbl'+counter+'" style="border-collapse:collapse;border:1px solid gray;">
								<td style="border-collapse:collapse;border:1px solid gray;">{{$i}}</td>
								<td style="border-collapse:collapse;border:1px solid gray;"><input type="hidden" name="nama_layanan[]" value="{{$layan->nama_layanan}}">{{$layan->nama_layanan}}</td>
								<td align="right" style="text-align:right" style="border-collapse:collapse;border:1px solid gray;"><input type="hidden" name="tarif_layanan[]" value="{{$layan->tarif}}" id="tarif{{$i}}">Rp. {{number_format($layan->tarif,0,"",".")}}</td>
							</tr>
							@php 
								$total += $layan->tarif;
								$pengobatan = 1; 
								$i++; 
							@endphp
						
						
						
						
					@endforeach
				@endif
			
			</tbody>
			<tfoot>
				<tr class="bg-secondary">
					<th colspan=2><b>Total <input type="hidden" name="total" id="total" value="{{$total}}"></b></th>
					<th align="right" style="text-align:right" ><b id="total_view">Rp. {{number_format($total,0,",",".")}}</b></th>
				</tr>
			</tfoot>
		</table>
		<p>Dasar Peraturan Gubernur Jawa Tengah Nomor 25 Tahun 2019 Tentang Perubahan Tarif Retribusi Daerah Provinsi Jawa Tengah</p>
		<div align="right">
			
		</div>
	</body>
</html>
