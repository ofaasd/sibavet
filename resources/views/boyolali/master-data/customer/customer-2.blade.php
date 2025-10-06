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
                                        {!! Form::model($listCustomer, ['method'=>'PATCH', 'url'=> '/master-data/customer/'.$listCustomer->id.$var['url']['all'], 'id'=>'form-customer']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-customer', 'method'=>'POST', 'url'=>'/master-data/customer']) !!}
                                    @else
                                        {!! Form::model($listCustomer, ['class'=>'form-customer']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('nama_pelanggan', 'Nama Pelanggan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nama_pelanggan', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama Pelanggan']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('alamat', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Alamat']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('provinsi_id', 'Provinsi', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('provinsi_id', $var['provinsi'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Provinsi', 'style'=>'width: 100%;', 'onchange'=>'dataKota()']) !!}
                                            </div>
                                        </div>
                                        <div id="areaKota">
                                            <div class="form-group row">
                                                {!! Form::label('kota_id', 'Kota / Kabupaten', ['class' => 'col-sm-2 col-form-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::select('kota_id', [], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kota / Kabupaten', 'style'=>'width: 100%;']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div id="areaKecamatan">
                                            <div class="form-group row">
                                                {!! Form::label('kecamatan_id', 'Kecamatan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::select('kecamatan_id', [], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kecamatan', 'style'=>'width: 100%;', 'onchange'=>'']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div id="areaKelurahan">
                                            <div class="form-group row">
                                                {!! Form::label('kelurahan_id', 'Kelurahan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::select('kelurahan_id', [], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kelurahan', 'style'=>'width: 100%;']) !!}
                                                </div>
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
