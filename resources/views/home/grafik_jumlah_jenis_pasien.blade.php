<canvas id="chartBeranda2" height="200"></canvas>
<script>
var pieCartData = {
	labels: {!! $var['list_spesies'] !!},
	datasets: [
		{
			//label: "Laboratorium",
			borderWidth: 1,
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
var chartOptions2 = {
		responsive: true,
		//maintainAspectRatio: false,
		legend: {
			position: "top"
		},
		title: {
			display: true,
			text: "Grafik Jumlah Pasien Bulan {{$var['list_bulan'][(int)$var['curr_bulan']]}} - {{$var['curr_tahun']}}"
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
var ctx2 = document.getElementById("chartBeranda2").getContext("2d");
	window.myBar = new Chart(ctx2, {
		type: "doughnut",
		data: pieCartData,
		options: chartOptions2
	});
</script>