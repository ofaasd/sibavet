<!DOCTYPE html>
<html lang="en">
    <head>
        @include('include/header')
    </head>
    <body class="hold-transition skin-blue sidebar-mini fixed">
        <div id="notifikasi" class="myadmin-alert myadmin-alert-img alert-success myadmin-alert-top-right">
            <a href="#" class="closed">&times;</a><h4>You have a Message!</h4> <b>John Doe</b> sent you a message.
        </div>
        <!-- Site wrapper -->
        <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="{{ url('beranda') }}" class="logo">
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
                            Kepala Dinas
                            <small class="mb-5"></small>
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
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form-1').submit();">
                                    <form id="logout-form-1" action="{{ url('logout') }}" method="post" style="display: none;">
                                        {{ csrf_field() }}
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
                <a href="#">
                    <img src="{{ asset('fabadmin/images/avatarku.png') }}" alt="user">
                    <span>Kepala Dinas</span>
                </a>
                </li>
                <li class="header nav-small-cap">Navigasi</li>
                <li class="@if(isset($varGlobal['statistik'])) {{ $varGlobal['statistik'] }} @endif"><a href="{{ url('statistik') }}"><i class="fa fa-dashboard"></i> <span>Statistik</span></a></li>
                
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
    </body>
</html>
