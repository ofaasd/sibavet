@extends('boyolali.layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratorium Boyolali
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Laboratorium Boyolali</li>
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
                            <li class="nav-item"><a href="{{ url('boyolali/lab-boyolali') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('boyolali/lab-boyolali/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listKlinik, ['method'=>'PATCH', 'url'=> '/boyolali/lab-boyolali/'.$listKlinik->id.$var['url']['all'], 'id'=>'form-klinik']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-klinik', 'method'=>'POST', 'url'=>'/boyolali/lab-boyolali']) !!}
                                    @else
                                        {!! Form::model($listKlinik, ['class'=>'form-klinik']) !!}
                                    @endif             
                                                         
                                        <div class="form-group row">
                                            {!! Form::label('kel_kerja_id', 'Kelompok Kerja', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('kel_kerja_id',$var['kelker'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kelompok Kerja']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('provinsi', 'Provinsi', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('provinsi',$var['provinsi'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Provinsi',"onchange"=>"getKota()"]) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('kota', 'Kota / Kabupaten', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('kota',$var['kota'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kota / Kabupaten']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('kecamatan_id', 'Kecamatan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('kecamatan_id',$var['kecamatan'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kecamatan']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('tanggal_input', 'Tanggal', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('tanggal_input', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Tanggal','autocomplete'=>'off']) !!}
                                            </div>              
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('total_sampel', 'Jumlah Sampel Keseluruhan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::number('total_sampel', null, ['class'=>'form-control', 'placeholder'=>'Jumlah Sampel Keseluruhan']) !!}
                                            </div>
                                        </div>
                                        
                            <legend>Sampel & Hasil Uji</legend>                                        

                                <div id="areaSampel">    
                                        <div class="form-group row">
                                            {!! Form::label('id_sampel', 'Sampel', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('id_sampel',$var['sampel'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Sampel']) !!}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {!! Form::label('jml_sampel', 'Jumlah Sampel', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::number('jml_sampel', null, ['class'=>'form-control', 'placeholder'=>'Jumlah Sampel']) !!}
                                            </div>
                                        </div>                                     
                                         <div class="form-group row">
                                            {!! Form::label('pengujian_id', 'Jenis Pengujian', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('pengujian_id',$var['pengujian'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Pengujian']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::number('jumlah', null, ['class'=>'form-control', 'placeholder'=>'Masukkan Jumlah']) !!}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {!! Form::label('positif', 'Hasil Positif', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::number('positif', null, ['class'=>'form-control', 'placeholder'=>'Masukkan Hasil Positif']) !!}
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            {!! Form::label('negatif', 'Hasil Negatif', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::number('negatif', null, ['class'=>'form-control', 'placeholder'=>'Masukkan Hasil Negatif']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                {!! Form::submit('Tambah', ['class'=>'btn btn-primary', 'id'=>'buttonTambahSampel']) !!}
                                                {!! Form::reset('Reset', ['class'=>'btn btn-danger', 'id'=>'buttonResetSampel']) !!}
                                            </div>
                                        </div>   
                                </div>                                     
                                        <div id="areaDataSampel"></div>  
                                                                
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
        function getKota(){
            var provinsi = $('#provinsi').val();
            $("#kota").load("{{ url('boyolali/lab-boyolali/get-kota') }}"+"?provinsi="+provinsi);
        }

        document.getElementById('kota').onchange = function(){getKecamatan()};

        function getKecamatan(){
            var kota = $('#kota').val();
            $("#kecamatan_id").load("{{ url('boyolali/lab-boyolali/get-kec') }}"+"?kota="+kota);
        }        

        function hapusDataSampel(id){
            swal({
                reverseButton: false,
                title: "Data yakin dihapus ?",
                text: "Mohon diteliti sebelum menghapus data",
                type: "warning",
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonClass: 'btn-danger',
                cancelButtonClass: 'btn-inverse',
                closeOnConfirm: false
            }, function(){
               $.ajax({
                    method : 'post',
                    url : '{{ url('/boyolali/lab-boyolali/hapus-data-sampel') }}',
                    data : 'id='+id,
                }).done(function (data) {
                    $("#areaDataSampel").html(data);
                    swal("Berhasil", "Data berhasil dihapus", "success");
                });
            });
        }

            $(document).ready(function() {
            @if($var['method']=='edit' || $var['method']=='show')
                var pk = "{{ $listKlinik->id }}";
                tampilDataSampel('{!! $var['method'] !!}', '{!! $listKlinik->id !!}');                
            @else
                var pk = null;
            @endif            

        $('#buttonTambahSampel').click(function(e){
                e.preventDefault();
                var data = {
                    id_sampel: ($("#id_sampel").val()!=""?$("#id_sampel").val():""),
                    jml_sampel: ($("#jml_sampel").val()!=""?$("#jml_sampel").val():""),
                    pengujian_id: ($("#pengujian_id").val()!=""?$("#pengujian_id").val():""),
                    jumlah: ($("#jumlah").val()!=""?$("#jumlah").val():""),
                    positif: ($("#positif").val()!=""?$("#positif").val():""),
                    negatif: ($("#negatif").val()!=""?$("#negatif").val():"")
                };

                $.ajax({
                    method : 'post',
                    url : '{{ url('/boyolali/lab-boyolali/tambah-data-sampel') }}',
                    data : data,
                }).done(function (data) {
                    tampilDataSampel();
                    resetFormSampel();
                });
            });

            $('#buttonResetSampel').click(function(e){
                e.preventDefault();
                resetFormSampel();
            });

            function resetFormSampel(){
                $("#id_sampel").val("").trigger("change");
                $("#jml_sampel").val("");
                $("#pengujian_id").val("").trigger("change");
                $("#jumlah").val("");
                $("#positif").val("");
                $("#negatif").val("");
            }

            function tampilDataSampel(method='create', id=''){
            $("#areaDataSampel").load('{!! url('/boyolali/lab-boyolali/area-data-sampel') !!}?method='+method+'&id='+id);
        }

        $('#tanggal_input').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        
            });

    </script>
@endsection
