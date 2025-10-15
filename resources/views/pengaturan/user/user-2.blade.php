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
                                        <form method="POST" action="/pengaturan/pengguna/{{ $listUser->id }}{{ $var['url']['all'] }}" id="form-pengguna">
                                            @csrf
                                            @method('PATCH')
                                    @elseif($var['method']=='create')
                                        <form method="POST" action="/pengaturan/pengguna" id="form-pengguna">
                                            @csrf
                                    @else
                                        <form class="form-horizontal">
                                    @endif
                                        <div class="form-group row">
                                            <label for="nip" class="col-sm-2 col-form-label">Nomor Induk Pegawai</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nip" id="nip" class="form-control" placeholder="Inputkan Nomor Induk Pegawai" 
                                                    value="{{ old('nip', isset($listUser) ? $listUser->nip : '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 col-form-label">Nama Pegawai</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Inputkan Nama Pegawai" 
                                                    value="{{ old('name', isset($listUser) ? $listUser->name : '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="no_handphone" class="col-sm-2 col-form-label">Nomor Handphone</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="no_handphone" id="no_handphone" class="form-control" placeholder="Inputkan Nomor Handphone" 
                                                    value="{{ old('no_handphone', isset($listUser) ? $listUser->no_handphone : '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" id="email" class="form-control" placeholder="Inputkan Email" 
                                                    value="{{ old('email', isset($listUser) ? $listUser->email : '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="satuan_kerja_id" class="col-sm-2 col-form-label">Satuan Kerja</label>
                                            <div class="col-sm-10">
                                                <select name="satuan_kerja_id" id="satuan_kerja_id" class="form-control" onchange="satuanKerja()">
                                                    <option value="">Pilih Satuan Kerja</option>
                                                    @foreach($var['satuanKerja'] as $key => $value)
                                                        <option value="{{ $key }}" {{ old('satuan_kerja_id', isset($listUser) ? $listUser->satuan_kerja_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div id="areaSubSatuanKerja">
                                            <div class="form-group row">
                                                <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Sub Satuan Kerja</label>
                                                <div class="col-sm-10">
                                                    <select name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control">
                                                        <option value="">Pilih Sub Satuan Kerja</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="view_data" class="col-sm-2 col-form-label">View Data</label>
                                            <div class="col-sm-10">
                                                <select name="view_data" id="view_data" class="form-control">
                                                    <option value="">Pilih View Data</option>
                                                    @foreach($var['viewData'] as $key => $value)
                                                        <option value="{{ $key }}" {{ old('view_data', isset($listUser) ? $listUser->view_data : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="role" class="col-sm-2 col-form-label">Role</label>
                                            <div class="col-sm-10">
                                                <select name="role" id="role" class="form-control">
                                                    <option value="">Pilih Role</option>
                                                    @foreach($var['role'] as $key => $value)
                                                        <option value="{{ $key }}" {{ old('role', isset($listUser) ? $listUser->role : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="username" id="username" class="form-control" placeholder="Inputkan Username" 
                                                    value="{{ old('username', isset($listUser) ? $listUser->username : '') }}">
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
