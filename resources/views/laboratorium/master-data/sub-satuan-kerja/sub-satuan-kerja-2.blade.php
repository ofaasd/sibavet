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
                                        <form id="form-sub-satuan-kerja" method="POST" action="{{ url('/master-data/sub-satuan-kerja/'.$listSubSatuanKerja->id.$var['url']['all']) }}">
                                        @csrf
                                        @method('PATCH')
                                    @elseif($var['method']=='create')
                                        <form id="form-sub-satuan-kerja" method="POST" action="{{ url('/master-data/sub-satuan-kerja') }}">
                                        @csrf
                                    @else
                                        <form class="form-sub-satuan-kerja">
                                    @endif
                                        <div class="form-group row">
                                            <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="kode" id="kode" class="form-control" placeholder="Inputkan Kode" value="{{ $var['method'] == 'edit' ? $listSubSatuanKerja->kode : old('kode') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="satuan_kerja_id" class="col-sm-2 col-form-label">Satuan Kerja</label>
                                            <div class="col-sm-10">
                                                <select name="satuan_kerja_id" id="satuan_kerja_id" class="form-control">
                                                    <option value="">Pilih Satuan Kerja</option>
                                                    @foreach($var['satuanKerja'] as $key => $value)
                                                        <option value="{{ $key }}" {{ $var['method'] == 'edit' && $listSubSatuanKerja->satuan_kerja_id == $key ? 'selected' : (old('satuan_kerja_id') == $key ? 'selected' : '') }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="sub_satuan_kerja" class="col-sm-2 col-form-label">Sub Satuan Kerja</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="sub_satuan_kerja" id="sub_satuan_kerja" class="form-control" placeholder="Inputkan Sub Satuan Kerja" value="{{ $var['method'] == 'edit' ? $listSubSatuanKerja->sub_satuan_kerja : old('sub_satuan_kerja') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nama_kepala" class="col-sm-2 col-form-label">Nama Kepala</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nama_kepala" id="nama_kepala" class="form-control" placeholder="Inputkan Nama Kepala" value="{{ $var['method'] == 'edit' ? $listSubSatuanKerja->nama_kepala : old('nama_kepala') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nip" class="col-sm-2 col-form-label">NIP.</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nip" id="nip" class="form-control" placeholder="Inputkan NIP." value="{{ $var['method'] == 'edit' ? $listSubSatuanKerja->nip : old('nip') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Inputkan Alamat" value="{{ $var['method'] == 'edit' ? $listSubSatuanKerja->alamat : old('alamat') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="telp" class="col-sm-2 col-form-label">Telepon</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="telp" id="telp" class="form-control" placeholder="Inputkan Telepon" value="{{ $var['method'] == 'edit' ? $listSubSatuanKerja->telp : old('telp') }}">
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
