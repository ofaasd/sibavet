@extends('boyolali.layouts.admin')

@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratorium Boyolali
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Laboratorium Boyolali</li>
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
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="{{ url('boyolali/lab-boyolali') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('boyolali/lab-boyolali/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listKlinik, ['method'=>'PATCH', 'url'=> '/boyolali/lab-boyolali/'.$listKlinik->id.$var['url']['all'], 'id'=>'form-klinik']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-klinik', 'method'=>'POST', 'url'=>'/boyolali/lab-boyolali']) !!}
                                    @else
                                        {!! Form::model($listKlinik, ['class'=>'form-klinik']) !!}
                                    @endif             
                                                         
                                        <div class="form-group row">
                                            {!! Form::label('kel_kerja_id', 'Kelompok Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('kel_kerja_id',$var['kelker'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kelompok Kerja']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('provinsi', 'Provinsi', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('provinsi',$var['provinsi'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Provinsi',"onchange"=>"getKota()"]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('kota', 'Kota / Kabupaten', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('kota',$var['kota'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kota / Kabupaten']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('kecamatan_id', 'Kecamatan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('kecamatan_id',$var['kecamatan'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kecamatan']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('tanggal_input', 'Tanggal', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('tanggal_input',(!empty($listKlinik->tanggal))?date('Y-m-d',strtotime($listKlinik->tanggal)):date('Y-m-d'), null, ['class'=>'form-control', 'placeholder'=>'Inputkan Tanggal','autocomplete'=>'off']) !!}
                                            </div>              
                                        </div>
							<legend>Hasil Pengujian</legend>
								<div id="areaPengujian">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group row">
												{!! Form::label('id_sampel', 'Sampel', ['class' => 'col-sm-2 col-form-label']) !!}
												<div class="col-sm-10">
													{!! Form::select('id_sampel',$var['sampel'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Sampel']) !!}
												</div>
											</div>
											<div class="form-group row">
												{!! Form::label('pengujian_id', 'Pengujian', ['class' => 'col-sm-2 col-form-label']) !!}
												<div class="col-sm-10">
													{!! Form::select('pengujian_id',$var['pengujian'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Pengujian']) !!}
												</div>
											</div>
											<div class="form-group row">
												{!! Form::label('hasil_pengujian', 'Hasil Pengujian', ['class' => 'col-sm-2 col-form-label']) !!}
												<div class="col-sm-10">
													{!! Form::select('hasil_pengujian',$var['hasil_pengujian'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Hasil Pengujian']) !!}
												</div>
											</div>
											<a href="#" id="add_row" class="btn btn-primary">Tambahkan</a> <br />
										</div>
									</div>
									<table class="table" id="datatable">
										<thead>
											<tr>
												<td>Sample</td>
												<td>Jenis Pengujian</td>
												<td>Hasil Pengujian</td> 
												<td></td>
											</tr>
										</thead>
										<tbody>
											@foreach($listDetailklinik as $value)
											<tr>
												<td><input type="hidden" name="sampel[]" value="'{{$value->id_sampel}}'">{{App\Models\Boyolali\MasterData\Sampel::where(['id'=>$value->id_sampel])->pluck('nm_sampel')->first()}}</td>
												<td><input type="hidden" name="pengujian[]" value="{{$value->id_pengujian}}">{{App\Models\MasterData\JenisPengujian::where(['id'=>$value->id_pengujian])->pluck('jenis_pengujian')->first()}}</td>
												<td><input type="hidden" name="hasil_pengujian[]" value="{{$value->hasil_pengujian}}">{{$value->hasil_pengujian}}</td>
												<td><a href="#" class="delete_row_update" ><input type="hidden" name="id_detail[]" value="{{$value->id}}" class="id_detail"><i class="fa fa-trash"></i></a></td>
											</tr>
											@endforeach
										</tbody>
									</table>   
                                </div>                                     
                                        <div id="areaDataSampel"></div>  
                                                                
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
        function getKota(){
            var provinsi = $('#provinsi').val();
            $("#kota").load("{{ url('boyolali/lab-boyolali/get-kota') }}"+"?provinsi="+provinsi);
        }

        document.getElementById('kota').onchange = function(){getKecamatan()};

        function getKecamatan(){
            var kota = $('#kota').val();
            $("#kecamatan_id").load("{{ url('boyolali/lab-boyolali/get-kec') }}"+"?kota="+kota);
        }        

        function hapusDataSampel(id){
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
                    url : '{{ url('/boyolali/lab-boyolali/hapus-data-sampel') }}',
                    data : 'id='+id,
                }).done(function (data) {
                    $("#areaDataSampel").html(data);
                    swal("Berhasil", "Data berhasil dihapus", "success");
                });
            });
        }
			
            $(document).ready(function() {
				@if($var['method']=='edit' || $var['method']=='show')
					var pk = "{{ $listKlinik->id }}";
				@else
					var pk = null;
				@endif            

				$('#buttonTambahSampel').click(function(e){
					e.preventDefault();
					var data = {
						id_sampel: ($("#id_sampel").val()!=""?$("#id_sampel").val():""),
						jml_sampel: ($("#jml_sampel").val()!=""?$("#jml_sampel").val():""),
						pengujian_id: ($("#pengujian_id").val()!=""?$("#pengujian_id").val():""),
						jumlah: ($("#jumlah").val()!=""?$("#jumlah").val():""),
						positif: ($("#positif").val()!=""?$("#positif").val():""),
						negatif: ($("#negatif").val()!=""?$("#negatif").val():"")
					};

					$.ajax({
						method : 'post',
						url : '{{ url('/boyolali/lab-boyolali/tambah-data-sampel') }}',
						data : data,
					}).done(function (data) {
						tampilDataSampel();
						resetFormSampel();
					});
				});

				$('#buttonResetSampel').click(function(e){
					e.preventDefault();
					resetFormSampel();
				});


				$('#tanggal_input').datepicker({
					autoclose: true,
					format: 'yyyy-mm-dd'
				});
				var t = $('#datatable').DataTable({
					"paging": false
				});
				var counter = 1;
				$("#add_row").on("click",function(){
					var sampel = $("#id_sampel").val();
					var pengujian = $("#pengujian_id").val();
					var hasil_pengujian = $("#hasil_pengujian").val();
					
					var sampel_text = $("#id_sampel option:selected").text();
					var pengujian_text = $("#pengujian_id option:selected").text();
					var hasil_pengujian_text = $("#hasil_pengujian option:selected").text();
					t.row.add([
						'<input type="hidden" name="sampel[]" value="'+sampel+'">'+sampel_text,
						'<input type="hidden" name="pengujian[]" value="'+pengujian+'">'+pengujian_text,
						'<input type="hidden" name="hasil_pengujian[]" value="'+hasil_pengujian+'">'+hasil_pengujian_text,
						'<a href="#" class="delete_row"><input type="hidden" name="id_detail[]" value="" class="id_detail"><i class="fa fa-trash"></i></a> ',
					]).draw();
					counter++;
				});
				

				$('#datatable tbody').on( 'click', '.delete_row', function () {
					t
						.row( $(this).parents('tr') )
						.remove()
						.draw();
				} );
				$('#datatable tbody').on( 'click', '.delete_row_update', function () {
					if (confirm('Are you sure you want to delete this?')) {
						if($(this).children("input").hasClass('id_detail')){
							$.ajax({
								method : 'post',
								url : '{{ url('/boyolali/lab-boyolali/hapus-detail') }}',
								data : 'id='+$(this).children("input").val(),
								success: function (data) {
									
										
									
								}
							});
							t
							.row( $(this).parents('tr') )
							.remove()
							.draw();
						}
						
					}else{
						return false;
					}
				} );
        
            });
		function delete_detail(id,lokasi){
			if (confirm('Are you sure you want to delete this?')) {
				t
					.row( $(lokasi).parents('tr') )
					.remove()
					.draw();
				/* 
				 */
			}else{
				return false;
			}
		}
		function resetFormSampel(){
			$("#id_sampel").val("").trigger("change");
			$("#jml_sampel").val("");
			$("#pengujian_id").val("").trigger("change");
			$("#jumlah").val("");
			$("#positif").val("");
			$("#negatif").val("");
		}
		

    </script>
@endsection
