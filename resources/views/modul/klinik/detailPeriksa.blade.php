@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Detail Periksa {{$listKlinik->nama_hewan}}
        </h1>
        
        <h3>
            Pemilik : {{$listKlinik->pemilik->nama}}
        </h3>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">
                    <h4> 
                        Data Hewan : {{$listKlinik->jenis_kelamin}} - {{$listKlinik->spesies['nama_spesies']}} - {{$listKlinik->umur}} Tahun
                    </h4>
                    <h4>
                        Nomor Rekam Medis : {{$listKlinik->no_pasien}}
                    </h4>    
                        <table border=1 class="table">
                            <thead>
                                <tr><th>No</th><th>Tanggal Periksa</th><th>Signalment</th><th>Anamnesa</th><th>Diagnosa</th><th>Tindakan Penanganan dan Keterangan Penanganan</th><th>Keterangan</th><th>Pemeriksa</th><th>Paramedis</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach($klinikTerapi as $dat)                        
                                <tr>
                                    <td>{{$no}}</td><td>{{date('d F Y',strtotime($dat->tanggal_periksa))}}</td><td>{{$dat->signalement}}</td><td>{{$dat->anamnesia}}</td><td>{{$diagnosa[$dat->id]->penyakit}}</td>
                                    <td>
                                    @foreach($dosis[$dat->id] as $dos)
										
										{{-- @if(date('Y-m-d h:i:s',strtotime($dos->created_at)) == date('Y-m-d h:i:s',strtotime($dat->created_at))) --}}
										
											@if($dos->tindakan == 1 or $dos->tindakan == 2 or $dos->tindakan ==3 or $dos->tindakan ==4)        
												{{$dos->obat}}
											@elseif($dos->tindakan == 5)
												Operasi {{$var['helper']->terapi($dos->tindakan,$dos->terapi_id)}}
											@endif
											{{$dos->dosis}} ,
										{{-- @endif   --}}
                                    @endforeach
                                    </td><td>{{$dat->keterangan}}</td><td>{{$dat->nmpemeriksa}}</td><td>{{$dat->paramedis}}</td>
                                    <td>
                                    <!--<button class="btn btn-primary" onclick="editTerapi('{{$dat->id}}','{{$dat->klinik_id}}','{{$dat->anamnesia}}','{{$dat->keterangan}}','{{$dat->paramedis}}','{{$diagnosa[$dat->id]->id}}','{{$diagnosa[$dat->id]->penyakit}}','{{$dat->tindakan}}','{{date("Y-m-d",strtotime($dat->tanggal_periksa))}}')">Edit Data</button>-->
									<div class="row">
										<div class="col-md-12" style="margin:5px 0">
											<a href="{{ url('/klinik/edit_pendaftaran/'.$dat->id.'/detail')}}" class="btn btn-primary btn-xs">Edit Pendaftaran</a><br />
										</div>
										<div class="col-md-12" style="margin:5px 0">
											<!--<button class="btn btn-primary" onclick="editObat('{{$dat->id}}','{{$dat->klinik_id}}','{{$dat->tindakan}}','{{$dat->created_at}}')">Edit Obat</button>-->
											<a href="{{ url('/klinik/add_pemeriksaan/'.$dat->id.'/detail')}}" class="btn btn-success btn-xs">Edit Pemeriksaan</a><br />
										</div>
										
										<div class="col-md-12" style="margin:5px 0">
											<a href="{{ url('/klinik/edit_pembayaran/'.$dat->id.'/detail')}}" class="btn btn-info btn-xs">Edit Pembayaran</a><br />
										</div>
									
										<div class="col-md-12">
											<a href="#" class="btn btn-danger btn-xs" onclick="hapusRiwayat('{{$dat->klinik_id}}','{{$dat->id}}','{{$dat->created_at}}','{{date('d F Y',strtotime($dat->tanggal_periksa))}}')">Hapus Riwayat</a>
										</div>
									</div>
                                    </td>
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

        

<!-- Modal -->
<div class="modal fade" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Transaksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ url('klinik/updateTransaksi') }}">
        @csrf
            <input type="hidden" name="id_terapi" id="id_terapi">
            <input type="hidden" name="klinik_id" id="klinik_id">
            Tanggal Periksa : <input type="date" id="tgl_periksa" name="tgl_periksa" class="form-control">
            Anamnesa : <input type="text" id="anamnesa" name="anamnesa" class="form-control">
            Diagnosa : 
            <select id="diagnosa" name="diagnosa" class="form-control">
            @foreach($var['penyakit'] as $pen)
                <option value="{{$pen->id}}">{{$pen->penyakit}}</option>
            @endforeach
            </select>
            Keterangan : <input type="text" name="ket" id="ket" class="form-control">
            Paramedis : <input type="text" name="paramedis" id="paramedis" class="form-control">
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Update">
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editobat" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">             
        {!! Form::open(['id'=>'form-klinik', 'method'=>'POST', 'url'=>'/klinik/updateObat/'.$var['url']['all']]) !!}

        <input type="hidden" name="created" id="created">
        <input type="hidden" name="klinik_id2" id="klinik_id2">

        <div class="form-group row">
                                {!! Form::label('tindakan', 'Jenis Penanganan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                            {!! Form::select('tindakan', $var['penanganan'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Penanganan', 'style'=>'width: 100%;', 'onchange'=>'penangananAksi()']) !!}
                                            </div>
                                        </div>
                                    <div id="areaTindakan">    
                                        <div class="form-group row">
                                            {!! Form::label('terapi_id', 'Terapi / Tindakan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('terapi_id', $var['obat'], null, ['class'=>'form-control  select2', 'placeholder'=>'Pilih Terapi / Tindakan', 'style'=>'width: 100%;']) !!}
                                            </div>
                                        </div>
                                    </div>    
                                        <div class="form-group row">
                                            {!! Form::label('dosis', 'Dosis / Ket Penaganan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('dosis', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Dosis atau Keterangan Penanganan']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                {!! Form::submit('Tambah', ['class'=>'btn btn-primary', 'id'=>'buttonTambahTerapiDosis']) !!}
                                                {!! Form::reset('Reset', ['class'=>'btn btn-danger', 'id'=>'buttonResetTerapiDosis']) !!}
                                            </div>
                                        </div>
            <div id="areaDataTerapiDosis"></div>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Update">
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalhps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Riwayat Periksa Tanggal <span id="tglt"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ url('klinik/hapusRiwayat') }}">
        @csrf
           <input type="hidden" id="id" name="id">
           <input type="hidden" id="created2" name="created2">
           <input type="hidden" id="klinik_id3" name="klinik_id3">
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Hapus">
        </form>
      </div>
    </div>
  </div>
</div>

    </section>
    <!-- /.content -->

@endsection

@section('javascript')
    <script>
        function tampilDataTerapiDosis2(id='',tindakan){
            var method = 'edit';
            $("#areaDataTerapiDosis").load('{!! url('/klinik/area-data-terapi2') !!}?method='+method+'&id='+id+'&tindakan='+tindakan);
        }

        function tampilDataTerapiDosis(method='create', id=''){
            $("#areaDataTerapiDosis").load('{!! url('/klinik/area-data-terapi') !!}?method='+method+'&id='+id);
        }

        function editObat(id,klinik_id,tindakan,created){
            $('#created').val(created);
            $('#klinik_id2').val(klinik_id);            
            tampilDataTerapiDosis2(id,tindakan);            
            $('#editobat').modal('show');
        }
        
        function hapusRiwayat(klinik_id,id,created,tglperiksa){
            $('#modalhps').modal('show');   
            $('#tglt').html(tglperiksa);
            $('#id').val(id);
            $('#created2').val(created);
            $('#klinik_id3').val(klinik_id);
        }

        
        function editTerapi(id,klinik_id,anamnesa,ket,paramedis,diagnosa_id,diagnosa,tindakan,tanggal){
            $('#anamnesa').val(anamnesa);
            $('#id_terapi').val(id);
            $('#klinik_id').val(klinik_id);
            $('#ket').val(ket);
            $('#diagnosa').prepend($('<option value="'+diagnosa_id+'">'+diagnosa+'</option>'));
            $('#diagnosa').prop("selectedIndex",0);
            $('#paramedis').val(paramedis);
            $('#tgl_periksa').val(tanggal);
            $('#modaledit').modal("show");            
        }

        function resetFormDataTerapiDosis(){
            $("#terapi_id").val("").trigger("change");
            $("#dosis").val("");
        }

        function hapusDataTerapiDosis(id){
            swal({
                reverseButton: false,
                title: "Data yakin dihapus ?",
                text: "Mohon diteliti sebelum menghapus data",
                type: "warning",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-inverse',
                closeOnConfirm: false
            }, function(){
               $.ajax({
                    method : 'post',
                    url : '{{ url('/klinik/hapus-data-terapi') }}',
                    data : 'id='+id,
                }).done(function (data) {
                    $("#areaDataTerapiDosis").html(data);
                    swal("Berhasil", "Data berhasil dihapus", "success");
                });
            });
        }

        function penangananAksi(penanganan = ''){
            if(penanganan == '') penanganan = $("#tindakan").val();

            if(penanganan == 0 || penanganan == 1 || penanganan == 2){
                $("#areaTindakan").load("{{ url('klinik/area-obat') }}");
            }else if(penanganan == 4){
                $("#areaTindakan").load("{{ url('klinik/area-operasi') }}");
            }else{

            }
        }

        $('#buttonTambahTerapiDosis').click(function(e){
                e.preventDefault();
                var data = {
                   terapi: ($("#terapi_id").val()!=""?$("#terapi_id").val():""),
                    dosis: ($("#dosis").val()!=""?$("#dosis").val():""),
                    tindakan: ($("#tindakan").val()!=""?$("#tindakan").val():"")
                };

                $.ajax({
                    method : 'post',
                    url : '{{ url('/klinik/tambah-data-terapi') }}',
                    data : data,
                }).done(function (data) {
                    tampilDataTerapiDosis();
                    resetFormDataTerapiDosis();
                });
            });
    </script>
@endsection
