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
                                        <form id="form-pemeriksa" method="POST" action="{{ url('/master-data/pemeriksa/'.$listPemeriksa->id.$var['url']['all']) }}">
                                            @csrf
                                            @method('PATCH')
                                    @elseif($var['method']=='create')
                                        <form id="form-pemeriksa" method="POST" action="{{ url('/master-data/pemeriksa') }}">
                                            @csrf
                                    @else
                                        <form class="form-pemeriksa">
                                    @endif
                                        <div class="form-group row">
                                            <label for="nip" class="col-sm-2 col-form-label">NIP.</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nip" id="nip" value="{{ old('nip', $listPemeriksa->nip ?? '') }}" class="form-control" placeholder="Inputkan NIP." />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nama" id="nama" value="{{ old('nama', $listPemeriksa->nama ?? '') }}" class="form-control" placeholder="Inputkan Nama" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Satuan Kerja</label>
                                            <div class="col-sm-10">
                                                <select name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control">
                                                    <option value="">Pilih Satuan Kerja</option>
                                                    @foreach($var['subSatuanKerja'] as $key => $value)
                                                        <option value="{{ $key }}" {{ old('sub_satuan_kerja_id', $listPemeriksa->sub_satuan_kerja_id ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
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
