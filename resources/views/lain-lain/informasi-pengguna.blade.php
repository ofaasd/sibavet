@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Informasi Pengguna
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Informasi Pengguna</li>
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
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    {!! Form::model($listUser, ['class'=>'form-horizontal']) !!}
                                        <div class="form-group row">
                                            {!! Form::label('nip', 'Nomor Induk Pegawai', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nip', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Induk Pegawai']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('name', 'Nama Pegawai', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama Pegawai']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('no_handphone', 'Nomor Handphone', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('no_handphone', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Handphone']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('email', 'Email', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Email']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('satuan_kerja_id', 'Satuan Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('satuan_kerja_id', $listUser->satuanKerja->satuan_kerja, ['class'=>'form-control', 'placeholder'=>'Inputkan Satuan Kerja']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('sub_satuan_kerja_id', 'Sub Satuan Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('sub_satuan_kerja_id', $listUser->subSatuanKerja->sub_satuan_kerja, ['class'=>'form-control', 'placeholder'=>'Inputkan Sub Satuan Kerja']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('view_data', 'View Data', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('view_data', $var['viewData'], null, ['class'=>'form-control', 'placeholder'=>'Pilih View Data']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('role', 'Role', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('role', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Role']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('username', 'Username', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('username', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Username']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
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
