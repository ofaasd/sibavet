@php
    $i = 0;
@endphp
<!-- /row -->
@if(!empty($listTerapi))
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="white-space: nowrap;">
                    <thead>
                        <tr class="bg-dark">
                            @if($method != 'show')
                                <th width="30px" style="text-align: center;"><b>Hapus</b></th>
                            @endif
                            <th style="text-align: center;"><b>Sampel</b></th>
                            <th style="text-align: center;"><b>Jumlah Sampel</b></th>
                            <th style="text-align: center;"><b>Jenis Pengujian</b></th>
                            <th style="text-align: center;"><b>Jumlah Hasil Uji</b></th>
                            <th style="text-align: center;"><b>Jumlah Positif</b></th>
                            <th style="text-align: center;"><b>Jumlah Negatif</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTerapi as $item)
                            <tr>
                                @if($method != 'show')
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            <a class="btn btn-danger btn-xs" href="#" onClick="hapusDataSampel('{{ $i }}')"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                @endif
                                <td>{{ $item['nm_sampel'] }}</td>
                                <td>{{ $item['jml_sampel'] }}</td>
                                <td>{{ $item['jenis_pengujian'] }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                                <td>{{ $item['positif'] }}</td>
                                <td>{{ $item['negatif'] }}</td>
                            </tr>
                            @php
                                 $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
<!-- /.row -->
