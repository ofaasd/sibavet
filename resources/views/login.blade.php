<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{{ asset('fabadmin/images/favicon.ico') }}">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ env('APP_NAME', 'siBavet') }} | Login</title>

        <!-- Bootstrap 4.0-->
        <link rel="stylesheet" href="{{ asset('fabadmin/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">

        <!-- Bootstrap extend-->
        <link rel="stylesheet" href="{{ asset('fabadmin/main/css/bootstrap-extend.css') }}">

        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('fabadmin/main/css/master_style.css') }}">

        <!-- Fab Admin skins -->
        <link rel="stylesheet" href="{{ asset('fabadmin/main/css/skins/_all-skins.css') }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <style type="text/css">
            /* Form Error */
            label.error {
                color: #ffffff;
                font-weight: 300;
            }
            .form-control.error {
                border: 1px solid #c4002e;
            }
        </style>

    </head>
    <body class="hold-transition login-page">

        <div class="container h-p100">
            <div class="row align-items-center justify-content-md-center h-p100">

                <div class="col-lg-4 col-md-8 col-12">
                    <div class="login-box">
                        <div class="login-box-body">
                            <h3 class="text-center">siBavet</h3>
                            <p class="login-box-msg">Sistem Informasi Balai Veteriner</p>

                            @if($errors->has('gagal'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    <strong>{{ $errors->first('gagal') }}</strong>
                                </div>
                            @endif

                            {!! Form::open(['id'=>'form-login', 'method'=>'POST', 'url'=>'/login']) !!}
                                <div class="form-group has-feedback">
                                    {!! Form::text('username', null, ['class'=>'form-control rounded', 'placeholder'=>'Inputkan Username']) !!}
                                    <span class="ion ion-person form-control-feedback"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    {!! Form::password('password', ['class'=>'form-control rounded', 'placeholder'=>'Inputkan Password']) !!}
                                    <span class="ion ion-locked form-control-feedback"></span>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="checkbox">
                                            <input type="checkbox" name="remember" id="remember-me" >
                                            <label for="remember-me">Remember Me</label>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-info btn-block margin-top-10">SIGN IN</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            {!! Form::close() !!}

                           <!--  <div class="social-auth-links text-center">
                            <p>- OR -</p>
                            <a href="#" class="btn btn-outline btn-light btn-social-icon"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="btn btn-outline btn-light btn-social-icon"><i class="fa fa-google-plus"></i></a>
                            <a href="#" class="btn btn-outline btn-light btn-social-icon"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="btn btn-outline btn-light btn-social-icon"><i class="fa fa-instagram"></i></a>
                            </div> -->
                            <!-- /.social-auth-links -->

                            <br />

                        </div>
                        <!-- /.login-box-body -->
                    </div>
                    <!-- /.login-box -->

                </div>
            </div>
        </div>

        <!-- jQuery 3 -->
        <script src="{{ asset('fabadmin/assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>

        <!-- popper -->
        <script src="{{ asset('fabadmin/assets/vendor_components/popper/dist/popper.min.js') }}"></script>

        <!-- Bootstrap 4.0-->
        <script src="{{ asset('fabadmin/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

        <!--Jquery Validate-->
        <script src="{{ asset('pluginku/jquery-validation-1.15.1/dist/jquery.validate.js') }}"></script>
        <script src="{{ asset('pluginku/jquery-validation-1.15.1/dist/additional-methods.js') }}"></script>

        <script>
            $(document).ready(function() {
                $("#form-login").validate({
                    rules: {
                        username: "required",
                        password: "required",
                    },
                    messages: {
                        username: "Kolom username harus diisi",
                        password: "Kolom password harus diisi",
                    }
                });
            });
        </script>
    </body>
</html>
