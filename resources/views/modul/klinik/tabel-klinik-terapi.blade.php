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
                            <th style="text-align: center;"><b>Terapi</b></th>
                            <th style="text-align: center;"><b>Dosis</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTerapi as $item)
                            <tr>
                                @if($method != 'show')
                                    <td class="text-center">
                                        <div class="btn-group btn-group-xs">
                                            <a class="btn btn-danger btn-xs" href="#" onClick="hapusDataTerapiDosis('{{ $i }}')"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                @endif
                                <td>{{ $item['namaTerapi'] }}</td>
                                <td>{{ $item['dosis'] }}</td>
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
