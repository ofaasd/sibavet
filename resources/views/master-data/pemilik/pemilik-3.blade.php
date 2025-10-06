@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pemilik
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Pemilik</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/pemilik') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/pemilik/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listPemilik, ['method'=>'PATCH', 'url'=> '/master-data/pemilik/'.$listPemilik->id.$var['url']['all'], 'id'=>'form-pemilik']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-pemilik', 'method'=>'POST', 'url'=>'/master-data/pemilik']) !!}
                                    @else
                                        {!! Form::model($listPemilik, ['class'=>'form-pemilik']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('kode', 'Kode', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                            @if($var['method']=='edit')
                                                {!! Form::text('kode', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Kode']) !!}
											@else
                                                {!! Form::text('kode', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Kode']) !!}                           
                                            @endif    
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('nama', 'Nama', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nama', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('alamat', 'Alamat', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('alamat', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Alamat']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('telepon', 'Telepon', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('telepon', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Telepon']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('ktp', 'Nomor KTP', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('ktp', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor KTP']) !!}
                                            </div>
                                        </div>
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
									<h3>Data Pasien</h3>
									<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#tambah">Tambah Pasien</a>
									<table class="table table-stripped">
										<thead>
											<tr>
												<th>Nama</th>
												<th>Jenis Hewan</th>
												<th>Jenis Kelamin</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@foreach($var['klinik'] as $row)
											<tr>
												<td>{{$row->nama_hewan}}</td>
												<td>{{$row->nama_spesies}}</td>
												<td>{{$row->jenis_kelamin}}</td>
												<td>
												<form method="post" action="{{ url('/master-data/pemilik/delete_pasien') }}" onsubmit="if(!confirm('Apakah anda yakin ? ')){return false;}" class="form">
													@csrf
													<input type="hidden" name="id" value="{{$row->id}}">
													<input type="hidden" name="id_pemilik" value="{{$listPemilik->id}}">
													<a href="" class="btn btn-primary" data-toggle="modal" data-target="#edit{{$row->id}}">Edit</a> 
													<a href="{{ url('/klinik/pendaftaran_pasien/' . $row->id) }}" class="btn btn-success">Daftarkan Pasien</a>
													<input type="submit" class="btn btn-danger" value="Delete">
												</form>
												</td>
											</tr>
											<div class="modal fade" id="edit{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												  <div class="modal-dialog" role="document">
													<div class="modal-content">
													  <div class="modal-header">
														<h5 class="modal-title" id="exampleModalLabel">Edit Pasien</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														  <span aria-hidden="true">&times;</span>
														</button>
													  </div>
													  <div class="modal-body">
														<form method="post" action="{{ url('/master-data/pemilik/update_pasien') }}">
														@csrf
															<input type="hidden" name="id" value="{{$row->id}}">
															<input type="hidden" name="id_pemilik" value="{{$listPemilik->id}}">
															<div class="form-group row">
																{!! Form::label('nama_hewan', 'Nama Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
																<div class="col-sm-10">
																	{!! Form::text('nama_hewan', $row->nama_hewan, ['class'=>'form-control', 'placeholder'=>'Nama Hewan']) !!}
																</div>
															</div>
															<div class="form-group row">
																{!! Form::label('spesies_id', 'Jenis Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
																<div class="col-sm-10">
																	{!! Form::select('spesies_id', $var['spesies'], $row->spesies_id, ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Hewan', 'style'=>'width: 100%;', 'onchange'=>'ras()']) !!}
																</div>
															</div>
															<div class="form-group row">
																{!! Form::label('jenis_kelamin', 'Jenis Kelamin', ['class' => 'col-sm-2 col-form-label']) !!}
																<div class="col-sm-10">
																	{!! Form::select('jenis_kelamin', ['Jantan'=>'Jantan', 'Betina'=>'Betina'], $row->jenis_kelamin, ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Kelamin']) !!}
																</div>
															</div>
														<br>
													  </div>
													  <div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														<input type="submit" class="btn btn-primary" value="Simpan">
														</form>
													  </div>
													</div>
												  </div>
												</div>
											@endforeach
										</tbody>
									</table>
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
	
	
<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pasien</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ url('master-data/pemilik/store_pasien') }}">
        @csrf
			<input type="hidden" name="kode_pemilik" value="{{$listPemilik->kode}}">
			<input type="hidden" name="id_pemilik" value="{{$listPemilik->id}}">
            <div class="form-group row">
				{!! Form::label('nama_hewan', 'Nama Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
				<div class="col-sm-10">
					{!! Form::text('nama_hewan', null, ['class'=>'form-control', 'placeholder'=>'Nama Hewan']) !!}
				</div>
			</div>
			<div class="form-group row">
				{!! Form::label('spesies_id', 'Jenis Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
				<div class="col-sm-10">
					{!! Form::select('spesies_id', $var['spesies'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Hewan', 'style'=>'width: 100%;', 'onchange'=>'ras()']) !!}
				</div>
			</div>
			<div class="form-group row">
				{!! Form::label('jenis_kelamin', 'Jenis Kelamin', ['class' => 'col-sm-2 col-form-label']) !!}
				<div class="col-sm-10">
					{!! Form::select('jenis_kelamin', ['Jantan'=>'Jantan', 'Betina'=>'Betina'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Kelamin']) !!}
				</div>
			</div>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" value="Simpan">
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            @if($var['method']=='edit' || $var['method']=='show')
                var pk = "{{ $listPemilik->id }}";
            @else
                var pk = null;
            @endif

            $("#form-pemilik").validate({
                rules: {
                    kode: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/pemilik/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "kode",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    nama: "required",
                },
                messages: {
                    kode: {
                        required: "Kolom kode harus diisi",
                        remote: "Kode sudah digunakan"
                    },
                    nama: "Kolom nama harus diisi",
                }
            });
        });
    </script>
@endsection
