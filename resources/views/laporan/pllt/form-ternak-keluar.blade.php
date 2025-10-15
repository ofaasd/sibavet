@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laporan Ternak Keluar
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Laporan</a></li>
            <li class="breadcrumb-item active">Laporan Ternak Keluar</li>
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
                                    <form id="form-cetak-ternak-keluar" method="POST" action="/laporan/lap-ternak-keluar" target="_blank">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="dari_tanggal" class="col-sm-2 col-form-label">Dari Tanggal</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="dari_tanggal" id="dari_tanggal" class="form-control tanggalku" placeholder="Inputkan Dari Tanggal" autocomplete="off">
                                            </div>
                                            <label for="sampai_tanggal" class="col-sm-2 col-form-label">Sampai Tanggal</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="sampai_tanggal" id="sampai_tanggal" class="form-control tanggalku" placeholder="Inputkan Sampai Tanggal" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jenis" class="col-sm-2 col-form-label">Jenis</label>
                                            <div class="col-sm-10">
                                                <select name="jenis" id="jenis" class="form-control">
                                                    <option value="">Pilih Jenis</option>
                                                    <option value="kota">Berdasar Kota</option>
                                                    <option value="provinsi">Berdasar Provinsi</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if(Auth::user()->view_data==3 || Auth::user()->view_data==4)
                                            <div class="form-group row">
                                                <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">PLLT</label>
                                                <div class="col-sm-10">
                                                    <select name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control">
                                                        @foreach($var['listPllt'] as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @elseif(Auth::user()->view_data==1 || Auth::user()->view_data==2)
                                            <div class="form-group row">
                                                <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">PLLT</label>
                                                <div class="col-sm-10">
                                                    <select name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control">
                                                        <option value="">Pilih PLLT</option>
                                                        @foreach($var['listPllt'] as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="form-group row">
                                            <label for="format" class="col-sm-2 col-form-label">Format Laporan</label>
                                            <div class="col-sm-10">
                                                <select name="format" id="format" class="form-control">
                                                    <option value="PDF">PDF</option>
                                                    <option value="Excel">Excel</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                <button type="submit" class="btn btn-success">Cetak</button>
                                                <button type="button" class="btn btn-primary" id="btnPrev">Preview</button>
                                                <button type="reset" class="btn btn-danger">Reset</button>
                                            </div>
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
            $("#form-cetak-ternak-keluar").validate({
                rules: {
                    dari_tanggal: "required",
                    sampai_tanggal: "required",
                    jenis: "required",
                    sub_satuan_kerja_id: "required",
                },
                messages: {
                    dari_tanggal: "Kolom dari tanggal harus diisi",
                    sampai_tanggal: "Kolom sampai tanggal harus diisi",
                    jenis: "Kolom jenis harus diisi",
                    sub_satuan_kerja_id: "Kolom PLLT harus diisi",
                }
            });
        });

        $('#btnPrev').click(function(e){
                e.preventDefault();
                var dari_tanggal = $('#dari_tanggal').val();
                var sampai_tanggal = $('#sampai_tanggal').val();
                var jenis = $('#jenis').val();
                var sat = $('#sub_satuan_kerja_id').val();
                var format = $('#format').val();

                $("#prev").load('{!! url('/laporan/lap-ternak-keluar-prev') !!}?dari_tanggal='+dari_tanggal+'&sampai_tanggal='+sampai_tanggal+'&sub_satuan_kerja_id='+sat+'&format='+format+'&jenis='+jenis);
            });
    </script>
@endsection
