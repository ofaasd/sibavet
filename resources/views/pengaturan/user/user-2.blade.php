@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pengguna
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
            <li class="breadcrumb-item active">Pengguna</li>
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
                            <li class="nav-item"><a href="{{ url('pengaturan/pengguna') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('pengaturan/pengguna/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listUser, ['method'=>'PATCH', 'url'=> '/pengaturan/pengguna/'.$listUser->id.$var['url']['all'], 'id'=>'form-pengguna']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-pengguna', 'method'=>'POST', 'url'=>'/pengaturan/pengguna']) !!}
                                    @else
                                        {!! Form::model($listUser, ['class'=>'form-horizontal']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('nip', 'Nomor Induk Pegawai', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nip', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Induk Pegawai']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('name', 'Nama Pegawai', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama Pegawai']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('no_handphone', 'Nomor Handphone', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('no_handphone', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Handphone']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('email', 'Email', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Email']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('satuan_kerja_id', 'Satuan Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('satuan_kerja_id', $var['satuanKerja'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Satuan Kerja', 'onchange'=>'satuanKerja()']) !!}
                                            </div>
                                        </div>
                                        <div id="areaSubSatuanKerja">
                                            <div class="form-group row">
                                                {!! Form::label('sub_satuan_kerja_id', 'Sub Satuan Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::select('sub_satuan_kerja_id', [], null, ['class'=>'form-control', 'placeholder'=>'Pilih Sub Satuan Kerja']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('view_data', 'View Data', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('view_data', $var['viewData'], null, ['class'=>'form-control', 'placeholder'=>'Pilih View Data']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('role', 'Role', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('role', $var['role'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Role']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('username', 'Username', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('username', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Username']) !!}
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
        function satuanKerja(aksi = '', subSatuanKerjaId= ''){
            var satuanKerja = $("#satuan_kerja_id").val();
            if(aksi == ''){
                $("#areaSubSatuanKerja").load("{{ url('pengaturan/pengguna/satuan-kerja') }}"+"?satuanKerjaId="+satuanKerja);
            }else{
                $("#areaSubSatuanKerja").load("{{ url('pengaturan/pengguna/satuan-kerja') }}"+"?satuanKerjaId="+satuanKerja+"&subSatuanKerjaId="+subSatuanKerjaId);
            }
        }

        $(document).ready(function() {
            @if($var['method']=='edit' || $var['method']=='show')
                var pk = "{{ $listUser->id }}";
                satuanKerja("{{ $var['method'] }}", "{{ $listUser->sub_satuan_kerja_id }}");
            @else
                var pk = null;
            @endif

            $("#form-pengguna").validate({
                rules: {
                    nip: {
                        required: true,
                        remote: {
                            url: "{{ url('pengaturan/pengguna/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "nip",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    name: "required",
                    email: {
                        required: true,
                        remote: {
                            url: "{{ url('pengaturan/pengguna/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "email",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    satuan_kerja_id: "required",
                    sub_satuan_kerja_id: "required",
                    view_data: "required",
                    role: "required",
                    username: {
                        required: true,
                        remote: {
                            url: "{{ url('pengaturan/pengguna/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "username",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                },
                messages: {
                    nip: {
                        required: "Kolom NIP harus diisi",
                        remote: "NIP sudah digunakan"
                    },
                    name: "Kolom nama karyawan harus diisi",
                    email: {
                        required: "Kolom email harus diisi",
                        remote: "Email sudah digunakan"
                    },
                    satuan_kerja_id: "Kolom satuan kerja harus diisi",
                    sub_satuan_kerja_id: "Kolom sub satuan kerja harus diisi",
                    view_data: "Kolom view data harus diisi",
                    role: "Kolom role harus diisi",
                    username: {
                        required: "Kolom username harus diisi",
                        remote: "Username sudah digunakan"
                    },
                }
            });
        });
    </script>
@endsection
