@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            PLLT
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item active">PLLT</li>
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
                            <li class="nav-item"><a href="{{ url('pllt') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('pllt/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    <div class="box-body wizard-content">
                                        @if($var['method']=='edit')
                                            {!! Form::model($listPllt, ['method'=>'PATCH', 'url'=> '/pllt/'.$listPllt->id.$var['url']['all'], 'id'=>'form-pllt', 'class'=>'tab-wizard wizard-circle', 'files'=>true]) !!}
                                        @elseif($var['method']=='create')
                                            {!! Form::open(['id'=>'form-pllt', 'method'=>'POST', 'url'=>'/pllt', 'class'=>'validation-wizard wizard-circle', 'files'=>true]) !!}
                                        @else
                                            {!! Form::model($listPllt, ['id'=>'form-pllt', 'class'=>'tab-wizard wizard-circle']) !!}
                                        @endif
                                            <!-- Step 1 -->
                                            <h6>Bagian 1</h6>
                                            <section>
                                                <div class="form-group row">
                                                    {!! Form::label('input_by', 'User', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('input_by', $var['user'], $var['currentUser'], ['class'=>'form-control select2', 'placeholder'=>'Pilih User', 'style'=>'width: 100%;', 'onchange'=>'subSatuanKerja(); pemeriksa()']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('sub_satuan_kerja_id', 'Nama Laboratorium', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('nama_sub_satuan_kerja', ($var['method']=='edit'||$var['method']=='show'?@$listPllt->inputBy->subSatuanKerja->sub_satuan_kerja:$var['namaPllt']), ['class'=>'form-control', 'id'=>'nama_sub_satuan_kerja', 'placeholder'=>'Inputkan Nama PLLT', 'readonly']) !!}
                                                        {!! Form::hidden('sub_satuan_kerja_id', $var['idPllt'], ['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('jenis_form', 'Jenis Form', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-4">
                                                        {!! Form::select('jenis_form', ['Ternak Masuk'=>'Ternak Masuk', 'Ternak Keluar'=>'Ternak Keluar', 'Ternak Lewat'=>'Ternak Lewat'], null,
                                                            ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Form']) !!}
                                                    </div>
                                                    {!! Form::label('jam_masuk', 'Jam Masuk', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-4">
                                                        <div class="bootstrap-timepicker">
                                                            {!! Form::text('jam_masuk', null, ['class'=>'form-control timepicker', 'placeholder'=>'Inputkan Jam Masuk']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <legend>Data Hewan</legend>
                                                <div class="form-group row">
                                                    {!! Form::label('jenis_spesies_id', 'Jenis Spesies / Hewan / Komoditas', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('jenis_spesies_id', $var['spesies'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Spesies / Hewan / Komoditas', 'style'=>'width: 100%;', 'onchange'=>'jenisHewan()']) !!}
                                                    </div>
                                                </div>
                                                <div id="areaJenisHewan">
                                                    <div class="form-group row">
                                                        {!! Form::label('jenis_hewan_id', 'Ras', ['class' => 'col-sm-2 col-form-label']) !!}
                                                        <div class="col-sm-10">
                                                            {!! Form::select('jenis_hewan_id', $var['ras'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Ras', 'style'=>'width: 100%;']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('jumlah', 'Jumlah', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-4">
                                                        {!! Form::number('jumlah', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Jumlah']) !!}
                                                    </div>
                                                    {!! Form::label('satuan', 'Satuan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-4">
                                                        {!! Form::select('satuan', ['Kilogram'=>'Kilogram','Ekor'=>'Ekor'], null, ['class'=>'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('jumlah_jantan', 'Jumlah Jantan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-4">
                                                        {!! Form::number('jumlah_jantan', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Jumlah Jantan']) !!}
                                                    </div>
                                                    {!! Form::label('jumlah_betina', 'Jumlah Betina', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-4">
                                                        {!! Form::number('jumlah_betina', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Jumlah Betina']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4 ml-auto">
                                                        {!! Form::submit('Tambah', ['class'=>'btn btn-primary', 'id'=>'buttonTambahDataHewan']) !!}
                                                        {!! Form::reset('Reset', ['class'=>'btn btn-danger', 'id'=>'buttonResetDataHewan']) !!}
                                                    </div>
                                                </div>
                                                <div id="areaDataHewan"></div>

                                                <div class="form-group row">
                                                    {!! Form::label('nopol_kendaraaan', 'NOPOL Kendaraan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('nopol_kendaraaan', null, ['class'=>'form-control', 'placeholder'=>'Inputkan NOPOL Kendaraan']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('peruntukan', 'Peruntukan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('peruntukan', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Peruntukan']) !!}
                                                    </div>
                                                </div>

                                                <legend><b>Daerah Asal</b></legend>
                                                <div class="form-group row">
                                                    {!! Form::label('provinsi_asal_id', 'Provinsi', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('provinsi_asal_id', $var['provinsiAsal'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Provinsi', 'style'=>'width: 100%;', 'onchange'=>'dataKotaAsal()']) !!}
                                                    </div>
                                                </div>
                                                <div id="areaFormKotaKabupatenAsal">
                                                    <div class="form-group row">
                                                        {!! Form::label('kabupaten_asal_id', 'Kota / Kabupaten', ['class' => 'col-sm-2 col-form-label']) !!}
                                                        <div class="col-sm-10">
                                                            {!! Form::select('kabupaten_asal_id', $var['kotaKabupatenAsal'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kota / Kabupaten', 'style'=>'width: 100%;', 'onchange'=>'dataKecamatanAsal()']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="areaFormKecamatanAsal">
                                                    <div class="form-group row">
                                                        {!! Form::label('kecamatan_asal_id', 'Kecamatan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                        <div class="col-sm-10">
                                                            {!! Form::select('kecamatan_asal_id', $var['kecamatanAsal'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kecamatan', 'style'=>'width: 100%;']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <legend><b>Daerah Tujuan</b></legend>
                                                <div class="form-group row">
                                                    {!! Form::label('provinsi_tujuan_id', 'Provinsi', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::select('provinsi_tujuan_id', $var['provinsiTujuan'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Provinsi', 'style'=>'width: 100%;', 'onchange'=>'dataKotaTujuan()']) !!}
                                                    </div>
                                                </div>
                                                <div id="areaFormKotaKabupatenTujuan">
                                                    <div class="form-group row">
                                                        {!! Form::label('kabupaten_tujuan_id', 'Kota / Kabupaten', ['class' => 'col-sm-2 col-form-label']) !!}
                                                        <div class="col-sm-10">
                                                            {!! Form::select('kabupaten_tujuan_id', $var['kotaKabupatenTujuan'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kota / Kabupaten', 'style'=>'width: 100%;', 'onchange'=>'dataKecamatanTujuan()']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="areaFormKecamatanTujuan">
                                                    <div class="form-group row">
                                                        {!! Form::label('kecamatan_tujuan_id', 'Kecamatan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                        <div class="col-sm-10">
                                                            {!! Form::select('kecamatan_tujuan_id', $var['kecamatanTujuan'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Kecamatan', 'style'=>'width: 100%;']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Step 4 -->
                                            <h6>Bagian 2</h6>
                                            <section>
                                                <div class="form-group row">
                                                    {!! Form::label('jenis_dokumen', 'Jenis Dokumen', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                       {!! Form::select('jenis_dokumen', ['SPT'=>'SPT', 'SKKH'=>'SKKH', 'SKSR'=>'SKSR', 'SKB'=>'SKB', 'Tanpa Surat'=>'Tanpa Surat', 'Lainnya'=>'Lainnya'],
                                                            null, ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Dokumen']) !!}
														
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('nomor_dokumen', 'Nomor Dokumen', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('nomor_dokumen', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Dokumen']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('tanggal_dokumen', 'Tanggal Input', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('tanggal_dokumen', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Tanggal Input']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('pengirim', 'Pemilik / Pengirim', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('pengirim', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Pemilik / Pengirim']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('penerima', 'Penerima', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::text('penerima', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Penerima']) !!}
                                                    </div>
                                                </div>
                                                <div id="areaPemeriksa">
                                                    <div class="form-group row">
                                                        {!! Form::label('pemeriksa_id', 'Dokter / Petugas Pemeriksa', ['class' => 'col-sm-2 col-form-label']) !!}
                                                        <div class="col-sm-10">
                                                            {!! Form::select('pemeriksa_id', $var['pemeriksa'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Dokter / Petugas Pemeriksa', 'style'=>'width: 100%;']) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-2 col-form-label']) !!}
                                                    <div class="col-sm-10">
                                                        {!! Form::textarea('keterangan', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Keterangan', 'rows'=>4]) !!}
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
                    url : '{{ url('/pllt/hapus-file') }}',
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
                url : '{{ url('/pllt/nama-pllt') }}',
                data : 'userId='+userId,
            }).done(function (data) {
                $("#nama_sub_satuan_kerja").val(data.sub_satuan_kerja);
                $("#sub_satuan_kerja_id").val(data.id);
            });
        }

        function pemeriksa(aksi = '', userId = '', pemeriksaId = '') {
            if(userId == '') userId = $("#input_by").val();
            $("#areaPemeriksa").load("{{ url('pllt/area-pemeriksa') }}"+"?userId="+userId+"&pemeriksaId="+pemeriksaId);
        }

        function jenisHewan(aksi = '', spesiesId = '', jenisHewanId = '') {
            if(spesiesId == '') spesiesId = $("#jenis_spesies_id").val();
            $("#areaJenisHewan").load("{{ url('pllt/area-jenis-hewan') }}"+"?spesiesId="+spesiesId+"&jenisHewanId="+jenisHewanId);
        }

        function dataKotaAsal(aksi = '', provinsiId = '', kotaId = '') {
            if(provinsiId == '') provinsiId = $("#provinsi_asal_id").val();
            $("#areaFormKotaKabupatenAsal").load("{{ url('pllt/area-kota-asal') }}"+"?provinsiId="+provinsiId+"&kotaId="+kotaId);
            if(aksi == '') dataKecamatanAsal();
        }

        function dataKecamatanAsal(aksi = '', kotaId = '', kecamatanId = '') {
            if(kotaId == '') kotaId = $("#kabupaten_asal_id").val();
            $("#areaFormKecamatanAsal").load("{{ url('pllt/area-kecamatan-asal') }}"+"?kotaId="+kotaId+"&kecamatanId="+kecamatanId);
        }

        function dataKotaTujuan(aksi = '', provinsiId = '', kotaId = '') {
            if(provinsiId == '') provinsiId = $("#provinsi_tujuan_id").val();
            $("#areaFormKotaKabupatenTujuan").load("{{ url('pllt/area-kota-tujuan') }}"+"?provinsiId="+provinsiId+"&kotaId="+kotaId);
            if(aksi == '') dataKecamatanTujuan();
        }

        function dataKecamatanTujuan(aksi = '', kotaId = '', kecamatanId = '') {
            if(kotaId == '') kotaId = $("#kabupaten_tujuan_id").val();
            $("#areaFormKecamatanTujuan").load("{{ url('pllt/area-kecamatan-tujuan') }}"+"?kotaId="+kotaId+"&kecamatanId="+kecamatanId);
        }

        //------------------------------------------------------------
        function tampilDataHewan(method='create', id=''){
            $("#areaDataHewan").load('{!! url('/pllt/area-data-hewans') !!}?method='+method+'&id='+id);
        }

        function resetFormDataHewan(){
            $("#jenis_spesies_id").val("").trigger("change");
            $("#jenis_hewan_id").val("").trigger("change");
            $("#jumlah").val("");
            $("#satuan").val("Kilogram");
            $("#jumlah_jantan").val("");
            $("#jumlah_betina").val("");
        }

        function hapusDataHewan(id){
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
                    url : '{{ url('/pllt/hapus-data-hewans') }}',
                    data : 'id='+id,
                }).done(function (data) {
                    $("#areaDataHewan").html(data);
                    swal("Berhasil", "Data berhasil dihapus", "success");
                });
            });
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
                var pk = "{{ $listPllt->id }}";
                $(document).ready(function(){
                    jenisHewan("$var['method']", "{{ $listPllt->jenis_spesies_id }}", "{{ $listPllt->jenis_hewan_id }}");
                    dataKotaAsal("$var['method']", "{{ $listPllt->provinsi_asal_id }}", "{{ $listPllt->kabupaten_asal_id }}");
                    dataKecamatanAsal("$var['method']", "{{ $listPllt->kabupaten_asal_id }}", "{{ $listPllt->kecamatan_asal_id }}");
                    dataKotaTujuan("$var['method']", "{{ $listPllt->provinsi_tujuan_id }}", "{{ $listPllt->kabupaten_tujuan_id }}");
                    dataKecamatanTujuan("$var['method']", "{{ $listPllt->kabupaten_tujuan_id }}", "{{ $listPllt->kecamatan_tujuan_id }}");
                    pemeriksa("$var['method']", "{{ $listPllt->input_by }}", "{{ $listPllt->pemeriksa_id }}");
                });
            @else
                var pk = null;
                labelTombol = 'Simpan';
            @endif

            var form = $("#form-pllt").show();
            $("#form-pllt").steps({
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
                        $("#form-pllt").submit();
                    @endif
                }
            }).validate({
                rules: {
                    jenis_form: "required",
                    // kabupaten_tujuan_id: "required",
                },
                messages: {
                    jenis_form: "Kolom jenis form harus diisi",
                    // kabupaten_tujuan_id: "Kolom kota/kabupaten tujuan harus diisi",
                }
            });

            $('#tanggal_dokumen').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });

            $('#jam_masuk').timepicker({
                showInputs: false,
                showMeridian: false
            });

            $('#buttonTambahDataHewan').click(function(e){
                e.preventDefault();
                var data = {
                    jenisSpesies: ($("#jenis_spesies_id").val()!=""?$("#jenis_spesies_id").val():""),
                    jenisHewan: ($("#jenis_hewan_id").val()!=""?$("#jenis_hewan_id").val():""),
                    jumlah: ($("#jumlah").val()!=""?$("#jumlah").val():""),
                    satuan: ($("#satuan").val()!=""?$("#satuan").val():""),
                    jumlahJantan: ($("#jumlah_jantan").val()!=""?$("#jumlah_jantan").val():""),
                    jumlahBetina: ($("#jumlah_betina").val()!=""?$("#jumlah_betina").val():"")
                };

                $.ajax({
                    method : 'post',
                    url : '{{ url('/pllt/tambah-data-hewan') }}',
                    data : data,
                }).done(function (data) {
                    tampilDataHewan();
                    resetFormDataHewan();
                });
            });

            $('#buttonResetDataHewan').click(function(e){
                e.preventDefault();
                resetFormDataHewan();
            });

            @if($var['method']=='edit' || $var['method']=='show')
                tampilDataHewan('{!! $var['method'] !!}', '{!! $listPllt->id !!}');
                $("#areaFile").load('{!! url('/pllt/area-file') !!}?method={{ $var['method'] }}&id={{ $listPllt->id }}');
            @endif
        });
    </script>
@endsection
