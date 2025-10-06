<table>
    <tr>
        <th class="center">NO.</th>
        <th class="center">Tanggal</th>
        <th class="center">Lokasi Pengambilan</th>
        <th class="center">CONTOH</th>
        <th class="center">JML</th>
        <!-- <th class="center">JENIS PENGUJIAN</th> -->
    <!-- </tr> -->
    <!-- <tr> -->
        <th>SNI MAKS</th>
        <th>Kadar Air</th>
        <th>SNI MAKS</th>
        <th>Kadar Abu</th>
        <th>SNI MIN</th>
        <th>Protein</th>
        <th>SNI MIN</th>
        <th>Lemak</th>
        <th>SNI MAKS</th>
        <th>Serat</th>
    </tr>
    <tr>
        @for($noKolom=1;$noKolom<=15;$noKolom++)
            <th>{!! $noKolom !!}</th>
        @endfor
    </tr>
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
                <td rowspan="{!! $pakan->labContoh->count() !!}">{!! @date('d', strtotime($pakan->created_at)) !!}</td>
                <td rowspan="{!! $pakan->labContoh->count() !!}">{!! @$pakan->customer->nama_pelanggan !!}</td>        
        @else
            <tr>
        @endif
        <td>{!! $lc->nama_sampel !!}</td>
        <td>{!! $lc->pcontoh->jumlah !!}</td>
        @for($i=0;$i<(count($uji));$i++)
            @php
                $idujian = @$ujian->where('id',$uji[$i])->first()->pPengujian->id;
                $ujicontoh = @$hasil->where('lab_pengujian_id',$idujian)->first();
            @endphp
            <td>{!! @$ujicontoh->sni !!}</td>
            <td>{!! @$ujicontoh->nilai !!}</td>
        @endfor
        </tr>
    @endforeach
@endforeach
</table>
