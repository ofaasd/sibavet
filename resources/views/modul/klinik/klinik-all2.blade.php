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
                        @include('modul.klinik.menu')
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    <!--<button class="btn btn-primary" data-toggle="modal" data-target="#modalsort">Sortir</button> -->
									
										@if($url == "pendaftaran")
											<a href="{{url('klinik/add_pendaftaran') }}" class="btn btn-primary">Tambah Pendaftaran</a>
										@endif
                                    <br> 
                                    <br />
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="myTable">
                                            <thead>
                                                <tr class="bg-dark">
                                                    <th width="130px" style="text-align:center;">Aksi</th>
                                                    <th style="text-align:center;">No. Pasien</th>
                                                    <th style="text-align:center;">Tanggal Periksa</th>
                                                    <!--<th style="text-align:center;">Klinik</th>-->
                                                    <th style="text-align:center;">Pemilik</th>
                                                    <th style="text-align:center;">Nama Hewan</th>
                                                    <th style="text-align:center;">Jenis Hewan</th>
                                                    <th style="text-align:center;">Status</th>
													@if($url == "rekap" or $url == "pembayaran")
														<th style="text-align:center;">Total</th>
													@endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach($listKlinik as $item)
                                                @php
                                                    $no++;
                                                @endphp
                                                <tr>
                                                    <td style="text-align:center">
													@if($url == "pemeriksaan")
														
														@if($item->status == 1)
															<a href="{{ url('/klinik/add_pemeriksaan/'.$item->id.'/awal')}}" class="btn btn-danger btn-xs">Blm Periksa</a>
														@else
															<a href="{{ url('/klinik/add_pemeriksaan/'.$item->id.'/awal')}}" class="btn btn-success btn-xs">Sudah Periksa</a>
														@endif
													@endif
													@if($url == "pendaftaran")
														{!! Form::open(['method'=>'post', 'url'=>'/klinik/hapus_pendaftaran', 'class'=> 'delete_form']) !!}
														{!! Form::hidden('id', $item->id, ['class'=>'form-control']) !!}
														
														<div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
															<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
															<a href="{{ url('/klinik/edit_pendaftaran/'.$item->id.'/awal')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
														</div>
														{!! Form::close() !!}
													@endif
													@if($url == "rekap")
														<div class="btn-group">
                                                            {!! Form::open(['method'=>'delete', 'url'=>'/klinik/'.$item->id.$var['url']['all'], 'class'=> 'delete_form']) !!}
                                                            {!! Form::hidden('nomor', $no, ['class'=>'form-control']) !!}
                                                            <div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
                                                                @can('Delete Klinik')
                                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                                @endcan
                                                                @can('Update Klinik')
                                                                    <a href="{{ url('/klinik/editRM/'.$item->klinik_id.'/'.$var['url']['all'])}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                                                @endcan                                                   <a href="{{ url('/klinik/detailPeriksa/'.$item->klinik_id.$var['url']['all'])}}" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a>
                                                                <a href="{{ url('/klinik/cetakRM/'.$item->klinik_id)}}" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
													@endif
													@if($url == "pembayaran")
														@if($item->status == 2)
															<a href="{{ url('/klinik/add_pembayaran/'.$item->id.'/awal')}}" class="btn btn-danger btn-xs">Blm Bayar</a>
														@else
															<div class="btn-group">
																<div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
																<a href="{{ url('/klinik/add_pembayaran/'.$item->id.'/awal')}}" class="btn btn-success btn-xs">Sudah Bayar</a>
																<!--<a href="{{ url('/klinik/edit_pembayaran/'.$item->id)}}" class="btn btn-success btn-xs">Edit</a>-->
																<a href="{{ url('/klinik/cetak/'.$item->id)}}" class="btn btn-primary btn-xs">Cetak</a>
																</div>
															</div>
														@endif
													@endif
                                                    </td>
                                                    <td>{{ $item->no_pasien }}</td>
                                                    <td>{{ date('d F Y',strtotime($item->tanggal_periksa)) }}</td>
                                                    <!--<td>{{ @$item->klinik->subSatuanKerja->sub_satuan_kerja }}</td>-->
                                                    <td>{{ @$item->klinik->pemilik->nama }}</td>
                                                    <td>{{ $item->nama_hewan }}</td>
                                                    <td>{{ @$item->klinik->spesies->nama_spesies }}</td>
                                                    <td>{{ $status[$item->status] }}</td>
													@if($url == "rekap" or $url == "pembayaran")
														<th style="text-align:center;">{{($item->status == 3)?"Rp. ". number_format($var['helper']->getTotal($item->id),0,"","."):0}}</th>
													@endif
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
