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
                                            <label for="input_by" class="col-sm-2 col-form-label">User</label>
                                            <div class="col-sm-10">
                                                <select name="input_by" id="input_by" class="form-control select2" placeholder="Pilih User" style="width: 100%;" onchange="subSatuanKerja()">
                                                    @foreach($var['user'] as $id => $name)
                                                        <option value="{{ $id }}" {{ $var['currentUser'] == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Klinik</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nama_sub_satuan_kerja" id="nama_sub_satuan_kerja" class="form-control" placeholder="Inputkan Nama Klinik" readonly value="{{ ($var['method']=='edit'||$var['method']=='show') ? (@$listKlinik->inputBy->subSatuanKerja->sub_satuan_kerja) : $var['namaKlinik'] }}">
                                                <input type="hidden" name="sub_satuan_kerja_id" value="{{ $var['idKlinik'] }}" class="form-control">
                                            </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="no_pasien" class="col-sm-2 col-form-label">No. RM</label>
                                            <div class="col-sm-10">
                                             <input type="text" name="no_pasien" class="form-control" placeholder="Inputkan No. RM" readonly value="{{ !empty($var['curr_klinik']) ? $var['curr_klinik']->no_pasien : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pemilik_id" class="col-sm-2 col-form-label">Pemilik</label>
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
                                            <label for="alamat_pemilik" class="col-sm-2 col-form-label">Alamat Pemilik</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="alamat_pemilik" class="form-control" placeholder="Inputkan Alamat Pemilik" readonly value="{{ !empty($var['curr_klinik']) ? $var['curr_klinik']->alamat_pemilik : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="telepon_pemilik" class="col-sm-2 col-form-label">Telepon Pemilik</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="telepon_pemilik" class="form-control" placeholder="Inputkan Telepon Pemilik" readonly value="{{ !empty($var['curr_klinik']) ? $var['curr_klinik']->telepon_pemilik : '' }}">
                                            </div>
                                        </div>
										<div class="form-group row">
											 <label for="nama_hewan" class="col-sm-2 col-form-label">Nama Hewan</label>
                                            <div class="col-sm-10" id="list_hewan">
												<select name="hewan" id="hewan" class="form-control" placeholder="Pilih Nama Hewan" style="width:100%" onchange="dataHewan()" readonly>
													@if(!empty($var['curr_klinik']))
														<option value="{{$var['curr_klinik']->id}}" selected >{{$var['curr_klinik']->nama_hewan}}</option>
													@endif
												</select>
                                            </div>
										</div>
                                        <div class="form-group row">
                                            <label for="spesies_id" class="col-sm-2 col-form-label">Jenis Hewan</label>
                                            <div class="col-sm-10">
                                                <select name="spesies_id" id="spesies_id" class="form-control" placeholder="Pilih Jenis Hewan" style="width: 100%;" onchange="ras()" readonly>
                                                    @foreach($var['spesies'] as $id => $name)
                                                        <option value="{{ $id }}" {{ (!empty($var['curr_klinik']) && $var['curr_klinik']->spesies_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div id="areaRas"> -->
                                        <input type="hidden" name="ras_id" id="ras_id" class="form-control" placeholder="Pilih Ras" style="width: 100%;" readonly>
                                        <div class="form-group row">
                                            <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                            <div class="col-sm-10">
                                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" placeholder="Pilih Jenis Kelamin" readonly>
                                                    <option value="Jantan" {{ (!empty($var['curr_klinik']) && $var['curr_klinik']->jenis_kelamin == 'Jantan') ? 'selected' : '' }}>Jantan</option>
                                                    <option value="Betina" {{ (!empty($var['curr_klinik']) && $var['curr_klinik']->jenis_kelamin == 'Betina') ? 'selected' : '' }}>Betina</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                           
                                            <label for="umur" class="col-sm-2 col-form-label">Umur</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="umur" class="form-control" placeholder="Inputkan Umur" readonly value="{{ !empty($var['curr_klinik']) ? $var['curr_klinik']->umur : '' }}">
                                            </div>
                                        </div>
                                        <input type="hidden" name="ciri_ciri" id="ciri_ciri" class="form-control" placeholder="Inputkan Ciri - Ciri" readonly>
                                        <div class="form-group row">
                                            <label for="tanggal_periksa" class="col-sm-2 col-form-label">Tanggal Periksa</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="tanggal_periksa" class="form-control" placeholder="Inputkan Tanggal Periksa" autocomplete="off" readonly value="{{ !empty($var['curr_klinik']) ? $var['curr_klinik']->tanggal_periksa : '' }}">
                                            </div>
                                        </div>
                                        
										<div class="form-group row">
                                            <label for="pemeriksa" class="col-sm-2 col-form-label">Pemeriksa</label>
                                            <div class="col-sm-10">
                                                <select name="pemeriksa" id="pemeriksa" class="form-control" placeholder="Pilih Pemeriksa" style="width: 100%;" readonly>
                                                    @foreach($var['pemeriksa'] as $id => $name)
                                                        <option value="{{ $id }}" {{ (!empty($var['curr_klinik']) && $var['curr_klinik']->pemeriksa == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label for="riwayat" class="col-sm-2 col-form-label">Riwayat Pasien</label>
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
										
										<form id="form-klinik" method="POST" action="/klinik/simpan_pemeriksaan">
										@csrf
                                        
										
										<input type="hidden" name="id" value="{{ $var['curr_klinik']->id }}">
										<div class="form-group row">
                                            <label for="signalement" class="col-sm-2 col-form-label">Signalement</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="signalement" class="form-control" placeholder="Inputkan Signalement" value="{{ !empty($var['curr_klinik']) ? $var['curr_klinik']->signalement : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="anamnesia" class="col-sm-2 col-form-label">Anamnesa</label>
                                            <div class="col-sm-10">
                                                <textarea name="anamnesia" class="form-control" placeholder="Inputkan Anamnesa">{{ !empty($var['curr_klinik']) ? $var['curr_klinik']->anamnesia : '' }}</textarea>
                                            </div>
                                        </div>
										<div class="form-group row">
                                            <label for="diagnosa" class="col-sm-2 col-form-label">Diagnosa</label>
                                            <div class="col-sm-10">
                                                <select name="diagnosa" id="diagnosa" class="form-control select2" placeholder="Pilih Penyakit" style="width: 100%;">
                                                    @foreach($var['penyakit'] as $id => $name)
                                                        <option value="{{ $id }}">{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
										<script>
											window.addEventListener("load", function(){
												$("#diagnosa").val({{$var['curr_klinik']->diagnosa}}).trigger("change");
											});
										</script>
										<div class="form-group row">
                                            <label for="paramedis" class="col-sm-2 col-form-label">Paramedis</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="paramedis" class="form-control" placeholder="Inputkan Nama Paramedis" value="{{ !empty($var['curr_klinik']) ? $var['curr_klinik']->paramedis : '' }}">
                                            </div>
                                        </div>
										<legend>Terapi & Dosis</legend>                                        
                                        <div class="form-group row">
                                            <label for="tindakan" class="col-sm-2 col-form-label">Jenis Penanganan</label>
                                            <div class="col-sm-10">
                                                <select name="tindakan" id="tindakan" class="form-control select2" placeholder="Pilih Jenis Penanganan" style="width: 100%;" onchange="penangananAksi()">
                                                    @foreach($var['penanganan'] as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
										<div id="areaTindakan">    
                                        <div class="form-group row">
                                            <label for="terapi_id" class="col-sm-2 col-form-label">Terapi / Tindakan</label>
                                            <div class="col-sm-10">
                                                <select name="terapi_id" id="terapi_id" class="form-control select2" placeholder="Pilih Terapi / Tindakan" style="width: 100%;">
                                                    @foreach($var['obat'] as $key => $value)
                                                        <option value="{{ $key }}">{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                        <div class="form-group row">
                                            <label for="dosis" class="col-sm-2 col-form-label">Dosis / Ket Penaganan</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="dosis" id="dosis" class="form-control" placeholder="Inputkan Dosis atau Keterangan Penanganan">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                <button type="button" class="btn btn-primary" id="buttonTambahTerapiDosis">Tambah</button>
                                                <button type="reset" class="btn btn-danger" id="buttonResetTerapiDosis">Reset</button>
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
                                            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                            <div class="col-sm-10">
                                                <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Inputkan Keterangan" rows="4" required="required">{{ !empty($var['curr_klinik']) ? $var['curr_klinik']->keterangan : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                @if($var['method']=='edit')
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="reset" class="btn btn-danger">Reset</button>
                                                @elseif($var['method']=='create')
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <button type="reset" class="btn btn-danger">Reset</button>
                                                @else
                                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                                                @endif
                                            </div>
                                        </div>                                    
                                    </form>
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
