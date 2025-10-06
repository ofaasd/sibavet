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
            table {width:100%;margin:5px 0px 5px 0px}
            h1,h2,h3,h4,h5 {padding:0 0 0 0;margin:0 0 0 0;line-height:1.4}
            .header tr td {vertical-align:top;}
            .header {
                border-bottom:4px double #222222;
                margin-bottom:5px;
            }
            div,p {
                margin:5px 0px 5px 0px;
            }
            .table_outer_border {border:1px solid #000000;padding:10px}

            .table-border {border-collapse: collapse;}
            .table-border tr td {
                border:1px solid #000000;
                vertical-align:top;
            }
            .table-border tr .bottom{
                border:1px solid #000000;
                vertical-align:top;
                border-bottom-style: none;
            }
            .table-border tr .bottom-top{
                border:1px solid #000000;
                vertical-align:top;
                border-bottom-style: none;
                border-top-style: none;
            }
            .table-border tr .top{
                border:1px solid #000000;
                vertical-align:top;
                border-top-style: none;
            }

            .table-border tr th {
                border:1px solid #000000;
                vertical-align: middle;
            }
            .table-header td {
                text-align:center;
                vertical-align:middle;
                font-weight:bold;
            }
            .table-no-border tr td {
                border:none;
                vertical-align:top;
            }

            div,p {font-size:13px;}
            table tr td {font-size:13px;}
            table tr th {font-size:13px;}

            .tengah {
                text-align: center;
            }
        </style>
	</head>
	<body>
        
    @if($var['jenis'] == 'Harian' || $var['jenis'] == 'utama')
		<center><h2>LAPORAN KEGIATAN </h2></center>
		<center><h2>{{$var['subSatuanKerja']->sub_satuan_kerja}}</h2></center>
		<center><h2>{{$var['subSatuanKerja']->alamat}}</h2></center>
        <br />
        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="7%"><b>Satker</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>{{ @$subSatuanKerja->sub_satuan_kerja }}</b></td>
                <td width="40%">&nbsp;</td>
                <td width="7%"><b>Periode</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>{{ $var['dari_tanggal'] }}</b></td>
                <td width="2%"><b>-</b></td>
                <td><b>{{ $var['sampai_tanggal'] }}</b></td>
            </tr>
        </table>
		<table class="table-border">
			<thead>
				<tr>
					<th rowspan=2>No.</th>
					<th rowspan=2>Tanggal</th>
					<th rowspan=2>Kegiatan</th>
					<th rowspan=2>Nama dan Alamat pemilik</th>
					<th rowspan=2>Nama Hewan</th>
					<th rowspan=2>Jenis Hewan</th>
					<th rowspan=2>Diagnosa</th>
					<th colspan="{{$var['cols_obat']}}">Pengobatan</th>
					<th colspan="{{$var['cols_vaksin']}}">Vaksinasi</th>
					<th colspan="{{$var['cols_operasi']}}">Operasi</th>
					<th rowspan=2>Tarif</th>
					
					
				</tr>
				<tr>
					@foreach($var['obat'] as $row)
						<th>{{$row->obat}}</th>
					@endforeach()
					@foreach($var['vaksin'] as $row)
						<th>{{$row->obat}}</th>
					@endforeach()
					@foreach($var['operasi'] as $row)
						<th>{{$row->tindakan}}</th>
					@endforeach()
					
				</tr>
			</thead>
			<tbody>
				@php $i = 1; $total = 0;$tanggal = "";$total_harian=0; @endphp
				@foreach($var['klinik'] as $klinik)
				@php
					if($tanggal != $klinik->tanggal_periksa){
						$tanggal = $klinik->tanggal_periksa;
						$total_harian = 0;
					}
					
				@endphp
					<tr>
						<td>{{$i}}</td>
						<td>{{$klinik->tanggal_periksa}}</td>
						<td>Pasif</td>
						<td>{{$klinik->klinik->pemilik->nama}}</td>
						<td>{{$klinik->klinik->nama_hewan}}</td>
						<td>{{$klinik->klinik->spesies->nama_spesies}}</td>
						<td>{{$klinik->penyakit}}</td>
						@foreach($var['obat'] as $row)
							<td>
								@if(empty($data_obat[$klinik->id][$row->id][2]))
									0
								@else
									
									@php 
										$pecah = explode(" ",$data_obat[$klinik->id][$row->id][2]);
										$convert = str_replace(',', '.', $pecah[0]);
										$angka = (float) $convert;
										$jumlah[$row->id] += $angka;
									@endphp
									{{$angka}}
								@endif
								
							</td>
						@endforeach
						@foreach($var['vaksin'] as $row)
							<td>
								@if(empty($data_obat[$klinik->id][$row->id][1]))
									0
								@else
									
									@php 
										$pecah = explode(" ",$data_obat[$klinik->id][$row->id][1]);
										$convert = str_replace(',', '.', $pecah[0]);
										$angka = (float) $convert;
										$jumlah[$row->id] += $angka;
									@endphp
									{{$angka}}
								@endif
								
							</td>
						@endforeach
						@foreach($var['operasi'] as $row)
							<td>
								@if(empty($data_obat[$klinik->id][$row->id][5]))
									0
								@else
									
									@php 
										$pecah = explode(" ",$data_obat[$klinik->id][$row->id][5]);
										$convert = str_replace(',', '.', $pecah[0]);
										$angka = (float) $convert;
										$jumlah_operasi[$row->id] += $angka;
									@endphp
									{{$angka}}
								@endif
								
							</td>
						@endforeach
						<td>
							Rp. {{number_format($var['tarif'][$klinik->id],2,",",".")}}
							@php
								$total_harian += $var['tarif'][$klinik->id];
							@endphp
						</td>
						<!-- <td>
							{{$total_harian}}
						</td>-->
					</tr>
					
				@php
					
					$total += $var['tarif'][$klinik->id];
					$i++; 
				@endphp
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan=7><b>Total</b></td>
					@foreach($var['obat'] as $row)
						<td>
							{{$jumlah[$row->id]}}
						</td>
					@endforeach
					@foreach($var['vaksin'] as $row)
						<td>
							{{$jumlah[$row->id]}}
						</td>
					@endforeach
					@foreach($var['operasi'] as $row)
						<td>
							{{$jumlah_operasi[$row->id]}}
						</td>
					@endforeach
					
					<td>
						Rp. {{number_format($total,2,",",".")}}
					</td>
				</tr>
			</tfoot>
		</table>
	@elseif($var['jenis'] == 'utama2')
		<center><h2>LAPORAN KEGIATAN </h2></center>
		<center><h2>KLINIK HEWAN SEMARANG</h2></center>
		<center><h2>Jl. Brigjen sudiarto no 134 Semarang-Jawa Tengah</h2></center>
        <br />
        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="7%"><b>Satker</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>{{ @$subSatuanKerja->sub_satuan_kerja }}</b></td>
                <td width="40%">&nbsp;</td>
                <td width="7%"><b>Periode</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>{{ $var['dari_tanggal'] }}</b></td>
                <td width="2%"><b>-</b></td>
                <td><b>{{ $var['sampai_tanggal'] }}</b></td>
            </tr>
        </table>
		<table class="table-border">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal</th>
					<th>Nama dan Alamat pemilik</th>
					<th>No. Telpon</th>
					<th>Jenis Hewan</th>
					<th>Nama Hewan</th>
					<th>Jumlah</th>
					<th>Umur</th>
					<th>Sinyalemen</th>
					<th>Anamnese</th>
					<th>Diagnosa</th>
					<th>Penganganan</th>
					<th>Terapi/Tindakan</th>
					<th>Keterangan</th>
					<th>Pemeriksa</th>
					<th>Paramedik Veteriner</th>
					<th>Retribusi</th>
					<th>No. Kwitansi</th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1; $total = 0;$tanggal = "";$total_harian=0; @endphp
				@foreach($var['klinik'] as $klinik)
				@php
					if($tanggal != $klinik->tanggal_periksa){
						$tanggal = $klinik->tanggal_periksa;
						$total_harian = 0;
					}
					
				@endphp
					<tr>
						<td>{{$i}}</td>
						<td>{{$klinik->tanggal_periksa}}</td>
						<td>{{$klinik->klinik->pemilik->nama}} - {{$klinik->klinik->pemilik->alamat}}</td>
						<td>{{$klinik->klinik->pemilik->telepon}}</td>
						<td>{{$klinik->klinik->spesies->nama_spesies}}</td>
						<td>{{$klinik->klinik->nama_hewan}}</td>
						<td>1</td>
						<td>{{$klinik->umur}}</td>
						<td>{{$klinik->signalement}}</td>
						<td>{{$klinik->anamnesia}}</td>
						<td>{{$penyakit[$klinik->diagnosa]}}</td>
						<td>{{$klinik_tindakan[$klinik->id]}}</td>
						<td>{{$terapitindakan[$klinik->id]}}</td>
						<td>{{$klinik->keterangan}}</td>
						<td>{{$pemeriksa[$klinik->pemeriksa]}}</td>
						<td>{{$klinik->paramedis}}</td>
						<td>
							Rp. {{number_format($var['tarif'][$klinik->id],2,",",".")}}
							@php
								$total_harian += $var['tarif'][$klinik->id];
							@endphp
						</td>	
						<td>{{ (!empty($var['kwitansi'][$klinik->id]))?$var['kwitansi'][$klinik->id]:"-"}}</td>
						<!-- <td>
							{{$total_harian}}
						</td>-->
					</tr>
					
				@php
					
					$total += $var['tarif'][$klinik->id];
					$i++; 
				@endphp
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan=16 align="center" valign="center"><b>Total</b></td>					
					<td>
						Rp. {{number_format($total,2,",",".")}}
					</td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	@elseif($var['jenis'] == 'pad')
		<center><h2>REKAP SETORAN PAD KLINIK HEWAN SEMARANG</h2></center>
        <br />
        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="7%"><b>Satker</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>{{ @$subSatuanKerja->sub_satuan_kerja }}</b></td>
                <td width="40%">&nbsp;</td>
                <td width="7%"><b>Periode</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>{{ $var['dari_tanggal'] }}</b></td>
                <td width="2%"><b>-</b></td>
                <td><b>{{ $var['sampai_tanggal'] }}</b></td>
            </tr>
        </table>
		@php
			$detailpad = $helper->detailpad('2022-01-10');
			$i = 1;
		@endphp
		<table class="table-border">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tanggal Penerimaan</th>
					<th>Jumlah</th>
					<th>Tanggal Setor</th>
					
					
				</tr>
			</thead>
			<tbody>
				@php $i = 1; $total = 0; $thisDate="" @endphp
				{{date('Y-m-d', strtotime($var['end']))}} 
					{{$var['end']}}
				@for ( $j = $var['begin']; $j <= $var['end']; $j = $j + 86400 )
					@php
						$thisDate = date( 'd-m-Y', $j );
						$thisDate2 = date( 'Y-m-d', $j );
						$total += $helper->jumlahpad($thisDate2);
					@endphp
					<tr>
						<td>{{$i}}</td>
						<td>{{$thisDate}}</td>
						<td>Rp. {{number_format($helper->jumlahpad($thisDate2),2,",",".")}}</td>
						<td>
							
						</td>
					</tr>
					@php
						$i++;
					@endphp
				@endfor
			</tbody>
			<tfoot>
				<tr>
					<td colspan=2><b>Total</b></td>
					<td>
						Rp. {{number_format($total,2,",",".")}}
					</td>
					<td></td>
				</tr>
			</tfoot>
		</table>
	@elseif($var['jenis'] == 'bulanan')
		<center><h2>REKAP LAPORAN BULANAN OBAT TERPAKAI</h2></center>
        <br />
        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="7%"><b>Satker</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>{{ @$subSatuanKerja->sub_satuan_kerja }}</b></td>
                <td width="40%">&nbsp;</td>
                <td width="7%"><b>Periode</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>{{ $var['tahun'] }}</b></td>
            </tr>
        </table>
		<table class="table-border">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama Obat</th>
					@foreach($var['bulan'] as $key=>$value)
						<th>{{$value}}</th>
					@endforeach
					<th><b>Total</b></th>
				</tr>
			</thead>
			<tbody>
				@php $i = 1; @endphp
				@foreach($var['obat'] as $obat)
					<tr>
					<td>{{$i}}</td>
					<td>{{$obat->obat}}</td>
					@foreach($var['bulan'] as $b=>$bulan)
						<td>{{$pengeluaran[$obat->id][$b]}}</td>
						
					@endforeach
					<td><b>{{$total[$obat->id]}}</b></td>
					</tr>
					@php $i++ @endphp
				@endforeach
			</tbody>
			<tfoot>
				
			</tfoot>
		</table>
	@endif
	</body>
</html>
