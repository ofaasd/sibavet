@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Klinik
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Klinik</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Nav tabs -->
                        @include('modul.klinik.menu')
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    
									
                                    
                                        <div class="form-group row">
                                            {!! Form::label('input_by', 'User', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('input_by', $var['user'], $var['currentUser'], ['class'=>'form-control select2', 'placeholder'=>'Pilih User', 'style'=>'width: 100%;', 'onchange'=>'subSatuanKerja()']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('sub_satuan_kerja_id', 'Nama Klinik', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nama_sub_satuan_kerja', ($var['method']=='edit'||$var['method']=='show'?@$listKlinik->inputBy->subSatuanKerja->sub_satuan_kerja:$var['namaKlinik']), ['class'=>'form-control', 'id'=>'nama_sub_satuan_kerja', 'placeholder'=>'Inputkan Nama Klinik', 'readonly']) !!}
                                                {!! Form::hidden('sub_satuan_kerja_id', $var['idKlinik'], ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('no_pasien', 'No. RM', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('no_pasien', (!empty($var['curr_klinik'])?$var['curr_klinik']->no_pasien:""), ['class'=>'form-control', 'placeholder'=>'Inputkan No. RM','readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('pemilik_id', 'Pemilik', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                
												<select name="pemilik_id" id="pemilik_id" class="form-control" style="width:100%" onchange="pemilik()" readonly>
													<option value="0">Pilih Pemilik</option>
													
													@if(!empty($var['curr_klinik']))
														<option value="{{$var['curr_klinik']->pemilik_id}}" selected >{{$var['curr_klinik']->nama_pemilik}} - {{$var['curr_klinik']->ktp_pemilik}}</option>
													@endif
												</select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('alamat_pemilik', 'Alamat Pemilik', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('alamat_pemilik', (!empty($var['curr_klinik'])?$var['curr_klinik']->alamat_pemilik:""), ['class'=>'form-control', 'placeholder'=>'Inputkan Alamat Pemilik', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('telepon_pemilik', 'Telepon Pemilik', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('telepon_pemilik',  (!empty($var['curr_klinik'])?$var['curr_klinik']->telepon_pemilik:""), ['class'=>'form-control', 'placeholder'=>'Inputkan Telepon Pemilik', 'readonly']) !!}
                                            </div>
                                        </div>
										<div class="form-group row">
											 {!! Form::label('nama_hewan', 'Nama Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10" id="list_hewan">
												<select name="hewan" id="hewan" class="form-control" placeholder="Pilih Nama Hewan" style="width:100%" onchange="dataHewan()" readonly>
													@if(!empty($var['curr_klinik']))
														<option value="{{$var['curr_klinik']->id}}" selected >{{$var['curr_klinik']->nama_hewan}}</option>
													@endif
												</select>
                                            </div>
										</div>
                                        <div class="form-group row">
                                            {!! Form::label('spesies_id', 'Jenis Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('spesies_id', $var['spesies'], (!empty($var['curr_klinik'])?$var['curr_klinik']->spesies_id:""), ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Hewan', 'style'=>'width: 100%;', 'onchange'=>'ras()','readonly']) !!}
                                            </div>
                                        </div>
                                        <!-- <div id="areaRas"> -->
                                            <!-- <div class="form-group row"> -->
                                                <!-- {!! Form::label('ras_id', 'Ras', ['class' => 'col-sm-2 col-form-label']) !!} -->
                                                <!-- <div class="col-sm-10"> -->
                                                    {!! Form::hidden('ras_id',null, ['class'=>'form-control', 'placeholder'=>'Pilih Ras', 'style'=>'width: 100%;','readonly']) !!}
                                                <!-- </div>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            {!! Form::label('jenis_kelamin', 'Jenis Kelamin', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('jenis_kelamin', ['Jantan'=>'Jantan', 'Betina'=>'Betina'], (!empty($var['curr_klinik'])?$var['curr_klinik']->jenis_kelamin:""), ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Kelamin','readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                           
                                            {!! Form::label('umur', 'Umur', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                                {!! Form::text('umur', (!empty($var['curr_klinik'])?$var['curr_klinik']->umur:""), ['class'=>'form-control', 'placeholder'=>'Inputkan Umur','readonly']) !!}
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row"> -->
                                            <!-- {!! Form::label('ciri_ciri', 'Ciri - Ciri', ['class' => 'col-sm-2 col-form-label']) !!} -->
                                            <!-- <div class="col-sm-10"> -->
                                                {!! Form::hidden('ciri_ciri', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Ciri - Ciri','readonly']) !!}
                                            <!-- </div>
                                        </div> -->
                                        <div class="form-group row">
                                            <!--{!! Form::label('no_periksa', 'Nomor Periksa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                                {!! Form::text('no_periksa', ($var['method']=='create'?$var['noPeriksa']:null), ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Periksa']) !!}
                                            </div>-->
                                            {!! Form::label('tanggal_periksa', 'Tanggal Periksa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                                {!! Form::text('tanggal_periksa', (!empty($var['curr_klinik'])?$var['curr_klinik']->tanggal_periksa:""), ['class'=>'form-control', 'placeholder'=>'Inputkan Tanggal Periksa','autocomplete'=>'off','readonly']) !!}
                                            </div>
                                        </div>
                                        
										<div class="form-group row">
                                        {!! Form::label('pemeriksa', 'Pemeriksa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('pemeriksa', $var['pemeriksa'], $var['curr_klinik']->pemeriksa, ['class'=>'form-control', 'placeholder'=>'Pilih Pemeriksa', 'style'=>'width: 100%;','readonly']) !!}
                                            </div>
                                        </div>
										<div class="form-group row">
                                        {!! Form::label('riwayat', 'Riwayat Pasien', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                <button id="riwayat" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Riwayat Pasien</button>
												<!-- Modal -->
												<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
												  <div class="modal-dialog modal-lg">
													<div class="modal-content">
													  <div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Riwayat Pasien</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														  <span aria-hidden="true">&times;</span>
														</button>
													  </div>
													  <div class="modal-body">
														<div class="row">
															<div class="col-md-6">
																<table class="table">
																	<tr>
																		<td>Nama pasien</td>
																		<td>: {{$var['curr_klinik']->nama_hewan}}
																	</tr>
																	<tr>
																		<td>Spesies</td>
																		<td>: {{$var['curr_klinik']->klinik->spesies->nama_spesies}}
																	</tr>
																	<tr>
																		<td>Jenis Kelamin</td>
																		<td>: {{$var['curr_klinik']->jenis_kelamin}} </td>
																	</tr>
																</table>
																
															</div>
														</div>
														<div class="row">
															<div class="col-md-12">
																<table class="table table-stripped table-bordered">
																	<thead>
																		<tr>
																			<th>No.</th>
																			<th>Tanggal Periksa</th>
																			<th>Signalement/Anamnesa</th>
																			<th>Diagnosa</th>
																			<th>Penanganan</th>
																			<th>Keterangan</th>
																			<th>Pemeriksa</th>
																			<th>Paramedis</th>
																		</tr>
																	</thead>
																	<tbody>
																		@php $i = 1; @endphp
																		@foreach($var['riwayat'] as $dat)
																		<tr>
																			<td>{{$i}}</td>
																			<td>{{$dat->tanggal_periksa}}</td>
																			<td>{{$dat->signalement}}/{{$dat->anamnesia}}</td>
																			<td>{{$diagnosa[$dat->id]->penyakit}}</td>
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
																			</td>
																			<td>
																				{{$dat['keterangan']}}
																			</td>
																			<td>
																				{{$dat->nmpemeriksa}}
																			</td>
																			<td>
																				{{$dat->paramedis}}
																			</td>
																		</tr>
																		@php $i++; @endphp
																		@endforeach
																	</tbody>
																</table>
															</div>
														</div>
													  </div>
													  <div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														
													  </div>
													</div>
												  </div>
												</div>
                                            </div>
                                        </div>
										
										{!! Form::open(['id'=>'form-klinik', 'method'=>'POST', 'url'=>'/klinik/simpan_pemeriksaan']) !!}
                                        
										
										<input type="hidden" name="id" value="{{$var['curr_klinik']->id}}">
										<input type="hidden" name="from_url" value="{{$var['from_url']}}">
										<input type="hidden" name="hewan" value="{{$var['curr_klinik']->klinik_id}}">
										<div class="form-group row">
                                            {!! Form::label('signalement', 'Signalement', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('signalement', (!empty($var['curr_klinik'])?$var['curr_klinik']->signalement:""), ['class'=>'form-control', 'placeholder'=>'Inputkan Signalement']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('anamnesia', 'Anamnesa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::textarea('anamnesia', (!empty($var['curr_klinik'])?$var['curr_klinik']->anamnesia:""), ['class'=>'form-control', 'placeholder'=>'Inputkan Anamnesa']) !!}
                                            </div>
                                        </div>
										<div class="form-group row">
                                            {!! Form::label('diagnosa', 'Diagnosa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('diagnosa', $var['penyakit'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Penyakit', 'style'=>'width: 100%;','required'=>'required']) !!}
                                            </div>
                                        </div>
										<script>
											window.addEventListener("load", function(){
												$("#diagnosa").val({{$var['curr_klinik']->diagnosa}}).trigger("change");
											});
											
										</script>
										<div class="form-group row">
                                            {!! Form::label('paramedis', 'Paramedis', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('paramedis', (!empty($var['curr_klinik'])?$var['curr_klinik']->paramedis:""), ['class'=>'form-control', 'placeholder'=>'Inputkan Nama Paramedis']) !!}
                                            </div>
                                        </div>
										<legend>Terapi & Dosis</legend>                                        
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
                                                {!! Form::select('terapi_id', $var['obat'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Terapi / Tindakan', 'style'=>'width: 100%;']) !!}
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
										<input type="hidden" name="counter" id="counter" value="{{$var['jml_klinik_dosis']}}">
                                        <div id="areaDataTerapiDosis">
											<table class="table table-hover table-bordered" style="white-space: nowrap;">
												<thead>
													<tr class="bg-dark">
														<th width="30px" style="text-align: center;"><b>Hapus</b></th>
														<th style="text-align: center;"><b>Penanganan</b></th>
														<th style="text-align: center;"><b>Terapi</b></th>
														<th style="text-align: center;"><b>Dosis</b></th>
													</tr>
												</thead>
												<tbody id="my_table">
													@if(!empty($var['klinik_dosis']))
														@php 
															$i = 1; 
														@endphp
														@foreach($var['klinik_dosis'] as $dosis)
															<tr class="tbl{{$i}}"><td><a href="#" class="delete_row" onclick="hapus_tbl('{{$i}}')"><input type="hidden" name="id_detail[]" value="" class="id_detail"><i class="fa fa-trash"></i></a></td>
															<td><input type="hidden" name="tindakan_id[]" value="{{$dosis->tindakan}}">{{$var['penanganan'][$dosis->tindakan]}}</td>
															<td><input type="hidden" name="terapi_id[]" value="{{$dosis->terapi_id}}">{{$var['helper']->terapi($dosis->tindakan,$dosis->terapi_id)}}</td>
															<td><input type="hidden" name="dosis[]" value="{{$dosis->dosis}}">{{$dosis->dosis}}</td></tr>
														@php $i++; @endphp
														@endforeach
													@endif
												</tbody>											
											</table>
										</div>
										<div class="form-group row">
                                            {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::textarea('keterangan', (!empty($var['curr_klinik'])?$var['curr_klinik']->keterangan:""), ['class'=>'form-control', 'placeholder'=>'Inputkan Keterangan', 'rows'=>4,'required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                @if($var['method']=='edit')
                                                    {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
                                                    {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
                                                @elseif($var['method']=='create')
                                                    {!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!}
                                                    {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
                                                @else
                                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                                                @endif
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
        </div>

    </section>
    <!-- /.content -->

@endsection

@section('javascript')
    <script>
        function subSatuanKerja(userId = '') {
            if(userId == '') userId = $("#input_by").val();
            $.ajax({
                method : 'get',
                url : '{{ url('/klinik/nama-klinik') }}',
                data : 'userId='+userId,
            }).done(function (data) {
                $("#nama_sub_satuan_kerja").val(data.sub_satuan_kerja);
                $("#sub_satuan_kerja_id").val(data.id);
            });
        }

        function pemilik(pemilikId = '') {
            if(pemilikId == '') pemilikId = $("#pemilik_id").val();
            $.ajax({
                method : 'get',
                url : '{{ url('/klinik/pemilik') }}',
                data : 'pemilikId='+pemilikId,
            }).done(function (data) {
                $("#alamat_pemilik").val(data[1].alamat);
                $("#telepon_pemilik").val(data[1].telepon);
                $("#no_pasien").val(data[1].kode+'/'+data[0]);

                console.log(data);
            });
			ambilDataHewan(pemilikId);
        }    
		function dataHewan(klinikId = '') {
            if(klinikId == '') klinikId = $("#hewan").val();
			if($("#hewan").val() != "999999999999"){
				$.ajax({
					method : 'get',
					url : '{{ url('/klinik/detailHewan') }}',
					data : 'klinikId='+klinikId,
				}).done(function (data) {
					//alert(data[0]);
					$("#spesies_id").val(data[2]);
					//$("#ras_id").val(data[0]);
					$("#jenis_kelamin").val(data[3]);
					$("#umur").val(data[4]);
					$("#no_pasien").val(data[5]);
				});
			}else{
				$("#list_hewan").append("<input type='text' name='hewan_baru' class='form-control' placeholder='Nama Hewan' style='margin-top:10px;'>");
			}

            ambilJmlPeriksa(klinikId);
        }
		function ambilJmlPeriksa(klinikId){
            $.ajax({
                method : 'get',
                url : '{{ url('/klinik/getJmlPeriksa') }}',
                data : 'klinikId='+klinikId,
            }).done(function (data) {
                $("#no_periksa").val(data);
            });
        }
		
        function penangananAksi(penanganan = ''){
            if(penanganan == '') penanganan = $("#tindakan").val();

            if(penanganan == 2 || penanganan == 3 || penanganan == 4){
                $("#areaTindakan").load("{{ url('klinik/area-obat') }}", function(){
					$('select').on(
						'select2:close',
						function () {
							$(this).focus();
						}
					);
				});
				
			}else if(penanganan == 1 ){
				$("#areaTindakan").load("{{ url('klinik/area-vaksin') }}", function(){
					$('select').on(
						'select2:close',
						function () {
							$(this).focus();
						}
					);
				});
			}else if(penanganan == 5){
                $("#areaTindakan").load("{{ url('klinik/area-operasi') }}", function(){
					$('select').on(
						'select2:close',
						function () {
							$(this).focus();
						}
					);
				});
				
            }else{

            }
			
        }    

		function ambilDataHewan(pemilikId){
            if(pemilikId == '') pemilikId = $("#pemilik_id").val();
            //alert($("#pemilik_id").val());
			$("#hewan").load("{{ url('klinik/hewan') }}"+"?pemilikId="+pemilikId);
			//$("#hewan").append("<option value='999999999'>Lainnya</option>");
        }
		
        function ras(aksi = '', spesiesId = '', rasId = '') {
            if(spesiesId == '') spesiesId = $("#spesies_id").val();
            $("#areaRas").load("{{ url('klinik/area-ras') }}"+"?spesiesId="+spesiesId+"&rasId="+rasId);
        }

        //------------------------------------------------------------
        function tampilDataTerapiDosis(method='create', id=''){
            $("#areaDataTerapiDosis").load('{!! url('/klinik/area-data-terapi') !!}?method='+method+'&id='+id);
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

        $(document).ready(function() {
            @if($var['method']=='edit' || $var['method']=='show')
                var pk = "{{ $listKlinik->id }}";
                tampilDataTerapiDosis('{!! $var['method'] !!}', '{!! $listKlinik->id !!}');
                $(document).ready(function(){
                    ras("$var['method']", "{{ $listKlinik->spesies_id }}", "{{ $listKlinik->ras_id }}");
                });
            @else
                var pk = null;
            @endif

            $("#form-klinik").validate({
                rules: {
                    no_pasien: {
                        required: true,
                        remote: {
                            url: "{{ url('klinik/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "no_pasien",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    tanggal_periksa:{
                        requred: true,
                    }
                },
                messages: {
                    no_pasien: {
                        required: "Kolom nomor pasien harus diisi",
                        remote: "Nomor Pasien sudah digunakan"
                    },
                    tanggal_periksa:{
                        required: "Tanggal periksa harus diisi"
                    }
                }
            });

            $('#buttonTambahTerapiDosis').click(function(e){
				var counter = $("#counter").val();
                e.preventDefault();
				if($("#terapi_id").val() == ""){
					alert("Terapi Belum Diisi");
				}else{
					var data = {
						terapi: ($("#terapi_id").val()!=""?$("#terapi_id").val():""),
						dosis: ($("#dosis").val()!=""?$("#dosis").val():""),
						tindakan: ($("#tindakan").val()!=""?$("#tindakan").val():"")
					};

					$.ajax({
						method : 'post',
						url : '{{ url("/klinik/tambah-data-terapi") }}',
						data : data,
					}).done(function (data) {
						//tampilDataTerapiDosis();
						resetFormDataTerapiDosis();
					});
					
					var tindakan = $("#tindakan").val();
					var terapi_id = $("#terapi_id").val();
					var dosis = $("#dosis").val();
					
					var tindakan_text = $("#tindakan option:selected").text();
					var terapi_text = $("#terapi_id option:selected").text();
					var dosis_text = $("#dosis option:selected").text();
					$("#my_table").append(
						'<tr class="tbl'+counter+'"><td><a href="#" class="delete_row" onclick="hapus_tbl('+counter+')"><input type="hidden" name="id_detail[]" value="" class="id_detail"><i class="fa fa-trash"></i></a></td>'+
						'<td><input type="hidden" name="tindakan_id[]" value="'+tindakan+'">'+tindakan_text+"</td>"+
						'<td><input type="hidden" name="terapi_id[]" value="'+terapi_id+'">'+terapi_text+"</td>"+
						'<td><input type="hidden" name="dosis[]" value="'+dosis+'">'+dosis+"</td></tr>"
					);
					counter++;
					$("#counter").val(counter);
				}
            });

            $('#buttonResetTerapiDosis').click(function(e){
                e.preventDefault();
                resetFormDataTerapiDosis();
            });

            $('#tanggal_periksa').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });
			
			 //$('#example').select2();
				
			  $('select').on(
					'select2:close',
					function () {
						$(this).focus();
					}
				);
        });
		function hapus_tbl(id){
			$(".tbl"+id).remove();
		}
    </script>
@endsection
