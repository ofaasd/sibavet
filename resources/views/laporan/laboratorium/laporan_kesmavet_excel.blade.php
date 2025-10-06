<table>
    <tr>
        <th rowspan="4">NO.</th>
        <th rowspan="4">Tanggal Masuk</th>
        <th rowspan="4">Tanggal Keluar</th>
        <th rowspan="4">ASAL KAB / KOTA</th>
        <th rowspan="4">CONTOH</th>
        <th rowspan="4">JML</th>
        <th colspan="40">JENIS PENGUJIAN</th>
    </tr>
    <tr>
        <th colspan="12">MIKROBIOLOGI</th>
        <th colspan="14">FISIKOKIMIA</th>
        <th colspan="14">RESIDO SCREENING DAN LOGAM BERAT</th>
    </tr>
    <tr>
        <th colspan="2">TPC</th>
        <th colspan="2">Coliform</th>
        <th colspan="2">E. Coli</th>
        <th colspan="2">Sakniba</th>
        <th colspan="2">S. Aureus</th>
        <th colspan="2">Champhy</th>
        <th colspan="2">Formald</th>
        <th colspan="2">Borak</th>
        <th colspan="2">Organol</th>
        <th colspan="2">pH</th>
        <th colspan="2">Lactosca</th>
        <th colspan="2">Chorin</th>
        <th colspan="2">Kadar Air</th>
        <th colspan="2">TC</th>
        <th colspan="2">ML</th>
        <th colspan="2">PC</th>
        <th colspan="2">AG</th>
        <th colspan="2">Pb</th>
        <th colspan="2">Cu</th>
        <th colspan="2">CD</th>
    </tr>
    <tr>
        @for($noKolom=1;$noKolom<=20;$noKolom++)
            <th>K</th>
            <th>B</th>
        @endfor
    </tr>
@php($uji = [29,30,31,33,32,34,37,38,52,39,51,41,24,42,43,44,45,48,46,47])
@foreach($data['kesmavet'] as $key=>$kesmavet)
    <tr>
        <td>{!! $key+1 !!}</td>
        <td>{!! @date('d', strtotime($kesmavet->created_at)) !!}</td>
        <td>{!! @date('d', strtotime($kesmavet->time_02)) !!}</td>
        <td>{!! @$kesmavet->kotaKabupaten->name !!}</td>
        <td>{!! @$kesmavet->spesies->nama_spesies !!}</td>
        <td>{!! @$kesmavet->labContoh->sum('pcontoh.jumlah') !!}</td>
        @for($i=0;$i<(count($uji));$i++)
        <td>{!! @$kesmavet->labPengujian->where('pPengujian.pengujian_id',$uji[$i])->sum('pPengujian.negatif') !!}</td>
        <td>{!! @$kesmavet->labPengujian->where('pPengujian.pengujian_id',$uji[$i])->sum('pPengujian.positif') !!}</td>
        @endfor
    </tr>
@endforeach
</table>