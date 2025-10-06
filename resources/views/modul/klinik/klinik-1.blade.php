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
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a href="{{ url('klinik') }}" class="nav-link active"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            @can('Create Klinik')
                                <li class="nav-item"><a href="{{ url('klinik/create') }}" class="nav-link"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data Baru</b></span></a></li>
                            @endcan
                            <li class="nav-item"><a href="{{ url('klinik/add') }}" class="nav-link"><span class="hidden-sm-up"><b>Update Data</b></span> <span class="hidden-xs-down"><b>Update Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            @can('Create Klinik')
                                                <a href="{{ url('klinik/create') }}" class="btn btn-primary"><b>Tambah Data</b></a>
                                            @endcan
                                        </div>                                                                            
                                        <div class="col-lg-6">                                            
                                            <form method="get" action="">
                                                <div class="input-group">
                                                    <input name="cari" type="text" class="form-control" placeholder="Inputkan Pencarian" value="{{ Request::get('cari') }}" />
                                                    <div class="input-group-prepend">
                                                        <button type="submit" class="btn btn-info">Cari</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div> <br>                                                                   
                                    <!--<button class="btn btn-primary" data-toggle="modal" data-target="#modalsort">Sortir</button> -->
									
                                    <br> 
                                    <br />
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr class="bg-dark">
                                                    <th width="130px" style="text-align:center;">Aksi</th>
                                                    <th style="text-align:center;">No. Pasien</th>
                                                    <th style="text-align:center;">Tanggal Periksa</th>
                                                    <th style="text-align:center;">Klinik</th>
                                                    <th style="text-align:center;">Pemilik</th>
                                                    <th style="text-align:center;">Jenis Hewan</th>
                                                    <th style="text-align:center;">Nama Hewan</th>
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
                                                        <div class="btn-group">
                                                            {!! Form::open(['method'=>'delete', 'url'=>'/klinik/'.$item->id.$var['url']['all'], 'class'=> 'delete_form']) !!}
                                                            {!! Form::hidden('nomor', $no, ['class'=>'form-control']) !!}
                                                            <div class="btn-group btn-group-xs" role="group" aria-label="Basic example">
                                                                @can('Delete Klinik')
                                                                    <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                                @endcan
                                                                @can('Update Klinik')
                                                                    <a href="{{ url('/klinik/editRM/'.$item->id.'/'.$var['url']['all'])}}" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i></a>
                                                                @endcan                                                   <a href="{{ url('/klinik/detailPeriksa/'.$item->id.$var['url']['all'])}}" class="btn btn-info btn-xs"><i class="fa fa-search"></i></a>
                                                                <a href="{{ url('/klinik/cetakRM/'.$item->id)}}" class="btn btn-success btn-xs"><i class="fa fa-print"></i></a>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->no_pasien }}</td>
                                                    <td>{{ date('d F Y',strtotime($item->tanggal_periksa)) }}</td>
                                                    <td>{{ @$item->subSatuanKerja->sub_satuan_kerja }}</td>
                                                    <td>{{ @$item->pemilik->nama }}</td>
                                                    <td>{{ @$item->spesies->nama_spesies }}</td>
                                                    <td>{{ $item->nama_hewan }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-8 ml-auto">
                                            {{ $listKlinik->render() }}
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

    <!-- Modal -->
<div class="modal fade" id="modalsort" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sorting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="col-sm-6" style="margin-left:-20px;">
                                    Sortir : 
                                        <form method="get" action="{{ url('klinik') }}">
                                            <select name="order" class="form-control">
                                                <option value="tgl">Tanggal Periksa</option>
                                                <option value="nama">Nama</option>
                                                <option value="rm">Nomor Rekam Medis</option>
                                            </select>

                                            <select name="urut" class="form-control">
                                                <option value="asc">Ascending</option>
                                                <option value="desc">Descending</option>
                                            </select><br>
                                            <input type="submit" class="btn btn-primary" value="Sortir">
                                            </form>
                                        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection
