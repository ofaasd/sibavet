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


/*th.rotate {
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
}*/

/*#rotate
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
*/
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
        <center><h3>Periode: {!! $data['tanggal_awal'].' s/d '.$data['tanggal_akhir'] !!}</h3></center>
        <br />

        <table class="table-border">
            <thead>
                <tr>
                    <th class="center">NO.</th>
                    <th class="center">Tanggal</th>
                    <th class="center">Lokasi Pengambilan</th>
                    <th class="center">CONTOH</th>
                    <th class="center">JML</th>
                    <!-- <th class="center">JENIS PENGUJIAN</th> -->
                <!-- </tr> -->
                <!-- <tr> -->
                    <th class="center">SNI MAKS</th>
                    <th class="center">Kadar Air</th>
                    <th class="center">SNI MAKS</th>
                    <th class="center">Kadar Abu</th>
                    <th class="center">SNI MIN</th>
                    <th class="center">Protein</th>
                    <th class="center">SNI MIN</th>
                    <th class="center">Lemak</th>
                    <th class="center">SNI MAKS</th>
                    <th class="center">Serat</th>
                </tr>
                <tr>
                    @for($noKolom=1;$noKolom<=15;$noKolom++)
                        <th>{!! $noKolom !!}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
            @php
                $uji = [24,28,25,26,27];
            @endphp
            @foreach($data['pakan'] as $key=>$pakan)
                @foreach($pakan->labContoh as $key=>$lc)
                    @php
                        $hasil = $pakan->hasilPenilaian->where('lab_contoh_id',$lc->pcontoh->id);
                        $ujian = $pakan->labPengujian;
                    @endphp
                    @if($key==0)
                        <tr>
                            <td rowspan="{!! $pakan->labContoh->count() !!}">{!! $key+1 !!}</td>
                            <td rowspan="{!! $pakan->labContoh->count() !!}" class="center">{!! @date('d', strtotime($pakan->created_at)) !!}</td>
                            <td rowspan="{!! $pakan->labContoh->count() !!}">{!! @$pakan->customer->nama_pelanggan !!}</td>        
                    @else
                        <tr>
                    @endif
                    <td class="center">{!! $lc->nama_sampel !!}</td>
                    <td class="center">{!! $lc->pcontoh->jumlah !!}</td>
                    @for($i=0;$i<(count($uji));$i++)
                        @php
                            $idujian = @$ujian->where('id',$uji[$i])->first()->pPengujian->id;
                            $ujicontoh = @$hasil->where('lab_pengujian_id',$idujian)->first();
                        @endphp
                        <td class="center">{!! @$ujicontoh->sni !!}</td>
                        <td class="center">{!! @$ujicontoh->nilai !!}</td>
                    @endfor
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>

    </body>
</html>
