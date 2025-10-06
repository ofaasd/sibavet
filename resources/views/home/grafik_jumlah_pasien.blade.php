<canvas id="chartBeranda4" height="120"></canvas>
<script>
var pasienChartData = {
	labels: {!! $var['tanggal_periksa'] !!},
	datasets: [
		{
			label: "Klinik Hewan Semarang",
			//borderWidth: 1,
			data: {!! $var['jumlah_periksa'] !!},
			backgroundColor: '#36a2eb',
		}
	]
};
var chartOptions4 = {
	responsive: true,
	legend: {
		position: "top"
	},
	title: {
		display: true,
		text: "Grafik Jumlah Pasien Harian Bulan {{$var['list_bulan'][(int)$var['curr_bulan']]}} - {{$var['curr_tahun']}}"
	},
	scales: {
		yAxes: [{
			ticks: {
				beginAtZero: true
			}
		}]
	}
}
var ctx4 = document.getElementById("chartBeranda4").getContext("2d");
	window.myBar = new Chart(ctx4, {
		type: "bar",
		data: pasienChartData,
		options: chartOptions4
	});
</script>