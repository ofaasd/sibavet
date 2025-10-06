@php
    $i = 0;
@endphp
<!-- /row -->
@if(!empty($listPlltFileAll))
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="white-space: nowrap;">
                    <thead>
                        <tr class="bg-dark">
                            <th width="90px" style="text-align: center;"><b>Aksi</b></th>
                            <th style="text-align: center;"><b>Nama File</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listPlltFileAll as $item)
                            <tr>
                                <td class="text-center">
                                    <div class="btn-group btn-group-xs">
                                        @if($method == 'edit')
                                        <a class="btn btn-danger btn-xs" href="#" onClick="hapusBerkas('{{ $i }}')"><i class="fa fa-trash"></i></a>
                                        @endif
                                        <a class="btn btn-primary btn-xs" href="{{ url('/')."/".$item['direktori'] }}" download><i class="fa fa-download"></i></a>
                                        <a class="btn btn-info btn-xs" href="{{ url('/')."/".$item['direktori'] }}" target="_blank"><i class="fa fa-search"></i></a>
                                    </div>
                                </td>
                                <td>{{ $item['namaFile'] }}</td>
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
