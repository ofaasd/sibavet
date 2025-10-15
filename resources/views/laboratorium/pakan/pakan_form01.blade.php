<section class="content-header">
    <h1>
        <a href="#" class="tombol-kembali"><i class="fa fa-angle-left" style="font-size: 20pt"></i>&nbsp;Lab-Pakan<a><small> FORM 01 - Penerimaan Contoh</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! URL::to('/lab/pakan') !!}"><i class="fa fa-hospital-o"/>Lab-Pakan</a></li>
        <li class="breadcrumb-item active">FORM 01</li>
    </ol>
</section>
<form id="form-pakan" method="POST" action="/lab/pakan/create" class="validation-wizard wizard-circle" enctype="multipart/form-data">
@csrf
<input type="hidden" id="id" name="id" value="{!! @$id?$pakan->id:0 !!}">
<section class="content">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">FORM 01 - Penerimaan Contoh</h4>
                    <ul class="box-controls pull-right">
                      <li><a class="box-btn-fullscreen" href="#"></a></li>
                      <li><a class="box-btn-slide" href="#"></a></li>   
                    </ul>
                </div>
                <div class="box-body wizard-content">
                    <section>
                        <div class="form-group row">
                            <label for="no_epid" class="col-sm-2 col-form-label" style="font-weight:bold;text-align:right;">No. EPID :</label>
                            @if($id==0)
                                <div class="col-sm-2">
                                    <select name="status_epid" id="status_epid" class="form-control" placeholder="- Status EPID -">
                                        <option value="">- Status EPID -</option>
                                        <option value="ES" {{ (isset($pakan) && $pakan->status_epid == 'ES') ? 'selected' : '' }}>ES (Pasif)</option>
                                        <option value="ED" {{ (isset($pakan) && $pakan->status_epid == 'ED') ? 'selected' : '' }}>ED (Aktif)</option>
                                    </select>
                                </div>
                            @endif
                            <div class="col-sm-5">
                                <input type="text" name="no_epid" id="no_epid" class="form-control" placeholder="Inputkan Nomor EPID" style="font-weight:bold;" value="{{ old('no_epid', $pakan->no_epid ?? '') }}" {{ $id ? 'readonly' : '' }}>
                            </div>
                        </div>
                        @if(Auth::user()->view_data > 2)
                            <input type="hidden" name="sub_satuan_kerja_id" value="{!! Auth::user()->sub_satuan_kerja_id !!}">
                        @else
                        <div class="form-group row">
                            <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Laboratorium :</label>
                            <div class="col-sm-10">
                                <select name="sub_satuan_kerja_id" id="sub_satuan_kerja_id" class="form-control col-sm-5">
                                    @foreach($subSatuanKerja as $id => $name)
                                        <option value="{{ $id }}" {{ (isset($pakan) && $pakan->sub_satuan_kerja_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="nama_pengirim_id" class="col-sm-2 col-form-label">Nama Pengirim :</label>
                            <div class="col-sm-10">
                                <select name="nama_pengirim_id" id="nama_pengirim_id" class="form-control col-sm-5">
                                    @foreach($customers as $id => $name)
                                        <option value="{{ $id }}" {{ (isset($pakan) && $pakan->nama_pengirim_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat_pengirim" class="col-sm-2 col-form-label">Alamat Pengirim :</label>
                            <div class="col-sm-10">
                                <input type="text" name="alamat_pengirim" id="alamat_pengirim" class="form-control" placeholder="Alamat Pengirim" readonly value="{{ ($var['method']=='edit' || $var['method']=='show') ? (@$pakan->customer->alamat) : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Contoh :</label>
                            <div class="col-sm-10">
                                <table class="table table-bordered mb-0" id='tabel_contoh'>
                                    <tr>
                                        <!-- <th style="width: 100pt;">Jumlah</th> -->
                                        <th style="width: 220px">Jenis Contoh</th>
                                        <th style="width: 55px">No. Uji</th>
                                        <th style="width: 110px">Kode</th>
                                        <th style="width: 110px">Berat</th>
                                        <th style="width: 150px">Bahan Pakan</th>
                                        <th>Pengujian</th>
                                        <th style="width: 10pt;">#</th>
                                    </tr>
                                    @if($id)
                                        @php
                                            $pakanurut = $pakan->pakanTr->groupBy('urut');
                                        @endphp
                                        @foreach($pakanurut as $key=>$ptr)
                                            <tr class="item-contoh">
                                                <td>                                                    
                                                    <select name="jenis_contoh[]" class="form-control select2">
                                                        @foreach($jenisContoh as $id => $name)
                                                            <option value="{{ $id }}" {{ ($ptr->first()->contoh_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="text-align: center;">
                                                    {!! $id?@$ptr->first()->status_uji." ".@$ptr->first()->no_uji:"-"  !!}
                                                </td>
                                                <td class="center">
                                                    <select name="sni_id[]" class="form-control select2">
                                                        @foreach($sni as $id => $name)
                                                            <option value="{{ $id }}" {{ ($ptr->first()->sni_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="center">
                                                    <input type="text" name="berat_pakan[]" value="{!! @$ptr->first()->berat !!}" class="form-control" style="text-align: right;" />
                                                </td>
                                                <td class="center">
                                                    <input type="text" name="bahan_pakan[]" value="{!! @$ptr->first()->bahan !!}" class="form-control"/>
                                                </td>
                                                <td>                                                    
                                                    <select name="permintaan_uji[][]" class="form-control select2 renumber" multiple="multiple" data-placeholder="Pilih Permintaan Uji">
                                                        @foreach($permintaanUji as $id => $name)
                                                            <option value="{{ $id }}" {{ (isset($ptr) && in_array($id, $ptr->pluck('pengujian_id')->toArray())) ? 'selected' : '' }}>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td class="center delete_contoh"><a class="text-danger" style="cursor:pointer"><i class="fa fa-times-circle"></i></a></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </table>
                                <br>
                                <a href="#" class="btn btn-rounded btn-sm btn-info" id="tambah_contoh">Tambah Contoh</a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kriteria_contoh" class="col-sm-2 col-form-label">Kriteria Contoh :</label>
                            <div class="col-sm-10">
                                <input name="kriteria_contoh" class="with-gap radio-col-blue form-control" type="radio" id="memenuhi" value="MS" {{ (isset($pakan) && $pakan->kriteria_contoh == 'MS') ? 'checked' : '' }}>
                                <label for="memenuhi">Memenuhi Syarat</label>&nbsp;&nbsp;&nbsp;
                                <input name="kriteria_contoh" class="with-gap radio-col-red form-control" type="radio" id="tidak_memenuhi" value="TMS" {{ (isset($pakan) && $pakan->kriteria_contoh == 'TMS') ? 'checked' : '' }}>
                                <label for="tidak_memenuhi">Tidak Memenuhi Syarat</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="peralatan" class="col-sm-2 col-form-label">Peralatan :</label>
                            <div class="col-sm-10">
                                <input name="peralatan" class="with-gap radio-col-blue form-control" type="radio" id="peralatan_mampu" value="Mampu" {{ (isset($pakan) && $pakan->peralatan == 'Mampu') ? 'checked' : '' }}>
                                <label for="peralatan_mampu">Mampu</label>&nbsp;&nbsp;&nbsp;
                                <input name="peralatan" class="with-gap radio-col-red form-control" type="radio" id="peralatan_tidak_mampu" value="Tidak Mampu" {{ (isset($pakan) && $pakan->peralatan == 'Tidak Mampu') ? 'checked' : '' }}>
                                <label for="peralatan_tidak_mampu">Tidak Mampu</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bahan" class="col-sm-2 col-form-label">Bahan :</label>
                            <div class="col-sm-10">
                                <input name="bahan" class="with-gap radio-col-blue form-control" type="radio" id="bahan_mampu" value="Mampu" {{ (isset($pakan) && $pakan->bahan == 'Mampu') ? 'checked' : '' }}>
                                <label for="bahan_mampu">Mampu</label>&nbsp;&nbsp;&nbsp;
                                <input name="bahan" class="with-gap radio-col-red form-control" type="radio" id="bahan_tidak_mampu" value="Tidak Mampu" {{ (isset($pakan) && $pakan->bahan == 'Tidak Mampu') ? 'checked' : '' }}>
                                <label for="bahan_tidak_mampu">Tidak Mampu</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="personil" class="col-sm-2 col-form-label">Personil :</label>
                            <div class="col-sm-10">
                                <input name="personil" class="with-gap radio-col-blue form-control" type="radio" id="personil_mampu" value="Mampu" {{ (isset($pakan) && $pakan->personil == 'Mampu') ? 'checked' : '' }}>
                                <label for="personil_mampu">Mampu</label>&nbsp;&nbsp;&nbsp;
                                <input name="personil" class="with-gap radio-col-red form-control" type="radio" id="personil_tidak_mampu" value="Tidak Mampu" {{ (isset($pakan) && $pakan->personil == 'Tidak Mampu') ? 'checked' : '' }}>
                                <label for="personil_tidak_mampu">Tidak Mampu</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-2 col-form-label">Catatan/Saran :</label>
                            <div class="col-sm-10">
                                <textarea name="catatan" id="catatan" class="form-control" rows="2" placeholder="Catatan/Saran">{{ old('catatan', $pakan->catatan ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_penerimaan" class="col-sm-2 col-form-label">Tanggal Diterima Contoh :</label>
                            <div class="col-sm-4">
                                <input type="text" name="tanggal_penerimaan" id="tanggal_penerimaan" class="form-control" placeholder="Tanggal Diterima Contoh" value="{{ old('tanggal_penerimaan', @$pakan->tanggal_penerimaan==""?date('d-m-Y'):@$pakan->tanggal_penerimaan) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pengirim" class="col-sm-2 col-form-label">Pengirim :</label>
                            <div class="col-sm-10">
                                <input type="text" name="pengirim" id="pengirim" class="form-control col-sm-4" placeholder="Nama Pengirim" value="{{ old('pengirim', $pakan->pengirim ?? '') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penerima" class="col-sm-2 col-form-label">Penerima :</label>
                            <div class="col-sm-10">
                                <input type="text" name="penerima" id="penerima" class="form-control col-sm-4" placeholder="Nama Penerima" value="{{ old('pakan', $pakan->penerima ?? '') }}">
                            </div>
                        </div>
                    </section>
                </div>
                <div class="box-footer flexbox">                     
                    <div class="text-right flex-grow">
                        <a href="#" class="tombol-kembali btn btn-secondary">Kembali</a>
                        <a href="#" style="{!! $id?'':'display: none;' !!}" id="tombol-cetak" target="_blank" class="btn btn-primary">Cetak</a>
                        <a href="#" id="tombol-simpan" class="btn btn-info">Simpan</a>
                        <a id="tombol-form02" href="#" class="btn btn-info">FORM 02</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</form>
<style>
    .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th{
        padding: 0.5rem !important;
    }
</style>
<script>
    $jid = {!! $id?$pakan->id:0 !!};
    $(document).ready(function() {
        $('#tanggal_penerimaan').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });

        @if(!$id)
            $('#tambah_contoh').click();
        @endif

        $('#form-pakan').validate({
            rules: {
                status_epid: "required",
                sub_satuan_kerja_id: "required",
                tanggal_penerimaan: "required",
                'permintaan_uji[]': "required",
                'jenis_contoh[]': "required",
                @if(!$id)
                no_epid: {
                    required: true,
                    remote: {
                        url: "{{ url('lab/checknoepid') }}",
                        type: "post",
                        data: {
                            "kolom" : "no_epid",
                        }
                    }
                },
                @endif
            },
            messages: {
                status_epid: "Kolom status epid harus diisi",
                sub_satuan_kerja_id: "Kolom Laboratorium harus diisi",
                'jenis_contoh[]': "Kolom Jenis Contoh harus diisi",
                no_epid: {
                    required: "Kolom nomor epid harus diisi",
                    remote: "Nomor epid sudah digunakan"
                },
            },
            focusInvalid: false,
            invalidHandler: function(form, validator) {
                // if (!validator.numberOfInvalids())
                //     return;
                $('html, body').animate({
                    scrollTop: $(validator.errorList[0].element).offset().top-100
                }, 1000);
            },
            errorPlacement: function (error, element) {
                    var type = $(element).attr("type");
                    if (type === "radio") {
                        // custom placement
                        error.insertAfter(element).wrap('');
                    } else if(element.hasClass('select2') && element.next('.select2-container').length) {
                        error.insertAfter(element.next('.select2-container')).wrap('<li/>');
                    } else {
                        error.insertAfter(element).wrap('');
                    }
                },
        });
        $('.select2').select2();
    });

    $('#nama_pengirim_id').on('change',function(){
        var  customerId = $(this).val();
        $.ajax({
            method : 'get',
            url : "{{ url('/lab/pakan/customer') }}",
            data : 'customerId='+customerId,
        }).done(function (data) {
            $("#alamat_pengirim").val(data.alamat);
        });
    });

    $('#tambah_contoh').on('click', function(){
        $('#tabel_contoh tbody').append(
            '<tr class="item-contoh">'
                +'<td>'
                    +'<select name="jenis_contoh[]" class="form-control select2">'
                        +'@foreach($jenisContoh as $id => $name)'
                            +'<option value="{{ $id }}">{{ $name }}</option>'
                        +'@endforeach'
                    +'</select>'
                +'</td>'
                +'<td style="text-align: center;">-</td>'
                +'<td class="center">'
                    +'<select name="sni_id[]" class="form-control select2">'
                        +'@foreach($sni as $id => $name)'
                            +'<option value="{{ $id }}">{{ $name }}</option>'
                        +'@endforeach'
                    +'</select>'
                +'</td>'
                +'<td class="center"><input type="text" name="berat_pakan[]" value="" class="form-control" style="text-align: right;" /></td>'
                +'<td class="center"><input type="text" name="bahan_pakan[]" value="" class="form-control"/></td>'
                +'<td>'
                    +'<select name="permintaan_uji[][]" class="form-control select2 renumber" multiple="multiple" data-placeholder="Pilih Permintaan Uji">'
                        +'@foreach($permintaanUji as $id => $name)'
                            +'<option value="{{ $id }}">{{ $name }}</option>'
                        +'@endforeach'
                    +'</select>'
                +'</td>'
                +'<td class="center delete_contoh"><a class="text-danger" style="cursor:pointer"><i class="fa fa-times-circle"></i></a></td>'
            +'</tr>'
        );
        $('.select2').select2();
        renumber_blocks();
    });

    $('#tabel_contoh').on('click','.delete_contoh', function(){
        $(this).parent().remove();
    });

    $("#status_epid").change(function(){
        var status = $(this).val()!=""?$(this).val()+'.':null;
        $("#no_epid").val(status);
    });

    $('.tombol-kembali').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/pakan');
    });

    $('#tombol-simpan').click(function(e){
        $preloader.fadeIn();
        renumber_blocks();
        store(function(result) {
        });
        $preloader.fadeOut();
    });

    $('#tombol-form02').click(function(e){
        renumber_blocks();
        $preloader.fadeIn();
        store(function(result) {
            if(result=="1"){
                gotoUrl('/lab/pakan/'+$jid+'/form02');
            }else{
                $preloader.fadeOut();
            }
        });
    });

    function store(callback) {
        var formData = new FormData($('#form-pakan')[0]);
        if($('#form-pakan').valid()){
            $.ajax({
                url : "{{ url('lab/pakan/form01') }}",
                type : 'POST',
                data : formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                },
                success:function(data){
                    $preloader.fadeOut();
                    if(data.kode == 1){
                        notif("Suksess!", data.pesan,'success');
                        $jid=data.id;
                        $('#id').val($jid);
                        $('#tombol-cetak').show();
                    }else{
                        notif("Fafal!", data.pesan,'error');
                    }
                    callback(data.kode);
                }
            });
        }else{
            callback(0);
        }
    }

    $('#tombol-cetak').on('click', function(){
        var win = window.open('{!! URL::to('') !!}/lab/pakan/'+$jid+'/cetak01', '_blank');
        if (win) {
            win.focus();
        } else {
            alert('Please allow popups for this website');
        }
    });

    function renumber_blocks() {
        $("#tabel_contoh").find($('.item-contoh')).each(function(index) {
            var prefix = "permintaan_uji["+index+"][]";
            
            $(this).find($('.renumber')).each(function() {
                $(this).attr('name',prefix);
            });
        });
        return false;
    }
</script>