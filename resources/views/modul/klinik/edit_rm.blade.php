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
                            <li class="nav-item"><a href="{{ url('klinik/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('klinik/add') }}" class="nav-link"><span class="hidden-sm-up"><b>Update Data</b></span> <span class="hidden-xs-down"><b>Update Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad"> @if($var['method']=='edit')
                                    <form method="POST" action="{{ url('/klinik/updateRM/'.$listKlinik->id.$var['url']['all']) }}" id="form-klinik">
                                        @method('PATCH') @elseif($var['method']=='create')
                                        <form method="POST" action="{{ url('/klinik') }}" id="form-klinik">
                                            @else
                                            <form class="form-klinik"> @endif @csrf
                                                <div class="form-group row">
                                                    <label for="input_by" class="col-sm-2 col-form-label">User</label>
                                                    <div class="col-sm-10">
                                                        <select name="input_by" id="input_by" class="form-control select2" placeholder="Pilih User" style="width: 100%;" onchange="subSatuanKerja()"> @foreach($var['user'] as $id => $name)
                                                            <option value="{{ $id }}" {{ ($var['currentUser'] == $id) ? 'selected' : '' }}>{{ $name }}</option> @endforeach
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
                                                    <label for="no_pasien" class="col-sm-2 col-form-label">No. RM</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="no_pasien" id="no_pasien" class="form-control" placeholder="Inputkan No. RM" readonly value="{{ old('no_pasien', $listKlinik->no_pasien ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="pemilik_id" class="col-sm-2 col-form-label">Pemilik</label>
                                                    <div class="col-sm-10">
                                                        <select name="pemilik_id" id="pemilik_id" class="form-control select2" placeholder="Pilih Pemilik" style="width: 100%;" onchange="pemilik()"> @foreach($var['pemilik'] as $id => $name)
                                                            <option value="{{ $id }}" {{ (isset($listKlinik) && $listKlinik->pemilik_id == $id) ? 'selected' : '' }}>{{ $name }}</option> @endforeach
                                                        </select>
                                                    </div>
                                                </div>
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
                                                    <label for="spesies_id" class="col-sm-2 col-form-label">Jenis Hewan</label>
                                                    <div class="col-sm-10">
                                                        <select name="spesies_id" id="spesies_id" class="form-control select2" placeholder="Pilih Jenis Hewan" style="width: 100%;" onchange="ras()"> @foreach($var['spesies'] as $id => $name)
                                                            <option value="{{ $id }}" {{ (isset($listKlinik) && $listKlinik->spesies_id == $id) ? 'selected' : '' }}>{{ $name }}</option> @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="ras_id" id="ras_id" class="form-control" placeholder="Pilih Ras" style="width: 100%;" value="{{ old('ras_id', $listKlinik->ras_id ?? '') }}">
                                                <div class="form-group row">
                                                    <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                                    <div class="col-sm-10">
                                                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" placeholder="Pilih Jenis Kelamin">
                                                            <option value="">Pilih Jenis Kelamin</option>
                                                            <option value="Jantan" {{ (isset($listKlinik) && $listKlinik->jenis_kelamin == 'Jantan') ? 'selected' : '' }}>Jantan</option>
                                                            <option value="Betina" {{ (isset($listKlinik) && $listKlinik->jenis_kelamin == 'Betina') ? 'selected' : '' }}>Betina</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama_hewan" class="col-sm-2 col-form-label">Nama Hewan</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="nama_hewan" id="nama_hewan" class="form-control" placeholder="Inputkan Nama Hewan" value="{{ old('nama_hewan', $listKlinik->nama_hewan ?? '') }}">
                                                    </div>
                                                    <label for="umur" class="col-sm-2 col-form-label">Umur</label>
                                                    <div class="col-sm-4">
                                                        <input type="text" name="umur" id="umur" class="form-control" placeholder="Inputkan Umur" value="{{ old('umur', $listKlinik->umur ?? '') }}">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="ciri_ciri" id="ciri_ciri" class="form-control" placeholder="Inputkan Ciri - Ciri" value="{{ old('ciri_ciri', $listKlinik->ciri_ciri ?? '') }}">
                                                <div class="form-group row">
                                                    <label for="signalement" class="col-sm-2 col-form-label">Signalement</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="signalement" id="signalement" class="form-control" placeholder="Inputkan Signalement" value="{{ old('signalement', $listKlinik->signalement ?? '') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-lg-4 ml-auto"> @if($var['method']=='edit')
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="reset" class="btn btn-danger">Reset</button> @elseif($var['method']=='create')
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                        <button type="reset" class="btn btn-danger">Reset</button> @else
                                                        <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a> @endif
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
                $("#no_pasien").val(data[1].kode+'/'+data[0]);

                console.log(data);
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
                    }
                },
                messages: {
                    no_pasien: {
                        required: "Kolom nomor pasien harus diisi",
                        remote: "Nomor Pasien sudah digunakan"
                    },
                }
            });

            $('#buttonTambahTerapiDosis').click(function(e){
                e.preventDefault();
                var data = {
                    terapi: ($("#terapi_id").val()!=""?$("#terapi_id").val():""),
                    dosis: ($("#dosis").val()!=""?$("#dosis").val():"")
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
