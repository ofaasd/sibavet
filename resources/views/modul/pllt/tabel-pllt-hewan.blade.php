@php
    $i = 0;
@endphp
<!-- /row -->
@if(!empty($listPlltHewan))
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="white-space: nowrap;">
                    <thead>
                        <tr class="bg-dark">
                            @if($method != 'show')
                                <th width="30px" style="text-align: center;"><b>Hapus</b></th>
                            @endif
                            <th style="text-align: center;"><b>Spesies</b></th>
                            <th style="text-align: center;"><b>Ras</b></th>
                            <th style="text-align: center;"><b>Jumlah</b></th>
                            <th style="text-align: center;"><b>Satuan</b></th>
                            <th style="text-align: center;"><b>Jumlah Jantan</b></th>
                            <th style="text-align: center;"><b>Jumlah Betina</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listPlltHewan as $item)
                            <tr>
                                @if($method != 'show')
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            <a class="btn btn-danger btn-xs" href="#" onClick="hapusDataHewan('{{ $i }}')"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                @endif
                                <td>{{ $item['namaJenisSpesies'] }}</td>
                                <td>{{ $item['namaJenisHewan'] }}</td>
                                <td>{{ $item['jumlah'] }}</td>
                                <td>{{ $item['satuan'] }}</td>
                                <td>{{ $item['jumlahJantan'] }}</td>
                                <td>{{ $item['jumlahBetina'] }}</td>
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
