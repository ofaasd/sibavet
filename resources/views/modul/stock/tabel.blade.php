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
<center><h2>DATA STOCK OBAT</h2></center>
        <br />
        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="7%"><b>Satker</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>Klinik Semarang</b></td>
                <td width="40%">&nbsp;</td>
                <td width="7%"><b>Periode</b></td>
                <td width="2%"><b>:</b></td>
                <td><b>{{ $l_bulan[$bulan] }}</b></td>
                <td width="2%"><b>-</b></td>
                <td><b>{{ $tahun }}</b></td>
            </tr>
        </table>
<table class="table table-hover">
	<thead>
		<tr class="bg-dark">
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;" rowspan=2>No</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;" rowspan=2>Jenis Obat</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;" colspan=2>Stok Awal Bulan</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;" colspan=2>Masuk</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;" colspan=2>Jumlah Pemakaian</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;" colspan=2>Sisa Akhir Bulan</th>
			<!--<th style="text-align:center;">Klinik</th>-->
		</tr>
		<tr>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Volume</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Satuan</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Volume</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Satuan</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Volume</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Satuan</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Volume</th>
			<th style="text-align:center; font-size:14px; background-color: #c1c1c1;">Satuan</th>
		</tr>
	</thead>
	<tbody>
	@php
		$no = 1;
	@endphp
	@foreach($stock as $id_obat=>$value)
		<tr>
			<td>{{$no}}</td>
			<td>
				{{$l_obat[$id_obat]}} 
				<input type="hidden" name="obat[]" value="{{$id_obat}}">
			</td>
			<td>{{$value}}</td>
			<td>ML</td>
			<td>{{$p_stock[$id_obat]}}</td>
			<td>ML</td>
			<td>{{$pengeluaran[$id_obat]}}</td>
			<td>ML</td>
			<td>
				{{($value-$pengeluaran[$id_obat]+$p_stock[$id_obat])}}
				<input type="hidden" name="stock[]" value="{{($value-$pengeluaran[$id_obat]+$p_stock[$id_obat])}}">
			</td>
			<td>ML</td>
		</tr>
		
		@php 
			$no++;
		@endphp
	@endforeach
	</tbody>
</table>
</body>
</html>