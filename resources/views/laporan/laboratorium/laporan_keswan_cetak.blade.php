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
            table {table-layout: auto;}
            h1,h2,h3,h4,h5 {padding:0 0 0 0;margin:0 0 0 0;line-height:1.4}
            .header {vertical-align:top;}
            .header {
                border-bottom:4px double #222222;
                margin-bottom:5px;
            }
            
            .table_outer_border {border:1px solid #000000;padding:10px}

            .table-border {border-collapse: collapse;}
            .table-border tr td {
                border:1px solid #000000;
                vertical-align:middle;
            }
            .table-border tr .bottom{
                border:1px solid #000000;
                vertical-align:middle;
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

            div,p {font-size:12px;}
            table tr td {font-size:10px;}
            table tr th {font-size:12px;}

            .tengah {
                text-align: center;
            }

            div.vertical{
                transform: rotate(-90deg);
            }
        </style>
        <style type="text/css">


th.rotate {
  height:80pt !important;
  white-space: nowrap;
  position:relative;
  text-align: left !important;
  width: 20px !important;
  overflow: hidden;
}

th.rotate > div {
  transform: rotate(90deg);
  position:absolute;
  left:0pt;
  right:0;
  top: 20pt;
  margin:auto;
  padding:0px;
}

#rotate
{
  height:125px;
}

#vertical
{
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
    margin-left: -50px;
    margin-right: -50px;
}

/*th.rotate > div {
    transform: rotate(-90deg);
    width: 30px;
}*/

th {
  padding: 2pt;
}

.center{
    text-align: center !important;
}

td{
    padding: 5pt;
}
</style>
    </head>
    <body>
        <center><h3>REKAPITULASI PEMERIKSAAN SAMPEL</h3></center>
        <center><h3>PERIODE :  {!! $data['tanggal_awal'].' s/d '.$data['tanggal_akhir'] !!}</h3></center>
        <br />

        <table class="table-border">
            <thead>
                <tr>
                    <th rowspan="4" class="center">NO.</th>
                    <th rowspan="4" class="center">ASAL KAB / KOTA</th>
                    <th rowspan="4" class="center">HEWAN</th>
                    <th colspan="39" class="center">JENIS UJI</th>
                    <th rowspan="4" class="center">JML</th>
                    <th rowspan="2" colspan="5" class="center">HASIL UJI</th>
                    <th rowspan="2" colspan="2" class="center">KEGIATAN</th>
                    <th rowspan="4" class="center">KETERANGAN</th>
                </tr>
                <tr>
                    <th rowspan="" colspan="3" class="center"><div><span>Ectoparasit</span></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>PCR AI</span></th></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>HA/HI AI</span></div></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>HA/HI ND</span></div></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>Hematologi</span></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>Parasit Darah</span></th></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>Parasit Internal</span></th></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>RBT</span></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>Pullorum</span></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>Micoplasma</span></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>PCR IS</span></th></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>CRD</span></th></div></th>
                    <th rowspan="" colspan="3" class="center"><div><span>Nekropsi</span></th></div></th>
                </tr>
                <tr>
                    @for($noKolom=1;$noKolom<=13;$noKolom++)
                        <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>JML</span></div></th>
                        <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>NEGATIF</span></div></th>
                        <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>POSITIF</span></div></th>
                    @endfor
                    <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>NEGATIF</span></div></th>
                    <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>POSITIF</span></div></th>
                    <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>Titer 0</span></div></th>
                    <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>Titer Rendah</span></div></th>
                    <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>Titer Tinggi</span></div></th>
                    <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>AKTIF</span></div></th>
                    <th rowspan="2" class="rotate" id="rotate"><div id="vertical"><span>PASIF</span></div></th>
                </tr>
                <tr>
                </tr>
                <tr>
                    @for($noKolom=1;$noKolom<=51;$noKolom++)
                        <th class="center">{{ $noKolom }}</th>
                    @endfor
                </tr>
                @php
                $cetak = $data['keswan'];
                $keswan = $data['keswan'];
                $asal = $cetak->unique('asal_contoh_id');
                @endphp
                @foreach($data['keswan']->unique('asal_contoh_id') as $key=>$asl)
                <tr>
                    @php
                        $data_asal = $data['keswan']->where('asal_contoh_id',$asl->asal_contoh_id);
                        $hewan = $data['keswan']->unique('jenis_hewan_id');
                    @endphp
                    <td>
                        {!! $key+1 !!}
                    </td>
                    <td>
                        {!! @$asl->kotaKabupaten->name !!}                        
                    </td>
                    @foreach($hewan as $key2=>$hwn)
                        {!! !$loop->first?"<tr><td></td><td></td>":"" !!}
                        @php
                        $data_hewan = $data_asal->where('jenis_hewan_id',$hwn->jenis_hewan_id);
                        $data_uji = $data_hewan->pluck('labPengujian')->flatten();
                        $data_uji = $data_uji->pluck('pPengujian')->flatten();
                        @endphp
                            <td class="center nilai">{!! $hwn->spesies->nama_spesies !!}</td>
                            
                            @php($lab[6] = sumUjian($data_uji,6))
                            <td class="center nilai">{!! @$lab[6]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[6][4] !!}</td>
                            <td class="center nilai">{!! @$lab[6][3] !!}</td>
                            @php($lab[16] = sumUjian($data_uji,16))
                            <td class="center nilai">{!! @$lab[16]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[16][4] !!}</td>
                            <td class="center nilai">{!! @$lab[16][3] !!}</td>
                            @php($lab[8] = sumUjian($data_uji,8))
                            <td class="center nilai">{!! @$lab[8]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[8][4] !!}</td>
                            <td class="center nilai">{!! @$lab[8][3] !!}</td>
                            @php($lab[9] = sumUjian($data_uji,9))
                            <td class="center nilai">{!! @$lab[9]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[9][4] !!}</td>
                            <td class="center nilai">{!! @$lab[9][3] !!}</td>
                            @php($lab[13] = sumUjian($data_uji,13))
                            <td class="center nilai">{!! @$lab[13]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[13][4] !!}</td>
                            <td class="center nilai">{!! @$lab[13][3] !!}</td>
                            @php($lab[7] = sumUjian($data_uji,7))
                            <td class="center nilai">{!! @$lab[7]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[7][4] !!}</td>
                            <td class="center nilai">{!! @$lab[7][3] !!}</td>
                            @php($lab[5] = sumUjian($data_uji,5))
                            <td class="center nilai">{!! @$lab[5]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[5][4] !!}</td>
                            <td class="center nilai">{!! @$lab[5][3] !!}</td>
                            @php($lab[10] = sumUjian($data_uji,10))
                            <td class="center nilai">{!! @$lab[10]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[10][4] !!}</td>
                            <td class="center nilai">{!! @$lab[10][3] !!}</td>
                            @php($lab[11] = sumUjian($data_uji,11))
                            <td class="center nilai">{!! @$lab[11]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[11][4] !!}</td>
                            <td class="center nilai">{!! @$lab[11][3] !!}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            @php($lab[17] = sumUjian($data_uji,17))
                            <td class="center nilai">{!! @$lab[17]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[17][4] !!}</td>
                            <td class="center nilai">{!! @$lab[17][3] !!}</td>
                            @php($lab[12] = sumUjian($data_uji,12))
                            <td class="center nilai">{!! @$lab[12]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[12][4] !!}</td>
                            <td class="center nilai">{!! @$lab[12][3] !!}</td>
                            @php($lab[19] = sumUjian($data_uji,19))
                            <td class="center nilai">{!! @$lab[19]->sum() !!}</td>
                            <td class="center nilai">{!! @$lab[19][4] !!}</td>
                            <td class="center nilai">{!! @$lab[19][3] !!}</td>
                            @php($total = sumUjianTotal($data_uji))
                            <td class="center nilai">{!! @$total[0] !!}</td>
                            <td class="center nilai">{!! @$total[1] !!}</td>
                            <td class="center nilai">{!! @$total[2] !!}</td>
                            <td class="center nilai">{!! @$total[3] !!}</td>
                            <td class="center nilai">{!! @$total[4] !!}</td>
                            <td class="center nilai">{!! @$total[5] !!}</td>
                            <td class="center nilai">{!! @$data_asal->where('status_epid','ED')->count() !!}</td>
                            <td class="center nilai">{!! @$data_asal->where('status_epid','Es')->count() !!}</td>
                            <td></td>
                        {!! $loop->last?"</tr>":"" !!}
                    @endforeach
                </tr>
                @endforeach
            </thead>
        </table>

    </body>
</html>
