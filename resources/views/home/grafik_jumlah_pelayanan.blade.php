<canvas id="chartBeranda3" height="200"></canvas>
<script>
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
var chartOptions3 = {
	responsive: true,
	legend: {
		position: "top"
	},
	title: {
		display: true,
		text: "Grafik Jumlah Pelayanan Pasien {{$var['list_bulan'][(int)$var['curr_bulan']]}} - {{$var['curr_tahun']}}"
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
var ctx3 = document.getElementById("chartBeranda3").getContext("2d");
	window.myBar = new Chart(ctx3, {
		type: "doughnut",
		data: jumlahPelayananCartData,
		options: chartOptions3
	});
	
</script>