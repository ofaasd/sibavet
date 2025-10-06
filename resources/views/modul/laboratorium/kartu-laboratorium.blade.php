<html>
	<head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

            .page_break { page-break-before: always; }
        </style>
	</head>
	<body>
        <table class="header">
			<tr>
				<td width="15%">
					<img height="110px" src="{{ asset('fabadmin/images/logo-laporan.gif') }}"/>
				</td>
				<td align="center">
					<p style="font-size:15px"><b>PEMERINTAH PROVINSI JAWA TENGAH</b></p>
                    <p style="font-size:18px"><b>DINAS PETERNAKAN DAN KESEHATAN HEWAN</b></p>
                    <p style="font-size:12px">Jalan Jenderal Gatot Subroto, Kompleks Tarubudaya Ungaran</p>
                    <p style="font-size:12px">Kode Pos 50501 Telepon 024 - 6921023 Faksimile 024 - 6912397</p>
					<p style="font-size:12px">Laman http://wwww.jatengprov.go.id Surat Elektronik disnakkewan@jatengprov.go.id</p>
                </td>
                <td width="15%">
                    <br/><br/>
                    <p style="height:20px;border:1px solid #000;font-size:10px;padding-top:5px;padding-left:5px;"><b>No. Epid : {{ $laboratorium->no_epid }}</b></p>
                </td>
			</tr>
        </table>

        <table class="table-border" style="border:1.5px solid #000000;">
            <tr>
                <td height="25px" width="85%" style="text-align:center; font-size: 16px; vertical-align:middle;"><b>PENERIMAAN CONTOH</b></td>
                <td style="text-align:center; font-size: 16px; vertical-align:middle;"><b>FORM 1</b></td>
            </tr>
        </table>

        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="30%"><b>NAMA LABORATORIUM</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->subSatuanKerja->sub_satuan_kerja }}</td>
            </tr>
            <tr>
                <td width="30%"><b>NAMA PENGIRIM</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->customer->nama_pelanggan }}</td>
            </tr>
            <tr>
                <td width="30%"><b>ALAMAT</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->customer->alamat }}</td>
            </tr>
            <tr>
                <td width="30%"><b>JENIS HEWAN</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->spesies->nama_spesies }}</td>
            </tr>
            <tr>
                <td width="30%"><b>JENIS CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td width="30%" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->jenisContoh->nama_sampel }}</td>
                <td width="10%"><b>JUMLAH</b></td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ $laboratorium->jumlah_contoh }}</td>
            </tr>
            <tr>
                <td width="30%"><b>&nbsp;</b></td>
                <td width="3%"><b>:</b></td>
                <td width="30%" style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
                <td width="10%"><b>JUMLAH</b></td>
                <td style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
            </tr>
            <tr>
                <td width="30%"><b>&nbsp;</b></td>
                <td width="3%"><b>:</b></td>
                <td width="30%" style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
                <td width="10%"><b>JUMLAH</b></td>
                <td style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
            </tr>
            <tr>
                <td width="30%"><b>BENTUK CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->bentukContoh->bentuk_sampel }}</td>
            </tr>
            <tr>
                <td width="30%"><b>PERMINTAAN UJI</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->jenisPengujian->jenis_pengujian }}</td>
            </tr>
        </table>

        <table class="table-no-border">
            <tr>
                <td width="50%" style="vertical-align:middle;"><b>BAHWA KIRIMAN CONTOH SDR. TELAH KAMI TERIMA</b></td>
                <td width="3%" style="vertical-align:middle;"><b>:</b></td>
                <td width="7%" style="vertical-align:middle;"><b>BAIK</b>&nbsp;&nbsp;</td>
                <td width="8%" style="padding-top: 12px;"><div style="height: 16px; width: 16px; border: 1px solid black;"></div>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td width="15%" style="vertical-align:middle;"><b>KURANG BAIK</b>&nbsp;&nbsp;</td>
                <td style="padding-top: 12px;"><div style="height: 16px; width: 16px; border: 1px solid black;"></div></td>
            </tr>
        </table>

        <table class="table-no-border" style="padding-top:-20px;">
            <tr>
                <td width="5%" style="text-align: center"><b>1.</b></td>
                <td width="25%"><b>Metode Uji</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ $laboratorium->metode_uji }}</td>
            </tr>
            <tr>
                <td width="5%" style="text-align: center"><b>2.</b></td>
                <td width="25%"><b>Peralatan</b></td>
                <td width="3%"><b>:</b></td>
                @if($laboratorium->peralatan == 'Mampu')
                    <td colspan="3"><b>1). Mampu* &nbsp;&nbsp;&nbsp;&nbsp; <s>2. Tidak Mampu*</s></b></td>
                @elseif($laboratorium->peralatan == 'Tidak Mampu')
                <td colspan="3"><b><s>1). Mampu*</s> &nbsp;&nbsp;&nbsp;&nbsp; 2. Tidak Mampu*</b></td>
                @endif
            </tr>
            <tr>
                <td width="5%" style="text-align: center"><b>3.</b></td>
                <td width="25%"><b>Bahan</b></td>
                <td width="3%"><b>:</b></td>
                @if($laboratorium->bahan == 'Mampu')
                    <td colspan="3"><b>1). Mampu* &nbsp;&nbsp;&nbsp;&nbsp; <s>2. Tidak Mampu*</s></b></td>
                @elseif($laboratorium->bahan == 'Tidak Mampu')
                <td colspan="3"><b><s>1). Mampu*</s> &nbsp;&nbsp;&nbsp;&nbsp; 2. Tidak Mampu*</b></td>
                @endif
            </tr>
            <tr>
                <td width="5%" style="text-align: center"><b>4.</b></td>
                <td width="25%"><b>Personil</b></td>
                <td width="3%"><b>:</b></td>
                @if($laboratorium->personil == 'Mampu')
                    <td colspan="3"><b>1). Mampu* &nbsp;&nbsp;&nbsp;&nbsp; <s>2. Tidak Mampu*</s></b></td>
                @elseif($laboratorium->personil == 'Tidak Mampu')
                <td colspan="3"><b><s>1). Mampu*</s> &nbsp;&nbsp;&nbsp;&nbsp; 2. Tidak Mampu*</b></td>
                @endif
            </tr>
            <tr>
                <td colspan="2"><b>CATATAN / SARAN</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ $laboratorium->catatan }}</td>
            </tr>
            <tr>
                <td colspan="6" style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
            </tr>
        </table>

        <table class="table-no-border">
            <tr>
                <td colspan="6" style="text-align:right; padding-right:30px;">................., .................................</td>
            </tr>
            <tr>
                <td colspan="2" width="25%" height="100px">
                    <table cellpadding="3" style="border-collapse: collapse;">
                        <tr>
                            <td width="70px" style="border:1px solid #000000;"><b style="font-size:11px;">Paraf MT</b></td>
                            <td style="border:1px solid #000000;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="border:1px solid #000000;"><b style="font-size:11px;">Paraf DMM</b></td>
                            <td style="border:1px solid #000000;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
                <td width="20%">&nbsp;</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">
                    <center><b>Pengirim</b></center>
                    <br /><br /><br /><br />
                    <center>{{  @$laboratorium->pengirim }}</center>
                </td>
                <td width="15%">&nbsp;</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">
                    <center><b>Penerima</b></center>
                    <br /><br /><br /><br />
                    <center>{{  @$laboratorium->penerima }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:left; padding-left:20px;"><b style="font-size:11px;">Disiapkan oleh Petugas Penerima Contoh</b></td>
            </tr>
        </table>

        <hr>

        <div class="page_break"></div>

        <table class="header">
			<tr>
				<td width="15%">
					<img height="110px" src="{{ asset('fabadmin/images/logo-laporan.gif') }}"/>
				</td>
				<td align="center">
					<p style="font-size:15px"><b>PEMERINTAH PROVINSI JAWA TENGAH</b></p>
                    <p style="font-size:18px"><b>DINAS PETERNAKAN DAN KESEHATAN HEWAN</b></p>
                    <p style="font-size:12px">Jalan Jenderal Gatot Subroto, Kompleks Tarubudaya Ungaran</p>
                    <p style="font-size:12px">Kode Pos 50501 Telepon 024 - 6921023 Faksimile 024 - 6912397</p>
					<p style="font-size:12px">Laman http://wwww.jatengprov.go.id Surat Elektronik disnakkewan@jatengprov.go.id</p>
                </td>
                <td width="15%">
                    <br/><br/>
                    <p style="height:20px;border:1px solid #000;font-size:10px;padding-top:5px;padding-left:5px;"><b>No. Epid : {{ $laboratorium->no_epid }}</b></p>
                </td>
			</tr>
        </table>

        <table class="table-border" style="border:1.5px solid #000000;">
            <tr>
                <td height="25px" width="85%" style="text-align:center; font-size: 16px; vertical-align:middle;"><b>PENOMORAN CONTOH</b></td>
                <td style="text-align:center; font-size: 16px; vertical-align:middle;"><b>FORM 2</b></td>
            </tr>
        </table>

        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="30%"><b>NAMA LABORATORIUM</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ @$laboratorium->subSatuanKerja->sub_satuan_kerja }}</td>
            </tr>
        </table>

        <table class="table-border">
            <thead>
                <tr>
                    <th height="35px" width="5%" style="text-align:center; font-size:14px;">NO</th>
                    <th width="25%" style="text-align:center; font-size:14px;">JENIS CONTOH</th>
                    <th width="20%" style="text-align:center; font-size:14px;">JUMLAH CONTOH</th>
                    <th width="25%" style="text-align:center; font-size:14px;">NOMOR ASAL</th>
                    <th width="25%" style="text-align:center; font-size:14px;">NOMOR BARU</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="height: 200px; overflow:hidden; text-align:center;">1.</td>
                    <td>{{ @$laboratorium->jenisContoh->nama_sampel }}</td>
                    <td>{{ $laboratorium->jumlah_contoh }}</td>
                    <td>{{ $laboratorium->nomor_asal }}</td>
                    <td>{{ $laboratorium->nomor_baru }}</td>
                </tr>
            </tbody>
        </table>
        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="30%"><b>TANGGAL DITERIMA CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ $laboratorium->tanggal_penerimaan }}</td>
            </tr>
            <tr>
                <td width="30%"><b>ASAL CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ $laboratorium->kotaKabupaten->name }}</td>
            </tr>
            <tr>
                <td width="30%"><b>PERMINTAAN UJI</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ @$laboratorium->jenisPengujian->jenis_pengujian }}</td>
            </tr>
            <tr>
                <td width="30%"><b>CATATAN / SARAN</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ $laboratorium->catatan }}</td>
            </tr>
        </table>

        <table class="table-no-border">
            <tr>
                <td colspan="6" style="text-align:right; padding-right:30px;">................., .................................</td>
            </tr>
            <tr>
                <td colspan="2" width="20%" height="100px">&nbsp;</td>
                <td width="15%">&nbsp;</td>
                <td>&nbsp;</td>
                <td width="10%">&nbsp;</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">
                    <center><b>PETUGAS PENERIMA CONTOH</b></center>
                    <br /><br /><br /><br />
                    <center>{{  @$laboratorium->penerima }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:left; padding-left:20px;"><b style="font-size:11px;">Diarsipkan oleh Petugas Penerima Contoh</b></td>
            </tr>
        </table>

        <hr>

        <div class="page_break"></div>

        <table class="header">
			<tr>
				<td width="15%">
					<img height="110px" src="{{ asset('fabadmin/images/logo-laporan.gif') }}"/>
				</td>
				<td align="center">
					<p style="font-size:15px"><b>PEMERINTAH PROVINSI JAWA TENGAH</b></p>
                    <p style="font-size:18px"><b>DINAS PETERNAKAN DAN KESEHATAN HEWAN</b></p>
                    <p style="font-size:12px">Jalan Jenderal Gatot Subroto, Kompleks Tarubudaya Ungaran</p>
                    <p style="font-size:12px">Kode Pos 50501 Telepon 024 - 6921023 Faksimile 024 - 6912397</p>
					<p style="font-size:12px">Laman http://wwww.jatengprov.go.id Surat Elektronik disnakkewan@jatengprov.go.id</p>
                </td>
                <td width="15%">
                    <br/><br/>
                    <p style="height:20px;border:1px solid #000;font-size:10px;padding-top:5px;padding-left:5px;"><b>No. Epid : {{ $laboratorium->no_epid }}</b></p>
                </td>
			</tr>
        </table>

        <table class="table-border" style="border:1.5px solid #000000;">
            <tr>
                <td height="25px" width="85%" style="text-align:center; font-size: 16px; vertical-align:middle;"><b>SURAT PENGANTAR PENGIRIMAN CONTOH KE LABORATORIUM</b></td>
                <td style="text-align:center; font-size: 16px; vertical-align:middle;"><b>FORM 3</b></td>
            </tr>
        </table>

        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="30%"><b>NAMA LABORATORIUM</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ @$laboratorium->subSatuanKerja->sub_satuan_kerja }}</td>
            </tr>
            <tr>
                <td width="30%"><b>NO. CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->jenisContoh->kode }}</td>
            </tr>
            <tr>
                <td width="30%"><b>LABORATORIUM PENGUJI</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->seksiLaboratorium->seksi_laboratorium }}</td>
            </tr>
            <tr>
                <td width="30%"><b>TANGGAL DITERIMA CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ $laboratorium->tanggal_penerimaan }}</td>
            </tr>
            <tr>
                <td width="30%"><b>JENIS CONTOH / JUMLAH</b></td>
                <td width="3%"><b>:</b></td>
                <td width="30%" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->jenisContoh->nama_sampel }}</td>
                <td width="10%"><b>JUMLAH</b></td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ $laboratorium->jumlah_contoh }}</td>
            </tr>
            <tr>
                <td width="30%"><b>&nbsp;</b></td>
                <td width="3%"><b>:</b></td>
                <td width="30%" style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
                <td width="10%"><b>JUMLAH</b></td>
                <td style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
            </tr>
            <tr>
                <td width="30%"><b>&nbsp;</b></td>
                <td width="3%"><b>:</b></td>
                <td width="30%" style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
                <td width="10%"><b>JUMLAH</b></td>
                <td style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
            </tr>
            <tr>
                <td width="30%"><b>PERMINTAAN UJI</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ @$laboratorium->jenisPengujian->jenis_pengujian }}</td>
            </tr>
            <tr>
                <td width="30%"><b>CATATAN / SARAN</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ $laboratorium->catatan }}</td>
            </tr>
        </table>

        <table class="table-no-border">
            <tr>
                <td colspan="6" style="text-align:right; padding-right:30px;">................., .................................</td>
            </tr>
            <tr>
                <td colspan="2" width="20%" height="100px">&nbsp;</td>
                <td width="15%">&nbsp;</td>
                <td>&nbsp;</td>
                <td width="10%">&nbsp;</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">
                    <center><b>MANAJER TEKNIS</b></center>
                    <br /><br /><br /><br />
                    <center>{{  @$laboratorium->manajer_teknis }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:left; padding-left:20px;"><b style="font-size:11px;">Diarsipkan oleh Petugas Penerima Contoh</b></td>
            </tr>
        </table>

        <hr>

        <div class="page_break"></div>

        <table class="header">
			<tr>
				<td width="15%">
					<img height="110px" src="{{ asset('fabadmin/images/logo-laporan.gif') }}"/>
				</td>
				<td align="center">
					<p style="font-size:15px"><b>PEMERINTAH PROVINSI JAWA TENGAH</b></p>
                    <p style="font-size:18px"><b>DINAS PETERNAKAN DAN KESEHATAN HEWAN</b></p>
                    <p style="font-size:12px">Jalan Jenderal Gatot Subroto, Kompleks Tarubudaya Ungaran</p>
                    <p style="font-size:12px">Kode Pos 50501 Telepon 024 - 6921023 Faksimile 024 - 6912397</p>
					<p style="font-size:12px">Laman http://wwww.jatengprov.go.id Surat Elektronik disnakkewan@jatengprov.go.id</p>
                </td>
                <td width="15%">
                    <br/><br/>
                    <p style="height:20px;border:1px solid #000;font-size:10px;padding-top:5px;padding-left:5px;"><b>No. Epid : {{ $laboratorium->no_epid }}</b></p>
                </td>
			</tr>
        </table>

        <table class="table-border" style="border:1.5px solid #000000;">
            <tr>
                <td height="25px" width="85%" style="text-align:center; font-size: 16px; vertical-align:middle;"><b>PERINTAH PENGUJIAN</b></td>
                <td style="text-align:center; font-size: 16px; vertical-align:middle;"><b>FORM 4</b></td>
            </tr>
        </table>

        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="30%"><b>NAMA LABORATORIUM</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ @$laboratorium->subSatuanKerja->sub_satuan_kerja }}</td>
            </tr>
            <tr>
                <td width="30%"><b>NO. CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->jenisContoh->kode }}</td>
            </tr>
            <tr>
                <td width="30%"><b>LABORATORIUM PENGUJI</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->seksiLaboratorium->seksi_laboratorium }}</td>
            </tr>
            <tr>
                <td width="30%"><b>PENGUJI YANG DITUNJUK</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ $laboratorium->penguji_ditunjuk }}</td>
            </tr>
            <tr>
                <td width="30%"><b>TANGGAL DITERIMA CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3" style="border-bottom-style: dotted; border-width: 1px;">{{ $laboratorium->tanggal_penerimaan }}</td>
            </tr>
            <tr>
                <td width="30%"><b>JENIS CONTOH / JUMLAH</b></td>
                <td width="3%"><b>:</b></td>
                <td width="30%" style="border-bottom-style: dotted; border-width: 1px;">{{ @$laboratorium->jenisContoh->nama_sampel }}</td>
                <td width="10%"><b>JUMLAH</b></td>
                <td style="border-bottom-style: dotted; border-width: 1px;">{{ $laboratorium->jumlah_contoh }}</td>
            </tr>
            <tr>
                <td width="30%"><b>&nbsp;</b></td>
                <td width="3%"><b>:</b></td>
                <td width="30%" style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
                <td width="10%"><b>JUMLAH</b></td>
                <td style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
            </tr>
            <tr>
                <td width="30%"><b>&nbsp;</b></td>
                <td width="3%"><b>:</b></td>
                <td width="30%" style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
                <td width="10%"><b>JUMLAH</b></td>
                <td style="border-bottom-style: dotted; border-width: 1px;">&nbsp;</td>
            </tr>
            <tr>
                <td width="30%"><b>PERMINTAAN UJI</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ @$laboratorium->jenisPengujian->jenis_pengujian }}</td>
            </tr>
            <tr>
                <td width="30%"><b>CATATAN / SARAN</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ $laboratorium->catatan }}</td>
            </tr>
        </table>

        <table class="table-no-border">
            <tr>
                <td colspan="6" style="text-align:right; padding-right:30px;">................., .................................</td>
            </tr>
            <tr>
                <td colspan="2" width="20%" height="100px">&nbsp;</td>
                <td width="15%">&nbsp;</td>
                <td>&nbsp;</td>
                <td width="10%">&nbsp;</td>
                <td style="border-bottom-style: dotted; border-width: 1px;">
                    <center><b>MANAJER TEKNIS</b></center>
                    <br /><br /><br /><br />
                    <center>{{  @$laboratorium->manajer_teknis }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:left; padding-left:20px;"><b style="font-size:11px;">Diarsipkan oleh Petugas Penerima Contoh</b></td>
            </tr>
        </table>

        <hr>
	</body>
</html>
