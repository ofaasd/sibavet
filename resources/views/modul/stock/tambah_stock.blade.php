@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Penambahan Stock
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Penambahan Stock</li>
        </ol>
    </section>
	
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body">
						@include('modul.stock.menu')
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    <!--<button class="btn btn-primary" data-toggle="modal" data-target="#modalsort">Sortir</button> -->
									
									@if(!empty($item))
										<form method="post" action="{{ url('/stock/update_stock') }}">
									@else
										<form method="post" action="{{ url('/stock/simpan_stock') }}">	
									@endif
										@csrf
											<input type="hidden" name="id" value="{{(!empty($item))?$item->id:""}}">
											<div class="form-group row">
												{!! Form::label('obat', 'Jenis Obat', ['class' => 'col-sm-2 col-form-label']) !!}
												<div class="col-sm-10">
													{!! Form::select('obat', $obat, (!empty($item))?$item->obat_id:"", ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Obat', 'style'=>'width: 100%;']) !!}
												</div>
											</div>
											@if(!empty($item))
												<script>
													window.addEventListener("load", function(){
														$("#obat").val({{$item->obat_id}}).trigger("change");
													});
												</script>
												@endif
											<div class="form-group row">
												{!! Form::label('Jumlah', 'Jumlah', ['class' => 'col-sm-2 col-form-label']) !!}
												<div class="col-sm-4">
													{!! Form::text('jumlah',(!empty($item))?$item->jumlah:"", ['class'=>'form-control', 'placeholder'=>'Jumlah, Ex : 0']) !!}
												</div>
											</div>
											<div class="form-group row">
												{!! Form::label('Satuan', 'Satuan', ['class' => 'col-sm-2 col-form-label']) !!}
												<div class="col-sm-4">
													{!! Form::text('satuan',(!empty($item))?$item->satuan:"ML", ['class'=>'form-control', 'placeholder'=>'Ex : ML']) !!}
												</div>
											</div>
											<div class="form-group row">
												{!! Form::label('Tanggal', 'Tanggal', ['class' => 'col-sm-2 col-form-label']) !!}
												<div class="col-sm-4">
													<input type="date" name="tanggal" class="form-control" value="{{(!empty($item))?date('Y-m-d', strtotime($item->tanggal)):""}}">
												</div>
											</div>
										<br>
									  
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<input type="submit" class="btn btn-primary" value="Simpan">
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
	<script>
		window.onload = function () {
			$("#myTable").dataTable();
		}
	</script>
@endsection
