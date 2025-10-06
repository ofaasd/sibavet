@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Stock
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Stock</li>
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
									
									<div class="row">
										<div class="col-md-6" style="text-alignL:right">
											
												<form method="post" action="{{url('stock/index')}}">
													@csrf
													<div class="row">
														<div class="col-md-4">
															
																<select name="bulan" class="form-control" style="float:right" id="bulan">
																	@foreach($l_bulan as $key=>$value)
																		<option value='{{$key}}' @if($key==$bulan) {{'selected'}} @endif>{{$value}}</option>
																	@endforeach
																</select>
														</div>
														<div class="col-md-4">
																<select name="tahun" class="form-control" id="tahun">
																	@for($i=date('Y');$i>((int)date('Y')-5);$i--)
																		<option value='{{$i}}' @if($i==$tahun) {{'selected'}} @endif>{{$i}}</option>
																	@endfor
																</select>
														</div>
														<div class="col-md-4">
															<input type="submit" class="btn btn-primary" value="Lihat Data">
														</div>	
													</div>
												</form>
										</div>
										<div class="col-md-6" style="text-align:right">
											<a href="{{url('stock/export/' . $bulan . '/' . $tahun)}}" id="export_excel" class="btn btn-success">Export Excel</a>
										</div>
									</div>
									
									
                                    <br> 
                                    <br />
									<br />
									<form method="post" action="{{url('stock/update_stock_opname')}}">
									@csrf
									<input type="hidden" name="bulan" id="bulan_stock" value="{{$bulan}}">
									<input type="hidden" name="tahun" id="tahun_stock" value="{{$tahun}}">
									
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="bg-dark">
                                                    <th style="text-align:center;" rowspan=2>No</th>
                                                    <th style="text-align:center;" rowspan=2>Jenis Obat</th>
                                                    <th style="text-align:center;" colspan=2>Stok Awal Bulan</th>
                                                    <th style="text-align:center;" colspan=2>Masuk</th>
													<th style="text-align:center;" colspan=2>Jumlah Pemakaian</th>
													<th style="text-align:center;" colspan=2>Sisa Akhir Bulan</th>
                                                    <!--<th style="text-align:center;">Klinik</th>-->
                                                </tr>
												<tr>
													<th>Volume</th>
													<th>Satuan</th>
													<th>Volume</th>
													<th>Satuan</th>
													<th>Volume</th>
													<th>Satuan</th>
													<th>Volume</th>
													<th>Satuan</th>
												</tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach($stock as $id_obat=>$value)
                                                <tr>
													<td>{{$no}}</td>
													<td>
														{{$l_obat[$id_obat]}} 
														<input type="hidden" name="obat[]" value="{{$id_obat}}">
													</td>
													<td>{{$value}}</td>
													<td>ML</td>
													<td>{{$p_stock[$id_obat]}}</td>
													<td>ML</td>
													<td>{{$pengeluaran[$id_obat]}}</td>
													<td>ML</td>
													<td>
														{{($value-$pengeluaran[$id_obat]+$p_stock[$id_obat])}}
														<input type="hidden" name="stock[]" value="{{($value-$pengeluaran[$id_obat]+$p_stock[$id_obat])}}">
													</td>
													<td>ML</td>
												</tr>
                                                
												@php 
													$no++;
												@endphp
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
									<div class="col-md-12" style="text-align:center">
										<input type="submit" class="btn btn-primary col-md-12" value="Simpan Stock Opname">
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
	<script>
		
		window.onload = function () {
			$("#myTable").dataTable();
			/* $("#bulan").change(function(){
				$("#bulan_stock").val($(this).val());
			});
			$("#tahun").change(function(){
				$("#tahun_stock").val($(this).val());
			}); */
		}
	</script>
@endsection
