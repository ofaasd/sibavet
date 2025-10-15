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
									
										
										<a href="{{url('stock/tambah_stock')}}" class="btn btn-primary">Tambah Stock</a>
                                    <br> 
                                    <br />
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="myTable">
                                            <thead>
                                                <tr class="bg-dark">
                                                    <th width="130px" style="text-align:center;">Aksi</th>
                                                    <th style="text-align:center;">Nama Obat</th>
                                                    <th style="text-align:center;">Jumlah</th>
                                                    <th style="text-align:center;">Satuan</th>
                                                    <th style="text-align:center;">Tanggal Masuk</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach($p_stock as $item)
                                                @php
                                                    $no++;
                                                @endphp
                                                <tr>
                                                    <td style="text-align:center">
													
													
														<div class="btn-group">
                                                            <form method="POST" action="/stock/hapus_stock" class="delete_form">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $item->id }}" class="form-control">
                                                                <div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
                                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                                    <a href="{{url('stock/edit_stock/' . $item->id)}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                                                </div>
                                                            </form>
                                                        </div>
													
                                                    </td>
                                                    <td>{{ $item->obat }}</td>
                                                    <td>{{ number_format($item->jumlah,0,"",".") }}</td>
                                                    <td>{{ $item->satuan }}</td>
                                                    <td>{{ date('d F Y',strtotime($item->tanggal)) }}</td>
                                                    <!--<td>{{ @$item->klinik->subSatuanKerja->sub_satuan_kerja }}</td>-->
													
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
