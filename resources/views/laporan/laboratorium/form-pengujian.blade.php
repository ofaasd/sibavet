@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laporan Pengujian
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Laporan</a></li>
            <li class="breadcrumb-item active">Laporan Pengujian</li>
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
                                    {!! Form::open(['id'=>'form-cetak-pengujian', 'method'=>'POST', 'url'=>'/laporan/lap-pengujian', 'target'=>'_blank']) !!}
                                        <div class="form-group row">
                                            {!! Form::label('bulan', 'Bulan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                                {!! Form::select('bulan', $var['bulan'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Bulan']) !!}
                                            </div>
                                            {!! Form::label('tahun', 'Tahun', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                                {!! Form::number('tahun', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Tahun']) !!}
                                            </div>
                                        </div>
                                        @if(Auth::user()->view_data==3 || Auth::user()->view_data==4)
                                            <div class="form-group row">
                                                {!! Form::label('sub_satuan_kerja_id', 'Laboratorium', ['class' => 'col-sm-2 col-form-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::select('sub_satuan_kerja_id', $var['listLaboratorium'], null, ['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        @elseif(Auth::user()->view_data==1 || Auth::user()->view_data==2)
                                            <div class="form-group row">
                                                {!! Form::label('sub_satuan_kerja_id', 'Laboratorium', ['class' => 'col-sm-2 col-form-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::select('sub_satuan_kerja_id', $var['listLaboratorium'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Laboratorium']) !!}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            {!! Form::label('format', 'Format Laporan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('format', ['PDF'=>'PDF', 'Excel'=>'Excel'], null, ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                {!! Form::submit('Cetak', ['class'=>'btn btn-primary']) !!}
                                                {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
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

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#form-cetak-pengujian").validate({
                rules: {
                    bulan: "required",
                    tahun: "required",
                    sub_satuan_kerja_id: "required",
                },
                messages: {
                    bulan: "Kolom bulan harus diisi",
                    tahun: "Kolom tahun harus diisi",
                    sub_satuan_kerja_id: "Kolom laboratorium harus diisi",
                }
            });
        });

    </script>
@endsection
