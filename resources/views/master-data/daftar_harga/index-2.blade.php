@extends('layouts.admin')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Daftar Harga (PAD)
        </h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="breadcrumb-item"><a href="#">Master Data</a></li>
            <li class="breadcrumb-item active">Daftar Harga</li>
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
                            <li class="nav-item"><a href="{{ url('master-data/obat') }}" class="nav-link"><span class="hidden-sm-up"><b>Lihat Data</b></span> <span class="hidden-xs-down"><b>Lihat Data</b></span></a></li>
                            <li class="nav-item"><a href="{{ url('master-data/obat/create') }}" class="nav-link active"><span class="hidden-sm-up"><b>Tambah Data</b></span> <span class="hidden-xs-down"><B>Tambah Data</b></span></a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active">
                                <div class="pad">
                                    @if($var['method'] == 'edit')
                                        <form id="form-daftar-harga" method="POST" action="{{ url('/master-data/daftar-harga/'.$listHarga->id.$var['url']['all']) }}">
                                            @csrf
                                            @method('PATCH')
                                    @elseif($var['method'] == 'create')
                                        <form id="form-daftar-harga" method="POST" action="{{ url('/master-data/daftar-harga') }}">
                                            @csrf
                                    @else
                                        <form class="form-daftar-harga">
                                    @endif

                                        <div class="form-group row">
                                            <label for="spesies_id" class="col-sm-2 col-form-label required">Spesies</label>
                                            <div class="col-sm-10">
                                                <select name="spesies_id" id="spesies_id" class="form-control select2" style="width: 100%;" required>
                                                    <option value="">Pilih Spesies</option>
                                                    @foreach($var['spesies'] as $id => $nama)
                                                        <option value="{{ $id }}" {{ old('spesies_id', $listHarga->spesies_id ?? '') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="tindakan" class="col-sm-2 col-form-label required">Tindakan</label>
                                            <div class="col-sm-10">
                                                <select name="tindakan" id="tindakan" class="form-control select2" style="width: 100%;" required>
                                                    <option value="">Pilih Tindakan</option>
                                                    {{-- Assuming $var['tindakan'] is available --}}
                                                    @foreach($var['tindakan'] ?? [] as $id => $nama)
                                                        <option value="{{ $id }}" {{ old('tindakan', $listHarga->tindakan ?? '') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="terapi_id" class="col-sm-2 col-form-label required">Terapi</label>
                                            <div class="col-sm-10">
                                                <select name="terapi_id" id="terapi_id" class="form-control select2" style="width: 100%;" required>
                                                    <option value="">Pilih Terapi</option>
                                                    {{-- Assuming $var['terapi'] is available --}}
                                                    @foreach($var['terapi'] ?? [] as $id => $nama)
                                                        <option value="{{ $id }}" {{ old('terapi_id', $listHarga->terapi_id ?? '') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="harga" id="harga" value="{{ old('harga', $listHarga->harga ?? '') }}" class="form-control" placeholder="Inputkan Harga">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-lg-4 ml-auto">
                                                @if($var['method'] == 'edit')
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="reset" class="btn btn-danger">Reset</button>
                                                @elseif($var['method'] == 'create')
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
            @if(isset($listHarga) && ($var['method'] == 'edit' || $var['method'] == 'show'))
                var pk = "{{ $listHarga->id }}";
            @else
                var pk = null;
            @endif

            $("#form-daftar-harga").validate({
                rules: {
                    spesies_id: "required",
                    tindakan: "required",
                    terapi_id: "required",
                    harga: "required",
                },
                messages: {
                    spesies_id: "Kolom spesies harus diisi",
                    tindakan: "Kolom tindakan harus diisi",
                    terapi_id: "Kolom terapi harus diisi",
                    harga: "Kolom harga harus diisi",
                }
            });
        });
    </script>
@endsection
