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
                                        <form id="form-jenis-pengujian" method="POST" action="{{ url('/master-data/jenis-pengujian/'.$listJenisPengujian->id.$var['url']['all']) }}">
                                            @csrf
                                            @method('PATCH')
                                    @elseif($var['method']=='create')
                                        <form id="form-jenis-pengujian" method="POST" action="{{ url('/master-data/jenis-pengujian') }}">
                                            @csrf
                                    @else
                                        <form class="form-jenis-pengujian">
                                    @endif
                                        <div class="form-group row">
                                            <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="kode" id="kode" value="{{ old('kode', $listJenisPengujian->kode ?? '') }}" class="form-control" placeholder="Inputkan Kode" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="seksi_laboratorium_id" class="col-sm-2 col-form-label">Seksi Laboratorium</label>
                                            <div class="col-sm-10">
                                                <select name="seksi_laboratorium_id" id="seksi_laboratorium_id" class="form-control">
                                                    <option value="">Pilih Seksi Laboratorium</option>
                                                    @foreach($var['seksiLaboratorium'] as $key => $value)
                                                        <option value="{{ $key }}" {{ old('seksi_laboratorium_id', $listJenisPengujian->seksi_laboratorium_id ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jenis_pengujian" class="col-sm-2 col-form-label">Jenis Pengujian</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="jenis_pengujian" id="jenis_pengujian" value="{{ old('jenis_pengujian', $listJenisPengujian->jenis_pengujian ?? '') }}" class="form-control" placeholder="Inputkan Jenis Pengujian" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="lab" class="col-sm-2 col-form-label">Laboratorium</label>
                                            <div class="col-sm-10">
                                                {!! viewSelectLaboratorium('lab',@$listJenisPengujian->lab) !!}
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
