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
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        {!! Form::model($listKlinik, ['method'=>'PATCH', 'url'=> '/klinik/'.$listKlinik->id.$var['url']['all'], 'id'=>'form-klinik']) !!}
                                    @elseif($var['method']=='create')
                                        {!! Form::open(['id'=>'form-klinik', 'method'=>'POST', 'url'=>'/klinik']) !!}
                                    @else
                                        {!! Form::model($listKlinik, ['class'=>'form-klinik']) !!}
                                    @endif
                                        <div class="form-group row">
                                            {!! Form::label('input_by', 'User', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('input_by', $var['user'], $var['currentUser'], ['class'=>'form-control select2', 'placeholder'=>'Pilih User', 'style'=>'width: 100%;', 'onchange'=>'subSatuanKerja()']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('sub_satuan_kerja_id', 'Nama Klinik', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('nama_sub_satuan_kerja', ($var['method']=='edit'||$var['method']=='show'?@$listKlinik->inputBy->subSatuanKerja->sub_satuan_kerja:$var['namaKlinik']), ['class'=>'form-control', 'id'=>'nama_sub_satuan_kerja', 'placeholder'=>'Inputkan Nama Klinik', 'readonly']) !!}
                                                {!! Form::hidden('sub_satuan_kerja_id', $var['idKlinik'], ['class'=>'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('no_pasien', 'No. RM', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('no_pasien', null, ['class'=>'form-control', 'placeholder'=>'Inputkan No. RM','readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('pemilik_id', 'Pemilik', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('pemilik_id', $var['pemilik'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Pemilik', 'style'=>'width: 100%;', 'onchange'=>'pemilik()']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('alamat_pemilik', 'Alamat Pemilik', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('alamat_pemilik', ($var['method']=='edit'||$var['method']=='show'?@$listKlinik->pemilik->alamat:null), ['class'=>'form-control', 'placeholder'=>'Inputkan Alamat Pemilik', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('telepon_pemilik', 'Telepon Pemilik', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('telepon_pemilik',  ($var['method']=='edit'||$var['method']=='show'?@$listKlinik->pemilik->telepon:null), ['class'=>'form-control', 'placeholder'=>'Inputkan Telepon Pemilik', 'readonly']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('spesies_id', 'Jenis Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('spesies_id', $var['spesies'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Hewan', 'style'=>'width: 100%;', 'onchange'=>'ras()']) !!}
                                            </div>
                                        </div>
                                        <!-- <div id="areaRas"> -->
                                            <!-- <div class="form-group row"> -->
                                                <!-- {!! Form::label('ras_id', 'Ras', ['class' => 'col-sm-2 col-form-label']) !!} -->
                                                <!-- <div class="col-sm-10"> -->
                                                    {!! Form::hidden('ras_id',null, ['class'=>'form-control', 'placeholder'=>'Pilih Ras', 'style'=>'width: 100%;']) !!}
                                                <!-- </div>
                                            </div>
                                        </div> -->
                                        <div class="form-group row">
                                            {!! Form::label('jenis_kelamin', 'Jenis Kelamin', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('jenis_kelamin', ['Jantan'=>'Jantan', 'Betina'=>'Betina'], null, ['class'=>'form-control', 'placeholder'=>'Pilih Jenis Kelamin']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('nama_hewan', 'Nama Hewan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                                {!! Form::text('nama_hewan', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama Hewan']) !!}
                                            </div>
                                            {!! Form::label('umur', 'Umur', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                                {!! Form::text('umur', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Umur']) !!}
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row"> -->
                                            <!-- {!! Form::label('ciri_ciri', 'Ciri - Ciri', ['class' => 'col-sm-2 col-form-label']) !!} -->
                                            <!-- <div class="col-sm-10"> -->
                                                {!! Form::hidden('ciri_ciri', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Ciri - Ciri']) !!}
                                            <!-- </div>
                                        </div> -->
                                        <div class="form-group row">
                                            {!! Form::label('no_periksa', 'Nomor Periksa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                                {!! Form::text('no_periksa', ($var['method']=='create'?$var['noPeriksa']:null), ['class'=>'form-control', 'placeholder'=>'Inputkan Nomor Periksa']) !!}
                                            </div>
                                            {!! Form::label('tanggal_periksa', 'Tanggal Periksa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-4">
                                                {!! Form::text('tanggal_periksa', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Tanggal Periksa','autocomplete'=>'off']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('signalement', 'Signalement', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('signalement', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Signalement']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('anamnesia', 'Anamnesa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('anamnesia', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Anamnesa']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('diagnosa', 'Diagnosa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('diagnosa', $var['penyakit'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Penyakit', 'style'=>'width: 100%;']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                        {!! Form::label('pemeriksa', 'Pemeriksa', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('pemeriksa', $var['pemeriksa'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Pemeriksa', 'style'=>'width: 100%;']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('paramedis', 'Paramedis', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('paramedis', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Nama Paramedis']) !!}
                                            </div>
                                        </div>
                                        <legend>Terapi & Dosis</legend>                                        
                                        <div class="form-group row">
                                            {!! Form::label('tindakan', 'Jenis Penanganan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                            {!! Form::select('tindakan', $var['penanganan'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Jenis Penanganan', 'style'=>'width: 100%;', 'onchange'=>'penangananAksi()']) !!}
                                            </div>
                                        </div>
                                    <div id="areaTindakan">    
                                        <div class="form-group row">
                                            {!! Form::label('terapi_id', 'Terapi / Tindakan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::select('terapi_id', $var['obat'], null, ['class'=>'form-control select2', 'placeholder'=>'Pilih Terapi / Tindakan', 'style'=>'width: 100%;']) !!}
                                            </div>
                                        </div>
                                    </div>    
                                        <div class="form-group row">
                                            {!! Form::label('dosis', 'Dosis / Ket Penaganan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::text('dosis', null, ['class'=>'form-control', 'placeholder'=>'Inputkan Dosis atau Keterangan Penanganan']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                <a href="#" id='buttonTambahTerapiDosis' class="btn btn-primary">Tambah</a>
                                                {!! Form::reset('Reset', ['class'=>'btn btn-danger', 'id'=>'buttonResetTerapiDosis']) !!}
                                            </div>
                                        </div>
                                        <!--<div id="areaDataTerapiDosis"></div>-->
										<table class="table" id="datatable">
											<thead>
												<tr>
													<td>Jenis Penanganan</td>
													<td>Terapi/Tindakan</td>
													<td>Dosis/Keterangan Penanganan</td> 
													<td></td>
												</tr>
											</thead>
											<tbody>
												@if(!empty($listDetailklinik))
												@foreach($listDetailklinik as $value)
												<tr>
													<td><input type="hidden" name="sampel[]" value="'{{$value->id_sampel}}'">{{App\Models\Boyolali\MasterData\Sampel::where(['id'=>$value->id_sampel])->pluck('nm_sampel')->first()}}</td>
													<td><input type="hidden" name="pengujian[]" value="{{$value->id_pengujian}}">{{App\Models\MasterData\JenisPengujian::where(['id'=>$value->id_pengujian])->pluck('jenis_pengujian')->first()}}</td>
													<td><input type="hidden" name="hasil_pengujian[]" value="{{$value->hasil_pengujian}}">{{$value->hasil_pengujian}}</td>
													<td><a href="#" class="delete_row_update" ><input type="hidden" name="id_detail[]" value="{{$value->id}}" class="id_detail"><i class="fa fa-trash"></i></a></td>
												</tr>
												@endforeach
												@endif
											</tbody>
										</table>

                                        <div class="form-group row">
                                            {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-2 col-form-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::textarea('keterangan', '-', ['class'=>'form-control', 'placeholder'=>'Inputkan Keterangan', 'rows'=>4,'required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                @if($var['method']=='edit')
                                                    {!! Form::submit('Update', ['class'=>'btn btn-primary']) !!}
                                                    {!! Form::reset('Reset', ['class'=>'btn btn-danger']) !!}
                                                @elseif($var['method']=='create')
                                                    {!! Form::submit('Simpan', ['id'=>'kirim_klinik','class'=>'btn btn-primary']) !!}
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
			var t = $('#datatable').DataTable({
				"paging": false
			});
			var counter = 1;
            $('#buttonTambahTerapiDosis').click(function(e){
                e.preventDefault();
                var data = {
                    terapi: ($("#terapi_id").val()!=""?$("#terapi_id").val():""),
                    dosis: ($("#dosis").val()!=""?$("#dosis").val():""),
                    tindakan: ($("#tindakan").val()!=""?$("#tindakan").val():"")
                };
				
                /* $.ajax({
                    method : 'post',
                    url : '{{ url("/klinik/tambah-data-terapi") }}',
                    data : data,
                }).done(function (data) {
                    tampilDataTerapiDosis();
                    resetFormDataTerapiDosis();
                }); */
				
				var tindakan = $("#tindakan").val();
				var terapi_id = $("#terapi_id").val();
				var dosis = $("#dosis").val();
				
				var tindakan_text = $("#tindakan option:selected").text();
				var terapi_text = $("#terapi_id option:selected").text();
				
				t.row.add([
					'<input type="hidden" name="tindakan[]" value="'+tindakan+'">'+tindakan_text,
					'<input type="hidden" name="terapi_id[]" value="'+terapi_id+'">'+terapi_text,
					'<input type="hidden" name="dosis[]" value="'+dosis+'">'+dosis,
					'<a href="#" class="delete_row"><input type="hidden" name="id_detail[]" value="" class="id_detail"><i class="fa fa-trash"></i></a> ',
				]).draw();
				counter++;
				resetFormDataTerapiDosis();
            });
			$('#datatable tbody').on( 'click', '.delete_row', function () {
				t
					.row( $(this).parents('tr') )
					.remove()
					.draw();
			} );
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
