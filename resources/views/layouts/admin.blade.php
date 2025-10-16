<!DOCTYPE html>
<html lang="en">
    <head>
        @include('include/header')
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed">
        <div id="notifikasi" class="myadmin-alert myadmin-alert-img alert-success myadmin-alert-top-right">
            <a href="#" class="closed">&times;</a><h4>You have a Message!</h4> <b>John Doe</b> sent you a message.
        </div>
        <!-- Site wrapper -->
        <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="{{ url('dashboard') }}" class="logo">
            <!-- mini logo -->
            {{-- <b class="logo-mini">
                <span class="light-logo"><img src="{{ asset('fabadmin/images/logo-light.png') }}" alt="logo"></span>
                <span class="dark-logo"><img src="{{ asset('fabadmin/images/logo-dark.png') }}" alt="logo"></span>
            </b> --}}
            <!-- logo-->
            <span class="logo-lg">
                <img src="{{ asset('fabadmin/images/logo-light-text-2.png') }}" alt="logo" class="light-logo">
                {{-- <img src="{{ asset('fabadmin/images/logo-dark-text.png') }}" alt="logo" class="dark-logo"> --}}
            </span>
            </a>
            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <div>
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
            </div>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account-->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('fabadmin/images/avatarku.png') }}" class="user-image rounded-circle" alt="User Image">
                        </a>
                        <ul class="dropdown-menu scale-up">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('fabadmin/images/avatarku.png') }}" class="float-left rounded-circle" alt="User Image">

                            <p>
                            {{ Auth::user()->name }}
                            <small class="mb-5">{{ Auth::user()->email }}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row no-gutters">
                            <div class="col-12 text-left">
                                <a href="{{ url('informasi-pengguna') }}"><i class="fa fa-user-circle"></i> Informasi Pengguna</a>
                            </div>
                            <div class="col-12 text-left">
                                <a href="{{ url('ganti-password') }}"><i class="fa fa-lock"></i> GantI Password</a>
                            </div>
                            <div role="separator" class="divider col-12"></div>
                            <div class="col-12 text-left">
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); $('#logout-form-1').submit();">
                                    <form id="logout-form-1" action="{{ url('logout') }}" method="post" style="display: none;">
                                        {{ csrf_field() }}
										<input type="submit">
                                    </form>
                                    <i class="fa fa-power-off"></i> Logout
                                </a>
                            </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                </ul>
            </div>
            </nav>
        </header>

        <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar-->
            <section class="sidebar">

            <!-- sidebar menu-->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="user-profile treeview">
                <a href="index.html">
                    <img src="{{ asset('fabadmin/images/avatarku.png') }}" alt="user">
                    <span>{{ Auth::user()->name }}</span>
                </a>
                </li>
                <li class="header nav-small-cap">Navigasi</li>
                <li class="@if(isset($varGlobal['dashboard'])) {{ $varGlobal['dashboard'] }} @endif"><a href="{{ url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>Beranda</span></a></li>
				@can('Read Master Data')
                <li class="treeview @if(isset($varGlobal['master-data'])) {{ $varGlobal['master-data'] }} @endif">
                    <a href="#">
                        <i class="fa fa-th"></i>
                        <span>Master Data</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu" style="max-height:300px;overflow-y:scroll;">
                        @can('Read Sub Satuan Kerja')
                            <li class="@if(isset($varGlobal['sub-satuan-kerja'])) {{ $varGlobal['sub-satuan-kerja'] }} @endif"><a href="{{ url('master-data/sub-satuan-kerja') }}"><i class="fa fa-circle-thin"></i>Sub Satuan Kerja</a></li>
                        @endcan
                        @can('Read Spesies')
                            <li class="@if(isset($varGlobal['spesies'])) {{ $varGlobal['spesies'] }} @endif"><a href="{{ url('master-data/spesies') }}"><i class="fa fa-circle-thin"></i>Spesies</a></li>
                        @endcan
                        @can('Read Ras')
                            <li class="@if(isset($varGlobal['ras'])) {{ $varGlobal['ras'] }} @endif"><a href="{{ url('master-data/ras') }}"><i class="fa fa-circle-thin"></i>Ras</a></li>
                        @endcan
                        @can('Read Jenis Contoh')
                            <li class="@if(isset($varGlobal['jenis-contoh'])) {{ $varGlobal['jenis-contoh'] }} @endif"><a href="{{ url('master-data/jenis-contoh') }}"><i class="fa fa-circle-thin"></i>Jenis Contoh</a></li>
                        @endcan
                        @can('Read Bentuk Contoh')
                            <li class="@if(isset($varGlobal['bentuk-contoh'])) {{ $varGlobal['bentuk-contoh'] }} @endif"><a href="{{ url('master-data/bentuk-contoh') }}"><i class="fa fa-circle-thin"></i>Bentuk Contoh</a></li>
                        @endcan
                        @can('Read Seksi Laboratorium')
                            <li class="@if(isset($varGlobal['seksi-laboratorium'])) {{ $varGlobal['seksi-laboratorium'] }} @endif"><a href="{{ url('master-data/seksi-laboratorium') }}"><i class="fa fa-circle-thin"></i>Seksi Laboratorium</a></li>
                        @endcan
                        @can('Read Jenis Pengujian')
                            <li class="@if(isset($varGlobal['jenis-pengujian'])) {{ $varGlobal['jenis-pengujian'] }} @endif"><a href="{{ url('master-data/jenis-pengujian') }}"><i class="fa fa-circle-thin"></i>Jenis Pengujian</a></li>
                        @endcan
                        @can('Read Customer')
                            <li class="@if(isset($varGlobal['customer'])) {{ $varGlobal['customer'] }} @endif"><a href="{{ url('master-data/customer') }}"><i class="fa fa-circle-thin"></i>Customer</a></li>
                        @endcan
                        @can('Read Asal Hewan')
                            <li class="@if(isset($varGlobal['asal-hewan'])) {{ $varGlobal['asal-hewan'] }} @endif"><a href="{{ url('master-data/asal-hewan') }}"><i class="fa fa-circle-thin"></i>Asal Hewan</a></li>
                        @endcan
                        @can('Read Pemeriksa')
                            <li class="@if(isset($varGlobal['pemeriksa'])) {{ $varGlobal['pemeriksa'] }} @endif"><a href="{{ url('master-data/pemeriksa') }}"><i class="fa fa-circle-thin"></i>Pemeriksa</a></li>
                        @endcan
                        @can('Read Pemilik')
                            <li class="@if(isset($varGlobal['pemilik'])) {{ $varGlobal['pemilik'] }} @endif"><a href="{{ url('master-data/pemilik') }}"><i class="fa fa-circle-thin"></i>Pemilik</a></li>
                        @endcan
                        @can('Read Penyakit')
                            <li class="@if(isset($varGlobal['penyakit'])) {{ $varGlobal['penyakit'] }} @endif"><a href="{{ url('master-data/penyakit') }}"><i class="fa fa-circle-thin"></i>Penyakit</a></li>
                        @endcan
                        @can('Read Obat')
                            <li class="@if(isset($varGlobal['obat'])) {{ $varGlobal['obat'] }} @endif"><a href="{{ url('master-data/obat') }}"><i class="fa fa-circle-thin"></i>Obat</a></li>
                        @endcan
                        @can('Read Operasi')
                            <li class="@if(isset($varGlobal['operasi'])) {{ $varGlobal['operasi'] }} @endif"><a href="{{ url('master-data/operasi') }}"><i class="fa fa-circle-thin"></i>Operasi</a></li>
                        @endcan
                        @can('Read Kan')
                            <li class="@if(isset($varGlobal['obat'])) {{ $varGlobal['obat'] }} @endif"><a href="{{ url('master-data/logo') }}"><i class="fa fa-circle-thin"></i>Logo</a></li>
                        @endcan
						@can('Read Pegawai')
							<li class="@if(isset($varGlobal['pegawai'])) {{ $varGlobal['pegawai'] }} @endif"><a href="{{ url('master-data/pegawai') }}"><i class="fa fa-circle-thin"></i>Pegawai</a></li>
						@endcan
                    </ul>
                </li>
				@endcan
                @can('Read Laboratorium')
                    <li class="treeview @if(isset($varGlobal['lab'])) {{ $varGlobal['lab'] }} @endif">
                        <a href="#">
                            <i class="fa fa-hospital-o"></i>
                            <span>Laboratorium</span>
                            <span class="pull-right-container">
                            <i class="fa fa-angle-right pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            @can('Read Lab Keswan')
                                @if(Auth::user()->view_data < 3 || \Session::get('user_jenis') == 1)
                                <li class="@if(isset($varGlobal['keswan'])) {{ $varGlobal['keswan'] }} @endif"><a href="{{ url('lab/keswan') }}"><i class="fa fa-circle-thin"></i>Keswan</a></li>
                                @endif
                            @endcan
                            @can('Read Lab Pakan')
                                @if(Auth::user()->view_data < 3 || \Session::get('user_jenis') == 2)
                                <li class="@if(isset($varGlobal['pakan'])) {{ $varGlobal['pakan'] }} @endif"><a href="{{ url('lab/pakan') }}"><i class="fa fa-circle-thin"></i>Pakan</a></li>
                                @endif
                            @endcan
                            @can('Read Lab Kesmavet')
                                @if(Auth::user()->view_data < 3 || \Session::get('user_jenis') == 3)
                                <li class="@if(isset($varGlobal['kesmavet'])) {{ $varGlobal['kesmavet'] }} @endif"><a href="{{ url('lab/kesmavet') }}"><i class="fa fa-circle-thin"></i>Kesmavet</a></li>
                                @endif
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('Read PLLT')
                    <li class="@if(isset($varGlobal['pllt'])) {{ $varGlobal['pllt'] }} @endif"><a href="{{ url('pllt') }}"><i class="fa fa-heart"></i> <span>PLLT</span></a></li>
                @endcan
                @can('Read Klinik')
                    <li class="@if(isset($varGlobal['klinik'])) {{ $varGlobal['klinik'] }} @endif"><a href="{{ url('klinik/rekap') }}"><i class="fa fa-medkit"></i> <span>Klinik</span></a></li>
                @endcan
                <li class="treeview @if(isset($varGlobal['laporan'])) {{ $varGlobal['laporan'] }} @endif">
                    <a href="#">
                        <i class="fa fa-clipboard"></i> <span>Laporan</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('Read Lab Keswan')
                            @if(Auth::user()->view_data < 3 || \Session::get('user_jenis') == 1)
                            <li class="@if(isset($varGlobal['Lab. Keswan'])) {{ $varGlobal['lap-pengujian'] }} @endif"><a href="{{ url('laporan/lab-keswan') }}"><i class="fa fa-circle-thin"></i>Lab. Keswan</a></li>
                            @endif
                        @endcan
                        @can('Read Lab Pakan')
                            @if(Auth::user()->view_data < 3 || \Session::get('user_jenis') == 2)
                            <li class="@if(isset($varGlobal['Lab. Pakan'])) {{ $varGlobal['lap-pengujian'] }} @endif"><a href="{{ url('laporan/lab-pakan') }}"><i class="fa fa-circle-thin"></i>Lab. Pakan</a></li>
                            @endif
                        @endcan
                        @can('Read Lab Kesmavet')
                            @if(Auth::user()->view_data < 3 || \Session::get('user_jenis') == 3)
                            <li class="@if(isset($varGlobal['Lab. Kesmavet'])) {{ $varGlobal['lap-pengujian'] }} @endif"><a href="{{ url('laporan/lab-kesmavet') }}"><i class="fa fa-circle-thin"></i>Lab. Kesmavet</a></li>
                            @endif
                        @endcan
                        <!-- @can('Read Laporan Pengujian')
                            <li class="@if(isset($varGlobal['lap-pengujian'])) {{ $varGlobal['lap-pengujian'] }} @endif"><a href="{{ url('laporan/lap-pengujian') }}"><i class="fa fa-circle-thin"></i>Lap. Pengujian</a></li>
                        @endcan -->
                        @can('Read Laporan Ternak Masuk')
                            <li class="@if(isset($varGlobal['lap-ternak-masuk'])) {{ $varGlobal['lap-ternak-masuk'] }} @endif"><a href="{{ url('laporan/lap-ternak-masuk') }}"><i class="fa fa-circle-thin"></i>Lap. Ternak Masuk</a></li>
                        @endcan
                        @can('Read Laporan Ternak Lewat')
                            <li class="@if(isset($varGlobal['lap-ternak-lewat'])) {{ $varGlobal['lap-ternak-lewat'] }} @endif"><a href="{{ url('laporan/lap-ternak-lewat') }}"><i class="fa fa-circle-thin"></i>Lap. Ternak Lewat</a></li>
                        @endcan
                        @can('Read Laporan Ternak Keluar')
                            <li class="@if(isset($varGlobal['lap-ternak-keluar'])) {{ $varGlobal['lap-ternak-keluar'] }} @endif"><a href="{{ url('laporan/lap-ternak-keluar') }}"><i class="fa fa-circle-thin"></i>Lap. Ternak Keluar</a></li>
                        @endcan
                        @can('Read Laporan Klinik')
                            <li class="@if(isset($varGlobal['lap-klinik'])) {{ $varGlobal['lap-klinik'] }} @endif"><a href="{{ url('laporan/lap-klinik') }}"><i class="fa fa-circle-thin"></i>Lap. Klinik</a></li>
                        @endcan
                    </ul>
                </li>
				@can('Read Stok Klinik')
					<li class="@if(isset($varGlobal['stock'])) {{ $varGlobal['stock'] }} @endif"><a href="{{ url('stock/index') }}"><i class="fa fa-medkit"></i> <span>Stock</span></a></li>
				@endcan
				@can('Read Setting')
                <li class="treeview @if(isset($varGlobal['pengaturan'])) {{ $varGlobal['pengaturan'] }} @endif">
                    <a href="#">
                        <i class="fa fa-cog"></i> <span>Pengaturan</span>
                        <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        @can('Read Pengguna')
                            <li class="@if(isset($varGlobal['pengguna'])) {{ $varGlobal['pengguna'] }} @endif"><a href="{{ url('pengaturan/pengguna') }}"><i class="fa fa-circle-thin"></i>Pengguna</a></li>
                        @endcan
                        @can('Read Hak Akses')
                            <li class="@if(isset($varGlobal['hak-akses'])) {{ $varGlobal['hak-akses'] }} @endif"><a href="{{ url('pengaturan/hak-akses') }}"><i class="fa fa-circle-thin"></i>Hak Akses</a></li>
                        @endcan
                    </ul>
                </li>
				@endcan
            </ul>
            </section>
        </aside>

        <!-- =============================================== -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- preloader -->
            <div class="preloader">
              <div class="loading">
                <img src="{{ asset('packages/img/preloader.gif') }}" width="80">
                <p>Harap Tunggu</p>
              </div>
            </div>
            <!-- end preloader -->

            @include('include/alert')
            <div id="konten_utama">
                @yield('content')
            </div>

        </div>
        <!-- /.content-wrapper -->

        @include('include/footer')

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        @include('include/javascript')

        @yield('javascript')

        <script>
            var $preloader = $(".preloader");
            var $stateurl = "";
            $(document).ready(function() {
                $('.select2').select2();
                $preloader.fadeOut();
            });
        </script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    </body>
</html>