<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Sibavet">
<meta name="author" content="Visualmedia Semarang">
<link rel="icon" href="{{ asset('fabadmin/images/icon.png') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ env('APP_NAME', 'siBavet') }}</title>

<!-- Bootstrap 4.0-->
<link rel="stylesheet" href="{{ asset('fabadmin/assets/vendor_components/bootstrap/dist/css/bootstrap.min.css') }}">

<!-- Bootstrap extend-->
<link rel="stylesheet" href="{{ asset('fabadmin/main/css/bootstrap-extend.css') }}">

<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{ asset('fabadmin/assets/vendor_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('fabadmin/assets/vendor_components/select2/dist/css/select2.min.css') }}">

<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('fabadmin/assets/vendor_plugins/timepicker/bootstrap-timepicker.min.css') }}">

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('fabadmin/main/css/master_style.css') }}">

<!-- Fab Admin skins -->
<link rel="stylesheet" href="{{ asset('fabadmin/main/css/skins/_all-skins.css') }}">

<!--alerts CSS -->
<link href="{{ asset('fabadmin/assets/vendor_components/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('fabadmin/assets/vendor_components/jquery-toast-plugin-master/dist/jquery.toast.min.css') }}" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
    /* Form Error */
    label.error {
        color: #c4002e;
        font-weight: 300;
    }
    .form-control.error {
        border: 1px solid #c4002e;
    }

    /*Sweet Alert*/
    .sa-button-container {
        display: -webkit-flex;
        display: flex;
        -webkit-justify-content: center;
                  justify-content: center;
    }
    .sa-button-container .cancel {
        -webkit-order: 2;
                order: 2;
    }
    .sa-button-container .sa-confirm-button-container {
        -webkit-order: 1;
                order: 1;
    }
	.required:after{ 
        content:'*'; 
        color:red; 
        padding-left:5px;
    }
</style>
<link href="{{ asset('packages/css/custom.css') }}" rel="stylesheet" type="text/css">
<!-- Preloader -->
<style type="text/css">
.jq-toast-wrap.top-right {
  top: 80px;
}

.preloader {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background-color: #fff;
}
.preloader .loading {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%,-50%);
  font: 14px arial;
}
</style>
<!-- end Preloader -->