<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sibavet">
    <meta name="author" content="Visualmedia Semarang">
    <link rel="icon" href="{{ asset('fabadmin/images/favicon.ico') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME', 'Laravel') }}</title>

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

</head>
<body class="hold-transition">

	<section class="bg-img h-p100" style="background-image: url({{ asset('fabadmin/images/photo1.jpg') }});">
		<div class="container h-p100">
		  <div class="row h-p100 align-items-center justify-content-center">
			<div class="col-lg-8 col-11">
			  <div class="error-page bg-white rounded">
				<div class="error-content">
					<div class="row h-p100 align-items-center bg-bubbles-dark bg-danger">
						<div class="col-lg-6 col-md-12 bg-white text-dark">
							<div class="p-30">
								<h1 class="text-danger font-size-80 font-weight-700"> 403</h1>
								<h2>Oopss</h2>
								<h5>Anda tidak punya akses !</h5>
								<p>Anda tidak mempunyai hak untuk mengakses halaman ini. Klik kembali untuk ke halaman sebelumnya. </p>
								<div class="mb-15">
								  <a href="{{ url()->previous() }}" class="btn btn-info btn-block margin-top-10">Kembali</a>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
						 	<div class="error-content-inner text-center p-15">
							  <h1 class="margin-top-0 headline"><i class="fa fa-warning text-white"></i></h1>
							  <h2>Anda tidak punya akses !</h2>
								 <h4 class="mb-15">Hubungi admin untuk membukakan akses ke halaman ini.</h4>
							</div>
						</div>
					</div>
				</div>
				<!-- /.error-content -->
			  </div>
              <!-- /.error-page -->
                <footer class="main-footer bg-transparent text-white ml-0 text-center no-border">
                    &copy; {!! \Carbon\Carbon::now()->format('Y') !!}. siBavet (Sistem Informasi Balai Veteriner). Development by <a href="http://visualmedia.web.id/">Visual Media</a>. All Rights Reserved.
                </footer>
			</div>
		  </div>
		</div>
	</section>


	<!-- jQuery 3 -->
	<script src={{ asset('fabadmin/assets/vendor_components/jquery/dist/jquery.min.js') }}"></script>

	<!-- popper -->
	<script src="{{ asset('fabadmin/assets/vendor_components/popper/dist/popper.min.js') }}"></script>

	<!-- Bootstrap 4.0-->
	<script src="{{ asset('fabadmin/assets/vendor_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>


</body>
</html>
