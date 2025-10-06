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
            table {width:100%;margin:5px 0px 5px 0px;table-layout: auto;}
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

            div.vertical{
                transform: rotate(-90deg);
            }
        </style>
	</head>
	<body>
        <center><h3>REKAPITULASI PEMERIKSAAN SAMPEL DI {{ $var['namaLaboratorium'] }}</h3></center>
        <center><h3>PERIODE : {{ $var['periode']}}</h3></center>
        <br />

        <table class="table-border">
            <thead>
                <tr>
                    <th rowspan="4" style="text-align:center; font-size:12px; background-color: #c1c1c1;">NO.</th>
                    <th rowspan="4" style="text-align:center; font-size:12px; background-color: #c1c1c1;">ASAL KAB / KOTA</th>
                    <th rowspan="2" colspan="12" style="text-align:center; font-size:12px; background-color: #c1c1c1;">SAMPEL</th>
                    <th colspan="21" style="text-align:center; font-size:12px; background-color: #c1c1c1;">UJI</th>
                    <th colspan="2" rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">KEGIATAN</th>
                    <th rowspan="4" style="text-align:center; font-size:12px; background-color: #c1c1c1;">KETERANGAN</th>
                </tr>
                <tr>
                    <th colspan="5" style="text-align:center; font-size:12px; background-color: #c1c1c1;">KELOMPOK UJI</th>
                    <th colspan="13" style="text-align:center; font-size:12px; background-color: #c1c1c1;">JENIS UJI</th>
                    <th rowspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">JML</th>
                    <th rowspan="2" colspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">HASIL UJI</th>
                </tr>
                <tr>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">HEWAN</th>
                    <th colspan="10" style="text-align:center; font-size:12px; background-color: #c1c1c1;">JENIS</th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;">JML</th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Parasitologi</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Bioteknologi</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Serologi</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Hematologi</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Patologi</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Ectoparasit</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">PCR AI</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">HA/HI AI</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">HA/HI ND</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Hematologi</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Parasit Darah</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Parasit Internal</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">RBT</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Pullorum</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Micoplasma</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">PCR IS</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">CRD Micoplasma</div></th>
                    <th rowspan="2" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Nekropsi Unggas</div></th>
                </tr>
                <tr>
                    <th height="60px" style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Sarang</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Telur</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Feses</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Serum</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Swab</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Darah</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Kerokan Kulit</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Daging</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Bulu</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Organ</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Negatif</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Positif</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Aktif</div></th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;"><div class="vertical">Pasif</div></th>
                </tr>
                <tr>
                    @for($noKolom=1;$noKolom<=38;$noKolom++)
                        <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ $noKolom }}</th>
                    @endfor
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
                        $kolomHewan = $helper->kolomHewan($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id);
                        $kolomHewanAsal = 0;
                    @endphp
                        @foreach($kolomHewan['jenisHewan'] as $jenisHewan)
                            @php
                                $kolomHewanAsal++;
                                $jumlahSampelJenis = 0;
                                $jumlahJenisPengujian = 0;
                            @endphp
                                <tr>
                                    @if($kolomHewanAsal == 1)
                                        <td style="text-align:center; vertical-align:middle;" rowspan="{!! $kolomHewan['jenisHewan']->count() !!}">{{ $no }}</td>
                                        <td style="text-align:center; vertical-align:middle;" rowspan="{!! $kolomHewan['jenisHewan']->count() !!}">{{ str_replace('KABUPATEN', '', $kolomHewan['kotaAsal']->name) }}</td>
                                    @endif
                                    <td style="text-align:center; vertical-align:middle;">{{ $jenisHewan->nama_spesies }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Sarang');
                                        @$jumArray['jumlah_sarang'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Telur');
                                        @$jumArray['jumlah_telur'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Feses');
                                        @$jumArray['jumlah_feses'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Serum');
                                        @$jumArray['jumlah_serum'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Swab');
                                        @$jumArray['jumlah_swab'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Darah');
                                        @$jumArray['jumlah_darah'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Kerokan Kulit');
                                        @$jumArray['jumlah_kerokan_kulit'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Daging');
                                        @$jumArray['jumlah_daging'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Bulu');
                                        @$jumArray['jumlah_bulu'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        $jumlahJenis = $helper->jumlahJenis($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Organ');
                                        @$jumArray['jumlah_organ'] += $jumlahJenis;
                                        $jumlahSampelJenis += $jumlahJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenis }}</td>

                                    @php
                                        @$jumArray['jumlah_sampel_jenis'] += $jumlahSampelJenis;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahSampelJenis }}</td>

                                    @php
                                        $jumlahKelompokUji = $helper->jumlahKelompokUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Parasitologi');
                                        @$jumArray['jumlah_parasitologi'] += $jumlahKelompokUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahKelompokUji }}</td>

                                    @php
                                        $jumlahKelompokUji = $helper->jumlahKelompokUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Bioteknologi');
                                        @$jumArray['jumlah_bioteknologi'] += $jumlahKelompokUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahKelompokUji }}</td>

                                    @php
                                        $jumlahKelompokUji = $helper->jumlahKelompokUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Serologi');
                                        @$jumArray['jumlah_serologi'] += $jumlahKelompokUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahKelompokUji }}</td>

                                    @php
                                        $jumlahKelompokUji = $helper->jumlahKelompokUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Hematologi');
                                        @$jumArray['jumlah_hematologi'] += $jumlahKelompokUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahKelompokUji }}</td>

                                    @php
                                        $jumlahKelompokUji = $helper->jumlahKelompokUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Patologi');
                                        @$jumArray['jumlah_patologi'] += $jumlahKelompokUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahKelompokUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Ectoparasit');
                                        @$jumArray['jumlah_ectoparasit'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'PCR AI');
                                        @$jumArray['jumlah_pcr_ai'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'HA/HI AI');
                                        @$jumArray['jumlah_ha/hi_ai'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'HA/HI ND');
                                        @$jumArray['jumlah_ha/hi_nd'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Hematologi');
                                        @$jumArray['jumlah_hematologi'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Parasit Darah');
                                        @$jumArray['jumlah_parasit_darah'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Parasit Internal');
                                        @$jumArray['jumlah_parasit_internal'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'RBT');
                                        @$jumArray['jumlah_rbt'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'PullorumRBT');
                                        @$jumArray['jumlah_pullorum'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Micoplasma');
                                        @$jumArray['jumlah_micoplasma'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'PCR IS');
                                        @$jumArray['jumlah_pcr_is'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'CRD Micoplasma');
                                        @$jumArray['jumlah_crd_micoplasma'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        $jumlahJenisUji = $helper->jumlahJenisUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Nekropsi Unggas');
                                        @$jumArray['jumlah_nekropsi_unggas'] += $jumlahJenisUji;
                                        $jumlahJenisPengujian += $jumlahJenisUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisUji }}</td>

                                    @php
                                        @$jumArray['jumlah_jenis_pengujian'] += $jumlahJenisPengujian;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahJenisPengujian }}</td>

                                    @php
                                        $jumlahHasilUji = $helper->jumlahHasilUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Negatif');
                                        @$jumArray['jumlah_negatif'] += $jumlahHasilUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahHasilUji }}</td>

                                    @php
                                        $jumlahHasilUji = $helper->jumlahHasilUji($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Positif');
                                        @$jumArray['jumlah_positif'] += $jumlahHasilUji;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahHasilUji }}</td>

                                    @php
                                        $jumlahKegiatan = $helper->jumlahKegiatan($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Aktif');
                                        @$jumArray['jumlah_aktif'] += $jumlahKegiatan;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahKegiatan }}</td>

                                    @php
                                        $jumlahKegiatan = $helper->jumlahKegiatan($var['dari_tanggal'], $var['sampai_tanggal'], $var['subSatuanKerjaId'], $item->asal_contoh_id,
                                                    $jenisHewan->id, 'Pasif');
                                        @$jumArray['jumlah_pasif'] += $jumlahKegiatan;
                                    @endphp
                                    <td style="text-align:center; vertical-align:middle;">{{ $jumlahKegiatan }}</td>

                                    <td style="text-align:center; vertical-align:middle;">&nbsp;</td>
                                </tr>
                        @endforeach
                @endforeach
                <tr>
                    <th colspan="3" style="text-align:center; font-size:12px; background-color: #c1c1c1;">JUMLAH</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_sarang'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_telur'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_feses'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_serum'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_swab'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_darah'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_kerokan_kulit'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_daging'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_bulu'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_organ'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_sampel_jenis'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_parasitologi'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_bioteknologi'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_serologi'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_hematologi'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_patologi'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_ectoparasit'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_pcr_ai'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_ha/hi_ai'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_ha/hi_nd'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_hematologi'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_parasit_darah'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_parasit_internal'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_rbt'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_pullorum'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_micoplasma'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_pcr_is'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_crd_micoplasma'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_nekropsi_unggas'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_jenis_pengujian'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_negatif'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_positif'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_aktif'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">{{ @$jumArray['jumlah_pasif'] }}</th>
                    <th style="text-align:center; font-size:12px; background-color: #c1c1c1;">&nbsp;</th>
                </tr>
            </tbody>
        </table>
	</body>
</html>
