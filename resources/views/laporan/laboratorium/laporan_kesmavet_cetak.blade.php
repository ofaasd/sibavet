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
                    <th rowspan="4" class="center">NO.</th>
                    <th rowspan="4" class="center"><div class="vertical">Tanggal Masuk</div></th>
                    <th rowspan="4" class="center"><div class="vertical">Tanggal Keluar</div></th>
                    <th rowspan="4" class="center">ASAL KAB / KOTA</th>
                    <th rowspan="4" class="center">CONTOH</th>
                    <th rowspan="4" class="center">JML</th>
                    <th colspan="40" class="center">JENIS PENGUJIAN</th>
                </tr>
                <tr>
                    <th rowspan="" colspan="12" class="center">MIKROBIOLOGI</th>
                    <th rowspan="" colspan="14" class="center">FISIKOKIMIA</th>
                    <th rowspan="" colspan="14" class="center">RESIDO SCREENING DAN LOGAM BERAT</th>
                </tr>
                <tr>
                    <th colspan="2" class="center" style="height: 100pt"><div class="vertical">TPC</div></th>
                    <th colspan="2" class="center"><div class="vertical">Coliform</div></th>
                    <th colspan="2" class="center"><div class="vertical">E. Coli</div></th>
                    <th colspan="2" class="center"><div class="vertical">Sakniba</div></th>
                    <th colspan="2" class="center"><div class="vertical">S. Aureus</div></th>
                    <th colspan="2" class="center"><div class="vertical">Champhy</div></th>
                    <th colspan="2" class="center"><div class="vertical">Formald</div></th>
                    <th colspan="2" class="center"><div class="vertical">Borak</div></th>
                    <th colspan="2" class="center"><div class="vertical">Organol</div></th>
                    <th colspan="2" class="center"><div class="vertical">pH</div></th>
                    <th colspan="2" class="center"><div class="vertical">Lactosca</div></th>
                    <th colspan="2" class="center"><div class="vertical">Chorin</div></th>
                    <th colspan="2" class="center"><div class="vertical">Kadar Air</div></th>
                    <th colspan="2" class="center"><div class="vertical">TC</div></th>
                    <th colspan="2" class="center"><div class="vertical">ML</div></th>
                    <th colspan="2" class="center"><div class="vertical">PC</div></th>
                    <th colspan="2" class="center"><div class="vertical">AG</div></th>
                    <th colspan="2" class="center"><div class="vertical">Pb</div></th>
                    <th colspan="2" class="center"><div class="vertical">Cu</div></th>
                    <th colspan="2" class="center"><div class="vertical">CD</div></th>
                </tr>
                <tr>
                    @for($noKolom=1;$noKolom<=20;$noKolom++)
                        <th class="center">K</th>
                        <th class="center">B</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
            @php($uji = [29,30,31,33,32,34,37,38,52,39,51,41,24,42,43,44,45,48,46,47])
            @foreach($data['kesmavet'] as $key=>$kesmavet)
                <tr>
                    <td class="center">{!! $key+1 !!}</td>
                    <td class="center">{!! @date('d', strtotime($kesmavet->created_at)) !!}</td>
                    <td class="center">{!! @date('d', strtotime($kesmavet->time_02)) !!}</td>
                    <td class="center">{!! @$kesmavet->kotaKabupaten->name !!}</td>
                    <td class="center">{!! @$kesmavet->spesies->nama_spesies !!}</td>
                    <td class="center">{!! @$kesmavet->labContoh->sum('pcontoh.jumlah') !!}</td>
                    @for($i=0;$i<(count($uji));$i++)
                    <td class="center">{!! @$kesmavet->labPengujian->where('pPengujian.pengujian_id',$uji[$i])->sum('pPengujian.negatif') !!}</td>
                    <td class="center">{!! @$kesmavet->labPengujian->where('pPengujian.pengujian_id',$uji[$i])->sum('pPengujian.positif') !!}</td>
                    @endfor
                </tr>
            @endforeach
            </tbody>
        </table>

    </body>
</html>
