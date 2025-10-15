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
 <form method="POST" action="{{ url('/laboratorium/'.$listLaboratorium->id.$var['url']['all']) }}" id="form-laboratorium" class="tab-wizard wizard-circle" enctype="multipart/form-data">
 @method('PATCH')
 @elseif($var['method']=='create')
 <form method="POST" action="{{ url('/laboratorium') }}" id="form-laboratorium" class="validation-wizard wizard-circle" enctype="multipart/form-data">
 @else
 <form id="form-laboratorium" class="tab-wizard wizard-circle">
 @endif
 @csrf
                                            <!-- Step 1 -->
                                            <h6>Bagian 1</h6>
                                            <section>
                                                <div class="form-group row">
                                                    <label for="input_by" class="col-sm-2 col-form-label">User</label>
                                                    <div class="col-sm-10">
                                                        <select name="input_by" id="input_by" class="form-control select2" placeholder="Pilih User" style="width: 100%;" onchange="subSatuanKerja(); jenisContoh()">
 @foreach($var['user'] as $id => $name)
 <option value="{{ $id }}" {{ ($var['currentUser'] == $id) ? 'selected' : '' }}>{{ $name }}</option>
 @endforeach
 </select>                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Laboratorium</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nama_sub_satuan_kerja" id="nama_sub_satuan_kerja" class="form-control" placeholder="Inputkan Nama Laboratorium" readonly value="{{ ($var['method']=='edit'||$var['method']=='show') ? (@$listLaboratorium->inputBy->subSatuanKerja->sub_satuan_kerja) : $var['namaLaboratorium'] }}">
                                                        <input type="hidden" name="sub_satuan_kerja_id" value="{{ $var['idLaboratorium'] }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="no_epid" class="col-sm-2 col-form-label">Nomor EPID</label>
                                                    <div class="col-sm-5">
 <select name="status_epid" id="status_epid" class="form-control" placeholder="Pilih Status EPID">
 <option value="">Pilih Status EPID</option>
 <option value="ES" {{ (isset($listLaboratorium) && $listLaboratorium->status_epid == 'ES') ? 'selected' : '' }}>ES (Pasif)</option>
 <option value="ED" {{ (isset($listLaboratorium) && $listLaboratorium->status_epid == 'ED') ? 'selected' : '' }}>ED (Aktif)</option>
 </select>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <input type="text" name="no_epid" class="form-control" placeholder="Inputkan Nomor EPID" value="{{ old('no_epid', $listLaboratorium->no_epid ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama_pengirim_id" class="col-sm-2 col-form-label">Nama Pengirim</label>
                                                    <div class="col-sm-10">
 <select name="nama_pengirim_id" id="nama_pengirim_id" class="form-control select2" placeholder="Pilih Nama Pengirim" style="width: 100%;" onchange="customer()">
 @foreach($var['customer'] as $id => $name)
 <option value="{{ $id }}" {{ (isset($listLaboratorium) && $listLaboratorium->nama_pengirim_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
 @endforeach
 </select>
                                                    </div> 
                                                </div>
                                                <div class="form-group row">
                                                    <label for="alamat_pengirim" class="col-sm-2 col-form-label">Alamat Pengirim</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="alamat_pengirim" class="form-control" placeholder="Inputkan Alamat Pengirim" readonly value="{{ ($var['method']=='edit' || $var['method']=='show') ? (@$listLaboratorium->customer->alamat) : '' }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jenis_hewan_id" class="col-sm-2 col-form-label">Jenis Hewan</label>
                                                    <div class="col-sm-10">
 <select name="jenis_hewan_id" id="jenis_hewan_id" class="form-control select2" placeholder="Pilih Jenis Hewan" style="width: 100%;">
 @foreach($var['spesies'] as $id => $name)
 <option value="{{ $id }}" {{ (isset($listLaboratorium) && $listLaboratorium->jenis_hewan_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
 @endforeach
 </select>
                                                    </div>
                                                </div>
                                                <div id="areaJenisContoh">
                                                    <div class="form-group row">
                                                        <label for="jenis_contoh_id" class="col-sm-2 col-form-label">Jenis Contoh</label>
                                                        <div class="col-sm-10">
 <select name="jenis_contoh_id" id="jenis_contoh_id" class="form-control select2" placeholder="Pilih Jenis Contoh" style="width: 100%;" onchange="bentukContoh()">
 @foreach($var['jenisContoh'] as $id => $name)
 <option value="{{ $id }}" {{ (isset($listLaboratorium) && $listLaboratorium->jenis_contoh_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
 @endforeach
 </select>                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="areaBentukContoh">
                                                    <div class="form-group row">
                                                        <label for="bentuk_contoh_id" class="col-sm-2 col-form-label">Bentuk Contoh</label>
                                                        <div class="col-sm-10">
 <select name="bentuk_contoh_id" id="bentuk_contoh_id" class="form-control select2" placeholder="Pilih Bentuk Contoh" style="width: 100%;">
 @foreach($var['bentukContoh'] as $id => $name)
 <option value="{{ $id }}" {{ (isset($listLaboratorium) && $listLaboratorium->bentuk_contoh_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
 @endforeach
 </select>                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jumlah_contoh" class="col-sm-2 col-form-label">Jumlah Contoh</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" name="jumlah_contoh" class="form-control" placeholder="Inputkan Jumlah Contoh" value="{{ old('jumlah_contoh', $listLaboratorium->jumlah_contoh ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="seksi_laboratorium_id" class="col-sm-2 col-form-label">Seksi Laboratorium</label>
                                                    <div class="col-sm-10">
 <select name="seksi_laboratorium_id" id="seksi_laboratorium_id" class="form-control select2" placeholder="Pilih Seksi Laboratorium" style="width: 100%;" onchange="jenisPengujian()">
 @foreach($var['seksiLaboratorium'] as $id => $name)
 <option value="{{ $id }}" {{ (isset($listLaboratorium) && $listLaboratorium->seksi_laboratorium_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
 @endforeach
 </select>
                                                    </div>
                                                </div>
                                                <div id="areaJenisPengujian">
                                                    <div class="form-group row">
                                                        <label for="permintaan_uji_id" class="col-sm-2 col-form-label">Jenis Pengujian</label>
                                                        <div class="col-sm-10">
 <select name="permintaan_uji_id" id="permintaan_uji_id" class="form-control select2" placeholder="Pilih Jenis Pengujian" style="width: 100%;">
 @foreach($var['jenisPengujian'] as $id => $name)
 <option value="{{ $id }}" {{ (isset($listLaboratorium) && $listLaboratorium->permintaan_uji_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
 @endforeach
 </select>                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="kriteria_contoh" class="col-sm-2 col-form-label">Kriteria Contoh</label>
                                                    <div class="col-sm-10">
 <select name="kriteria_contoh" id="kriteria_contoh" class="form-control" placeholder="Pilih Kriteria Contoh">
 <option value="">Pilih Kriteria Contoh</option>
 <option value="MS" {{ (isset($listLaboratorium) && $listLaboratorium->kriteria_contoh == 'MS') ? 'selected' : '' }}>Memenuhi Syarat</option>
 <option value="TMS" {{ (isset($listLaboratorium) && $listLaboratorium->kriteria_contoh == 'TMS') ? 'selected' : '' }}>Tidak Memenuhi Syarat</option>
 </select>
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Step 3 -->
                                            <h6>Bagian 2</h6>
                                            <section>
                                                <div class="form-group row">
                                                    <label for="metode_uji" class="col-sm-2 col-form-label">Metode Uji</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="metode_uji" class="form-control" placeholder="Inputkan Metode Uji" value="{{ old('metode_uji', $listLaboratorium->metode_uji ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="peralatan" class="col-sm-2 col-form-label">Peralatan</label>
                                                    <div class="col-sm-10">
 <select name="peralatan" id="peralatan" class="form-control" placeholder="Pilih Peralatan">
 <option value="">Pilih Peralatan</option>
 <option value="Mampu" {{ (isset($listLaboratorium) && $listLaboratorium->peralatan == 'Mampu') ? 'selected' : '' }}>Mampu</option>
 <option value="Tidak Mampu" {{ (isset($listLaboratorium) && $listLaboratorium->peralatan == 'Tidak Mampu') ? 'selected' : '' }}>Tidak Mampu</option>
 </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="bahan" class="col-sm-2 col-form-label">Bahan</label>
                                                    <div class="col-sm-10">
                                                        <select name="bahan" id="bahan" class="form-control" placeholder="Pilih Bahan">
 <option value="">Pilih Bahan</option>
 <option value="Mampu" {{ (isset($listLaboratorium) && $listLaboratorium->bahan == 'Mampu') ? 'selected' : '' }}>Mampu</option>
 <option value="Tidak Mampu" {{ (isset($listLaboratorium) && $listLaboratorium->bahan == 'Tidak Mampu') ? 'selected' : '' }}>Tidak Mampu</option>
 </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="personil" class="col-sm-2 col-form-label">Personil</label>
                                                    <div class="col-sm-10">
                                                        <select name="personil" id="personil" class="form-control" placeholder="Pilih Personil">
                                                            <option value="">Pilih Personil</option>
                                                            <option value="Mampu" {{ (isset($listLaboratorium) && $listLaboratorium->personil == 'Mampu') ? 'selected' : '' }}>Mampu</option>
                                                            <option value="Tidak Mampu" {{ (isset($listLaboratorium) && $listLaboratorium->personil == 'Tidak Mampu') ? 'selected' : '' }}>Tidak Mampu</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="catatan" class="col-sm-2 col-form-label">Catatan / Saran</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="catatan" class="form-control" placeholder="Inputkan Catatan / Saran" rows="4">{{ old('catatan', $listLaboratorium->catatan ?? '') }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="jenis_kegiatan" class="col-sm-2 col-form-label">Jenis Kegiatan</label>
                                                    <div class="col-sm-10">
 <select name="jenis_kegiatan" id="jenis_kegiatan" class="form-control" placeholder="Pilih Jenis Kegiatan">
 <option value="">Pilih Jenis Kegiatan</option>
 <option value="Aktif" {{ (isset($listLaboratorium) && $listLaboratorium->jenis_kegiatan == 'Aktif') ? 'selected' : '' }}>Aktif</option>
 <option value="Pasif" {{ (isset($listLaboratorium) && $listLaboratorium->jenis_kegiatan == 'Pasif') ? 'selected' : '' }}>Pasif</option>
 </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="pengirim" class="col-sm-2 col-form-label">Pengirim</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="pengirim" class="form-control" placeholder="Inputkan Pengirim" value="{{ old('pengirim', $listLaboratorium->pengirim ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="tanggal_penerimaan" class="col-sm-2 col-form-label">Tanggal Penerimaan</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="tanggal_penerimaan" class="form-control datepicker" placeholder="Inputkan Tanggal Penerimaan" value="{{ old('tanggal_penerimaan', $listLaboratorium->tanggal_penerimaan ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="penerima" class="col-sm-2 col-form-label">Penerima</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="penerima" class="form-control" placeholder="Inputkan Penerima" value="{{ old('penerima', $listLaboratorium->penerima ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nomor_asal" class="col-sm-2 col-form-label">Nomor Asal</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nomor_asal" class="form-control" placeholder="Inputkan Nomor Asal" value="{{ old('nomor_asal', $listLaboratorium->nomor_asal ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nomor_baru" class="col-sm-2 col-form-label">Nomor Baru</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nomor_baru" class="form-control" placeholder="Inputkan Nomor Baru" value="{{ old('nomor_baru', $listLaboratorium->nomor_baru ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="asal_contoh_id" class="col-sm-2 col-form-label">Asal Contoh</label>
                                                    <div class="col-sm-10">
 <select name="asal_contoh_id" id="asal_contoh_id" class="form-control select2" placeholder="Pilih Asal Contoh" style="width: 100%;">
 @foreach($var['kotaKabupaten'] as $id => $name)
 <option value="{{ $id }}" {{ (isset($listLaboratorium) && $listLaboratorium->asal_contoh_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
 @endforeach
 </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="manajer_teknis" class="col-sm-2 col-form-label">Manajer Teknis / Penyelia</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="manajer_teknis" class="form-control" placeholder="Inputkan Manajer Teknis / Penyelia" value="{{ old('manajer_teknis', $listLaboratorium->manajer_teknis ?? '') }}">
                                                    </div>
                                                </div>
                                            </section>
                                            <!-- Step 4 -->
                                            <h6>Bagian 3</h6>
                                            <section>
                                                <div class="form-group row">
                                                    <label for="penguji_ditunjuk" class="col-sm-2 col-form-label">Penguji yang Ditunjuk</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="penguji_ditunjuk" class="form-control" placeholder="Inputkan Penguji yang Ditunjuk" value="{{ old('penguji_ditunjuk', $listLaboratorium->penguji_ditunjuk ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="hasil_pengujian" class="col-sm-2 col-form-label">Hasil Pengujian Kualitatif</label>
                                                    <div class="col-sm-10">
 <select name="hasil_pengujian" id="hasil_pengujian" class="form-control" placeholder="Pilih Hasil Pengujian Kualitatif">
 <option value="">Pilih Hasil Pengujian Kualitatif</option>
 <option value="Positif" {{ (isset($listLaboratorium) && $listLaboratorium->hasil_pengujian == 'Positif') ? 'selected' : '' }}>Positif</option>
 <option value="Negatif" {{ (isset($listLaboratorium) && $listLaboratorium->hasil_pengujian == 'Negatif') ? 'selected' : '' }}>Negatif</option>
 </select>
                                                        <div class="form-control-feedback"><small>PULLORUM, RBT, PCR, Parasit External</small></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="hasil_pengujian2" class="col-sm-2 col-form-label">Hasil Pengujian Kualitatif</label>
                                                    <div class="col-sm-10">
 <select name="hasil_pengujian2" id="hasil_pengujian2" class="form-control" placeholder="Pilih Hasil Pengujian Kualitatif">
 <option value="">Pilih Hasil Pengujian Kualitatif</option>
 <option value="Titer 0" {{ (isset($listLaboratorium) && $listLaboratorium->hasil_pengujian2 == 'Titer 0') ? 'selected' : '' }}>Titer 0</option>
 <option value="Titer Rendah" {{ (isset($listLaboratorium) && $listLaboratorium->hasil_pengujian2 == 'Titer Rendah') ? 'selected' : '' }}>Titer Rendah</option>
 <option value="Titer Tinggi" {{ (isset($listLaboratorium) && $listLaboratorium->hasil_pengujian2 == 'Titer Tinggi') ? 'selected' : '' }}>Titer Tinggi</option>
 </select>
                                                        <div class="form-control-feedback"><small>AI & ND</small></div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="pengujian_parasit" class="col-sm-2 col-form-label">Hasil Pengujian Kualitatif</label>
                                                    <div class="col-sm-10">
 <select name="pengujian_parasit" id="pengujian_parasit" class="form-control" placeholder="Pilih Hasil Pengujian Kualitatif">
 <option value="">Pilih Hasil Pengujian Kualitatif</option>
 <option value="Positif" {{ (isset($listLaboratorium) && $listLaboratorium->pengujian_parasit == 'Positif') ? 'selected' : '' }}>Positif</option>
 <option value="Negatif" {{ (isset($listLaboratorium) && $listLaboratorium->pengujian_parasit == 'Negatif') ? 'selected' : '' }}>Negatif</option>
 </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="keterangan_hasil" class="col-sm-2 col-form-label">Keterangan Hasil Uji</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="keterangan_hasil" class="form-control" placeholder="Inputkan Keterangan Hasil Uji" rows="4">{{ old('keterangan_hasil', $listLaboratorium->keterangan_hasil ?? '') }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="upload_file" class="col-sm-2 col-form-label">Upload File</label>
                                                    <div class="col-sm-10">
 <input type="file" name="upload_file[]" id="upload_file" class="form-control" placeholder="Upload File" multiple="multiple">
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
