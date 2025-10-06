@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Laboratorium
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">Laboratorium</li>
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
                            <li class="nav-item"><a href="{{ url('laboratorium') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('laboratorium/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    <div class="box-body wizard-content">
                                        @if($var['method']=='edit')
                                            {!! Form::model($listLaboratorium, ['method'=>'PATCH', 'url'=> '/laboratorium/'.$listLaboratorium->id.$var['url']['all'], 'id'=>'form-laboratorium', 'class'=>'tab-wizard wizard-circle', 'files'=>true]) !!}
                                        @elseif($var['method']=='create')
                                            {!! Form::open(['id'=>'form-laboratorium', 'method'=>'POST', 'url'=>'/laboratorium', 'class'=>'validation-wizard wizard-circle', 'files'=>true]) !!}
                                        @else
                                            {!! Form::model($listLaboratorium, ['id'=>'form-laboratorium', 'class'=>'tab-wizard wizard-circle']) !!}
                                        @endif
                                            <!-- Step 1 -->
                                            <h6>Bagian 1</h6>
                                            <section>
                                                <div class="form-group row">
                                                    {!! Form::label('input_by', 'User', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('input_by', $var['user'], $var['currentUser'], ['class'=>'form-control select2', 'placeholder'=>'Pilih User', 'style'=>'width: 100%;', 'onchange'=>'subSatuanKerja(); jenisContoh()']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('sub_satuan_kerja_id', 'Nama Laboratorium', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('nama_sub_satuan_kerja', ($var['method']=='edit'||$var['method']=='show'?@$listLaboratorium->inputBy->subSatuanKerja->sub_satuan_kerja:$var['namaLaboratorium']), ['class'=>'form-control', 'id'=>'nama_sub_satuan_kerja', 'placeholder'=>'Inputkan Nama Laboratorium', 'readonly']) !!}
                                                        {!! Form::hidden('sub_satuan_kerja_id', $var['idLaboratorium'], ['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('no_epid', 'Nomor EPID', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-5">
                                                        {!! Form::select('status_epid', ['ES'=>'ES (Pasif)', 'ED'=>'ED (Aktif)'], null, ['class'=>'form-control', 'id'=>'status_epid', 'placeholder'=>'Pilih Status EPID']) !!}
                                                    </div>
                                                    <div class="col-sm-5">
                                                        {!! Form::text('no_epid', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor EPID']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('nama_pengirim_id', 'Nama Pengirim', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('nama_pengirim_id', $var['customer'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Nama Pengirim', 'style'=>'width: 100%;', 'onchange'=>'customer()']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('alamat_pengirim', 'Alamat Pengirim', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('alamat_pengirim', ($var['method']=='edit' || $var['method']=='show'?@$listLaboratorium->customer->alamat:null), ['class'=>'form-control', 'placeholder'=>'Inputkan Alamat Pengirim', 'readonly']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('jenis_hewan_id', 'Jenis Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('jenis_hewan_id', $var['spesies'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Hewan', 'style'=>'width: 100%;']) !!}
                                                    </div>
                                                </div>
                                                <div id="areaJenisContoh">
                                                    <div class="form-group row">
                                                        {!! Form::label('jenis_contoh_id', 'Jenis Contoh', ['class' => 'col-sm-2 col-form-label']) !!}
                                                        <div class="col-sm-10">
                                                            {!! Form::select('jenis_contoh_id', $var['jenisContoh'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Contoh', 'style'=>'width: 100%;', 'onchange'=>'bentukContoh()']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="areaBentukContoh">
                                                    <div class="form-group row">
                                                        {!! Form::label('bentuk_contoh_id', 'Bentuk Contoh', ['class' => 'col-sm-2 col-form-label']) !!}
                                                        <div class="col-sm-10">
                                                            {!! Form::select('bentuk_contoh_id', $var['bentukContoh'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Bentuk Contoh', 'style'=>'width: 100%;']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('jumlah_contoh', 'Jumlah Contoh', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::number('jumlah_contoh', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Jumlah Contoh']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('seksi_laboratorium_id', 'Seksi Laboratorium', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('seksi_laboratorium_id', $var['seksiLaboratorium'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Seksi Laboratorium', 'style'=>'width: 100%;', 'onchange'=>'jenisPengujian()']) !!}
                                                    </div>
                                                </div>
                                                <div id="areaJenisPengujian">
                                                    <div class="form-group row">
                                                        {!! Form::label('permintaan_uji_id', 'Jenis Pengujian', ['class' => 'col-sm-2 col-form-label']) !!}
                                                        <div class="col-sm-10">
                                                            {!! Form::select('permintaan_uji_id', $var['jenisPengujian'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Pengujian', 'style'=>'width: 100%;']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('kriteria_contoh', 'Kriteria Contoh', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('kriteria_contoh', ['MS'=>'Memenuhi Syarat', 'TMS'=>'Tidak Memenuhi Syarat'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Kriteria Contoh']) !!}
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Step 3 -->
                                            <h6>Bagian 2</h6>
                                            <section>
                                                <div class="form-group row">
                                                    {!! Form::label('metode_uji', 'Metode Uji', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('metode_uji', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Metode Uji']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('peralatan', 'Peralatan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('peralatan', ['Mampu'=>'Mampu', 'Tidak Mampu'=>'Tidak Mampu'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Peralatan']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('bahan', 'Bahan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('bahan', ['Mampu'=>'Mampu', 'Tidak Mampu'=>'Tidak Mampu'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Bahan']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('personil', 'Personil', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('personil', ['Mampu'=>'Mampu', 'Tidak Mampu'=>'Tidak Mampu'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Personil']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('catatan', 'Catatan / Saran', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::textarea('catatan', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Catatan / Saran', 'rows'=>4]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('jenis_kegiatan', 'Jenis Kegiatan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('jenis_kegiatan', ['Aktif'=>'Aktif', 'Pasif'=>'Pasif'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Kegiatan']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('pengirim', 'Pengirim', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('pengirim', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Pengirim']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('tanggal_penerimaan', 'Tanggal Penerimaan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('tanggal_penerimaan', null, ['class'=>'form-control datepicker', 'placeholder'=>'Inputkan Tanggal Penerimaan']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('penerima', 'Penerima', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('penerima', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Penerima']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('nomor_asal', 'Nomor Asal', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('nomor_asal', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Asal']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('nomor_baru', 'Nomor Baru', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('nomor_baru', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Baru']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('asal_contoh_id', 'Asal Contoh', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('asal_contoh_id', $var['kotaKabupaten'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Asal Contoh', 'style'=>'width: 100%;']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('manajer_teknis', 'Manajer Teknis / Penyelia', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('manajer_teknis', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Manajer Teknis / Penyelia']) !!}
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Step 4 -->
                                            <h6>Bagian 3</h6>
                                            <section>
                                                <div class="form-group row">
                                                    {!! Form::label('penguji_ditunjuk', 'Penguji yang Ditunjuk', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('penguji_ditunjuk', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Penguji yang Ditunjuk']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('hasil_pengujian', 'Hasil Pengujian Kualitatif', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('hasil_pengujian', ['Positif'=>'Positif', 'Negatif'=>'Negatif'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Hasil Pengujian Kualitatif']) !!}
                                                        <div class="form-control-feedback"><small>PULLORUM, RBT, PCR, Parasit External</small></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('hasil_pengujian2', 'Hasil Pengujian Kualitatif', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('hasil_pengujian2', ['Titer 0'=>'Titer 0', 'Titer Rendah'=>'Titer Rendah', 'Titer Tinggi'=>'Titer Tinggi'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Hasil Pengujian Kualitatif']) !!}
                                                        <div class="form-control-feedback"><small>AI & ND</small></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('pengujian_parasit', 'Hasil Pengujian Kualitatif', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('pengujian_parasit', ['Positif'=>'Positif', 'Negatif'=>'Negatif'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Hasil Pengujian Kualitatif']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('keterangan_hasil', 'Keterangan Hasil Uji', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::textarea('keterangan_hasil', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Keterangan Hasil Uji', 'rows'=>4]) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('upload_file', 'Upload File', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::file('upload_file[]', ['class'=>'form-control', 'placeholder'=>'Upload File', 'multiple'=>'multiple']) !!}
                                                        <br>
                                                        <div id="areaFile"></div>
                                                    </div>
                                                </div>
                                            </section>
                                        {!! Form::close() !!}
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

@endsection

@section('javascript')
    <script>
        function hapusBerkas(id){
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
                    url : '{{ url('/laboratorium/hapus-file') }}',
                    data : 'id='+id,
                }).done(function (data) {
                    $("#areaFile").html(data);
                    swal("Berhasil", "Data berhasil dihapus", "success");
                });
            });
        }

        function subSatuanKerja(userId = '') {
            if(userId == '') userId = $("#input_by").val();
            $.ajax({
                method : 'get',
                url : '{{ url('/laboratorium/nama-laboratorium') }}',
                data : 'userId='+userId,
            }).done(function (data) {
                $("#nama_sub_satuan_kerja").val(data.sub_satuan_kerja);
                $("#sub_satuan_kerja_id").val(data.id);
            });
        }

        function customer(customerId = '') {
            if(customerId == '') customerId = $("#nama_pengirim_id").val();
            $.ajax({
                method : 'get',
                url : '{{ url('/laboratorium/customer') }}',
                data : 'customerId='+customerId,
            }).done(function (data) {
                $("#alamat_pengirim").val(data.alamat);
            });
        }

        function jenisContoh(aksi = '', userId = '', jenisContohId = '') {
            if(userId == '') userId = $("#input_by").val();
            $("#areaJenisContoh").load("{{ url('laboratorium/area-jenis-contoh') }}"+"?userId="+userId+"&jenisContohId="+jenisContohId);
            if(aksi == '') bentukContoh();
        }

        function bentukContoh(aksi = '', jenisContohId = '', bentukContohId = '') {
            if(jenisContohId == '') jenisContohId = $("#jenis_contoh_id").val();
            $("#areaBentukContoh").load("{{ url('laboratorium/area-bentuk-contoh') }}"+"?jenisContohId="+jenisContohId+"&bentukContohId="+bentukContohId);
        }

        function jenisPengujian(aksi = '', seksiLaboratoriumId = '', jenisPengujianId = '') {
            if(seksiLaboratoriumId == '') seksiLaboratoriumId = $("#seksi_laboratorium_id").val();
            $("#areaJenisPengujian").load("{{ url('laboratorium/area-jenis-pengujian') }}"+"?seksiLaboratoriumId="+seksiLaboratoriumId+"&jenisPengujianId="+jenisPengujianId);
        }

        $(document).ready(function() {
            var labelTombol;

            @if($var['method']=='edit' || $var['method']=='show')
                @if($var['method']=='edit')
                    labelTombol = 'Update';
                @endif
                @if($var['method']=='show')
                    labelTombol = 'Kembali';
                @endif
                var pk = "{{ $listLaboratorium->id }}";
                $(document).ready(function(){
                    jenisContoh("$var['method']", "{{ $listLaboratorium->input_by }}", "{{ $listLaboratorium->jenis_contoh_id }}");
                    bentukContoh("$var['method']", "{{ $listLaboratorium->jenis_contoh_id }}", "{{ $listLaboratorium->bentuk_contoh_id }}");
                    jenisPengujian("$var['method']", "{{ $listLaboratorium->seksi_laboratorium_id }}", "{{ $listLaboratorium->permintaan_uji_id }}");
                });

            @else
                var pk = null;
                labelTombol = 'Simpan';
            @endif

            var form = $("#form-laboratorium").show();
            $("#form-laboratorium").steps({
                headerTag: "h6"
                , bodyTag: "section"
                , transitionEffect: "none"
                , titleTemplate: '<span class="step">#index#</span> #title#'
                , labels: {
                    finish: labelTombol
                }
                , onStepChanging: function (event, currentIndex, newIndex) {
                    return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
                }
                , onFinishing: function (event, currentIndex) {
                    return form.validate().settings.ignore = ":disabled", form.valid()
                }
                , onFinished: function (event, currentIndex) {
                    @if($var['method']=='show')
                        top.location = "{{ url()->previous() }}"
                    @else
                        $("#form-laboratorium").submit();
                    @endif
                }
            }).validate({
                rules: {
                    status_epid: "required",
                    no_epid: {
                        required: true,
                        remote: {
                            url: "{{ url('laboratorium/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "no_epid",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                },
                messages: {
                    status_epid: "Kolom status epid harus diisi",
                    no_epid: {
                        required: "Kolom nomor epid harus diisi",
                        remote: "Nomor epid sudah digunakan"
                    },
                }
            });

            $("#status_epid").change(function(){
                var status = ($(this).val()!=""?$(this).val()+'.':null);
                $("#no_epid").val(status);
            });

            $('#tanggal_penerimaan').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });

            @if($var['method']=='edit' || $var['method']=='show')
                $("#areaFile").load('{!! url('/laboratorium/area-file') !!}?method={{ $var['method'] }}&id={{ $listLaboratorium->id }}');
            @endif
        });
    </script>
@endsection
