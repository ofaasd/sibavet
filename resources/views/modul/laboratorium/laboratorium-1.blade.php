@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratorium
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Laboratorium</li>
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
                            <li class="nav-item"><a href="{{ url('laboratorium') }}" class="nav-link active"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            @can('Create Laboratorium')
                                <li class="nav-item"><a href="{{ url('laboratorium/create') }}" class="nav-link"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                            @endcan
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            @can('Create Laboratorium')
                                                <a href="{{ url('laboratorium/create') }}" class="btn btn-primary"><b>Tambah Data</b></a>
                                            @endcan
                                        </div>
                                        <div class="col-lg-6">
                                            <form method="get" action="">
                                                <div class="input-group">
                                                    <input name="cari" type="text" class="form-control" placeholder="Inputkan Pencarian" value="{{ Request::get('cari') }}" />
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="btn btn-info">Cari</button>
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
                                                    <th style="text-align:center;">Laboratorium</th>
                                                    <th style="text-align:center;">No. Epid</th>
                                                    <th style="text-align:center;">Nama Pelanggan</th>
                                                    <th style="text-align:center;">Jenis Hewan</th>
                                                    <th style="text-align:center;">Seksi Laboratorium</th>
                                                    <th style="text-align:center;">Pengirim</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach($listLaboratorium as $item)
                                                @php
                                                    $no++;
                                                @endphp
                                                <tr>
                                                    <td style="text-align:center">
                                                        <div class="btn-group">
                                                            {!! Form::open(['method'=>'delete', 'url'=>'/laboratorium/'.$item->id.$var['url']['all'], 'class'=> 'delete_form']) !!}
                                                            {!! Form::hidden('nomor', $no, ['class'=>'form-control']) !!}
                                                            <div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
                                                                @can('Delete Laboratorium')
                                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                                @endcan
                                                                @can('Update Laboratorium')
                                                                    <a href="{{ url('/laboratorium/'.$item->id.'/edit'.$var['url']['all'])}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                                                @endcan
                                                                <a href="{{ url('/laboratorium/'.$item->id.$var['url']['all'])}}" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a>
                                                                <a href="{{ url('/laboratorium/cetak/'.$item->id)}}" class="btn btn-success btn-xs" target="_blank"><i class="fa fa-print"></i></a>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </td>
                                                    <td>{{ @$item->subSatuanKerja->sub_satuan_kerja }}</td>
                                                    <td>{{ $item->no_epid }}</td>
                                                    <td>{{ @$item->customer->nama_pelanggan }}</td>
                                                    <td>{{ @$item->spesies->nama_spesies }}</td>
                                                    <td>{{ @$item->seksiLaboratorium->seksi_laboratorium }}</td>
                                                    <td>{{ $item->pengirim }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-8 ml-auto">
                                            {{ $listLaboratorium->render() }}
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
