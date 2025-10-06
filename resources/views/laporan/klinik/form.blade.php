@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laporan Klinik
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Laporan</a></li>
            <li class="breadcrumb-item active">Laporan Klinik</li>
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
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    {!! Form::open(['id'=>'form-cetak-klinik', 'method'=>'POST', 'url'=>'/laporan/lap-klinik']) !!}
                                        <div class="form-group row">
                                            {!! Form::label('dari_tanggal', 'Dari Tanggal', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                            {!! Form::text('dari_tanggal', null, ['class'=>'form-control tanggalku', 'placeholder'=>'Inputkan Dari Tanggal', 'autocomplete'=>'off']) !!}
                                            </div>
                                            {!! Form::label('sampai_tanggal', 'Sampai Tanggal', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                            {!! Form::text('sampai_tanggal', null, ['class'=>'form-control tanggalku', 'placeholder'=>'Inputkan Sampai Tanggal', 'autocomplete'=>'off']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('jenis', 'Jenis Pelaporan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('jenis', ['Penyakit' => 'Penyakit','Vaksinasi'=>'Vaksinasi', 'Operasi'=>'Operasi','Harian'=>'Harian'], null, ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        @if(Auth::user()->view_data==3 || Auth::user()->view_data==4)
                                            <div class="form-group row">
                                                {!! Form::label('sub_satuan_kerja_id', 'Klinik', ['class' => 'col-sm-2 col-form-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::select('sub_satuan_kerja_id', $var['listKlinik'], null, ['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                        @elseif(Auth::user()->view_data==1 || Auth::user()->view_data==2)
                                            <div class="form-group row">
                                                {!! Form::label('sub_satuan_kerja_id', 'Klinik', ['class' => 'col-sm-2 col-form-label']) !!}
                                                <div class="col-sm-10">
                                                    {!! Form::select('sub_satuan_kerja_id', $var['listKlinik'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Klinik']) !!}
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            {!! Form::label('format', 'Format Laporan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('format', ['PDF'=>'PDF', 'Excel'=>'Excel'], null, ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                            {!! Form::submit('Cetak', ['class'=>'btn btn-success']) !!}
                                            {!! Form::submit('Preview', ['class'=>'btn btn-primary', 'id'=>'btnPrev']) !!}
                                                {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
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
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="box box-default">
                    <!-- /.box-header -->
                    <div class="box-body" style="overflow-x:scroll">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs">
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div id="prev">
                                    
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
    <script type="text/javascript">
        $(document).ready(function() {
            $("#form-cetak-klinik").validate({
                rules: {
                    bulan: "required",
                    tahun: "required",
                    sub_satuan_kerja_id: "required",
                },
                messages: {
                    bulan: "Kolom bulan harus diisi",
                    tahun: "Kolom tahun harus diisi",
                    sub_satuan_kerja_id: "Kolom klinik harus diisi",
                }
            });
        });

        function tampilPreviewCetak(){
            $("#areaDataTerapiDosis").load('{!! url('/klinik/area-data-terapi') !!}?method='+method+'&id='+id);
        }

        $('#btnPrev').click(function(e){
                e.preventDefault();
                var dari_tanggal = $('#dari_tanggal').val();
                var sampai_tanggal = $('#sampai_tanggal').val();
                var sat = $('#sub_satuan_kerja_id').val();
                var format = $('#format').val();
                var jenis = $('#jenis').val();

                $("#prev").load('{!! url('/laporan/lap-klinik-prev') !!}?dari_tanggal='+dari_tanggal+'&sampai_tanggal='+sampai_tanggal+'&sub_satuan_kerja_id='+sat+'&format='+format+'&jenis='+jenis);
            });
    </script>
@endsection
