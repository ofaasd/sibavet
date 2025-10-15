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
                            <li class="nav-item"><a href="{{ url('klinik') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('klinik/create') }}" class="nav-link"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('klinik/add') }}" class="nav-link active"><span class="hidden-sm-up"><b>Update Data</b></span> <span class="hidden-xs-down"><b>Update Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                    <form method="POST" action="{{ url('/klinik/'.$listKlinik->id.$var['url']['all']) }}" id="form-klinik">
                                        @method('PATCH')
                                    @elseif($var['method']=='create')
                                    <form method="POST" action="{{ url('/klinik/tambahTerapi') }}" id="form-klinik">
                                    @else
                                    <form class="form-klinik">
                                    @endif
                                        @csrf
                                        <div class="form-group row">
                                            <label for="input_by" class="col-sm-2 col-form-label">User</label>
                                            <div class="col-sm-10">
                                                <select name="input_by" id="input_by" class="form-control select2" placeholder="Pilih User" style="width: 100%;" onchange="subSatuanKerja()">
                                                    @foreach($var['user'] as $id => $name)
                                                        <option value="{{ $id }}" {{ ($var['currentUser'] == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Klinik</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nama_sub_satuan_kerja" id="nama_sub_satuan_kerja" class="form-control" placeholder="Inputkan Nama Klinik" readonly value="{{ ($var['method']=='edit'||$var['method']=='show') ? (@$listKlinik->inputBy->subSatuanKerja->sub_satuan_kerja) : $var['namaKlinik'] }}">
                                                <input type="hidden" name="sub_satuan_kerja_id" value="{{ $var['idKlinik'] }}" class="form-control">
                                            </div>
                                        </div>                                        
                                        <div class="form-group row">
                                            <label for="pemilik_id" class="col-sm-2 col-form-label">Pemilik</label>
                                            <div class="col-sm-10">
                                                <select name="pemilik_id" id="pemilik_id" class="form-control select2" placeholder="Pilih Pemilik" style="width: 100%;" onchange="pemilik()">
                                                    @foreach($var['pemilik'] as $id => $name)
                                                        <option value="{{ $id }}" {{ (isset($listKlinik) && $listKlinik->pemilik_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                            
                                        <div class="form-group row">
                                            <label for="hewan" class="col-sm-2 col-form-label">Nama Hewan</label>
                                            <div class="col-sm-10">
                                                <select name="hewan" id="hewan" class="form-control select2" placeholder="Pilih Nama Hewan" style="width: 100%;" onchange="dataHewan()">
                                                    @foreach($var['hewan'] as $id => $name)
                                                        <option value="{{ $id }}" {{ (isset($listKlinik) && $listKlinik->hewan == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jenis_hewan" class="col-sm-2 col-form-label">Jenis Hewan</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="jenis_hewan" id="jenis_hewan" class="form-control" placeholder="Jenis Hewan" readonly value="{{ old('jenis_hewan', $listKlinik->jenis_hewan ?? '') }}">
                                            </div>
                                        </div>
                                        <input type="hidden" name="ras_id" id="ras_id" class="form-control" placeholder="Pilih Ras" style="width: 100%;" value="{{ old('ras_id', $listKlinik->ras_id ?? '') }}">
                                        <div class="form-group row">
                                            <label for="alamat_pemilik" class="col-sm-2 col-form-label">Alamat Pemilik</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="alamat_pemilik" id="alamat_pemilik" class="form-control" placeholder="Inputkan Alamat Pemilik" readonly value="{{ ($var['method']=='edit'||$var['method']=='show') ? (@$listKlinik->pemilik->alamat) : '' }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="telepon_pemilik" class="col-sm-2 col-form-label">Telepon Pemilik</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="telepon_pemilik" id="telepon_pemilik" class="form-control" placeholder="Inputkan Telepon Pemilik" readonly value="{{ ($var['method']=='edit'||$var['method']=='show') ? (@$listKlinik->pemilik->telepon) : '' }}">
                                            </div>
                                        </div>                                       
                                        <div class="form-group row">
                                            <label for="no_periksa" class="col-sm-2 col-form-label">Nomor Periksa</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="no_periksa" id="no_periksa" class="form-control" placeholder="Inputkan Nomor Periksa" value="{{ ($var['method']=='create'?$var['noPeriksa']:'') }}">
                                            </div>
                                            <label for="tanggal_periksa" class="col-sm-2 col-form-label">Tanggal Periksa</label>
                                            <div class="col-sm-4">
                                                <input type="text" name="tanggal_periksa" id="tanggal_periksa" class="form-control" placeholder="Inputkan Tanggal Periksa" autocomplete="off" value="{{ old('tanggal_periksa', $listKlinik->tanggal_periksa ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="signalement" class="col-sm-2 col-form-label">Signalement</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="signalement" id="signalement" class="form-control" placeholder="Inputkan Signalement" value="{{ old('signalement', $listKlinik->signalement ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="anamnesia" class="col-sm-2 col-form-label">Anamnesa</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="anamnesia" id="anamnesia" class="form-control" placeholder="Inputkan Anamnesa" value="{{ old('anamnesia', $listKlinik->anamnesia ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="diagnosa" class="col-sm-2 col-form-label">Diagnosa</label>
                                            <div class="col-sm-10">
                                                <select name="diagnosa" id="diagnosa" class="form-control select2" placeholder="Pilih Penyakit" style="width: 100%;">
                                                    @foreach($var['penyakit'] as $id => $name)
                                                        <option value="{{ $id }}" {{ (isset($listKlinik) && $listKlinik->diagnosa == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="pemeriksa" class="col-sm-2 col-form-label">Pemeriksa</label>
                                            <div class="col-sm-10">
                                                <select name="pemeriksa" id="pemeriksa" class="form-control select2" placeholder="Pilih Pemeriksa" style="width: 100%;">
                                                    @foreach($var['pemeriksa'] as $id => $name)
                                                        <option value="{{ $id }}" {{ (isset($listKlinik) && $listKlinik->pemeriksa == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="paramedis" class="col-sm-2 col-form-label">Paramedis</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="paramedis" id="paramedis" class="form-control" placeholder="Inputkan Nama Paramedis" value="{{ old('paramedis', $listKlinik->paramedis ?? '') }}">
                                            </div>
                                        </div>
                                        <legend>Terapi & Dosis</legend>                                        
                                        <div class="form-group row">
                                            <label for="tindakan" class="col-sm-2 col-form-label">Jenis Penanganan</label>
                                            <div class="col-sm-10">
                                                <select name="tindakan" id="tindakan" class="form-control select2" placeholder="Pilih Jenis Penanganan" style="width: 100%;" onchange="penangananAksi()">
                                                    @foreach($var['penanganan'] as $key => $value)
                                                        <option value="{{ $key }}" {{ (isset($listKlinik) && $listKlinik->tindakan == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    <div id="areaTindakan">    
                                        <div class="form-group row">
                                            <label for="terapi_id" class="col-sm-2 col-form-label">Terapi / Tindakan</label>
                                            <div class="col-sm-10">
                                                <select name="terapi_id" id="terapi_id" class="form-control select2" placeholder="Pilih Terapi / Tindakan" style="width: 100%;">
                                                    @foreach($var['obat'] as $key => $value)
                                                        <option value="{{ $key }}" {{ (isset($listKlinik) && $listKlinik->terapi_id == $key) ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>    
                                        <div class="form-group row">
                                            <label for="dosis" class="col-sm-2 col-form-label">Dosis / Ket Penaganan</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="dosis" id="dosis" class="form-control" placeholder="Inputkan Dosis atau Keterangan Penanganan" value="{{ old('dosis', $listKlinik->dosis ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                <button type="button" class="btn btn-primary" id="buttonTambahTerapiDosis">Tambah</button>
                                                <button type="reset" class="btn btn-danger" id="buttonResetTerapiDosis">Reset</button>
                                            </div>
                                        </div>
                                        <div id="areaDataTerapiDosis"></div>
                                        <div class="form-group row">
                                            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                            <div class="col-sm-10">
                                                <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Inputkan Keterangan" rows="4" required="required">{{ old('keterangan', $listKlinik->keterangan ?? '-') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                @if($var['method']=='edit')
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="reset" class="btn btn-danger">Reset</button>
                                                @elseif($var['method']=='create')
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                    <button type="reset" class="btn btn-danger">Reset</button>
                                                @else
                                                    <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
                                                @endif
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

    </section>
    <!-- /.content -->

@endsection

@section('javascript')
    <script>
        function subSatuanKerja(userId = '') {
            if(userId == '') userId = $("#input_by").val();
            $.ajax({
                method : 'get',
                url : '{{ url('/klinik/nama-klinik') }}',
                data : 'userId='+userId,
            }).done(function (data) {
                $("#nama_sub_satuan_kerja").val(data.sub_satuan_kerja);
                $("#sub_satuan_kerja_id").val(data.id);
            });
        }

        function pemilik(pemilikId = '') {
            if(pemilikId == '') pemilikId = $("#pemilik_id").val();
            $.ajax({
                method : 'get',
                url : '{{ url('/klinik/pemilik') }}',
                data : 'pemilikId='+pemilikId,
            }).done(function (data) {
                $("#alamat_pemilik").val(data[1].alamat);
                $("#telepon_pemilik").val(data[1].telepon);
                console.log(data);
            });
            
            ambilDataHewan(pemilikId);
        }

        function dataHewan(klinikId = '') {
            if(klinikId == '') klinikId = $("#hewan").val();
            $.ajax({
                method : 'get',
                url : '{{ url('/klinik/detailHewan') }}',
                data : 'klinikId='+klinikId,
            }).done(function (data) {
                $("#jenis_hewan").val(data[1]);
                $("#ras").val(data[0]);
            });

            ambilJmlPeriksa(klinikId);
        }

        function ambilJmlPeriksa(klinikId){
            $.ajax({
                method : 'get',
                url : '{{ url('/klinik/getJmlPeriksa') }}',
                data : 'klinikId='+klinikId,
            }).done(function (data) {
                $("#no_periksa").val(data);
            });
        }

        function penangananAksi(penanganan = ''){
            if(penanganan == '') penanganan = $("#tindakan").val();

            if(penanganan == 0 || penanganan == 1 || penanganan == 2){
                $("#areaTindakan").load("{{ url('klinik/area-obat') }}");
            }else if(penanganan == 4){
                $("#areaTindakan").load("{{ url('klinik/area-operasi') }}");
            }else{

            }
        }    

        function ambilDataHewan(pemilikId){
            if(pemilikId == '') pemilikId = $("#pemilik_id").val();
            $("#hewan").load("{{ url('klinik/hewan') }}"+"?pemilikId="+pemilikId);
        }

        function ras(aksi = '', spesiesId = '', rasId = '') {
            if(spesiesId == '') spesiesId = $("#spesies_id").val();
            $("#areaRas").load("{{ url('klinik/area-ras') }}"+"?spesiesId="+spesiesId+"&rasId="+rasId);
        }

        //------------------------------------------------------------
        function tampilDataTerapiDosis(method='create', id=''){
            $("#areaDataTerapiDosis").load('{!! url('/klinik/area-data-terapi') !!}?method='+method+'&id='+id);
        }

        function resetFormDataTerapiDosis(){
            $("#terapi_id").val("").trigger("change");
            $("#dosis").val("");
        }

        function hapusDataTerapiDosis(id){
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
                    url : '{{ url('/klinik/hapus-data-terapi') }}',
                    data : 'id='+id,
                }).done(function (data) {
                    $("#areaDataTerapiDosis").html(data);
                    swal("Berhasil", "Data berhasil dihapus", "success");
                });
            });
        }

        $(document).ready(function() {

            @if($var['method']=='edit' || $var['method']=='show')
                var pk = "{{ $listKlinik->id }}";
                tampilDataTerapiDosis('{!! $var['method'] !!}', '{!! $listKlinik->id !!}');
                $(document).ready(function(){
                    ras("$var['method']", "{{ $listKlinik->spesies_id }}", "{{ $listKlinik->ras_id }}");
                });
            @else
                var pk = null;
            @endif

            $("#form-klinik").validate({
                rules: {
                    no_pasien: {
                        required: true,
                        remote: {
                            url: "{{ url('klinik/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "no_pasien",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    tanggal_periksa:{
                        requred: true,
                    }
                },
                messages: {
                    no_pasien: {
                        required: "Kolom nomor pasien harus diisi",
                        remote: "Nomor Pasien sudah digunakan"
                    },
                    tanggal_periksa:{
                        required: "Tanggal periksa harus diisi"
                    }
                }
            });

            $('#buttonTambahTerapiDosis').click(function(e){
                e.preventDefault();
                var data = {
                   terapi: ($("#terapi_id").val()!=""?$("#terapi_id").val():""),
                    dosis: ($("#dosis").val()!=""?$("#dosis").val():""),
                    tindakan: ($("#tindakan").val()!=""?$("#tindakan").val():"")
                };

                $.ajax({
                    method : 'post',
                    url : '{{ url('/klinik/tambah-data-terapi') }}',
                    data : data,
                }).done(function (data) {
                    tampilDataTerapiDosis();
                    resetFormDataTerapiDosis();
                });
            });

            $('#buttonResetTerapiDosis').click(function(e){
                e.preventDefault();
                resetFormDataTerapiDosis();
            });

            $('#tanggal_periksa').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });
        });        

    </script>
@endsection
