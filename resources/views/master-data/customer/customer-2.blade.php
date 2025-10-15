@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Customer</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/customer') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/customer/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        <form id="form-customer" method="POST" action="{{ url('/master-data/customer/'.$listCustomer->id.$var['url']['all']) }}">
                                            @csrf
                                            @method('PATCH')
                                    @elseif($var['method']=='create')
                                        <form id="form-customer" method="POST" action="{{ url('/master-data/customer') }}">
                                            @csrf
                                    @else
                                        <form class="form-customer">
                                    @endif
                                        <div class="form-group row">
                                            <label for="nama_pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nama_pelanggan" id="nama_pelanggan" value="{{ old('nama_pelanggan', $listCustomer->nama_pelanggan ?? '') }}" class="form-control" placeholder="Inputkan Nama Pelanggan" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $listCustomer->alamat ?? '') }}" class="form-control" placeholder="Inputkan Alamat" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="provinsi_id" class="col-sm-2 col-form-label">Provinsi</label>
                                            <div class="col-sm-10">
                                                <select name="provinsi_id" id="provinsi_id" class="form-control select2" style="width: 100%;" onchange="dataKota()">
                                                    <option value="">Pilih Provinsi</option>
                                                    @foreach($var['provinsi'] as $key => $value)
                                                        <option value="{{ $key }}" {{ old('provinsi_id', $listCustomer->provinsi_id ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div id="areaKota">
                                            <div class="form-group row">
                                                <label for="kota_id" class="col-sm-2 col-form-label">Kota / Kabupaten</label>
                                                <div class="col-sm-10">
                                                    <select name="kota_id" id="kota_id" class="form-control select2" style="width: 100%;">
                                                        <option value="">Pilih Kota / Kabupaten</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="areaKecamatan">
                                            <div class="form-group row">
                                                <label for="kecamatan_id" class="col-sm-2 col-form-label">Kecamatan</label>
                                                <div class="col-sm-10">
                                                    <select name="kecamatan_id" id="kecamatan_id" class="form-control select2" style="width: 100%;">
                                                        <option value="">Pilih Kecamatan</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="areaKelurahan">
                                            <div class="form-group row">
                                                <label for="kelurahan_id" class="col-sm-2 col-form-label">Kelurahan</label>
                                                <div class="col-sm-10">
                                                    <select name="kelurahan_id" id="kelurahan_id" class="form-control select2" style="width: 100%;">
                                                        <option value="">Pilih Kelurahan</option>
                                                    </select>
                                                </div>
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
        function dataKota(aksi = '', provinsiId = '', kotaId = '') {
            if(provinsiId == '') provinsiId = $("#provinsi_id").val();
            $("#areaKota").load("{{ url('master-data/customer/area-kota') }}"+"?provinsiId="+provinsiId+"&kotaId="+kotaId);
            if(aksi == '') dataKecamatan();
        }

        function dataKecamatan(aksi = '', kotaId = '', kecamatanId = '') {
            if(kotaId == '') kotaId = $("#kota_id").val();
            $("#areaKecamatan").load("{{ url('master-data/customer/area-kecamatan') }}"+"?kotaId="+kotaId+"&kecamatanId="+kecamatanId);
            if(aksi == '') dataKelurahan();
        }

        function dataKelurahan(aksi = '', kecamatanId = '', kelurahanId = '') {
            if(kecamatanId == '') kecamatanId = $("#kecamatan_id").val();
            $("#areaKelurahan").load("{{ url('master-data/customer/area-kelurahan') }}"+"?kecamatanId="+kecamatanId+"&kelurahanId="+kelurahanId);
        }

        $(document).ready(function() {
            @if($var['method']=='edit' || $var['method']=='show')
                var pk = "{{ $listCustomer->id }}";
                dataKota("$var['method']", "{{ $listCustomer->provinsi_id }}", "{{ $listCustomer->kota_id }}");
                dataKecamatan("$var['method']", "{{ $listCustomer->kota_id }}", "{{ $listCustomer->kecamatan_id }}");
                dataKelurahan("$var['method']", "{{ $listCustomer->kecamatan_id }}", "{{ $listCustomer->kelurahan_id }}");
            @else
                var pk = null;
            @endif

            $("#form-customer").validate({
                rules: {
                    nama_pelanggan: "required",
                    alamat: "required",
                },
                messages: {
                    nama_pelanggan: "Kolom nama pelanggan harus diisi",
                    alamat: "Kolom alamat harus diisi",
                }
            });
        });
    </script>
@endsection
