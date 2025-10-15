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
									<div class="row">
										<div class="col-md-6">
										@if($url == "pendaftaran")
											<a href="{{url('klinik/add_pendaftaran') }}" class="btn btn-primary">Tambah Pendaftaran</a>
										@endif
										</div>
										<div class="col-md-12" style="text-alignL:right">
											
												<form method="post" action="{{url('klinik/rekap')}}">
													@csrf
													<div class="row">
														<div class="col-md-4">
															<select name="bulan" class="form-control" style="float:right">
																@foreach($l_bulan as $key=>$value)
																	<option value='{{$key}}'  {{($key==$bulan)?'selected':''}}>{{$value}}</option>
																@endforeach
															</select>
														</div>
														<div class="col-md-4">
															<select name="tahun" class="form-control">
																@for($i=date('Y');$i>((int)date('Y')-5);$i--)
																	<option value='{{$i}}' {{($i==$tahun)?'selected':''}}>{{$i}}</option>
																@endfor
															</select>
														</div>
														<div class="col-md-4">
															<input type="submit" class="btn btn-primary" value="Lihat Data">
														</div>	
													<div>
												</form>
												
											</div>
										</div>
									</div>
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
                                                    <th style="text-align:center;">Waktu Pendaftaran</th>
                                                    <th style="text-align:center;">Waktu Pemeriksaan</th>
                                                    <th style="text-align:center;">Waktu Pembayaran</th>
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
                                                <tr class="item-row">
                                                    <td style="text-align:center">
													@if($url == "pemeriksaan")
														@if($item->status == 1)
															<a href="{{ url('/klinik/add_pemeriksaan/'.$item->id.'/awal')}}" class="btn btn-danger btn-xs">Blm Periksa</a>
														@else
															<a href="{{ url('/klinik/add_pemeriksaan/'.$item->id.'/awal')}}" class="btn btn-success btn-xs">Sudah Periksa</a>
														@endif
													@endif
													@if($url == "pendaftaran")
														<form method="post" action="/klinik/hapus_pendaftaran" class="delete_form">
															<input type="hidden" name="_token" value="{{ csrf_token() }}">
															<input type="hidden" name="id" value="{{ $item->id }}" class="form-control">
														
														<div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
															<button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
															<a href="{{ url('/klinik/edit_pendaftaran/'.$item->id.'/awal')}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
														</div>
														</form>
													@endif
													@if($url == "rekap")
														<div class="btn-group"> {{-- This div is already present in the original code --}}
                                                            <form method="post" action="/klinik/{{ $item->id }}{{ $var['url']['all'] }}" class="delete_form">
                                                                @csrf
                                                                @method('delete')
                                                                <input type="hidden" name="nomor" value="{{ $no }}" class="form-control">
                                                            <div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
                                                                @can('Delete Klinik')
                                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                                @endcan
                                                                <a href="{{ url('/klinik/detailPeriksa/'.$item->klinik_id.$var['url']['all'])}}" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a>
                                                                <a href="{{ url('/klinik/cetakRM/'.$item->klinik_id)}}" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>
                                                            </div>
                                                            </form>
                                                        </div>
													@endif
													@if($url == "pembayaran")
														@if($item->status == 2)
															<a href="{{ url('/klinik/add_pembayaran/'.$item->id)}}" class="btn btn-danger btn-xs">Blm Bayar</a>
														@else
															<a href="{{ url('/klinik/add_pembayaran/'.$item->id)}}" class="btn btn-success btn-xs">Sudah Bayar</a>
														@endif
													@endif
                                                    </td>
                                                    <td>{{ $item->no_pasien }}</td>
                                                    <td>{{ date('d-m-Y',strtotime($item->tanggal_periksa)) }}</td>
                                                    <!--<td>{{ @$item->klinik->subSatuanKerja->sub_satuan_kerja }}</td>-->
                                                    <td>{{ @$item->klinik->pemilik->nama }}</td>
                                                    <td>{{ $item->nama_hewan }}</td>
                                                    
                                                    <td>{{ @$item->klinik->spesies->nama_spesies }}</td>
													<td>{{ $item->jam_pendaftaran }}</td>
                                                    <td>{{ $item->jam_pemeriksaan }}</td>
                                                    <td>{{ $item->jam_pembayaran }}</td>
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
			$("#myTable").dataTable({
				"order" : [[2,"desc"]]
			});
		}
	</script>
@endsection
