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
            table tr td {font-size:9px;}
            table tr th {font-size:13px;}

            .tengah {
                text-align: center;
            }
        </style>
	</head>
	<body>
        <center><h3>LAPORAN DATA TERNAK MASUK PROVINSI JAWA TENGAH</h3></center>
        <center><h3>PERIODE : {{ $var['periode']}}</h3></center>
        <br />

        <table class="table-border">
            <thead>
                <tr>
                    <th rowspan="4" style="text-align:center; font-size:12px; background-color: #c1c1c1;">No.</th>
                    <th rowspan="4" style="text-align:center; font-size:12px; background-color: #c1c1c1;">KAB / KOTA ASAL</th>
                    <th rowspan="4" style="text-align:center; font-size:12px; background-color: #c1c1c1;">KOTA TUJUAN</th>
                    <th colspan="35" style="text-align:center; font-size:12px; background-color: #c1c1c1;">POPULASI</th>
                    <th colspan="5" style="text-align:center; font-size:12px; background-color: #c1c1c1;">DOKUMEN</th>
                </tr>
                <tr>
                    <th colspan="10" style="text-align:center; font-size:12px; background-color: #c1c1c1;">SAPI BIBIT</th>
                    <th colspan="12" style="text-align:center; font-size:12px; background-color: #c1c1c1;">SAPI POTONG</th>
                    <th colspan="2" rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">KERBAU</th>
                    <th colspan="2" rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">KUDA</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">BABI</th>
                    <th colspan="2" rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">KAMBING</th>
                    <th colspan="2" rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">DOMBA</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">UNGGAS</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">ITIK</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">DOC</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">TELUR</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">SPT</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">SKKH</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">SKSR</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">SKB</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">TANPA SURAT</th>
                </tr>
                <tr>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.B/BX</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.L</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.S</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.O</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.FH</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.B/BX</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.L</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.S</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.O</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">P.FH</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">Bali</th>
                </tr>
                <tr>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Jtn</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">Btn</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $jumArray = array();
                    $no = 0;
                @endphp

                @foreach($kotaAsal as $item)
                    @php
                        $no++;
                        $kolomKota = $helper->kolomKota($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->kabupaten_asal_id, $var['jenisForm']);
                        $kolomKotaTujuan = 0;
                    @endphp
                        @foreach($kolomKota['kotaTujuan'] as $kotaTujuan)
                            @php $kolomKotaTujuan++; @endphp
                                <tr>
                                    @if($kolomKotaTujuan == 1)
                                        <td style="text-align:center; vertical-align:middle;" rowspan="{!! $kolomKota['kotaTujuan']->count() !!}">{{ $no }}</td>
                                        <td style="text-align:center; vertical-align:middle;" rowspan="{!! $kolomKota['kotaTujuan']->count() !!}">{{ str_replace('KABUPATEN', '', @$kolomKota['kotaAsal']->name) }}</td>
                                    @endif
                                    <td style="text-align:center; vertical-align:middle;">{{ str_replace('KABUPATEN', '', $kotaTujuan->name) }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.B/BX', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.B/BX', 'Betina');
                                        @$jumArray['sapi_bibit_pb_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_bibit_pb_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.L', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.L', 'Betina');
                                        @$jumArray['sapi_bibit_pl_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_bibit_pl_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.S', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.S', 'Betina');
                                        @$jumArray['sapi_bibit_ps_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_bibit_ps_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.O', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.O', 'Betina');
                                        @$jumArray['sapi_bibit_po_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_bibit_po_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.FH', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI BIBIT', 'P.FH', 'Betina');
                                        @$jumArray['sapi_bibit_pfh_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_bibit_pfh_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.B/BX', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.B/BX', 'Betina');
                                        @$jumArray['sapi_potong_pb_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_potong_pb_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.L', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.L', 'Betina');
                                        @$jumArray['sapi_potong_pl_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_potong_pl_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.S', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.S', 'Betina');
                                        @$jumArray['sapi_potong_ps_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_potong_ps_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.O', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.O', 'Betina');
                                        @$jumArray['sapi_potong_po_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_potong_po_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.FH', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'P.FH', 'Betina');
                                        @$jumArray['sapi_potong_pfh_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_potong_pfh_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'Bali', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SAPI POTONG', 'Bali', 'Betina');
                                        @$jumArray['sapi_potong_bali_jtn'] += $jumlahJantan;
                                        @$jumArray['sapi_potong_bali_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'KERBAU', '', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'KERBAU', '', 'Betina');
                                        @$jumArray['kerbau_jtn'] += $jumlahJantan;
                                        @$jumArray['kerbau_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'KUDA', '', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'KUDA', '', 'Betina');
                                        @$jumArray['kuda_jtn'] += $jumlahJantan;
                                        @$jumArray['kuda_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlah = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'BABI', '', 'JanBet');
                                        @$jumArray['babi'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'KAMBING', '', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'KAMBING', '', 'Betina');
                                        @$jumArray['kambing_jtn'] += $jumlahJantan;
                                        @$jumArray['kambing_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlahJantan = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'DOMBA', '', 'Jantan');
                                        $jumlahBetina = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'DOMBA', '', 'Betina');
                                        @$jumArray['domba_jtn'] += $jumlahJantan;
                                        @$jumArray['domba_btn'] += $jumlahBetina;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJantan }}</td>
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahBetina }}</td>

                                    @php
                                        $jumlah = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'UNGGAS', '', 'JanBet');
                                        @$jumArray['unggas'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>

                                    @php
                                        $jumlah = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'ITIK', '', 'JanBet');
                                        @$jumArray['itik'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>

                                    @php
                                        $jumlah = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'DOC', '', 'JanBet');
                                        @$jumArray['doc'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>

                                    @php
                                        $jumlah = $helper->jumlahPopulasi($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'TELUR', '', 'JanBet');
                                        @$jumArray['telur'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>

                                    @php
                                        $jumlah = $helper->jumlahDokumen($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SPT');
                                        @$jumArray['spt'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>

                                    @php
                                        $jumlah = $helper->jumlahDokumen($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SKKH');
                                        @$jumArray['skkh'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>

                                    @php
                                        $jumlah = $helper->jumlahDokumen($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SKSR');
                                        @$jumArray['sksr'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>

                                    @php
                                        $jumlah = $helper->jumlahDokumen($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'SKB');
                                        @$jumArray['skb'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>

                                    @php
                                        $jumlah = $helper->jumlahDokumen($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $var['jenisForm'],
                                                                    $item->kabupaten_asal_id, $kotaTujuan->id, 'TANPA SURAT');
                                        @$jumArray['tanpa_surat'] += $jumlah;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlah }}</td>
                                </tr>
                        @endforeach
                @endforeach
                <tr>
                    <th colspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">JUMLAH</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_pb_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_pb_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_pl_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_pl_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_ps_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_ps_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_po_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_po_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_pfh_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_pfh_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_pb_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_pb_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_pl_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_pl_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_ps_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_ps_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_po_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_po_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_pfh_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_pfh_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_bali_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_bali_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['kerbau_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['kerbau_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['kuda_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['kuda_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['babi'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['kambing_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['kambing_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['domba_jtn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['domba_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['unggas'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['itik'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['doc'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['telur'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['spt'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['skkh'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sksr'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['skb'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['tanpa_surat'] }}</th>
                </tr>
                <tr>
                    <th colspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">TOTAL</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_pb_jtn']+@$jumArray['sapi_bibit_pb_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_pl_jtn']+@$jumArray['sapi_bibit_pl_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_ps_jtn']+@$jumArray['sapi_bibit_ps_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_po_jtn']+@$jumArray['sapi_bibit_po_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_bibit_pfh_jtn']+@$jumArray['sapi_bibit_pfh_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_pb_jtn']+@$jumArray['sapi_potong_pb_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_pl_jtn']+@$jumArray['sapi_potong_pl_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_ps_jtn']+@$jumArray['sapi_potong_ps_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_po_jtn']+@$jumArray['sapi_potong_po_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_pfh_jtn']+@$jumArray['sapi_potong_pfh_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sapi_potong_bali_jtn']+@$jumArray['sapi_potong_bali_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['kerbau_jtn']+@$jumArray['kerbau_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['kuda_jtn']+@$jumArray['kuda_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['babi'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['kambing_jtn']+@$jumArray['kambing_btn'] }}</th>
                    <th colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['domba_jtn']+@$jumArray['domba_btn'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['unggas'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['itik'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['doc'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['telur'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['spt'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['skkh'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['sksr'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['skb'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['tanpa_surat'] }}</th>
                </tr>
            </tbody>
        </table>
	</body>
</html>
