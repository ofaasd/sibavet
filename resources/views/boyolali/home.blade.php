@extends('boyolali/layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Beranda
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Beranda</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xl-3 col-md-6 col-12">
                    <div class="box box-body">
                    <h6 class="text-uppercase"><b>Laboratorium</b></h6>
                    <div class="flexbox mt-2">
                    <span class="fa fa-hospital-o text-danger font-size-40"></span>
                    <span class=" font-size-30">{{ $var['jumlahLaboratorium'] }}</span>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xl-3 col-md-6 col-12">
                    <div class="box box-body">
                    <h6 class="text-uppercase"><b>PLLT</b></h6>
                    <div class="flexbox mt-2">
                    <span class="fa fa-heart text-info font-size-40"></span>
                    <span class=" font-size-30">{{ $var['jumlahPllt'] }}</span>
                    </div>
                </div>
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-xl-3 col-md-6 col-12">
                    <div class="box box-body">
                    <h6 class="text-uppercase"><b>Klinik</b></h6>
                    <div class="flexbox mt-2">
                    <span class="fa fa-medkit font-size-40 text-primary"></span>
                    <span class=" font-size-30">{{ $var['jumlahKlinik'] }}</span>
                    </div>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xl-3 col-md-6 col-12">
                    <div class="box box-body">
                    <h6 class="text-uppercase"><b>Pengguna</b></h6>
                    <div class="flexbox mt-2">
                    <span class="fa fa-user font-size-40 text-success"></span>
                    <span class=" font-size-30">{{ $var['jumlahUsers'] }}</span>
                    </div>
                </div>
            </div>
            <!-- /.col -->

            <div class="col-xl-12 col-12">
                <!-- Radar CHART -->
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <form method="get" action="">
                                    <div class="input-group">
                                        <input name="tahun" type="text" class="form-control" placeholder="Inputkan Tahun" />
                                        <div class="input-group-prepend">
                                            <button type="button" class="btn btn-info">Tampilkan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <canvas id="chartBeranda" height="100"></canvas>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

    </section>
    <!-- /.content -->

@endsection

@section('javascript')
    <!-- ChartJS -->
	<script src="{{ asset('fabadmin/assets/vendor_components/chart.js-master/Chart.min.js') }}"></script>
    <script>
        var barChartData = {
            labels: {!! $var['bulan'] !!},
            datasets: [
                {
                    label: "Laboratorium",
                    backgroundColor: "#ff6384",
                    borderColor: "#ff6384",
                    borderWidth: 1,
                    data: {!! $var['jumlahLaboratoriumGrafik'] !!}
                },
                {
                    label: "PLLT",
                    backgroundColor: "#36a2eb",
                    borderColor: "#36a2eb",
                    borderWidth: 1,
                    data: {!! $var['jumlahPlltGrafik'] !!}
                },
                {
                    label: "Klinik",
                    backgroundColor: "#4bd190",
                    borderColor: "#4bd190",
                    borderWidth: 1,
                    data: {!! $var['jumlahKlinikGrafik'] !!}
                },
            ]
        };

        var chartOptions = {
            responsive: true,
            legend: {
                position: "top"
            },
            title: {
                display: true,
                text: "Grafik Jumlah Semua Data Per Bulan siBavet {!! $var['tahun'] !!}"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }

        window.onload = function() {
            var ctx = document.getElementById("chartBeranda").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: "bar",
                data: barChartData,
                options: chartOptions
            });
        };
    </script>
@endsection
