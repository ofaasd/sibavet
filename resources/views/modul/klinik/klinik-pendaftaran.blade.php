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
                                    @if($var['method'] == 'create')
									<form id="form-klinik" method="POST" action="{{ url('/klinik/simpan_pendaftaran') }}">
                                    @elseif($var['method'] == 'edit')
									<form id="form-klinik" method="POST" action="{{ url('/klinik/update_pendaftaran') }}">
									<input type="hidden" name="id_klinik_terapi" value="{{$var['curr_klinik']->id}}">
									<input type="hidden" name="from_url" value="{{$var['from_url']}}">
									@endif
									@csrf
									<div class="row">
										<div class="col-md-12">
											<div class="card">
												<div class="card-content">
													<div class="form-group row">
														<label for="input_by" class="col-sm-2 col-form-label">User</label>
														<div class="col-sm-10">                                                            
															<select name="input_by" id="input_by" class="form-control select2" placeholder="Pilih User" style="width: 100%;" onchange="subSatuanKerja()">
																@foreach($var['user'] as $id => $name)
																	<option value="{{ $id }}" {{ ($var['currentUser'] == $id) ? 'selected' : '' }}>{{ $name }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Klinik</label>
														<div class="col-sm-10">
															<input type="text" name="nama_sub_satuan_kerja" id="nama_sub_satuan_kerja" class="form-control" placeholder="Inputkan Nama Klinik" readonly value="{{ ($var['method']=='edit'||$var['method']=='show'?@$var['curr_klinik']->inputBy->subSatuanKerja->sub_satuan_kerja:$var['namaKlinik']) }}">
															<input type="hidden" name="sub_satuan_kerja_id" value="{{ $var['idKlinik'] }}" class="form-control">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="card">
												<div class="card-header">
													<h3>Data Pemilik</h3>
												</div>
												<div class="card-content">
													
													
													<div class="form-group row">
														<label for="pemilik_id" class="col-sm-2 col-form-label">Pemilik</label>
														<div class="col-sm-10">
															
															<select name="pemilik_id" id="pemilik_id" class="form-control select2" style="width:100%" onchange="pemilik()" required>
																<option value="0">Pilih Pemilik</option>
																@foreach($var['pemilik'] as $row)
																	<option value="{{$row->id}}">{{$row->nama}} - {{$row->alamat}}</option>
																@endforeach
																@if(!empty($var['curr_klinik']))
																	<option value="{{$var['curr_klinik']->pemilik_id}}" selected >{{$var['curr_klinik']->nama_pemilik}} - {{$var['curr_klinik']->alamat_pemilik}}</option>
																@endif
															</select>
															<small><a href="{{url('master-data/pemilik/create') }}">Klik Disini untuk menambah pemilik</a></small>
														</div>
													</div>
													
													<div class="form-group row">
														<label for="alamat_pemilik" class="col-sm-2 col-form-label">Alamat Pemilik</label>
														<div class="col-sm-10">
															<input type="text" id="alamat_pemilik" name="alamat_pemilik" value="{{ (!empty($var['curr_klinik'])?$var['curr_klinik']->alamat_pemilik:"") }}" class="form-control" placeholder="Inputkan Alamat Pemilik" readonly>
														</div>
													</div>
													<div class="form-group row">
														<label for="telepon_pemilik" class="col-sm-2 col-form-label">Telepon Pemilik</label>
														<div class="col-sm-10">
															<input type="text" id="telepon_pemilik" name="telepon_pemilik" value="{{ (!empty($var['curr_klinik'])?$var['curr_klinik']->telepon_pemilik:"") }}" class="form-control" placeholder="Inputkan Telepon Pemilik" readonly>
														</div>
													</div>
													
													
													<!-- <div class="form-group row"> -->
														<!-- <label for="ciri_ciri" class="col-sm-2 col-form-label">Ciri - Ciri</label> -->
														<!-- <div class="col-sm-10"> -->
															<input type="hidden" name="ciri_ciri" value="" class="form-control" placeholder="Inputkan Ciri - Ciri">
														<!-- </div>
													</div> -->
													<div class="form-group row">
														<label for="no_periksa" class="col-sm-2 col-form-label">Nomor Periksa</label>
														<div class="col-sm-4">
															<input type="text" name="no_periksa" id="no_periksa" class="form-control" placeholder="Inputkan Nomor Periksa" value="{{ ($var['method']=='create' ? $var['noPeriksa'] : null) }}">
														</div>
														<label for="tanggal_periksa" class="col-sm-2 col-form-label">Tanggal Periksa</label>
														<div class="col-sm-4">
															<input type="text" name="tanggal_periksa" value="{{ (!empty($var['curr_klinik'])?$var['curr_klinik']->tanggal_periksa:$var['tanggal_now']) }}" class="form-control" placeholder="Inputkan Tanggal Periksa" autocomplete="off">
														</div>
													</div>
													<div class="form-group row">
														<label for="pemeriksa" class="col-sm-2 col-form-label required">Pemeriksa</label>
														<div class="col-sm-10">
															<select name="pemeriksa" id="pemeriksa" class="form-control select2" placeholder="Pilih Pemeriksa" style="width: 100%;" required="required">
																@foreach($var['pemeriksa'] as $id => $name)
																	<option value="{{ $id }}">{{ $name }}</option>
																@endforeach
															</select>
														</div>
													</div>
													@if(!empty($var['curr_klinik']))
													<script>
														window.addEventListener("load", function(){
															$("#pemeriksa").val({{$var['curr_klinik']->pemeriksa}}).trigger("change");
														});
													</script>
													@endif
													<div class="form-group row">
														<label for="keluhan" class="col-sm-2 col-form-label">Keluhan</label>
														<div class="col-sm-10">
															<textarea name="keluhan" class="form-control" placeholder="Inputkan Keluhan" rows="4" required>{{ (!empty($var['curr_klinik'])?$var['curr_klinik']->keluhan:"-") }}</textarea>
														</div>
													</div>
													
												</div>
											</div>	
										</div>
										<div class="col-md-6">
											<div class="card">
												<div class="card-header">
													<h3>Data Pasien</h3>
												</div>
												<div class="card-content">
													<div class="form-group row">
														 <label for="nama_hewan" class="col-sm-2 col-form-label">Nama Hewan</label>
														<div class="col-sm-10" id="list_hewan">
															<select name="hewan" id="hewan" class="form-control select2" placeholder="Pilih Nama Hewan" style="width:100%" onchange="dataHewan()" required>
																@if(!empty($var['curr_klinik']))
																	<option value="{{$var['new_klinik_id']}}" selected >{{$var['curr_klinik']->nama_hewan}}</option>
																	@foreach($var['list_hewan'] as $value)
																		<option value="{{$value->id}}">{{$value->nama_hewan}}</option>
																	@endforeach
																@endif
															</select>
															<div id="new_hewan">
															
															</div>	
														</div>
													</div>
													<div class="form-group row">
														<label for="no_pasien" class="col-sm-2 col-form-label">No. RM</label>
														<div class="col-sm-10">
															<input type="text" name="no_pasien" id="no_pasien" value="{{ (!empty($var['curr_klinik'])?$var['curr_klinik']->no_pasien:"") }}" class="form-control" placeholder="Inputkan No. RM" readonly required>
														</div>
														<input type="hidden" id="new_no_pasien">
													</div>
													<div class="form-group row">
														<label for="spesies_id" class="col-sm-2 col-form-labe required">Jenis Hewan</label>
														<div class="col-sm-10">
															<select name="spesies_id" id="spesies_id" class="form-control" placeholder="Pilih Jenis Hewan" style="width: 100%;" required="required">
																@foreach($var['spesies'] as $id => $name)
																	<option value="{{ $id }}" {{ (!empty($var['curr_klinik']) && $var['curr_klinik']->spesies_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
																@endforeach
															</select>
														</div>
													</div>
													<!-- <div id="areaRas"> -->
							<!-- <div class="form-group row"> -->
							<!-- <label for="ras_id" class="col-sm-2 col-form-label">Ras</label> -->
							<!-- <div class="col-sm-10"> -->
								<input type="hidden" name="ras_id" id="ras_id" class="form-control" placeholder="Pilih Ras" style="width: 100%;" value="">
							<!-- </div>
							</div>
						    </div> -->
													<div class="form-group row">
														<label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
														<div class="col-sm-10">
															<select name="jenis_kelamin" id="jenis_kelamin" class="form-control" placeholder="Pilih Jenis Kelamin">
																<option value="Jantan" {{ (!empty($var['curr_klinik']) && $var['curr_klinik']->jenis_kelamin == 'Jantan') ? 'selected' : '' }}>Jantan</option>
																<option value="Betina" {{ (!empty($var['curr_klinik']) && $var['curr_klinik']->jenis_kelamin == 'Betina') ? 'selected' : '' }}>Betina</option>
															</select>
														</div>
													</div>
													<div class="form-group row">
													   
														<label for="umur" class="col-sm-2 col-form-label">Umur</label>
														<div class="col-sm-4">
															<input type="text" name="umur" value="{{ (!empty($var['curr_klinik'])?$var['curr_klinik']->umur:"") }}" class="form-control" placeholder="Inputkan Umur" required="required">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<div class="col-lg-4 ml-auto">
													@if($var['method'] == 'edit')
														<button type="submit" class="btn btn-primary">Update</button>
														<button type="reset" class="btn btn-danger">Reset</button>
													@elseif($var['method'] == 'create')
														<button type="submit" class="btn btn-primary">Simpan</button>
														<button type="reset" class="btn btn-danger">Reset</button>
													@else
														<a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
													@endif
												</div>
											</div>
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
				// alert(data[1].alamat)
                $("#alamat_pemilik").val(data[1].alamat);
                $("#telepon_pemilik").val(data[1].telepon);
                $("#new_no_pasien").val(data[1].kode+'/'+data[0]);
				
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
					$("#new_hewan").html("");
				});
			}else{
				$("#new_hewan").html("<input type='text' name='hewan_baru' class='form-control' placeholder='Nama Hewan' style='margin-top:10px;'>");
				$("#no_pasien").val($("#new_no_pasien").val());
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

            if(penanganan == 0 || penanganan == 1 || penanganan == 2){
                $("#areaTindakan").load("{{ url('klinik/area-obat') }}");
            }else if(penanganan == 4){
                $("#areaTindakan").load("{{ url('klinik/area-operasi') }}");
            }else{

            }
        }    

		function ambilDataHewan(pemilikId){
            if(pemilikId == '') pemilikId = $("#pemilik_id").val();
            //alert($("#pemilik_id").val());
			//$("#hewan").load("{{ url('klinik/hewan') }}"+"?pemilikId="+pemilikId);
			$.ajax({
				url : "{{ url('klinik/hewan') }}"+"?pemilikId="+pemilikId,
				method : "GET",
				success : function(data){
					$("#list_hewan").html(data);
				}
			});
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
                var pk = "{{ $var['curr_klinik']->id }}";
                tampilDataTerapiDosis('{!! $var['method'] !!}', '{!! $var['curr_klinik']->id !!}');
                $(document).ready(function(){
                    ras("$var['method']", "{{ $var['curr_klinik']->spesies_id }}", "{{ $var['curr_klinik']->ras_id }}");
                });
            @else
                var pk = null;
            @endif

            /* $("#form-klinik").validate({
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
                    },
					pemeriksa:{
                        requred: true,
                    },
					umur:{
                        requred: true,
                    },
					
					
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
            }); */

            $('#buttonTambahTerapiDosis').click(function(e){
                e.preventDefault();
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
                    tampilDataTerapiDosis();
                    resetFormDataTerapiDosis();
                });
            });

            $('#buttonResetTerapiDosis').click(function(e){
                e.preventDefault();
                resetFormDataTerapiDosis();
            });

            $('#tanggal_periksa').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });
			//$('#form-klinik').validate();
        });
    </script>
@endsection
