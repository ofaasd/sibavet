@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pemeriksa
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Pemeriksa</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/pemeriksa') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/pemeriksa/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listPemeriksa, ['method'=>'PATCH', 'url'=> '/master-data/pemeriksa/'.$listPemeriksa->id.$var['url']['all'], 'id'=>'form-pemeriksa']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-pemeriksa', 'method'=>'POST', 'url'=>'/master-data/pemeriksa']) !!}
                                    @else
                                        {!! Form::model($listPemeriksa, ['class'=>'form-pemeriksa']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('nip', 'NIP.', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nip', null, ['class'=>'form-control', 'placeholder'=>'Inputkan NIP.']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('nama', 'Nama', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nama', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('sub_satuan_kerja_id', 'Satuan Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('sub_satuan_kerja_id', $var['subSatuanKerja'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Satuan Kerja']) !!}
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
                var pk = "{{ $listPemeriksa->id }}";
            @else
                var pk = null;
            @endif

            $("#form-pemeriksa").validate({
                rules: {
                    nip: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/pemeriksa/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "nip",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    nama: "required",
                    sub_satuan_kerja_id: "required",
                },
                messages: {
                    nip: {
                        required: "Kolom NIP. harus diisi",
                        remote: "NIP. sudah digunakan"
                    },
                    nama: "Kolom nama harus diisi",
                    sub_satuan_kerja_id: "Kolom PLLT harus diisi",
                }
            });
        });
    </script>
@endsection
