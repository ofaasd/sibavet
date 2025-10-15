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
        <table class="header">
			<tr>
				<td width="25%">
					<img height="130px" src="{{ asset('fabadmin/images/logo-laporan.gif') }}"/>
				</td>
				<td align="center">
					<p style="font-size:16px"><b>DINAS PETERNAKAN DAN KESEHATAN HEWAN</b></p>
                    <p style="font-size:16px"><b>PROVINSI JAWA TENGAH</b></p>
                    <p style="font-size:16px"><b>BALAI VETERINER SEMARANG</b></p>
                    <p style="font-size:20px"><b>KLINIK HEWAN</b></p>
					<p style="font-size:12px">Jalan Bridgen S. Sudiarto Nomor 134 Semarang Telephone 024-6722330</p>
				</td>
			</tr>
        </table>

        <table class="table-no-border">
            <tr>
                <td width="40%">&nbsp;</td>
                <td width="35%"><p style="font-size:17px"><b><u>KARTU PASIEN</u></b></p></td>
                <td >
                    <table style="border:2px solid #000000;padding:0px">
                        <tr>
                        <td><p style="font-size:13px"><b>NO. RM : {{ $klinik->no_pasien }}</b></p></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="20%">KLINIK HEWAN</td>
                <td width="3%">:</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ @$klinik->subSatuanKerja->sub_satuan_kerja }}</td>
            </tr>
            <tr>
                <td width="20%">NAMA PEMILIK</td>
                <td width="3%">:</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ @$klinik->pemilik->nama }}</td>
            </tr>
            <tr>
                <td width="20%">ALAMAT</td>
                <td width="3%">:</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ @$klinik->pemilik->alamat }}</td>
            </tr>
            <tr>
                <td width="20%">NO. TLPN / HP</td>
                <td width="3%">:</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ @$klinik->pemilik->telepon }}</td>
            </tr>
            <tr>
                <td width="20%">JENIS KELAMIN</td>
                <td width="3%">:</td>
                @if($klinik->jenis_kelamin == 'Jantan')
                    <td>(JANTAN / <s>BETINA</s>)</td>
                @elseif($klinik->jenis_kelamin == 'Betina')
                    <td>(<s>JANTAN</s> / BETINA)</td>
                @endif
            </tr>
            <tr>
                <td width="20%">RAS</td>
                <td width="3%">:</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ @$klinik->ras->nama_ras }}</td>
            </tr>
            <tr>
                <td width="20%">NAMA HEWAN</td>
                <td width="3%">:</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ $klinik->nama_hewan }}</td>
            </tr>
            <tr>
                <td width="20%">UMUR</td>
                <td width="3%">:</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ $klinik->umur }} Tahun</td>
            </tr>
            <tr>
                <td width="20%">CIRI - CIRI SPESIFIK</td>
                <td width="3%">:</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ $klinik->ciri_ciri }}</td>
            </tr>
        </table>
        <br />
        <table class="table-border">
            <thead>
                <tr>
                    <th width="5%" style="text-align:center; font-size:12px;">NO</th>
                    <th width="10%" style="text-align:center; font-size:12px;">TGL PERIKSA</th>
                    <th width="15%" style="text-align:center; font-size:12px;">SIGNALEMENT</th>
                    <th width="25%" style="text-align:center; font-size:12px;">ANAMNESIA</th>
                    <th width="15%" style="text-align:center; font-size:12px;">DIAGNOSA</th>
                    <th width="15%" style="text-align:center; font-size:12px;">TERAPI</th>
                    <th width="15%" style="text-align:center; font-size:12px;">KETERANGAN</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="height: 500px; overflow:hidden; text-align:center;">1.</td>
                    <td>{{ $klinik->tanggal_periksa }}</td>
                    <td>{{ $klinik->signalement }}</td>
                    <td>{{ $klinik->anamnesia }}</td>
                    <td>{{ $klinik->diagnosa }}</td>
                    <td>
                        @foreach(@$klinik->klinikDosis as $item)
                            {{ $item->terapi->obat }} <br>
                        @endforeach
                    </td>
                    <td>{{ $klinik->keterangan }}</td>
                </tr>
            </tbody>
        </table>

	</body>
</html>
