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
            </tbody>
			<tfoot>
				<tr>
					<th>Total</th>
					@foreach($var['vaksin'] as $vaksin)
						<th>{{$var['jumlah_vaksin'][$vaksin->id]}}</th>
					@endforeach
					<th>{{$var['jumlah_vaksin'][0]}}</th>
				</tr>
			</tfoot>
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
            </tbody>
			<tfoot>
				<tr>
					<th>Total</th>
					@foreach($var['opr'] as $operasi)
						<th>{{$var['jumlah_operasi'][$operasi->id]}}</th>
					@endforeach
					<th>{{$var['jumlah_operasi'][0]}}</th>
				</tr>
			</tfoot>
    </table> 
    @elseif($var['jenis'] == 'Penyakit' || $var['jenis'] == 'penyakit')
	
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
            </tbody>
			<tfoot>
				<tr>
					<td>Total</td>
					@foreach($var['penyakit'] as $pen)
						<td style="text-align:center; vertical-align:middle;">{{ $jumlah_pen[$pen->diagnosa] }}</td>
					@endforeach
					<td style="text-align:center; vertical-align:middle;">{{ $jumlah_pen[0] }}</td>
				</tr>
			</tfoot>
    </table>
    @endif       
	</body>
</html>
