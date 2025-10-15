@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Obat
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Obat</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/obat') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/obat/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad"> 
 @if($var['method']=='edit')
 <form id="form-obat" method="POST" action="{{ url('/master-data/obat/'.$listObat->id.$var['url']['all']) }}">
 @csrf
 @method('PATCH')
 @elseif($var['method']=='create')
 <form id="form-obat" method="POST" action="{{ url('/master-data/obat') }}">
 @csrf
 @else
 <form class="form-obat">
 @endif
 <div class="form-group row">
 <label for="kode" class="col-sm-2 col-form-label">Kode</label>
 <div class="col-sm-10">
 <input type="text" name="kode" id="kode" value="{{ old('kode', $listObat->kode ?? '') }}" class="form-control" placeholder="Inputkan Kode" />
 </div>
 </div>
 <div class="form-group row">
 <label for="obat" class="col-sm-2 col-form-label">Obat</label>
 <div class="col-sm-10">
 <input type="text" name="obat" id="obat" value="{{ old('obat', $listObat->obat ?? '') }}" class="form-control" placeholder="Inputkan Obat" />
 </div>
 </div>
 <div class="form-group row">
 <label for="klinik" class="col-sm-2 col-form-label">Status</label>
 <div class="col-sm-10">
 <select name="klinik" id="klinik" class="form-control select2" style="width: 100%;">
 <option value="0" {{ old('klinik', $listObat->klinik ?? '') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
 <option value="1" {{ old('klinik', $listObat->klinik ?? '') == '1' ? 'selected' : '' }}>Aktif</option>
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
                var pk = "{{ $listObat->id }}";
            @else
                var pk = null;
            @endif

            $("#form-obat").validate({
                rules: {
                    kode: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/obat/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "kode",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    obat: "required",
                },
                messages: {
                    kode: {
                        required: "Kolom kode harus diisi",
                        remote: "Kode sudah digunakan"
                    },
                    obat: "Kolom obat harus diisi",
                }
            });
        });
    </script>
@endsection
