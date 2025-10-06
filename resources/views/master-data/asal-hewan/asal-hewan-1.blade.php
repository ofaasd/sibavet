@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Asal Hewan
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Asal Hewan</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/asal-hewan') }}" class="nav-link active"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            @can('Create Asal Hewan')
                                <li class="nav-item"><a href="{{ url('master-data/asal-hewan/create') }}" class="nav-link"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                            @endcan
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            @can('Create Asal Hewan')
                                                <a href="{{ url('master-data/asal-hewan/create') }}" class="btn btn-primary"><b>Tambah Data</b></a>
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
                                                    <th width="100px" style="text-align:center;">Aksi</th>
                                                    <th style="text-align:center;">Kode</th>
                                                    <th style="text-align:center;">Nama Bahan Asal Hewan</th>
                                                    <th style="text-align:center;">Satuan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach($listAsalHewan as $item)
                                                @php
                                                    $no++;
                                                @endphp
                                                <tr>
                                                    <td style="text-align:center">
                                                        <div class="btn-group">
                                                            {!! Form::open(['method'=>'delete', 'url'=>'/master-data/asal-hewan/'.$item->id.$var['url']['all'], 'class'=> 'delete_form']) !!}
                                                            {!! Form::hidden('nomor', $no, ['class'=>'form-control']) !!}
                                                            <div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
                                                                @can('Delete Asal Hewan')
                                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                                @endcan
                                                                @can('Update Asal Hewan')
                                                                    <a href="{{ url('/master-data/asal-hewan/'.$item->id.'/edit'.$var['url']['all'])}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                                                @endcan
                                                                <a href="{{ url('/master-data/asal-hewan/'.$item->id.$var['url']['all'])}}" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->kode }}</td>
                                                    <td>{{ $item->asal_hewan }}</td>
                                                    <td>{{ $item->satuan }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-8 ml-auto">
                                            {{ $listAsalHewan->render() }}
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
