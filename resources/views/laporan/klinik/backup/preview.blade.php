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

        <table class="table-border">
            <thead>
                <tr>
                    <th width="15%" height="35px" style="text-align:center; font-size:14px; background-color: #c1c1c1;">Jenis Penanganan</th>
                    @foreach($spesies as $item)
                        <th style="text-align:center; font-size:14px; background-color: #c1c1c1;">{{ $item->nama_spesies }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach($var['penanganan'] as $pen)
                <tr>
                <td>
                    {{$pen}}
                </td>
                @foreach($spesies as $item)
                            @php
                                $jumlah =  $helper->jumlahPasienHewan($var['dari_tanggal'], $var['sampai_tanggal'],$pen,$var['subSatuanKerjaId'], $item->id);
                                @$jumArray[$item->kode] += $jumlah;
                            @endphp
                            <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>
                        @endforeach                    
                </tr>
            @endforeach    
            </tbody>
        </table>        
	</body>
</html>
