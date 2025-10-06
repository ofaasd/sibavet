        <table class="table-border">
                <tr>
                    <td rowspan="4">NO.</td>
                    <td rowspan="4">ASAL KAB / KOTA</td>
                    <td rowspan="4">HEWAN</td>
                    <td colspan="39">JENIS UJI</td>
                    <td rowspan="4">JML</td>
                    <td rowspan="2" colspan="5">HASIL UJI</td>
                    <td rowspan="2" colspan="2">KEGIATAN</td>
                    <td rowspan="4">KETERANGAN</td>
                </tr>
                <tr>
                    <td colspan="3">Ectoparasit</td>
                    <td colspan="3">PCR AI</td></td>
                    <td colspan="3">HA/HI AI</td>
                    <td colspan="3">HA/HI ND</td>
                    <td colspan="3">Hematologi</td>
                    <td colspan="3">Parasit Darah</td></td>
                    <td colspan="3">Parasit Internal</td></td>
                    <td colspan="3">RBT</td>
                    <td colspan="3">Pullorum</td>
                    <td colspan="3">Micoplasma</td>
                    <td colspan="3">PCR IS</td></td>
                    <td colspan="3">CRD</td>
                    <td colspan="3">Nekropsi</td>
                </tr>
                <tr>
                    @for($noKolom=1;$noKolom<=13;$noKolom++)
                        <td rowspan="2">JML</td>
                        <td rowspan="2">NEGATIF</td>
                        <td rowspan="2">POSITIF</td>
                    @endfor
                    <td rowspan="2">NEGATIF</td>
                    <td rowspan="2">POSITIF</td>
                    <td rowspan="2">Titer 0</td>
                    <td rowspan="2">Titer Rendah</td>
                    <td rowspan="2">Titer Tinggi</td>
                    <td rowspan="2">AKTIF</td>
                    <td rowspan="2">PASIF</td>
                </tr>
                <tr>
                </tr>
                <tr>
                    @for($noKolom=1;$noKolom<=51;$noKolom++)
                        <td>{{ $noKolom }}</td>
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
        </table>