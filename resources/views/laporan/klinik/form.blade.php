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
                                    <form id="form-cetak-klinik" method="POST" action="/laporan/lap-klinik">
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
                                            <label for="jenis" class="col-sm-2 col-form-label">Jenis Pelaporan</label>
                                            <div class="col-sm-10">
                                                <select name="jenis" id="jenis" class="form-control">
                                                    <option value="Penyakit">Penyakit</option>
                                                    <option value="Vaksinasi">Vaksinasi</option>
                                                    <option value="Operasi">Operasi</option>
                                                    <option value="Harian">Harian</option>
                                                </select>
                                            </div>
                                        </div>
                                        @if(Auth::user()->view_data==3 || Auth::user()->view_data==4)
                                            <div class="form-group row">
                                                <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Klinik</label>
                                                <div class="col-sm-10">
                                                    <select name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control">
                                                        @foreach($var['listKlinik'] as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @elseif(Auth::user()->view_data==1 || Auth::user()->view_data==2)
                                            <div class="form-group row">
                                                <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Klinik</label>
                                                <div class="col-sm-10">
                                                    <select name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control">
                                                        <option value="">Pilih Klinik</option>
                                                        @foreach($var['listKlinik'] as $id => $name)
                                                            <option value="{{ $id }}">{{ $name }}</option>
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
