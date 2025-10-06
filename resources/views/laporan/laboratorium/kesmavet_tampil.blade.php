<div class="box box-default" id="tabelkonten">
    <div class="box-header with-border">
        <h4 class="box-title">Periode: {!! $data['tanggal_awal'].' s/d '.$data['tanggal_akhir'] !!}</h4>
        <ul class="box-controls pull-right">
          <li><a class="box-btn-fullscreen" href="#"></a></li>
          <li><a class="box-btn-slide" href="#"></a></li>   
        </ul>
    </div>
    <div class="box-body" style="overflow-x: scroll;">
        <table class="table-bordered table">
            <thead>
                <tr>
                    <th rowspan="4" class="center">NO.</th>
                    <th rowspan="4" class="center rotate"><div><span>Tanggal Masuk</span></div></th>
                    <th rowspan="4" class="center rotate"><div><span>Tanggal Keluar</span></div></th>
                    <th rowspan="4" class="center">ASAL KAB / KOTA</th>
                    <th rowspan="4" class="center">CONTOH</th>
                    <th rowspan="4" class="center">JML</th>
                    <th colspan="40" class="center">JENIS PENGUJIAN</th>
                </tr>
                <tr>Input[name=tanggal_awal]                    <th rowspan="" colspan="12" class="center"><div><span>MIKROBIOLOGI</span></div></th>
                    <th rowspan="" colspan="14" class="center"><div><span>FISIKOKIMIA</span></div></th>
                    <th rowspan="" colspan="14" class="center"><div><span>RESIDO SCREENING DAN LOGAM BERAT</span></div></th>
                </tr>
                <tr>
                    <th colspan="2" class="center rotate"><div><span>TPC</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Coliform</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>E. Coli</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Sakniba</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>S. Aureus</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Champhy</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Formald</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Borak</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Organol</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>pH</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Lactosca</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Chorin</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Kadar Air</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>TC</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>ML</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>PC</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>AG</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Pb</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>Cu</span></div></th>
                    <th colspan="2" class="center rotate"><div><span>CD</span></div></th>
                </tr>
                <tr>
                    @for($noKolom=1;$noKolom<=20;$noKolom++)
                        <th class="center"><div><span>K</span></div></th>
                        <th class="center"><div><span>B</span></div></th>
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
    </div>
    <div class="box-footer flexbox">                     
        <div class="text-right flex-grow">
            <a href="#" id="tombol-cetak-excel" class="btn btn-info">excel</a>
            <a href="#" id="tombol-cetak-pdf" class="btn btn-primary">PDF</a>
        </div>
    </div>
    <!-- /.box -->
</div>
<style type="text/css">
table {
  border:1px solid black;
}
table th {
  border-bottom:1px solid black;
}


th.rotate {
  height:80px;
  white-space: nowrap;
  position:relative;
}

th.rotate > div {
  transform: rotate(90deg);
  position:absolute;
  left:0;
  right:0;
  top: 10px;
  padding: 10px;
  margin:auto;
  
}
</style>
<script type="text/javascript">
    $('#tombol-cetak-excel').click(function () {
        $('#tipe').val('Excel');
        $('#form-laporan-kesmavet').submit();
    });

    $('#tombol-cetak-pdf').click(function () {
        $('#tipe').val('PDF');
        $('#form-laporan-kesmavet').submit();
    });
</script>