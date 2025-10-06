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
                    <th rowspan="2" colspan="12" class="center">SAMPEL</th>
                    <th colspan="22" class="center">UJI</th>
                    <th rowspan="2" colspan="5" class="center">HASIL UJI</th>
                    <th rowspan="2" colspan="2" class="center">KEGIATAN</th>
                </tr>
                <tr>
                    <th colspan="6" class="center">KELOMPOK UJI</th>
                    <th colspan="15" class="center">JENIS UJI</th>
                    <th rowspan="3" class="center">JML</th>
                </tr>
                <tr>
                    <th rowspan="2" class="center">HEWAN</th>
                    <th colspan="10" class="center">JENIS</th>
                    <th rowspan="2" class="center">JML</th>
                    <th rowspan="2" class="center rotate"><div><span>Parasitologi</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Bioteknologi</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Serologi</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Hematologi</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Patologi</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Bakteriologi</span></div></th>

                    <th rowspan="2" class="center rotate"><div><span>Ectoparasit</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>PCR AI</span></th></div></th>
                    <th rowspan="2" class="center rotate"><div><span>HA/HI AI</span></div></div></th>
                    <th rowspan="2" class="center rotate"><div><span>HA/HI ND</span></div></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Hematologi</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Parasit Darah</span></th></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Parasit Internal</span></th></div></th>
                    <th rowspan="2" class="center rotate"><div><span>RBT</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Pullorum</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Micoplasma</span></div></th>
                    <th rowspan="2" class="center rotate"><div><span>PCR IS</span></th></div></th>
                    <th rowspan="2" class="center rotate"><div><span>CRD</span></th></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Nekropsi</span></th></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Kultur Bakteri</span></th></div></th>
                    <th rowspan="2" class="center rotate"><div><span>Pewarnaan Gram</span></th></div></th>
                </tr>
                <tr>
                    <th height="60px" class="center rotate"><div><span>Sarang</span></div></th>
                    <th class="center rotate"><div><span>Telur</span></div></th>
                    <th class="center rotate"><div><span>Feses</span></div></th>
                    <th class="center rotate"><div><span>Serum</span></div></th>
                    <th class="center rotate"><div><span>Swab</span></div></th>
                    <th class="center rotate"><div><span>Darah</span></div></th>
                    <th class="center rotate"><div><span>Kerokan</span></th></div></th>
                    <th class="center rotate"><div><span>Daging</span></div></th>
                    <th class="center rotate"><div><span>Bulu</span></div></th>
                    <th class="center rotate"><div><span>Organ</span></div></th>
                    <th class="center rotate"><div><span>Negatif</span></div></th>
                    <th class="center rotate"><div><span>Positif</span></div></th>
                    <th class="center rotate"><div><span>Titer 0</span></div></th>
                    <th class="center rotate"><div><span>Titer &darr;</span></div></th>
                    <th class="center rotate"><div><span>Titer &uarr;</span></div></th>
                    <th class="center rotate"><div><span>Pasif</span></div></th>
                    <th class="center rotate"><div><span>Aktif</span></div></th>
                </tr>
                <tr>
                    @for($noKolom=1;$noKolom<=43;$noKolom++)
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
                        $data_contoh = $data_hewan->pluck('labContoh')->flatten();
                        $data_contoh = $data_contoh->pluck('pcontoh')->flatten();
                        $data_uji = $data_hewan->pluck('labPengujian')->flatten();
                        $data_uji = $data_uji->pluck('pPengujian')->flatten();
                        @endphp
                            <td>{!! $hwn->spesies->nama_spesies !!}</td>
                            
                            <td>{!! @$data_contoh->where('contoh_id',21)->sum('jumlah') !!}</td>
                            <td>{!! @$data_contoh->where('contoh_id',24)->sum('jumlah') !!}</td>
                            <td>{!! @$data_contoh->where('contoh_id',23)->sum('jumlah') !!}</td>
                            <td>{!! @$data_contoh->where('contoh_id',18)->sum('jumlah') !!}</td>
                            <td>{!! @$data_contoh->where('contoh_id',19)->sum('jumlah') !!}</td>
                            <td>{!! @$data_contoh->where('contoh_id',22)->sum('jumlah') !!}</td>
                            <td>0</td>
                            <td>{!! @$data_contoh->where('contoh_id',20)->sum('jumlah') !!}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>{!! @$data_contoh->sum('jumlah') !!}</td>
                            <!-- Kelompok Uji -->
                            <td>{!! @sumContohSeksi($data_hewan,5) !!}</td>
                            <td>{!! @sumContohSeksi($data_hewan,10) !!}</td>
                            <td>{!! @sumContohSeksi($data_hewan,6) !!}</td>
                            <td>{!! @sumContohSeksi($data_hewan,7) !!}</td>
                            <td>{!! @sumContohSeksi($data_hewan,1) !!}</td>
                            <td>{!! @sumContohSeksi($data_hewan,3) !!}</td>
                            <td>{!! @sumContohUji($data_uji,6) !!}</td>
                            <td>{!! @sumContohUji($data_uji,16) !!}</td>
                            <td>{!! @sumContohUji($data_uji,8) !!}</td>
                            <td>{!! @sumContohUji($data_uji,9) !!}</td>
                            <td>{!! @sumContohUji($data_uji,13) !!}</td>
                            <td>{!! @sumContohUji($data_uji,7) !!}</td>
                            <td>{!! @sumContohUji($data_uji,5) !!}</td>
                            <td>{!! @sumContohUji($data_uji,10) !!}</td>
                            <td>{!! @sumContohUji($data_uji,11) !!}</td>
                            <td>0</td>
                            <td>{!! @sumContohUji($data_uji,17) !!}</td>
                            <td>{!! @sumContohUji($data_uji,12) !!}</td>
                            <td>{!! @sumContohUji($data_uji,19) !!}</td>
                            <td>{!! @sumContohUji($data_uji,22) !!}</td>
                            <td>{!! @sumContohUji($data_uji,23) !!}</td>
                            <td>{!! @$data_contoh->sum('jumlah')*2 !!}</td>
                            <td>{!! @$data_uji->sum('negatif') !!}</td>
                            <td>{!! @$data_uji->sum('positif') !!}</td>
                            <td>{!! @$data_uji->sum('nol') !!}</td>
                            <td>{!! @$data_uji->sum('rendah') !!}</td>
                            <td>{!! @$data_uji->sum('tinggi') !!}</td>
                            <td>{!! @$data_contoh->sum('jumlah')*2 !!}</td>
                            <td>0</td>
                        {!! $loop->last?"</tr>":"" !!}
                    @endforeach
                </tr>
                @endforeach
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