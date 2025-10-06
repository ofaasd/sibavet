@extends('layouts.admin')

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
			<div class="col-xl-6 col-6">
                <!-- Radar CHART -->
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="get" action="">
                                    <div class="input-group">
										<select name="bulan" id="bulan" class="form-control" onchange="ubah_jenis_pasien()">
											@foreach($var['list_bulan'] as $key=>$bulan)
												<option value="{{$key}}" {{($key == $var['curr_bulan'])?"selected":""}}>{{$bulan}}</option>
											@endforeach
										</select>
                                        <select name="tahun" id="tahun" class="form-control" onchange="ubah_jenis_pasien()">
											@for($i=date('Y'); $i > date('Y')-5; $i--)
												<option value="{{$i}}">{{$i}}</option>
											@endfor
										</select>
                                    </div>
                                </form>
                            </div>
                        </div>
						<div id="chartJumlahJenis">
							<canvas id="chartBeranda2" height="200"></canvas>
						</div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
			<div class="col-xl-6 col-6">
                <!-- Radar CHART -->
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="get" action="">
                                    <div class="input-group">
										<select name="bulan" id="bulan2" class="form-control" onchange="ubah_jumlah_pelayanan()">
											@foreach($var['list_bulan'] as $key=>$bulan)
												<option value="{{$key}}" {{($key == $var['curr_bulan'])?"selected":""}}>{{$bulan}}</option>
											@endforeach
										</select>
                                        <select name="tahun" id="tahun2" class="form-control" onchange="ubah_jumlah_pelayanan()">
											@for($i=date('Y'); $i > date('Y')-5; $i--)
												<option value="{{$i}}">{{$i}}</option>
											@endfor
										</select>
                                    </div>
                                </form>
                            </div>
                        </div>
						<div id="chartJumlahPelayanan">
							<canvas id="chartBeranda3" height="200"></canvas>
						</div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
			<div class="col-xl-12 col-12">
                <!-- Jumlah pasien -->
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="get" action="">
                                    <div class="input-group">
										<select name="bulan" id="bulan3" class="form-control" onchange="ubah_jumlah_pasien()">
											@foreach($var['list_bulan'] as $key=>$bulan)
												<option value="{{$key}}" {{($key == $var['curr_bulan'])?"selected":""}}>{{$bulan}}</option>
											@endforeach
										</select>
                                        <select name="tahun" id="tahun3" class="form-control" onchange="ubah_jumlah_pasien()">
											@for($i=date('Y'); $i > date('Y')-5; $i--)
												<option value="{{$i}}">{{$i}}</option>
											@endfor
										</select>
                                    </div>
                                </form>
                            </div>
                        </div>
						<div id="chartJumlahPasien">
							<canvas id="chartBeranda4" height="150"></canvas>
						</div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
			<div class="col-xl-12 col-12">
				 <!-- Radar CHART -->
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="get" action="">
                                    <div class="input-group">
                                        <!--<select name="tahun" id="tahun3" class="form-control" onchange="ubah_jumlah_pasien()">
											@for($i=date('Y'); $i > date('Y')-5; $i--)
												<option value="{{$i}}">{{$i}}</option>
											@endfor
										</select>-->
                                    </div>
                                </form>
                            </div>
                        </div>
						<div id="chartJumlahPad">
							<canvas id="chartBeranda5" height="120"></canvas>
						</div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
			</div>
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
		function ubah_jenis_pasien(){
			var bulan = $("#bulan").val();
			var tahun = $("#tahun").val();
			$.ajax({
				method:"POST",
				url:"{{url('beranda/get_jumlah_jenis_pasien') }}",
				data:"bulan="+bulan+"&tahun="+tahun,
				success:function(data){
					$("#chartJumlahJenis").html(data);
				}
			});
		}
		function ubah_jumlah_pelayanan(){
			var bulan = $("#bulan2").val();
			var tahun = $("#tahun2").val();
			$.ajax({
				method:"POST",
				url:"{{url('beranda/get_jumlah_pelayanan') }}",
				data:"bulan="+bulan+"&tahun="+tahun,
				success:function(data){
					$("#chartJumlahPelayanan").html(data);
				}
			});
		}function ubah_jumlah_pasien(){
			var bulan = $("#bulan3").val();
			var tahun = $("#tahun3").val();
			$.ajax({
				method:"POST",
				url:"{{url('beranda/get_jumlah_pasien') }}",
				data:"bulan="+bulan+"&tahun="+tahun,
				success:function(data){
					$("#chartJumlahPasien").html(data);
				}
			});
		}
		var pieCartData = {
			labels: {!! $var['list_spesies'] !!},
			datasets: [
                {
					//label: "Laboratorium",
                    //borderWidth: 1,
                    data: {!! $var['jumlah_jenis_pasien'] !!},
					backgroundColor: [
						'#f1c40f',
						'#3498db',
						'#16a085',
						'#9b59b6',
						'#e74c3c',
						'#bdc3c7'
					],
				}
			]
		};
		var jumlahPelayananCartData = {
			labels: {!! $var['nama_pelayanan'] !!},
			datasets: [
                {
					//label: "Laboratorium",
                    //borderWidth: 1,
                    data: {!! $var['jumlah_pelayanan'] !!},
					backgroundColor: [
						'#f1c40f',
						'#3498db',
						'#16a085',
						'#9b59b6',
						'#e74c3c',
						'#bdc3c7'
					],
				}
			]
		};
        var pasienChartData = {
            labels: {!! $var['tanggal_periksa'] !!},
            datasets: [
                {
					label: "{{(empty($var['nama']))? 'Klinik Hewan' : $var['nama']}}",
                    //borderWidth: 1,
                    data: {!! $var['jumlah_periksa'] !!},
					backgroundColor: '#36a2eb',
				}
			]
        };
		var padChartData = {
            labels: {!! $var['bulan_pad'] !!}, 
            datasets: [
                {
					label: "{{(empty($var['nama']))? 'Klinik Hewan' : $var['nama']}}",
                    //borderWidth: 1,
                    data: {!! $var['pad_bulanan'] !!},
					backgroundColor: '#1abc9c',
				}
			]
        };
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
		var chartOptions4 = {
            responsive: true,
            legend: {
                position: "top"
            },
            title: {
                display: true,
                text: "Grafik Jumlah Pasien Klinik Hewan Harian Bulan {{$var['list_bulan'][(int)$var['curr_bulan']]}} - {{$var['curr_tahun']}}"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
		var chartOptions5 = {
            responsive: true,
            legend: {
                position: "top"
            },
            title: {
                display: true,
                text: "Grafik Jumlah PAD Bulanan"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
		var chartOptions2 = {
            responsive: true,
            legend: {
                position: "top"
            },
            title: {
                display: true,
                text: "Grafik Jumlah Pasien Klinik Hewan Bulan {{$var['list_bulan'][(int)$var['curr_bulan']]}} - {{$var['curr_tahun']}}"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
						display:false,
                    },
					gridLines: {
						color: "rgba(0, 0, 0, 0)",
						drawBorder: false,
						display: false,
					},
					
                }],
				xAxes: [{
					gridLines: {
						color: "rgba(0, 0, 0, 0)",
						drawBorder: false,
						display: false,
					},
					ticks: {
						display:false,
					},
				}],
            }
        }
		var chartOptions3 = {
            responsive: true,
            legend: {
                position: "top"
            },
            title: {
                display: true,
                text: "Grafik Jumlah Pelayanan Pasien Klinik Hewan {{$var['list_bulan'][(int)$var['curr_bulan']]}} - {{$var['curr_tahun']}}"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
						display:false,
                    },
					gridLines: {
						color: "rgba(0, 0, 0, 0)",
						drawBorder: false,
						display: false,
					},
					
                }],
				xAxes: [{
					gridLines: {
						color: "rgba(0, 0, 0, 0)",
						drawBorder: false,
						display: false,
					},
					ticks: {
						display:false,
					},
				}],
            }
        }

        window.onload = function() {
            var ctx = document.getElementById("chartBeranda").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: "bar",
                data: barChartData,
                options: chartOptions
            });
			var ctx2 = document.getElementById("chartBeranda2").getContext("2d");
            window.myBar = new Chart(ctx2, {
                type: "doughnut",
                data: pieCartData,
                options: chartOptions2
            });
			
			var ctx3 = document.getElementById("chartBeranda3").getContext("2d");
            window.myBar = new Chart(ctx3, {
                type: "doughnut",
                data: jumlahPelayananCartData,
                options: chartOptions3
            });
			var ctx4 = document.getElementById("chartBeranda4").getContext("2d");
            window.myBar = new Chart(ctx4, {
                type: "bar",
                data: pasienChartData,
                options: chartOptions4
            });
			var ctx5 = document.getElementById("chartBeranda5").getContext("2d");
            window.myBar = new Chart(ctx5, {
                type: "bar",
                data: padChartData,
                options: chartOptions5
            });
			
        };
    </script>
@endsection
