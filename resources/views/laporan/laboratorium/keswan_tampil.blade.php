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
                    <th rowspan="4" class="center">ASAL KAB / KOTA</th>
                    <th rowspan="4" class="center">HEWAN</th>
                    <th colspan="39" class="center">JENIS UJI</th>
                    <th rowspan="4" class="center">JML</th>
                    <th rowspan="3" colspan="5" class="center">HASIL UJI</th>
                    <th rowspan="3" colspan="2" class="center">KEGIATAN</th>
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
                        <th rowspan="2" class="center rotate"><div><span>JML</span></div></th>
                        <th rowspan="2" class="center rotate"><div><span>NEGATIF</span></div></th>
                        <th rowspan="2" class="center rotate"><div><span>POSITIF</span></div></th>
                    @endfor
                </tr>
                <tr>
                    <th rowspan="" class="center rotate"><div><span>NEGATIF</span></div></th>
                    <th rowspan="" class="center rotate"><div><span>POSITIF</span></div></th>
                    <th class="center rotate"><div><span>Titer 0</span></div></th>
                    <th class="center rotate"><div><span>Titer &darr;</span></div></th>
                    <th class="center rotate"><div><span>Titer &uarr;</span></div></th>
                    <th rowspan="" class="center rotate"><div><span>AKTIF</span></div></th>
                    <th rowspan="" class="center rotate"><div><span>PASIF</span></div></th>
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
                @foreach($asal as $key=>$asl)
                <tr>
                    @php
                        $data_asal = $keswan->where('asal_contoh_id',$asl->asal_contoh_id);
                        $hewan = $keswan->unique('jenis_hewan_id');
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
                            <td>{!! $hwn->spesies->nama_spesies !!}</td>
                            
                            @php($lab[6] = sumUjian($data_uji,6))
                            <td>{!! @$lab[6]->sum() !!}</td>
                            <td>{!! @$lab[6][4] !!}</td>
                            <td>{!! @$lab[6][3] !!}</td>
                            @php($lab[16] = sumUjian($data_uji,16))
                            <td>{!! @$lab[16]->sum() !!}</td>
                            <td>{!! @$lab[16][4] !!}</td>
                            <td>{!! @$lab[16][3] !!}</td>
                            @php($lab[8] = sumUjian($data_uji,8))
                            <td>{!! @$lab[8]->sum() !!}</td>
                            <td>{!! @$lab[8][4] !!}</td>
                            <td>{!! @$lab[8][3] !!}</td>
                            @php($lab[9] = sumUjian($data_uji,9))
                            <td>{!! @$lab[9]->sum() !!}</td>
                            <td>{!! @$lab[9][4] !!}</td>
                            <td>{!! @$lab[9][3] !!}</td>
                            @php($lab[13] = sumUjian($data_uji,13))
                            <td>{!! @$lab[13]->sum() !!}</td>
                            <td>{!! @$lab[13][4] !!}</td>
                            <td>{!! @$lab[13][3] !!}</td>
                            @php($lab[7] = sumUjian($data_uji,7))
                            <td>{!! @$lab[7]->sum() !!}</td>
                            <td>{!! @$lab[7][4] !!}</td>
                            <td>{!! @$lab[7][3] !!}</td>
                            @php($lab[5] = sumUjian($data_uji,5))
                            <td>{!! @$lab[5]->sum() !!}</td>
                            <td>{!! @$lab[5][4] !!}</td>
                            <td>{!! @$lab[5][3] !!}</td>
                            @php($lab[10] = sumUjian($data_uji,10))
                            <td>{!! @$lab[10]->sum() !!}</td>
                            <td>{!! @$lab[10][4] !!}</td>
                            <td>{!! @$lab[10][3] !!}</td>
                            @php($lab[11] = sumUjian($data_uji,11))
                            <td>{!! @$lab[11]->sum() !!}</td>
                            <td>{!! @$lab[11][4] !!}</td>
                            <td>{!! @$lab[11][3] !!}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            @php($lab[17] = sumUjian($data_uji,17))
                            <td>{!! @$lab[17]->sum() !!}</td>
                            <td>{!! @$lab[17][4] !!}</td>
                            <td>{!! @$lab[17][3] !!}</td>
                            @php($lab[12] = sumUjian($data_uji,12))
                            <td>{!! @$lab[12]->sum() !!}</td>
                            <td>{!! @$lab[12][4] !!}</td>
                            <td>{!! @$lab[12][3] !!}</td>
                            @php($lab[19] = sumUjian($data_uji,19))
                            <td>{!! @$lab[19]->sum() !!}</td>
                            <td>{!! @$lab[19][4] !!}</td>
                            <td>{!! @$lab[19][3] !!}</td>
                            @php($total = sumUjianTotal($data_uji))
                            <td>{!! @$total[0] !!}</td>
                            <td>{!! @$total[1] !!}</td>
                            <td>{!! @$total[2] !!}</td>
                            <td>{!! @$total[3] !!}</td>
                            <td>{!! @$total[4] !!}</td>
                            <td>{!! @$total[5] !!}</td>
                            <td>{!! @$data_asal->where('status_epid','ED')->count() !!}</td>
                            <td>{!! @$data_asal->where('status_epid','Es')->count() !!}</td>
                            <td></td>
                        {!! $loop->last?"</tr>":"" !!}
                    @endforeach
                </tr>
                @endforeach
            </thead>
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
        $('#form-laporan-keswan').submit();
    });

    $('#tombol-cetak-pdf').click(function () {
        $('#tipe').val('PDF');
        $('#form-laporan-keswan').submit();
    });
</script>