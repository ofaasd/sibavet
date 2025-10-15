@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ras
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Ras</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/ras') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/ras/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        <form id="form-ras" method="POST" action="{{ url('/master-data/ras/'.$listRas->id.$var['url']['all']) }}">
                                            @csrf
                                            @method('PATCH')
                                    @elseif($var['method']=='create')
                                        <form id="form-ras" method="POST" action="{{ url('/master-data/ras') }}">
                                            @csrf
                                    @else
                                        <form class="form-ras">
                                    @endif
                                        <div class="form-group row">
                                            <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="kode" id="kode" value="{{ old('kode', $listRas->kode ?? '') }}" class="form-control" placeholder="Inputkan Kode" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="spesies_id" class="col-sm-2 col-form-label">Spesies</label>
                                            <div class="col-sm-10">
                                                <select name="spesies_id" id="spesies_id" class="form-select">
                                                    <option value="">Pilih Spesies</option>
                                                    @foreach($var['spesies'] as $key => $value)
                                                        <option value="{{ $key }}" {{ old('spesies_id', $listRas->spesies_id ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama_ras" class="col-sm-2 col-form-label">Nama Ras</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nama_ras" id="nama_ras" value="{{ old('nama_ras', $listRas->nama_ras ?? '') }}" class="form-control" placeholder="Inputkan Nama Ras" />
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
                var pk = "{{ $listRas->id }}";
            @else
                var pk = null;
            @endif

            $("#form-ras").validate({
                rules: {
                    kode: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/ras/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "kode",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    spesies_id: "required",
                    nama_ras: "required",
                },
                messages: {
                    kode: {
                        required: "Kolom kode harus diisi",
                        remote: "Kode sudah digunakan"
                    },
                    spesies_id: "Kolom spesies harus diisi",
                    nama_ras: "Kolom nama ras harus diisi",
                }
            });
        });
    </script>
@endsection
