@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pemilik
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Pemilik</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/pemilik') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/pemilik/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method']=='edit')
                                        <form id="form-pemilik" method="POST" action="{{ url('/master-data/pemilik/'.$listPemilik->id.$var['url']['all']) }}">
                                            @csrf
                                            @method('PATCH')
                                    @elseif($var['method']=='create')
                                        <form id="form-pemilik" method="POST" action="{{ url('/master-data/pemilik') }}">
                                            @csrf
                                    @else
                                        <form class="form-pemilik">
                                    @endif
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                                                    <div class="col-sm-10">
                                                    @if($var['method']=='edit')
                                                        <input type="text" name="kode" id="kode" value="{{ old('kode', $listPemilik->kode ?? '') }}" class="form-control" placeholder="Inputkan Kode" />
                                                    @elseif($var['method']=='create')
                                                        <input type="text" name="kode" id="kode" value="{{ old('kode', $var['kode'] ?? '') }}" class="form-control" placeholder="Inputkan Kode" />
                                                    @else
                                                        <input type="text" name="kode" id="kode" value="{{ old('kode', $listPemilik->kode ?? '') }}" class="form-control" placeholder="Inputkan Kode" />
                                                    @endif    
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="nama" class="col-sm-2 col-form-label required">Nama</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="nama" id="nama" value="{{ old('nama', $listPemilik->nama ?? '') }}" class="form-control" placeholder="Inputkan Nama" required />
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon', $listPemilik->telepon ?? '') }}" class="form-control" placeholder="Inputkan Telepon" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="ktp" class="col-sm-2 col-form-label required">Nomor KTP</label> 
                                                    <div class="col-sm-10">
                                                        <input type="text" name="ktp" id="ktp" value="{{ old('ktp', $listPemilik->ktp ?? '') }}" class="form-control" placeholder="Inputkan Nomor KTP" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $listPemilik->alamat ?? '') }}" class="form-control" placeholder="Inputkan Alamat" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="province_id" class="col-sm-2 col-form-label">Provinsi</label>
                                                    <div class="col-sm-10">
                                                        <select name="province_id" id="province_id" class="form-control" style="width: 100%;">
                                                            @foreach($var['pronvice'] as $key => $value)
                                                                <option value="{{$value->id_wil}}" {{($value->id_wil == $var['curr_province'])?"selected":""}}>{{$value->nm_wil}}</option>
                                                            @endforeach 
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="city_id" class="col-sm-2 col-form-label">Kota</label>
                                                    <div class="col-sm-10">
                                                        <select name="city_id" id="city_id" class="form-control" style="width: 100%;">
                                                            @foreach($var['city'] as $key => $value)
                                                                <option value="{{$value->id_wil}}" {{($value->id_wil == $var['curr_city'])?"selected":""}}>{{$value->nm_wil}}</option>
                                                            @endforeach 
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="region_id" class="col-sm-2 col-form-label">Kecamatan</label>
                                                    <div class="col-sm-10">
                                                        <select name="region_id" id="region_id" class="form-control" style="width: 100%;">
                                                            @foreach($var['region'] as $key => $value)
                                                                <option value="{{$value->id_wil}}" {{($value->id_wil == $var['curr_region'])?"selected":""}}>{{$value->nm_wil}}</option>
                                                            @endforeach 
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
										<div class="row">
											<div class="col-md-12">
												<h3>Data Pasien</h3>
											</div>
										</div> 
                                        <div class="form-group row">
                                            <label for="nama_hewan" class="col-sm-2 col-form-label">Nama Hewan</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="nama_hewan" id="nama_hewan" value="{{ old('nama_hewan', $listPemilik->nama_hewan ?? '') }}" class="form-control" placeholder="Nama Hewan" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="spesies_id" class="col-sm-2 col-form-label">Jenis Hewan</label>
                                            <div class="col-sm-10">
                                                <select name="spesies_id" id="spesies_id" class="form-control" style="width: 100%;">
                                                    <option value="">Pilih Jenis Hewan</option>
                                                    @foreach($var['spesies'] as $key => $value)
                                                        <option value="{{ $key }}" {{ old('spesies_id', $listPemilik->spesies_id ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                            <div class="col-sm-10">
                                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="Jantan" {{ old('jenis_kelamin', $listPemilik->jenis_kelamin ?? '') == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                                                    <option value="Betina" {{ old('jenis_kelamin', $listPemilik->jenis_kelamin ?? '') == 'Betina' ? 'selected' : '' }}>Betina</option>
                                                </select>
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
        $(document).ready(function() {
            @if($var['method']=='edit' || $var['method']=='show')
                var pk = "{{ $listPemilik->id }}";
            @else
                var pk = null;
            @endif

            /* $("#form-pemilik").validate({
                rules: {
                    kode: {
                        required: true,
                        remote: {
                            url: "{{ url('master-data/pemilik/cek-validasi') }}",
                            type: "post",
                            data: {
                                "kolom" : "kode",
                                "aksi" : "{{ $var['method'] }}",
                                "pk" : pk
                            }
                        }
                    },
                    nama: "required",
                },
                messages: {
                    kode: {
                        required: "Kolom kode harus diisi",
                        remote: "Kode sudah digunakan"
                    },
                    nama: "Kolom nama harus diisi",
                }
            }); */
            $('#province_id').change(function(){
                //alert("asdasd");
                var id=$(this).val();
                const url = "{{URL::to('master-data/pemilik/get_wilayah')}}";
                $.ajax({
                    url : url,
                    method : "POST",
                    data : {"_token": "{{ csrf_token() }}",id: id},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '<option value="0">--Pilih Kota</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+ data[i].id_wil +'">'+data[i].nm_wil+'</option>';
                        }
                        $('#city_id').html(html);
                        $('#region_id').html(`<option value="0">--Pilih Kecamatan</option>`)

                    }
                });
            });
            $('#city_id').change(function(){
                //alert("asdasd");
                var id=$(this).val();
                const url = "{{URL::to('master-data/pemilik/get_wilayah')}}";
                $.ajax({
                    url : url,
                    method : "POST",
                    data : {"_token": "{{ csrf_token() }}",id: id},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '<option value="0">--Pilih Kota</option>';
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<option value="'+ data[i].id_wil +'">'+data[i].nm_wil+'</option>';
                        }
                        $('#region_id').html(html)

                    }
                });
            });
        });
    </script>
@endsection
