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
									{!! Form::open(['id'=>'form-klinik', 'method'=>'POST', 'url'=>'/klinik/simpan_pendaftaran']) !!}
                                    @elseif($var['method'] == 'edit')
									{!! Form::open(['id'=>'form-klinik', 'method'=>'POST', 'url'=>'/klinik/update_pendaftaran']) !!}
									<input type="hidden" name="id_klinik_terapi" value="{{$var['curr_klinik']->id}}">
									<input type="hidden" name="from_url" value="{{$var['from_url']}}">
									@endif
									<div class="row">
										<div class="col-md-12">
											<div class="card">
												<div class="card-content">
													<div class="form-group row">
														{!! Form::label('input_by', 'User', ['class' => 'col-sm-2 col-form-label']) !!}
														<div class="col-sm-10">
															{!! Form::select('input_by', $var['user'], $var['currentUser'], ['class'=>'form-control select2', 'placeholder'=>'Pilih User', 'style'=>'width: 100%;', 'onchange'=>'subSatuanKerja()']) !!}
														</div>
													</div>
													<div class="form-group row">
														{!! Form::label('sub_satuan_kerja_id', 'Nama Klinik', ['class' => 'col-sm-2 col-form-label']) !!}
														<div class="col-sm-10">
															{!! Form::text('nama_sub_satuan_kerja', ($var['method']=='edit'||$var['method']=='show'?@$var['curr_klinik']->inputBy->subSatuanKerja->sub_satuan_kerja:$var['namaKlinik']), ['class'=>'form-control', 'id'=>'nama_sub_satuan_kerja', 'placeholder'=>'Inputkan Nama Klinik', 'readonly']) !!}
															{!! Form::hidden('sub_satuan_kerja_id', $var['idKlinik'], ['class'=>'form-control']) !!}
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
														{!! Form::label('pemilik_id', 'Pemilik', ['class' => 'col-sm-2 col-form-label']) !!}
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
													
													
													<!-- <div class="form-group row"> -->
														<!-- {!! Form::label('ciri_ciri', 'Ciri - Ciri', ['class' => 'col-sm-2 col-form-label']) !!} -->
														<!-- <div class="col-sm-10"> -->
															{!! Form::hidden('ciri_ciri', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Ciri - Ciri']) !!}
														<!-- </div>
													</div> -->
													<div class="form-group row">
														<!--{!! Form::label('no_periksa', 'Nomor Periksa', ['class' => 'col-sm-2 col-form-label']) !!}
														<div class="col-sm-4">
															{!! Form::text('no_periksa', ($var['method']=='create'?$var['noPeriksa']:null), ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Periksa']) !!}
														</div>-->
														{!! Form::label('tanggal_periksa', 'Tanggal Periksa', ['class' => 'col-sm-2 col-form-label']) !!}
														<div class="col-sm-4">
															{!! Form::text('tanggal_periksa', (!empty($var['curr_klinik'])?$var['curr_klinik']->tanggal_periksa:$var['tanggal_now']), ['class'=>'form-control', 'placeholder'=>'Inputkan Tanggal Periksa','autocomplete'=>'off']) !!}
														</div>
													</div>
													<div class="form-group row">
														{!! Form::label('pemeriksa', 'Pemeriksa', ['class' => 'col-sm-2 col-form-label required']) !!}
														<div class="col-sm-10">
															{!! Form::select('pemeriksa', $var['pemeriksa'],null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Pemeriksa', 'style'=>'width: 100%;', 'required'=>'required']) !!}
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
														{!! Form::label('keluhan', 'Keluhan', ['class' => 'col-sm-2 col-form-label']) !!}
														<div class="col-sm-10">
															{!! Form::textarea('keluhan', (!empty($var['curr_klinik'])?$var['curr_klinik']->keluhan:"-"), ['class'=>'form-control', 'placeholder'=>'Inputkan Keluhan', 'rows'=>4, 'required']) !!}
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
														 {!! Form::label('nama_hewan', 'Nama Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
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
														{!! Form::label('no_pasien', 'No. RM', ['class' => 'col-sm-2 col-form-label']) !!}
														<div class="col-sm-10">
															{!! Form::text('no_pasien', (!empty($var['curr_klinik'])?$var['curr_klinik']->no_pasien:""), ['class'=>'form-control', 'placeholder'=>'Inputkan No. RM','readonly','required']) !!}
														</div>
														<input type="hidden" id="new_no_pasien">
													</div>
													<div class="form-group row">
														{!! Form::label('spesies_id', 'Jenis Hewan', ['class' => 'col-sm-2 col-form-labe required']) !!}
														<div class="col-sm-10">
															{!! Form::select('spesies_id', $var['spesies'], (!empty($var['curr_klinik'])?$var['curr_klinik']->spesies_id:""), ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Hewan', 'style'=>'width: 100%;','required'=>'required']) !!}
														</div>
													</div>
													<!-- <div id="areaRas"> -->
														<!-- <div class="form-group row"> -->
															<!-- {!! Form::label('ras_id', 'Ras', ['class' => 'col-sm-2 col-form-label']) !!} -->
															<!-- <div class="col-sm-10"> -->
																{!! Form::hidden('ras_id',null, ['class'=>'form-control', 'placeholder'=>'Pilih Ras', 'style'=>'width: 100%;']) !!}
															<!-- </div>
														</div>
													</div> -->
													<div class="form-group row">
														{!! Form::label('jenis_kelamin', 'Jenis Kelamin', ['class' => 'col-sm-2 col-form-label']) !!}
														<div class="col-sm-10">
															{!! Form::select('jenis_kelamin', ['Jantan'=>'Jantan', 'Betina'=>'Betina'], (!empty($var['curr_klinik'])?$var['curr_klinik']->jenis_kelamin:""), ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Kelamin']) !!}
														</div>
													</div>
													<div class="form-group row">
													   
														{!! Form::label('umur', 'Umur', ['class' => 'col-sm-2 col-form-label']) !!}
														<div class="col-sm-4">
															{!! Form::text('umur', (!empty($var['curr_klinik'])?$var['curr_klinik']->umur:""), ['class'=>'form-control', 'placeholder'=>'Inputkan Umur','required'=>'required']) !!}
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
