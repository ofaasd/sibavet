@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Hak Akses
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
            <li class="breadcrumb-item active">Hak Akses</li>
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
                            <li class="nav-item"><a href="{{ url('pengaturan/hak-akses') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('pengaturan/hak-akses/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listHakAkses, ['method'=>'PATCH', 'url'=> '/pengaturan/hak-akses/'.$listHakAkses->id.$var['url']['all'], 'id'=>'form-hak-akses']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-hak-akses', 'method'=>'POST', 'url'=>'/pengaturan/hak-akses']) !!}
                                    @else
                                        {!! Form::model($listHakAkses, ['class'=>'form-hak-akses']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('name', 'Nama Hak Akses', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama Hak Akses']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::textarea('keterangan', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Keterangan', 'rows'=>4]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-10 ml-auto">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr class="bg-dark">
                                                                <th style="text-align:center;">Menu</th>
                                                                <th style="text-align:center;">Read</th>
                                                                <th style="text-align:center;">Create</th>
                                                                <th style="text-align:center;">Update</th>
                                                                <th style="text-align:center;">Delete</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $no = 0;
                                                        @endphp
                                                        @foreach($var['role'] as $item)
                                                            @php
                                                                $read = $userHelper->hakAkses($item->menu, 'Read');
                                                                $create = $userHelper->hakAkses($item->menu, 'Create');
                                                                $update = $userHelper->hakAkses($item->menu, 'Update');
                                                                $delete = $userHelper->hakAkses($item->menu, 'Delete');

                                                                $no++;
                                                            @endphp
                                                            <tr>
                                                                <td><b>{{ $item->menu }}</b></td>
                                                                <td style="text-align:center;">
                                                                    @if(!empty($read))
                                                                        <div style="margin:-15px;">
                                                                            {!! Form::checkbox('permission[]', $read->name, (in_array($read->name, $var['permission'])?'checked':null), ['id'=>$read->id]) !!}
                                                                            <label for="{!! $read->id !!}"></label>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td style="text-align:center;">
                                                                    @if(!empty($create))
                                                                        <div style="margin:-15px;">
                                                                            {!! Form::checkbox('permission[]', $create->name, (in_array($create->name, $var['permission'])?'checked':null), ['id'=>$create->id]) !!}
                                                                            <label for="{!! $create->id !!}"></label>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td style="text-align:center;">
                                                                    @if(!empty($update))
                                                                        <div style="margin:-15px;">
                                                                            {!! Form::checkbox('permission[]', $update->name, (in_array($update->name, $var['permission'])?'checked':null), ['id'=>$update->id]) !!}
                                                                            <label for="{!! $update->id !!}"></label>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td style="text-align:center;">
                                                                    @if(!empty($delete))
                                                                        <div style="margin:-15px;">
                                                                            {!! Form::checkbox('permission[]', $delete->name, (in_array($delete->name, $var['permission'])?'checked':null), ['id'=>$delete->id]) !!}
                                                                            <label for="{!! $delete->id !!}"></label>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
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
        $(document).ready(function() {
            $("#form-hak-akses").validate({
                rules: {
                    name: "required",
                },
                messages: {
                    name: "Kolom nama hak akses harus diisi",
                }
            });
        });
    </script>
@endsection
