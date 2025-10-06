@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Jenis Pengujian
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Jenis Pengujian</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/jenis-pengujian') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/jenis-pengujian/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listJenisPengujian, ['method'=>'PATCH', 'url'=> '/master-data/jenis-pengujian/'.$listJenisPengujian->id.$var['url']['all'], 'id'=>'form-jenis-pengujian']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-jenis-pengujian', 'method'=>'POST', 'url'=>'/master-data/jenis-pengujian']) !!}
                                    @else
                                        {!! Form::model($listJenisPengujian, ['class'=>'form-jenis-pengujian']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('kode', 'Kode', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('kode', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Kode']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('seksi_laboratorium_id', 'Seksi Laboratorium', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('seksi_laboratorium_id', $var['seksiLaboratorium'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Seksi Laboratorium']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('jenis_pengujian', 'Jenis Pengujian', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('jenis_pengujian', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Jenis Pengujian']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('lab', 'Laboratorium', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! viewSelectLaboratorium('lab',@$listJenisPengujian->lab) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                @if($var['method']=='edit')
                                                    {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
                                                    {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
                                                @elseif($var['method']=='create')
                                                    {!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!}
                                                    {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
                                                @else
                                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                                                @endif
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
    <script>
        $(document).ready(function() {
            @if($var['method']=='edit' || $var['method']=='show')
                var pk = "{{ $listJenisPengujian->id }}";
            @else
                var pk = null;
            @endif

            $("#form-jenis-pengujian").validate({
                rules: {
                    kode: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/jenis-pengujian/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "kode",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    seksi_laboratorium_id: "required",
                    jenis_pengujian: "required",
                },
                messages: {
                    kode: {
                        required: "Kolom kode harus diisi",
                        remote: "Kode sudah digunakan"
                    },
                    seksi_laboratorium_id: "Kolom seksi laboratorium harus diisi",
                    jenis_pengujian: "Kolom jenis pengujian harus diisi",
                }
            });
        });
    </script>
@endsection
