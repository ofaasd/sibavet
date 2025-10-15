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
										<form method="post" action="{{ url('/stock/update_stock_awal') }}">
									@else
										<form method="post" action="{{ url('/stock/simpan_stock_awal') }}">	
									@endif
										@csrf
											<input type="hidden" name="id" value="{{(!empty($item))?$item->id:""}}">
											<div class="form-group row">
												<label for="obat" class="col-sm-2 col-form-label">Jenis Obat</label>
												<div class="col-sm-10">
													<select name="obat" id="obat" class="form-control select2" style="width: 100%;">
														<option value="">Pilih Jenis Obat</option>
														@foreach($obat as $key => $value)
															<option value="{{ $key }}" {{ (!empty($item) && $item->obat_id == $key) ? 'selected' : '' }}>{{ $value }}</option>
														@endforeach
													</select>
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
												<label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
												<div class="col-sm-4">
													<input type="text" name="jumlah" id="jumlah" class="form-control" placeholder="Jumlah, Ex : 0" value="{{ !empty($item) ? $item->stock : '' }}">
												</div>
											</div>
											<div class="form-group row">
												<label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
												<div class="col-sm-4">
													<input type="text" name="satuan" id="satuan" class="form-control" placeholder="Ex : ML" value="{{ !empty($item) ? $item->satuan : 'ML' }}">
												</div>
											</div>
											
											<div class="form-group row">
												<label for="bulan" class="col-sm-2 col-form-label">Bulan</label>
												<div class="col-sm-4">
													<select name="bulan" id="bulan" class="form-control" style="float:right">
														@foreach($l_bulan as $key=>$value)
															<option value='{{$key}}'  {{($key==$bulan)?'selected':''}}>{{$value}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
												<div class="col-sm-4">
													<select name="tahun" id="tahun" class="form-control">
														@for($i=date('Y');$i>((int)date('Y')-5);$i--)
															<option value='{{$i}}' {{($i==$tahun)?'selected':''}}>{{$i}}</option>
														@endfor
													</select>
												</div>
											</div>
											
											
										<br>
									  
										<a href="{{ url('/stock/add_stock_awal') }}" class="btn btn-secondary">Kembali</a>
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
