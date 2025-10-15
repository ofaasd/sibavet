@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Seksi Laboratorium
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Seksi Laboratorium</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/seksi-laboratorium') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/seksi-laboratorium/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        <form id="form-spesies" method="POST" action="/master-data/seksi-laboratorium/{{ $listSeksiLaboratorium->id }}{{ $var['url']['all'] }}">
                                            @csrf
                                            @method('PATCH')
                                    @elseif($var['method']=='create')
                                        <form id="form-seksi-laboratorium" method="POST" action="/master-data/seksi-laboratorium">
                                            @csrf
                                    @else
                                        <form class="form-seksi-laboratorium">
                                            @csrf
                                    @endif
                                        <div class="form-group row">
                                            <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="kode" id="kode" class="form-control" placeholder="Inputkan Kode" value="{{ old('kode', $listSeksiLaboratorium->kode ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="seksi_laboratorium" class="col-sm-2 col-form-label">Seksi Laboratorium</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="seksi_laboratorium" id="seksi_laboratorium" class="form-control" placeholder="Inputkan Seksi Laboratorium" value="{{ old('seksi_laboratorium', $listSeksiLaboratorium->seksi_laboratorium ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lab" class="col-sm-2 col-form-label">Laboratorium</label>
                                            <div class="col-sm-10">
                                                {!! viewSelectLaboratorium('lab',@$listSeksiLaboratorium->lab) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                @if($var['method']=='edit')
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="reset" class="btn btn-danger">Reset</button>
                                                @elseif($var['method']=='create')
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <button type="reset" class="btn btn-danger">Reset</button>
                                                @else
                                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                                                @endif
                                            </div>
                                        </div>
                                    </form>
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
                var pk = "{{ $listSeksiLaboratorium->id }}";
            @else
                var pk = null;
            @endif

            $("#form-seksi-laboratorium").validate({
                rules: {
                    kode: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/seksi-laboratorium/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "kode",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    seksi_laboratorium: "required",
                },
                messages: {
                    kode: {
                        required: "Kolom kode harus diisi",
                        remote: "Kode sudah digunakan"
                    },
                    seksi_laboratorium: "Kolom seksi laboratorium harus diisi",
                }
            });
        });
    </script>
@endsection
