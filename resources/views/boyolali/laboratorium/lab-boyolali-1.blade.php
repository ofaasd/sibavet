@extends('boyolali.layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratorium Boyolali
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Laboratorium Boyolali</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="{{ url('boyolali') }}" class="nav-link active"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                                <li class="nav-item"><a href="{{ url('boyolali/lab-boyolali/create') }}" class="nav-link"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data Baru</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            @can('Create Klinik')
                                                <a href="{{ url('boyolali/lab-boyolali/create') }}" class="btn btn-primary"><b>Tambah Data</b></a>
                                            @endcan
                                        </div>
                                        <div class="col-lg-6">
                                            <form method="get" action="">
                                                <div class="input-group">
                                                    <input name="cari" type="text" class="form-control" placeholder="Inputkan Pencarian" value="{{ Request::get('cari') }}" />
                                                    <div class="input-group-prepend">
                                                        <button type="submit" class="btn btn-info">Cari</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <br />
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="bg-dark">
                                                    <th width="130px" style="text-align:center;">Aksi</th>
                                                    <th style="text-align:center;">Kelompok Kerja</th>
                                                    <th style="text-align:center;">Tanggal</th>
                                                    <th style="text-align:center;">Kecamatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach($listKlinik as $item)
                                                @php
                                                    $no++;
                                                @endphp
                                                <tr>
                                                    <td style="text-align:center">
                                                    <div class="btn-group">
                                                            {!! Form::open(['method'=>'delete', 'url'=>'/boyolali/lab-boyolali/'.$item->id.$var['url']['all'], 'class'=> 'delete_form']) !!}
                                                            {!! Form::hidden('nomor', $no, ['class'=>'form-control']) !!}
                                                            <div class="btn-group btn-group-xs" role="group" aria-label="Basic example">                                
                                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>                                                            
                                                                    <a href="{{ url('/boyolali/lab-boyolali/'.$item->id.'/edit'.$var['url']['all'])}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                                                
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </td>
                                                    <td>
                                                    {{$item->kelompok}} - {{$item->jenis}}
                                                    </td>
                                                    <td>
                                                    {{date('d F Y',strtotime($item->tanggal))}}
                                                    </td>
                                                    <td>
                                                    {{$item->kecamatan}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-8 ml-auto">
                                            {{ $listKlinik->render() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
    <!-- /.content -->

@endsection
