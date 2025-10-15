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
                                            <form method="POST" action="/pllt/{{ $listPllt->id }}{{ $var['url']['all'] }}" id="form-pllt" class="tab-wizard wizard-circle" enctype="multipart/form-data">
                                                @csrf
                                                @method('PATCH')
                                        @elseif($var['method']=='create')
                                            <form method="POST" action="/pllt" id="form-pllt" class="validation-wizard wizard-circle" enctype="multipart/form-data">
                                                @csrf
                                        @else
                                            <form id="form-pllt" class="tab-wizard wizard-circle">
                                        @endif
                                            <!-- Step 1 -->
                                            <h6>Bagian 1</h6>
                                            <section>
                                                <div class="form-group row">
                                                    <label for="input_by" class="col-sm-2 col-form-label">User</label>
                                                    <div class="col-sm-10">
                                                        <select name="input_by" id="input_by" class="form-control select2" style="width: 100%;" onchange="subSatuanKerja(); pemeriksa()">
                                                            <option value="">Pilih User</option>
                                                            @foreach($var['user'] as $key => $value)
                                                                <option value="{{ $key }}" {{ $var['currentUser'] == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama_sub_satuan_kerja" class="col-sm-2 col-form-label">Nama Laboratorium</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nama_sub_satuan_kerja" id="nama_sub_satuan_kerja" class="form-control" placeholder="Inputkan Nama PLLT" readonly 
                                                            value="{{ ($var['method']=='edit'||$var['method']=='show') ? @$listPllt->inputBy->subSatuanKerja->sub_satuan_kerja : $var['namaPllt'] }}">
                                                        <input type="hidden" name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control" value="{{ $var['idPllt'] }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jenis_form" class="col-sm-2 col-form-label">Jenis Form</label>
                                                    <div class="col-sm-4">
                                                        <select name="jenis_form" id="jenis_form" class="form-control">
                                                            <option value="">Pilih Jenis Form</option>
                                                            <option value="Ternak Masuk" {{ old('jenis_form', isset($listPllt) ? $listPllt->jenis_form : '') == 'Ternak Masuk' ? 'selected' : '' }}>Ternak Masuk</option>
                                                            <option value="Ternak Keluar" {{ old('jenis_form', isset($listPllt) ? $listPllt->jenis_form : '') == 'Ternak Keluar' ? 'selected' : '' }}>Ternak Keluar</option>
                                                            <option value="Ternak Lewat" {{ old('jenis_form', isset($listPllt) ? $listPllt->jenis_form : '') == 'Ternak Lewat' ? 'selected' : '' }}>Ternak Lewat</option>
                                                        </select>
                                                    </div>
                                                    <label for="jam_masuk" class="col-sm-2 col-form-label">Jam Masuk</label>
                                                    <div class="col-sm-4">
                                                        <div class="bootstrap-timepicker">
                                                            <input type="text" name="jam_masuk" id="jam_masuk" class="form-control timepicker" 
                                                                value="{{ old('jam_masuk', isset($listPllt) ? $listPllt->jam_masuk : '') }}" placeholder="Inputkan Jam Masuk">
                                                        </div>
                                                    </div>
                                                </div>
                                                <legend>Data Hewan</legend>
                                                <div class="form-group row">
                                                    <label for="jenis_spesies_id" class="col-sm-2 col-form-label">Jenis Spesies / Hewan / Komoditas</label>
                                                    <div class="col-sm-10">
                                                        <select name="jenis_spesies_id" id="jenis_spesies_id" class="form-control select2" style="width: 100%;" onchange="jenisHewan()">
                                                            <option value="">Pilih Jenis Spesies / Hewan / Komoditas</option>
                                                            @foreach($var['spesies'] as $key => $value)
                                                                <option value="{{ $key }}" {{ old('jenis_spesies_id', isset($listPllt) ? $listPllt->jenis_spesies_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="areaJenisHewan">
                                                    <div class="form-group row">
                                                        <label for="jenis_hewan_id" class="col-sm-2 col-form-label">Ras</label>
                                                        <div class="col-sm-10">
                                                            <select name="jenis_hewan_id" id="jenis_hewan_id" class="form-control select2" style="width: 100%;">
                                                                <option value="">Pilih Ras</option>
                                                                @foreach($var['ras'] as $key => $value)
                                                                    <option value="{{ $key }}" {{ old('jenis_hewan_id', isset($listPllt) ? $listPllt->jenis_hewan_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jumlah" class="col-sm-2 col-form-label">Jumlah</label>
                                                    <div class="col-sm-4">
                                                        <input type="number" name="jumlah" id="jumlah" class="form-control" placeholder="Inputkan Jumlah" 
                                                            value="{{ old('jumlah', isset($listPllt) ? $listPllt->jumlah : '') }}">
                                                    </div>
                                                    <label for="satuan" class="col-sm-2 col-form-label">Satuan</label>
                                                    <div class="col-sm-4">
                                                        <select name="satuan" id="satuan" class="form-control">
                                                            <option value="Kilogram" {{ old('satuan', isset($listPllt) ? $listPllt->satuan : '') == 'Kilogram' ? 'selected' : '' }}>Kilogram</option>
                                                            <option value="Ekor" {{ old('satuan', isset($listPllt) ? $listPllt->satuan : '') == 'Ekor' ? 'selected' : '' }}>Ekor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jumlah_jantan" class="col-sm-2 col-form-label">Jumlah Jantan</label>
                                                    <div class="col-sm-4">
                                                        <input type="number" name="jumlah_jantan" id="jumlah_jantan" class="form-control" placeholder="Inputkan Jumlah Jantan" 
                                                            value="{{ old('jumlah_jantan', isset($listPllt) ? $listPllt->jumlah_jantan : '') }}">
                                                    </div>
                                                    <label for="jumlah_betina" class="col-sm-2 col-form-label">Jumlah Betina</label>
                                                    <div class="col-sm-4">
                                                        <input type="number" name="jumlah_betina" id="jumlah_betina" class="form-control" placeholder="Inputkan Jumlah Betina" 
                                                            value="{{ old('jumlah_betina', isset($listPllt) ? $listPllt->jumlah_betina : '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4 ml-auto">
                                                        <button type="button" class="btn btn-primary" id="buttonTambahDataHewan">Tambah</button>
                                                        <button type="reset" class="btn btn-danger" id="buttonResetDataHewan">Reset</button>
                                                    </div>
                                                </div>
                                                <div id="areaDataHewan"></div>

                                                <div class="form-group row">
                                                    <label for="nopol_kendaraaan" class="col-sm-2 col-form-label">NOPOL Kendaraan</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nopol_kendaraaan" id="nopol_kendaraaan" class="form-control" placeholder="Inputkan NOPOL Kendaraan" 
                                                            value="{{ old('nopol_kendaraaan', isset($listPllt) ? $listPllt->nopol_kendaraaan : '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="peruntukan" class="col-sm-2 col-form-label">Peruntukan</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="peruntukan" id="peruntukan" class="form-control" placeholder="Inputkan Peruntukan" 
                                                            value="{{ old('peruntukan', isset($listPllt) ? $listPllt->peruntukan : '') }}">
                                                    </div>
                                                </div>

                                                <legend><b>Daerah Asal</b></legend>
                                                <div class="form-group row">
                                                    <label for="provinsi_asal_id" class="col-sm-2 col-form-label">Provinsi</label>
                                                    <div class="col-sm-10">
                                                        <select name="provinsi_asal_id" id="provinsi_asal_id" class="form-control select2" style="width: 100%;" onchange="dataKotaAsal()">
                                                            <option value="">Pilih Provinsi</option>
                                                            @foreach($var['provinsiAsal'] as $key => $value)
                                                                <option value="{{ $key }}" {{ old('provinsi_asal_id', isset($listPllt) ? $listPllt->provinsi_asal_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="areaFormKotaKabupatenAsal">
                                                    <div class="form-group row">
                                                        <label for="kabupaten_asal_id" class="col-sm-2 col-form-label">Kota / Kabupaten</label>
                                                        <div class="col-sm-10">
                                                            <select name="kabupaten_asal_id" id="kabupaten_asal_id" class="form-control select2" style="width: 100%;" onchange="dataKecamatanAsal()">
                                                                <option value="">Pilih Kota / Kabupaten</option>
                                                                @foreach($var['kotaKabupatenAsal'] as $key => $value)
                                                                    <option value="{{ $key }}" {{ old('kabupaten_asal_id', isset($listPllt) ? $listPllt->kabupaten_asal_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="areaFormKecamatanAsal">
                                                    <div class="form-group row">
                                                        <label for="kecamatan_asal_id" class="col-sm-2 col-form-label">Kecamatan</label>
                                                        <div class="col-sm-10">
                                                            <select name="kecamatan_asal_id" id="kecamatan_asal_id" class="form-control select2" style="width: 100%;">
                                                                <option value="">Pilih Kecamatan</option>
                                                                @foreach($var['kecamatanAsal'] as $key => $value)
                                                                    <option value="{{ $key }}" {{ old('kecamatan_asal_id', isset($listPllt) ? $listPllt->kecamatan_asal_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <legend><b>Daerah Tujuan</b></legend>
                                                <div class="form-group row">
                                                    <label for="provinsi_tujuan_id" class="col-sm-2 col-form-label">Provinsi</label>
                                                    <div class="col-sm-10">
                                                        <select name="provinsi_tujuan_id" id="provinsi_tujuan_id" class="form-control select2" style="width: 100%;" onchange="dataKotaTujuan()">
                                                            <option value="">Pilih Provinsi</option>
                                                            @foreach($var['provinsiTujuan'] as $key => $value)
                                                                <option value="{{ $key }}" {{ old('provinsi_tujuan_id', isset($listPllt) ? $listPllt->provinsi_tujuan_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div id="areaFormKotaKabupatenTujuan">
                                                    <div class="form-group row">
                                                        <label for="kabupaten_tujuan_id" class="col-sm-2 col-form-label">Kota / Kabupaten</label>
                                                        <div class="col-sm-10">
                                                            <select name="kabupaten_tujuan_id" id="kabupaten_tujuan_id" class="form-control select2" style="width: 100%;" onchange="dataKecamatanTujuan()">
                                                                <option value="">Pilih Kota / Kabupaten</option>
                                                                @foreach($var['kotaKabupatenTujuan'] as $key => $value)
                                                                    <option value="{{ $key }}" {{ old('kabupaten_tujuan_id', isset($listPllt) ? $listPllt->kabupaten_tujuan_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="areaFormKecamatanTujuan">
                                                    <div class="form-group row">
                                                        <label for="kecamatan_tujuan_id" class="col-sm-2 col-form-label">Kecamatan</label>
                                                        <div class="col-sm-10">
                                                            <select name="kecamatan_tujuan_id" id="kecamatan_tujuan_id" class="form-control select2" style="width: 100%;">
                                                                <option value="">Pilih Kecamatan</option>
                                                                @foreach($var['kecamatanTujuan'] as $key => $value)
                                                                    <option value="{{ $key }}" {{ old('kecamatan_tujuan_id', isset($listPllt) ? $listPllt->kecamatan_tujuan_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Step 4 -->
                                            <h6>Bagian 2</h6>
                                            <section>
                                                <div class="form-group row">
                                                    <label for="jenis_dokumen" class="col-sm-2 col-form-label">Jenis Dokumen</label>
                                                    <div class="col-sm-10">
                                                        <select name="jenis_dokumen" id="jenis_dokumen" class="form-control">
                                                            <option value="">Pilih Jenis Dokumen</option>
                                                            <option value="SPT" {{ old('jenis_dokumen', isset($listPllt) ? $listPllt->jenis_dokumen : '') == 'SPT' ? 'selected' : '' }}>SPT</option>
                                                            <option value="SKKH" {{ old('jenis_dokumen', isset($listPllt) ? $listPllt->jenis_dokumen : '') == 'SKKH' ? 'selected' : '' }}>SKKH</option>
                                                            <option value="SKSR" {{ old('jenis_dokumen', isset($listPllt) ? $listPllt->jenis_dokumen : '') == 'SKSR' ? 'selected' : '' }}>SKSR</option>
                                                            <option value="SKB" {{ old('jenis_dokumen', isset($listPllt) ? $listPllt->jenis_dokumen : '') == 'SKB' ? 'selected' : '' }}>SKB</option>
                                                            <option value="Tanpa Surat" {{ old('jenis_dokumen', isset($listPllt) ? $listPllt->jenis_dokumen : '') == 'Tanpa Surat' ? 'selected' : '' }}>Tanpa Surat</option>
                                                            <option value="Lainnya" {{ old('jenis_dokumen', isset($listPllt) ? $listPllt->jenis_dokumen : '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nomor_dokumen" class="col-sm-2 col-form-label">Nomor Dokumen</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nomor_dokumen" id="nomor_dokumen" class="form-control" placeholder="Inputkan Nomor Dokumen" 
                                                            value="{{ old('nomor_dokumen', isset($listPllt) ? $listPllt->nomor_dokumen : '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggal_dokumen" class="col-sm-2 col-form-label">Tanggal Input</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="tanggal_dokumen" id="tanggal_dokumen" class="form-control" placeholder="Inputkan Tanggal Input" 
                                                            value="{{ old('tanggal_dokumen', isset($listPllt) ? $listPllt->tanggal_dokumen : '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="pengirim" class="col-sm-2 col-form-label">Pemilik / Pengirim</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="pengirim" id="pengirim" class="form-control" placeholder="Inputkan Pemilik / Pengirim" 
                                                            value="{{ old('pengirim', isset($listPllt) ? $listPllt->pengirim : '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="penerima" class="col-sm-2 col-form-label">Penerima</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="penerima" id="penerima" class="form-control" placeholder="Inputkan Penerima" 
                                                            value="{{ old('penerima', isset($listPllt) ? $listPllt->penerima : '') }}">
                                                    </div>
                                                </div>
                                                <div id="areaPemeriksa">
                                                    <div class="form-group row">
                                                        <label for="pemeriksa_id" class="col-sm-2 col-form-label">Dokter / Petugas Pemeriksa</label>
                                                        <div class="col-sm-10">
                                                            <select name="pemeriksa_id" id="pemeriksa_id" class="form-control select2" style="width: 100%;">
                                                                <option value="">Pilih Dokter / Petugas Pemeriksa</option>
                                                                @foreach($var['pemeriksa'] as $key => $value)
                                                                    <option value="{{ $key }}" {{ old('pemeriksa_id', isset($listPllt) ? $listPllt->pemeriksa_id : '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Inputkan Keterangan" rows="4">{{ old('keterangan', isset($listPllt) ? $listPllt->keterangan : '') }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="upload_file" class="col-sm-2 col-form-label">Upload File</label>
                                                    <div class="col-sm-10">
                                                        <input type="file" name="upload_file[]" id="upload_file" class="form-control" placeholder="Upload File" multiple>
                                                        <br>
                                                        <div id="areaFile"></div>
                                                    </div>
                                                </div>
                                            </section>
                                        </form>
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
