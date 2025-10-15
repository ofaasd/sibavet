<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <a href="#" class="tombol-kembali"><i class="fa fa-angle-left" style="font-size: 20pt"></i>&nbsp;Lab-Keswan<a><small> FORM 01 - Penerimaan Contoh</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! URL::to('/lab/keswan') !!}"><i class="fa fa-hospital-o"/>Lab-Keswan</a></li>
        <li class="breadcrumb-item active">FORM 01</li>
    </ol>
</section>
<form id="form-keswan" method="POST" action="/lab/keswan/create" class="validation-wizard wizard-circle" enctype="multipart/form-data">

@csrf
<input type="hidden" id="id" name="id" value="{!! @$id?$keswan->id:0 !!}">
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
                                <div class="col-sm-2">
                                    <select name="status_epid" id="status_epid" class="form-control" placeholder="- Status EPID -">
                                        <option value="">- Status EPID -</option>
                                        <option value="ES" {{ (isset($keswan) && $keswan->status_epid == 'ES') ? 'selected' : '' }}>ES (Pasif)</option>
                                        <option value="ED" {{ (isset($keswan) && $keswan->status_epid == 'ED') ? 'selected' : '' }}>ED (Aktif)</option>
                                    </select>
                                    
                                </div>
                            <div class="col-sm-5">
                                <input type="text" name="no_epid" id="no_epid" class="form-control" placeholder="Inputkan Nomor EPID" style="font-weight:bold;" value="{{ old('no_epid', $keswan->no_epid ?? '') }}" {{ $id ? 'readonly' : '' }}>
                            </div>
                        </div>
                        @if(Auth::user()->view_data > 2)
                            <input type="hidden" name="sub_satuan_kerja_id" value="{!! Auth::user()->sub_satuan_kerja_id !!}">
                        @else
                        <div class="form-group row">
                            <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Laboratorium :</label>
                            <div class="col-sm-10">                                
                                {!! viewSelectLab(1, 'sub_satuan_kerja_id', isset($keswan) ? $keswan->sub_satuan_kerja_id : '', 'col-sm-5') !!}
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <label for="nama_pengirim_id" class="col-sm-2 col-form-label">Nama Pengirim :</label>
                            <div class="col-sm-10">
                                {!! viewSelectCustomer('nama_pengirim_id', isset($keswan) ? $keswan->nama_pengirim_id : '', 'col-sm-5') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat_pengirim" class="col-sm-2 col-form-label">Alamat Pengirim :</label>
                            <div class="col-sm-10">
                                <input type="text" name="alamat_pengirim" id="alamat_pengirim" class="form-control" placeholder="Alamat Pengirim" readonly value="{{ !empty($var) && ($var['method']=='edit' || $var['method']=='show') ? (@$keswan->customer->alamat) : '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jenis_hewan_id" class="col-sm-2 col-form-label">Jenis Hewan :</label>
                            <div class="col-sm-10">
                                {!! viewSelectSpesies(1, 'jenis_hewan_id', isset($keswan) ? $keswan->jenis_hewan_id : '', 'col-sm-4') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Contoh :</label>
                            <div class="col-sm-10">
                                <table class="table table-bordered mb-0" id='tabel_contoh'>
                                    <tr>
                                        <th style="width: 100pt;">Jumlah</th>
                                        <th>Jenis Contoh</th>
                                        <th style="width: 20pt;">#</th>
                                    </tr>
                                    @if($id)
                                        @foreach($keswan->labContoh as $contoh)
                                            <tr>
                                                <td class="center"><input class="form-control" value="{{ $contoh->pcontoh->jumlah }}" name="jumlah_contoh[]" type="number" style="text-align: center;"/></td>
                                                <td>
                                                    {!! viewSelectJenisContoh(1, 'jenis_contoh[]', $contoh->jenis_contoh_id, 'select2') !!}
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
                        <div id="areaJenisPengujian">
                            <div class="form-group row">
                                <label for="permintaan_uji[]" class="col-sm-2 col-form-label">Permintaan Uji :</label>
                                <div class="col-sm-10">                                    
                                    {!! viewSelectPermintaanUji(1, 'permintaan_uji[]', $id ? $keswan->labPengujian->pluck('permintaan_uji_id')->toArray() : [], 'select2') !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kriteria_contoh" class="col-sm-2 col-form-label">Kriteria Contoh :</label>
                            <div class="col-sm-10">
                                <input name="kriteria_contoh" class="with-gap radio-col-blue form-control" type="radio" id="memenuhi" value="MS" {{ (isset($keswan) && $keswan->kriteria_contoh == 'MS') ? 'checked' : '' }}>
                                <label for="memenuhi">Memenuhi Syarat</label>&nbsp;&nbsp;&nbsp;
                                <input name="kriteria_contoh" class="with-gap radio-col-red form-control" type="radio" id="tidak_memenuhi" value="TMS" {{ (isset($keswan) && $keswan->kriteria_contoh == 'TMS') ? 'checked' : '' }}>
                                <label for="tidak_memenuhi">Tidak Memenuhi Syarat</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="peralatan" class="col-sm-2 col-form-label">Peralatan :</label>
                            <div class="col-sm-10">
                                <input name="peralatan" class="with-gap radio-col-blue form-control" type="radio" id="peralatan_mampu" value="Mampu" {{ (isset($keswan) && $keswan->peralatan == 'Mampu') ? 'checked' : '' }}>
                                <label for="peralatan_mampu">Mampu</label>&nbsp;&nbsp;&nbsp;
                                <input name="peralatan" class="with-gap radio-col-red form-control" type="radio" id="peralatan_tidak_mampu" value="Tidak Mampu" {{ (isset($keswan) && $keswan->peralatan == 'Tidak Mampu') ? 'checked' : '' }}>
                                <label for="peralatan_tidak_mampu">Tidak Mampu</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bahan" class="col-sm-2 col-form-label">Bahan :</label>
                            <div class="col-sm-10">
                                <input name="bahan" class="with-gap radio-col-blue form-control" type="radio" id="bahan_mampu" value="Mampu" {{ (isset($keswan) && $keswan->bahan == 'Mampu') ? 'checked' : '' }}>
                                <label for="bahan_mampu">Mampu</label>&nbsp;&nbsp;&nbsp;
                                <input name="bahan" class="with-gap radio-col-red form-control" type="radio" id="bahan_tidak_mampu" value="Tidak Mampu" {{ (isset($keswan) && $keswan->bahan == 'Tidak Mampu') ? 'checked' : '' }}>
                                <label for="bahan_tidak_mampu">Tidak Mampu</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="personil" class="col-sm-2 col-form-label">Personil :</label>
                            <div class="col-sm-10">
                                <input name="personil" class="with-gap radio-col-blue form-control" type="radio" id="personil_mampu" value="Mampu" {{ (isset($keswan) && $keswan->personil == 'Mampu') ? 'checked' : '' }}>
                                <label for="personil_mampu">Mampu</label>&nbsp;&nbsp;&nbsp;
                                <input name="personil" class="with-gap radio-col-red form-control" type="radio" id="personil_tidak_mampu" value="Tidak Mampu" {{ (isset($keswan) && $keswan->personil == 'Tidak Mampu') ? 'checked' : '' }}>
                                <label for="personil_tidak_mampu">Tidak Mampu</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-2 col-form-label">Catatan/Saran :</label>
                            <div class="col-sm-10">
                                <textarea name="catatan" id="catatan" class="form-control" rows="2" placeholder="Catatan/Saran">{{ old('catatan', $keswan->catatan ?? '') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_penerimaan" class="col-sm-2 col-form-label">Tanggal Diterima Contoh :</label>
                            <div class="col-sm-4">
                                <input type="text" name="tanggal_penerimaan" id="tanggal_penerimaan" class="form-control" placeholder="Tanggal Diterima Contoh" value="{{ old('tanggal_penerimaan', @$keswan->tanggal_penerimaan==""?date('d-m-Y'):@$keswan->tanggal_penerimaan) }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pengirim" class="col-sm-2 col-form-label">Pengirim :</label>
                            <div class="col-sm-10">
                                <input type="text" name="pengirim" id="pengirim" class="form-control col-sm-4" placeholder="Nama Pengirim" value="{{ old('pengirim', $keswan->pengirim ?? '') }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penerima" class="col-sm-2 col-form-label">Penerima :</label>
                            <div class="col-sm-10">
                                <input type="text" name="penerima" id="penerima" class="form-control col-sm-4" placeholder="Nama Penerima" value="{{ old('penerima', $keswan->penerima ?? '') }}">
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
<script>
    $jid = {!! $id?$keswan->id:0 !!};
    $(document).ready(function() {
        $('#tanggal_penerimaan').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });

        @if(!$id)
            $('#tambah_contoh').click();
        @endif

        $('#form-keswan').validate({
            rules: {
                status_epid: "required",
                sub_satuan_kerja_id: "required",
                jenis_hewan_id: "required",
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
            url : "{{ url('/lab/keswan/customer') }}",
            data : 'customerId='+customerId,
        }).done(function (data) {
            $("#alamat_pengirim").val(data.alamat);
        });
    });

    $('#tambah_contoh').on('click', function(){
        $('#tabel_contoh tbody').append(
            '<tr>'
                +'<td class="center"><input class="form-control" value="1" name="jumlah_contoh[]" type="number" style="text-align: center;"/></td>'
                +'<td>'
                    +'<select name="jenis_contoh[]" class="form-control select2">'
                        +'@foreach($jenisContoh as $id => $name)'
                            +'<option value="{{ $id }}">{{ $name }}</option>'
                        +'@endforeach'
                    +'</select>'
                +'</td>'
                +'<td class="center delete_contoh"><a class="text-danger" style="cursor:pointer"><i class="fa fa-times-circle"></i></a></td>'
            +'</tr>'
        );
        $('.select2').select2();
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
        gotoUrl('/lab/keswan');
    });

    $('#tombol-simpan').click(function(e){
        $preloader.fadeIn();
        store(function(result) {
            $preloader.fadeOut();
        });
    });

    $('#tombol-form02').click(function(e){
        $preloader.fadeIn();
        store(function(result) {
            if(result=="1"){
                gotoUrl('/lab/keswan/'+$jid+'/form02');
            }else{
                $preloader.fadeOut();
            }
        });
    });

    function store(callback) {
        var formData = new FormData($('#form-keswan')[0]);
        if($('#form-keswan').valid()){
            $.ajax({
                url : "{{ url('lab/keswan/form01') }}",
                type : 'POST',
                data : formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                },
                success:function(data){
                    $preloader.fadeOut();
                    if(data.kode == 0){
                        notif("Fafal!", data.pesan,'error');
                    }else{
                        notif("Suksess!", data.pesan,'success');
                        $jid=data.id;
                        $('#id').val($jid);
                        $('#tombol-cetak').show();
                    }
                    callback(data.kode);
                }
            });
        }else{
            callback(0);
        }
    }

    $('#tombol-cetak').on('click', function(){
        var win = window.open('{!! URL::to('') !!}/lab/keswan/'+$jid+'/cetak01', '_blank');
        if (win) {
            win.focus();
        } else {
            alert('Please allow popups for this website');
        }
    });
</script>