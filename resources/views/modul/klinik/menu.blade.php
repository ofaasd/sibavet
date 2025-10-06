<!-- Nav tabs -->
<ul class="nav nav-tabs">
	<li class="nav-item"><a href="{{ url('klinik/rekap') }}" class="nav-link {{($url == 'rekap')?'active':''}}"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Semua Data</b></span></a></li>
	<li class="nav-item"><a href="{{ url('klinik/pendaftaran') }}" class="nav-link {{($url == 'pendaftaran')?'active':''}}"><span class="hidden-sm-up"><b>Pendaftaran</b></span> <span class="hidden-xs-down"><B>Pendaftaran</b></span></a></li>
	<li class="nav-item"><a href="{{ url('klinik/pemeriksaan') }}" class="nav-link {{($url == 'pemeriksaan')?'active':''}}"><span class="hidden-sm-up"><b>Pemeriksaan Hewan</b></span> <span class="hidden-xs-down"><b>Pemeriksaan Hewan</b></span></a></li>
	<li class="nav-item"><a href="{{ url('klinik/pembayaran') }}" class="nav-link {{($url == 'pembayaran')?'active':''}}"><span class="hidden-sm-up"><b>Pembayaran</b></span> <span class="hidden-xs-down"><b>Pembayaran</b></span></a></li>
</ul>