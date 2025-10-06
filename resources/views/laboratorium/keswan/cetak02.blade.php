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
    <body><table class="header">
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
                    <img height="50px" src="{!! url_kan() !!}" />
                    <p style="height:20px;border:1px solid #000;font-size:10px;padding-top:5px;padding-left:5px;"><b>No. Epid : {{ $keswan->no_epid }}</b></p>
                </td>
            </tr>
        </table>

        <table class="table-border" style="border:1.5px solid #000000;">
            <tr>
                <td height="25px" width="85%" style="text-align:center; font-size: 16px; vertical-align:middle;"><b>PENOMORAN CONTOH</b></td>
                <td style="text-align:center; font-size: 16px; vertical-align:middle;"><b>FORM 02</b></td>
            </tr>
        </table>

        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="30%"><b>NAMA LABORATORIUM</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ @$keswan->subSatuanKerja->sub_satuan_kerja }}</td>
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
                @foreach($keswan->labContoh as $key=>$contoh)
                <tr>
                    <td style="padding:5px;vertical-align:middle;text-align: center;" height="25px">{!! $key+1 !!}</td>
                    <td style="padding:5px;vertical-align:middle;">{{ @$contoh->nama_sampel }}</td>
                    <td style="padding:5px;vertical-align:middle;text-align: center;">{{ @$contoh->pcontoh->jumlah }}</td>
                    <td style="padding:5px;vertical-align:middle;text-align: center;">{{ @$contoh->pcontoh->nomor_asal }}</td>
                    <td style="padding:5px;vertical-align:middle;text-align: center;">{{  @$contoh->pcontoh->nomor_baru }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table class="table-no-border" cellpadding="3">
            <tr>
                <td width="30%"><b>TANGGAL DITERIMA CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ $keswan->tanggal_penerimaan }}</td>
            </tr>
            <tr>
                <td width="30%"><b>ASAL CONTOH</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ $keswan->kotaKabupaten->name }}</td>
            </tr>
            @php
            $pengujian = "";
            foreach($keswan->labPengujian as $key=>$uji){
                    $pengujian .= ($key==0?'':', ').$uji->jenis_pengujian;
            }
            @endphp
            <tr>
                <td width="30%"><b>PERMINTAAN UJI</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ $pengujian }}</td>
            </tr>
            <tr>
                <td width="30%"><b>CATATAN / SARAN</b></td>
                <td width="3%"><b>:</b></td>
                <td colspan="3">{{ $keswan->catatan_02 }}</td>
            </tr>
        </table>

        <table class="table-no-border">
            <tr>
                <td colspan="5"></td>
                <td style="text-align: center">Semarang, {!! tanggal($keswan->time_02) !!}</td>
            </tr>
            <tr>
                <td colspan="2" width="20%" height="100px">&nbsp;</td>
                <td width="15%">&nbsp;</td>
                <td>&nbsp;</td>
                <td width="10%">&nbsp;</td>
                <td>
                    <center><b>PETUGAS PENERIMA CONTOH</b></center>
                    <br /><br /><br /><br />
                    <center>{{  @$keswan->penerima }}</center>
                </td>
            </tr>
            <tr>
                <td colspan="6" style="text-align:left; padding-left:20px;"><b style="font-size:11px;">Diarsipkan oleh Petugas Penerima Contoh</b></td>
            </tr>
        </table>
</body>
</html>
