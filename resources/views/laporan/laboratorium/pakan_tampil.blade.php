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
                    <th class="center">NO.</th>
                    <th class="center">Tanggal</th>
                    <th class="center">Lokasi Pengambilan</th>
                    <th class="center">CONTOH</th>
                    <!-- <th class="center">JML</th> -->
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
                @php
                    $pakang = $pakan->pakanTr;
                    if($pakang->count()==0){
                        continue;
                    }else{
                        $pakang = $pakang->groupBy('urut');
                    }
                @endphp
                @foreach($pakang as $key2=>$lc)
                    @php
                        $pakanc = $pakan->labContoh->where('pcontoh.urut',$key2)->first();
                        $pakanp = $pakan->pakanTr->where('urut',$key2);
                    @endphp
                    @if($key2==0)
                        <tr>
                            <td rowspan="{!! $pakang->count() !!}">{!! $key+1 !!}</td>
                            <td rowspan="{!! $pakang->count() !!}" class="center">{!! @date('d', strtotime($pakan->created_at)) !!}</td>
                            <td rowspan="{!! $pakang->count() !!}">{!! @$pakan->customer->nama_pelanggan !!}</td>        
                    @else
                        <tr>
                    @endif
                    <td center>{!! @$pakanc->nama_sampel !!}</td>
                    <!-- <td center></td> -->
                    @for($i=0;$i<(count($uji));$i++)
                        @php
                            $ujicontoh = @$pakanp->where('pengujian_id',$uji[0])->first();
                        @endphp
                        <td class="center">{!! @$ujicontoh->sni !!}</td>
                        <td class="center">{!! @$ujicontoh->nilai !!}</td>
                    @endfor
                    </tr>
                @endforeach
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
        $('#form-laporan-pakan').submit();
    });

    $('#tombol-cetak-pdf').click(function () {
        $('#tipe').val('PDF');
        $('#form-laporan-pakan').submit();
    });
</script>