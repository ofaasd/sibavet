@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Detail Periksa {{$listKlinik->nama_hewan}}
        </h1>
        
        <h3>
            Pemilik : {{$listKlinik->pemilik->nama}}
        </h3>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">
                    <h4> 
                        Data Hewan : {{$listKlinik->jenis_kelamin}} - {{$listKlinik->spesies['nama_spesies']}} - {{$listKlinik->ras['nama_ras']}} - {{$listKlinik->umur}} Tahun
                    </h4>
                    <h4>
                        Ciri-ciri : {{$listKlinik->ciri_ciri}}
                    </h4>
                    <h4>
                        Nomor Rekam Medis : {{$listKlinik->no_pasien}}
                    </h4>    
                        <table border=1 class="table">
                            <thead>
                                <tr><th>No</th><th>Tanggal Periksa</th><th>Anamnesa / Signalment</th><th>Diagnosa</th><th>Tindakan Penanganan dan Keterangan Penanganan</th><th>Keterangan</th><th>Pemeriksa</th></tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($klinikTerapi as $dat)
                                <tr>
                                    <td>{{$no}}</td><td>{{date('d F Y',strtotime($dat->tanggal_periksa))}}</td><td>{{$dat->anamnesia}} / {{$dat->anamnesia}}</td><td>{{$dat->diagnosa}}</td>
                                    <td>
                                    @foreach($dosis as $dos)
                                        @if(date('Y-m-d',strtotime($dos->created_at)) == date('Y-m-d',strtotime($dat->created_at)))
                                @if($dat->tindakan == 0 or $dat->tindakan == 1 or $dat->tindakan ==2)        
                                    {{$dos->obat}}
                                @elseif($dat->tindakan == 4)
                                    @foreach($operasi as $opr)
                                    {{$opr->tindakan}}
                                    @endforeach
                                @endif
                                    {{$dos->dosis}} ,
                                        @endif                                    
                                    @endforeach
                                    </td><td>{{$dat->keterangan}}</td><td>{{$dat->nmpemeriksa}}</td>
                                </tr>

                                @php
                                    $no++;
                                @endphp                                
                                @endforeach    
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
    <!-- /.content -->

@endsection

