@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Sub Satuan Kerja
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Sub Satuan Kerja</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/sub-satuan-kerja') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/sub-satuan-kerja/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listSubSatuanKerja, ['method'=>'PATCH', 'url'=> '/master-data/sub-satuan-kerja/'.$listSubSatuanKerja->id.$var['url']['all'], 'id'=>'form-sub-satuan-kerja']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-sub-satuan-kerja', 'method'=>'POST', 'url'=>'/master-data/sub-satuan-kerja']) !!}
                                    @else
                                        {!! Form::model($listSubSatuanKerja, ['class'=>'form-sub-satuan-kerja']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('kode', 'Kode', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('kode', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Kode']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('satuan_kerja_id', 'Satuan Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('satuan_kerja_id', $var['satuanKerja'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Satuan Kerja']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('sub_satuan_kerja', 'Sub Satuan Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('sub_satuan_kerja', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Sub Satuan Kerja']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('nama_kepala', 'Nama Kepala', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nama_kepala', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama Kepala']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('nama_kepala', 'Nama Kepala', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nama_kepala', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama Kepala']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('nip', 'NIP.', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nip', null, ['class'=>'form-control', 'placeholder'=>'Inputkan NIP.']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('alamat', 'Alamat.', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('alamat', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Alamat']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('telp', 'Telepon.', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('telp', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Telepon']) !!}
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
                var pk = "{{ $listSubSatuanKerja->id }}";
            @else
                var pk = null;
            @endif

            $("#form-sub-satuan-kerja").validate({
                rules: {
                    kode: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/sub-satuan-kerja/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "kode",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    satuan_kerja_id: "required",
                    sub_satuan_kerja: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/sub-satuan-kerja/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "sub_satuan_kerja",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                },
                messages: {
                    kode: {
                        required: "Kolom kode harus diisi",
                        remote: "Kode sudah digunakan"
                    },
                    satuan_kerja_id: "Kolom satuan kerja harus diisi",
                    sub_satuan_kerja: {
                        required: "Kolom sub satuan kerja harus diisi",
                        remote: "Sub satuan kerja sudah digunakan"
                    },
                }
            });
        });
    </script>
@endsection
