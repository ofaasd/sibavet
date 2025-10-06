@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ganti Password
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Ganti Password</li>
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
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    {!! Form::open(['id'=>'form-ganti-password', 'method'=>'POST', 'url'=>'/ganti-password']) !!}
                                        <div class="form-group row">
                                            {!! Form::label('password', 'Password Baru', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>'Inputkan Password Baru']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('password2', 'Konfirmasi Password', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::password('password2', ['class'=>'form-control', 'placeholder'=>'Inputkan Konfirmasi Password']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
                                                {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#form-ganti-password").validate({
                rules: {
                    password: "required",
                    password2: {
                        required: true,
                        equalTo: password
                    }
                },
                messages: {
                    password: "Kolom password harus diisi",
                    password2: {
                        required: "Kolom konfirmasi password harus diisi",
                        equalTo: "Konfirmasi password harus sama dengan password baru"
                    }
                }
            });
        });

    </script>
@endsection
