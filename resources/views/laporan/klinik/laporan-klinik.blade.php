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
				font-size:8px;
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
        <center><h2>DATA PELAYANAN KESEHATAN HEWAN</h2></center>
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
    @if($var['jenis'] == 'Vaksinasi')
        <table class="table-border">
            <thead>
                <tr>
                    <th width="15%" height="35px" style="text-align:center; font-size:14px; background-color: #c1c1c1;">Jenis Spesies</th>
                    
                        @foreach($var['vaksin'] as $vaksin)
							<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">{{$vaksin->obat}}</th>
						
						<!--<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Felocell 4</th>         
                        <th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Purevax RCP</th>  
                        <th style="text-align:center; font-size:14px; background-color: #c1c1c1;">DHPPi-2</th>
                        <th style="text-align:center; font-size:14px; background-color: #c1c1c1;">DHPPi-2 L</th>    
                        <th style="text-align:center; font-size:14px; background-color: #c1c1c1;">DHPPi-2 LR</th>    
                        <th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Rabies</th>    -->
						@endforeach
						<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Total</th>
                </tr>
            </thead>
            <tbody>
          
                <tr>
                <td>
                    Sapi
                </td>
				@foreach($var['vaksin'] as $vaksin)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $vaksin->id,193);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_vaksin'][$vaksin->id] += $jumlah;
						$var['jumlah_vaksin'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp
                </tr>

                <tr>
                <td>
                    Domba
                </td>
                @foreach($var['vaksin'] as $vaksin)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $vaksin->id,291);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_vaksin'][$vaksin->id] += $jumlah;
						$var['jumlah_vaksin'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp
                </tr>
                <tr>
                <td>
                    Kambing
                </td>
                @foreach($var['vaksin'] as $vaksin)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $vaksin->id,9);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_vaksin'][$vaksin->id] += $jumlah;
						$var['jumlah_vaksin'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp
                </tr>

                <tr>
                <td>
                    Ayam
                </td>
                @foreach($var['vaksin'] as $vaksin)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $vaksin->id,'ayam');
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_vaksin'][$vaksin->id] += $jumlah;
						$var['jumlah_vaksin'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp
                </tr>  

                <tr>
                <td>
                    Kucing
                </td>
                @foreach($var['vaksin'] as $vaksin)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $vaksin->id,5);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_vaksin'][$vaksin->id] += $jumlah;
						$var['jumlah_vaksin'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp
                </tr>

                <tr>
                <td>
                    Anjing
                </td>
                @foreach($var['vaksin'] as $vaksin)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $vaksin->id,6);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_vaksin'][$vaksin->id] += $jumlah;
						$var['jumlah_vaksin'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp 
                </tr>

                <tr>
                <td>
                    Lainnya
                </td>
                @foreach($var['vaksin'] as $vaksin)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $vaksin->id,'lain');
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_vaksin'][$vaksin->id] += $jumlah;
						$var['jumlah_vaksin'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp
                </tr> 				
				<tr>
					<th>Total</th>
					@foreach($var['vaksin'] as $vaksin)
						<th>{{$var['jumlah_vaksin'][$vaksin->id]}}</th>
					@endforeach
					<th>{{$var['jumlah_vaksin'][0]}}</th>
				</tr>
            </tbody>
        </table>
    @elseif($var['jenis'] == 'Operasi')
    <table class="table-border">
            <thead>
                <tr>
                    <th width="15%" height="35px" style="text-align:center; font-size:14px; background-color: #c1c1c1;">Jenis Spesies</th>                    
                        @foreach($var['opr'] as $operasi)
							<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">{{$operasi->tindakan}}</th>                                
						@endforeach
						<th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>
                    Sapi
                </td>
                
				@foreach($var['opr'] as $operasi)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $operasi->id,193);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_operasi'][$operasi->id] += $jumlah;
						$var['jumlah_operasi'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp 
                                                
                </tr> 

                <tr>
                <td>
                    Domba
                </td>
                
                
				@foreach($var['opr'] as $operasi)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $operasi->id,291);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_operasi'][$operasi->id] += $jumlah;
						$var['jumlah_operasi'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp 
                                                
                </tr>

                <tr>
                <td>
                    Kambing
                </td>
                
				@foreach($var['opr'] as $operasi)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $operasi->id,9);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_operasi'][$operasi->id] += $jumlah;
						$var['jumlah_operasi'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp 
                                               
                </tr>

                <tr>
                <td>
                    Ayam
                </td>
                
                
				@foreach($var['opr'] as $operasi)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $operasi->id,'ayam');
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_operasi'][$operasi->id] += $jumlah;
						$var['jumlah_operasi'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp 
                                                   
                </tr>         

                <tr>
                <td>
                    Kucing
                </td>
                
                 
				@foreach($var['opr'] as $operasi)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $operasi->id,5);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_operasi'][$operasi->id] += $jumlah;
						$var['jumlah_operasi'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp 
                                                     
                </tr> 

                <tr>
                <td>
                    Anjing
                </td>
                
				@foreach($var['opr'] as $operasi)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $operasi->id,6);
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_operasi'][$operasi->id] += $jumlah;
						$var['jumlah_operasi'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp 
                                                   
                </tr> 

                <tr>
                <td>
                    Lainnya
                </td>
                
                
				@foreach($var['opr'] as $operasi)
					@php
						$jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $operasi->id,'lain');
						@$jumArray[$item->kode] += $jumlah;
						$var['jumlah_hewan'] += $jumlah;
						$var['jumlah_operasi'][$operasi->id] += $jumlah;
						$var['jumlah_operasi'][0] += $jumlah;
					@endphp
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>  
				@endforeach 
				<td style="text-align:center; vertical-align:middle;"><b>{{ $var['jumlah_hewan'] }}</b></td> 
				@php $var['jumlah_hewan'] =0 @endphp 
                                                
                </tr> 
				<tr>
					<th>Total</th>
					@foreach($var['opr'] as $operasi)
						<th>{{$var['jumlah_operasi'][$operasi->id]}}</th>
					@endforeach
					<th>{{$var['jumlah_operasi'][0]}}</th>
				</tr>
            </tbody>
    </table> 
    @elseif($var['jenis'] == 'Penyakit')
    @php
		$jumlah = array();
		$jumlah_hewan = 0;
	@endphp
    <table class="table-border">
            <thead>
                <tr>
                    <th width="15%" height="35px" style="text-align:center; font-size:14px; background-color: #c1c1c1;">Jenis Spesies</th>
                    @foreach($var['penyakit'] as $pen)
						@php
							$jumlah_pen[$pen->diagnosa] = 0;
							$jumlah_pen[0] = 0;
						@endphp
                        <th style="text-align:center; font-size:14px; background-color: #c1c1c1;">{{@$helper->getPenyakit($pen->diagnosa)}}</th>             
                    @endforeach  
					<th>Total</th>					
                </tr>
            </thead>
            <tbody>
                
                    <tr>
                        <td>
                            Sapi
                        </td>
                @foreach($var['penyakit'] as $pen)
                    @php                    
                        $jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $pen->diagnosa,193);                                        
						$jumlah_pen[$pen->diagnosa] += $jumlah;
						$jumlah_hewan += $jumlah;
						$jumlah_pen[0] += $jumlah;
                    @endphp
                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>
                @endforeach
					<td>{{$jumlah_hewan}}</td>
                    </tr>
                    <tr>
                        <td>
                            Domba
                        </td>
				@php $jumlah_hewan = 0; @endphp
                @foreach($var['penyakit'] as $pen)
                    @php                    
                        $jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $pen->diagnosa,291);                                        
						$jumlah_pen[$pen->diagnosa] += $jumlah;
						$jumlah_hewan += $jumlah;
						$jumlah_pen[0] += $jumlah;
                    @endphp
                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>
                @endforeach
					<td>{{$jumlah_hewan}}</td>
                    </tr>

                    <tr>
                        <td>
                            Kambing
                        </td>
				@php $jumlah_hewan = 0; @endphp
                @foreach($var['penyakit'] as $pen)
                    @php                    
                        $jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $pen->diagnosa,9);                                        
						$jumlah_pen[$pen->diagnosa] += $jumlah;
						$jumlah_hewan += $jumlah;
						$jumlah_pen[0] += $jumlah;
                    @endphp
                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>
					
					
                @endforeach
					<td>{{$jumlah_hewan}}</td>
                    </tr>

                    <tr>
                        <td>
                            Ayam
                        </td>
				@php $jumlah_hewan = 0; @endphp
                @foreach($var['penyakit'] as $pen)
                    @php                    
                        $jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $pen->diagnosa,'ayam');                                        
						$jumlah_pen[$pen->diagnosa] += $jumlah;
						$jumlah_hewan += $jumlah;
						$jumlah_pen[0] += $jumlah;
                    @endphp
                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>
                @endforeach
				
					<td>{{$jumlah_hewan}}</td>
                    </tr>

                    <tr>
                        <td>
                            Kucing
                        </td>
				@php $jumlah_hewan = 0; @endphp
                @foreach($var['penyakit'] as $pen)
                    @php                    
                        $jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $pen->diagnosa,5);                                        
						$jumlah_pen[$pen->diagnosa] += $jumlah;
						$jumlah_hewan += $jumlah;
						$jumlah_pen[0] += $jumlah;
                    @endphp
                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>
                @endforeach
				
					<td>{{$jumlah_hewan}}</td>
                    </tr>

                    <tr>
                        <td>
                            Anjing
                        </td>
				@php $jumlah_hewan = 0; @endphp
                @foreach($var['penyakit'] as $pen)
                    @php                    
                        $jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $pen->diagnosa,6);                                        
						$jumlah_pen[$pen->diagnosa] += $jumlah;
						$jumlah_hewan += $jumlah;
						$jumlah_pen[0] += $jumlah;
                    @endphp
                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>
                @endforeach
				
					<td>{{$jumlah_hewan}}</td>
                    </tr>

                    <tr>
                        <td>
                            Lainnya
                        </td>
				@php $jumlah_hewan = 0; @endphp
                @foreach($var['penyakit'] as $pen)
                    @php                    
                        $jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$var['jenis'],$var['subSatuanKerjaId'], $pen->diagnosa,'lain');                                        
						$jumlah_pen[$pen->diagnosa] += $jumlah;
						$jumlah_hewan += $jumlah;
						$jumlah_pen[0] += $jumlah;
                    @endphp
					
					
                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>
                @endforeach
					<td>{{$jumlah_hewan}}</td>
                    </tr>
					<tr>
					<td>Total</td>
					@foreach($var['penyakit'] as $pen)
						<td style="text-align:center; vertical-align:middle;">{{ $jumlah_pen[$pen->diagnosa] }}</td>
					@endforeach
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah_pen[0] }}</td>
				</tr>
            </tbody>
    </table>
	@elseif($var['jenis'] == 'pad')
    @php
		$total = 0;
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
			<tr>
				<td colspan=2><b>Total</b></td>
				<td>
					Rp. {{number_format($total,2,",",".")}}
				</td>
				<td></td>
			</tr>
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
	@elseif($var['jenis'] == 'utama')
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
				@php $i = 1; $total = 0; @endphp
				@foreach($var['klinik'] as $klinik)
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
						</td>
					</tr>
					
				@php
					$total += $var['tarif'][$klinik->id];
					$i++; 
				@endphp
				@endforeach
				<tr>
					<td colspan=7><b>Jumlah</b></td>
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
			</tbody>
		</table>
	@elseif($var['jenis'] == 'utama2')
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
						<td>{{$var['kwitansi'][$klinik->id]}}</td>
						<!-- <td>
							{{$total_harian}}
						</td>-->
					</tr>
					
				@php
					
					$total += $var['tarif'][$klinik->id];
					$i++; 
				@endphp
				@endforeach
				<tr>
					<td colspan=16 align="center" valign="center"><b>Total</b></td>					
					<td>
						Rp. {{number_format($total,2,",",".")}}
					</td>
					<td></td>
				</tr>
			</tbody>
		</table>
	@elseif($var['jenis'] == 'bulanan')
		@php $total = $var['total']; $pengeluaran = $var['pengeluaran']; @endphp
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
