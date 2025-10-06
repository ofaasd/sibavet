<html>
<style type="text/css" media="print">
	@page{
		size:auto;
		margin:5mm;
	}
	body{
		background-color:#ffffff;
		
		margin:0px;
	}
</style>
    <body style="font-family:arial;">
    <div style="float:left;">
        <img src="{{asset('fabadmin/images/logo-laporan.png')}}" width="120" height="120">
    </div>
    <div style="margin:auto;padding-left:-30px;">
    <center>
       <b> 
       <h4>
        DINAS PETERNAKAN DAN KESEHATAN HEWAN<br>
        PROVINSI JAWA TENGAH<BR>
        BALAI VETERINER SEMARANG<BR>
        </h4>
        <h3 style="margin-top:-10px">KLINIK HEWAN</h3>
        <h5 style="margin-top:-10px">
            {{$dataklinik->alamat}} Telepon {{$dataklinik->telp}}
        </h5>
       </b> 
    </center>
    <hr style="border:1.5px solid black"><hr style="border:1.5px solid black; margin-top:-7px;">
    </div>
    <div>
        <center>
        <h3>
        <b><u>KARTU PASIEN</u></b>
        </h3>
        </center>
    </div>
    <div style="float:right;border:1.5px solid black; margin-top:-40px; width:200px; height:30px;">
        <center>
            <h4 style="margin-top:7px;margin-left:-40px;">NO.RM : {{$listKlinik->no_pasien}}</h4>
        </center>
    </div>

    <br>
    <table border=0 style="margin-left:30px; font-weight:bold;">
        <tr><td>KLINIK HEWAN</td><td>:</td><td>{{$dataklinik->sub_satuan_kerja}}</td></tr>
        <tr><td>NAMA PEMILIK</td><td>:</td><td>{{$listKlinik->pemilik->nama}}</td></tr>
        <tr><td>ALAMAT</td><td>:</td><td>{{$listKlinik->pemilik->alamat}}</td></tr>
        <tr><td>NO TELEPON / HP</td><td>:</td><td>{{$listKlinik->pemilik->telepon}}</td></tr>
        <tr><td>JENIS KELAMIN</td><td>:</td><td>{{$listKlinik->jenis_kelamin}}</td></tr>
        <tr><td>RAS</td><td>:</td><td>{{$listKlinik->spesies->nama_spesies}} - {{$listKlinik->ras['nama_ras']}}</td></tr>
        <tr><td>NAMA HEWAN</td><td>:</td><td>{{$listKlinik->nama_hewan}}</td></tr>
        <tr><td>UMUR</td><td>:</td><td>{{$listKlinik->umur}} Tahun</td></tr>
        <tr><td>CIRI - CIRI SPESIFIK</td><td>:</td><td>{{$listKlinik->ciri_ciri}}</td></tr>
    </table>

<br>
    <div class="row">
            <div class="col-12 col-lg-12">
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">                      
                        <table style="border-collapse:collapse;border:1px solid gray;">
                            <thead>
                                <tr style="border-collapse:collapse;border:1px solid gray;"><th style="border-collapse:collapse;border:1px solid gray;">No</th><th style="border-collapse:collapse;border:1px solid gray;">Tanggal Periksa</th><th style="border-collapse:collapse;border:1px solid gray;">Anamnesa / Signalment</th><th style="border-collapse:collapse;border:1px solid gray;">Diagnosa</th><th>Tindakan Penanganan dan Keterangan Tindakan</th><th style="border-collapse:collapse;border:1px solid gray;">Keterangan</th><th>Pemeriksa</th></tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($klinikTerapi as $dat)
                                <tr style="border-collapse:collapse;border:1px solid gray;">
                                    <td style="border-collapse:collapse;border:1px solid gray;">{{$no}}</td><td style="border-collapse:collapse;border:1px solid gray;">{{date('d F Y',strtotime($dat->tanggal_periksa))}}</td><td style="border-collapse:collapse;border:1px solid gray;">{{$dat->anamnesia}} / {{$dat->anamnesia}}</td><td style="border-collapse:collapse;border:1px solid gray;">{{$dat->diagnosa}}</td>
                                    <td style="border-collapse:collapse;border:1px solid gray;">
                                    @foreach($dosis as $dos)
                                        @if($dos->created_at == $dat->created_at)
                                        
                                @if($dat->tindakan == 0 or $dat->tindakan == 1 or $dat->tindakan == 2)
                                    {{$dos->obat}}
                                @elseif($dat->tindakan == 4)
                                    @foreach($operasi as $opr)
                                    {{$opr->tindakan}}
                                    @endforeach
                                @endif
                                     {{$dos->dosis}} ,
                                        @endif                                    
                                    @endforeach
                                    </td><td style="border-collapse:collapse;border:1px solid gray;">{{$dat->keterangan}}</td><td style="border-collapse:collapse;border:1px solid gray;">{{$dat->nmpemeriksa}}</td>
                                </tr>

                                @php
                                    $no++;
                                @endphp                                
                                @endforeach    
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
    </body>
<script>
    document.title = 'Kartu Periksa '+'{{$listKlinik->nama_hewan}}'+'-'+'{{$listKlinik->pemilik->nama}}';
    print();
</script>
</html>