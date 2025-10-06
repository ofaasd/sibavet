@php
    $cetak = $data['keswan'];
    $keswan = $data['keswan'];
    $asal = $cetak->unique('asal_contoh_id');
@endphp
<div class="box box-default">
    <div class="box-header with-border">
        <h4 class="box-title">Periode: {!! $data['bulan'].' '.$data['tahun'] !!}</h4>
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
                    <th rowspan="4" class="center">ASAL KAB / KOTA</th>
                    <th rowspan="4" class="center">HEWAN</th>

                    <th rowspan="4" class="center">HEWAN</th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="box-footer flexbox">                     
        <div class="text-right flex-grow">
            <a href="#" id="tombol-cetak" class="btn btn-primary">Cetak</a>
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
