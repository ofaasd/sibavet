<section class="content-header">
    <h1>
        <a href="#" class="tombol-home"><i class="fa fa-angle-left" style="font-size: 20pt"></i>&nbsp;Lab-Pakan<a> <small> FORM HASIL PENGUJIAN</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! URL::to('/lab/pakan') !!}"><i class="fa fa-hospital-o"/>Lab-Pakan</a></li>
        <li class="breadcrumb-item active">HASIL PENGUJIAN</li>
    </ol>
</section>
<form id="form-pakan" method="POST" action="/lab/pakan/create" class="validation-wizard wizard-circle" enctype="multipart/form-data">
@csrf
<input type="hidden" id="id" name="id" value="{!! $pakan->id !!}">
<section class="content">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">FORM HASIL PENGUJIAN <b>{!! $pakan->no_epid !!}</b></h4>
                    <ul class="box-controls pull-right">
                      <li><a class="box-btn-fullscreen" href="#"></a></li>
                      <li><a class="box-btn-slide" href="#"></a></li>   
                    </ul>
                </div>
                <div class="box-body wizard-content">
                    <section>
                        <div class="form-group row">
                            <label for="no_epid" class="col-sm-2 col-form-label" style="font-weight:bold;">No. EPID :</label>
                            <div class="col-sm-2">                                
                                <input type="text" name="no_epid" id="no_epid" class="form-control" style="font-weight:bold;" value="{{ $pakan->no_epid ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Laboratorium :</label>
                            <div class="col-sm-7">
                                <input class="form-control" readonly type="text" value="{!! $pakan->subSatuankerja->sub_satuan_kerja !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="seksi_laboratorium_id" class="col-sm-2 col-form-label">Seksi Laboratorium</label>
                            <div class="col-sm-7">
                                <input class="form-control" readonly type="text" value="{!! @$pakan->seksiLaboratorium->kode !!} - {!! @$pakan->seksiLaboratorium->seksi_laboratorium !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_penerimaan" class="col-sm-2 col-form-label">Tanggal Diterima Contoh :</label>
                            <div class="col-sm-4">
                                <input class="form-control" readonly type="text" value="{!! $pakan->tanggal_penerimaan !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penguji_ditunjuk" class="col-sm-2 col-form-label">Penguji yang Ditunjuk</label>
                            <div class="col-sm-10">
                                <input type="text" name="penguji_ditunjuk" id="penguji_ditunjuk" class="form-control" value="{{ $pakan->penguji_ditunjuk ?? '' }}" readonly placeholder="Inputkan Penguji yang Ditunjuk">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Hasil Pengujian :</label>
                            <div class="col-sm-10">
                                @php
                                    $pakangroup = $pakan->pakanTr->groupBy('urut');
                                @endphp
                                @foreach($pakangroup as $keygroup => $pakang)
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <th rowspan="2">Jenis Contoh</th>
                                        @php($pak = [])
                                        @foreach($pakang as $key=>$pkn)
                                            <th colspan="2">{!! @$pkn->pengujian->jenis_pengujian !!}</th>
                                            @php($pak[$key]=$pkn->id)
                                        @endforeach
                                    </tr>
                                    <tr>
                                    @for($i=0;$i<=$key;$i++)
                                        <th>SNI</th>
                                        <th>Nilai</th>
                                    @endfor
                                    </tr>
                                    <tr>
                                        <td>{!! $pakang[0]->contoh->nama_sampel !!}</td>
                                        @for($i=0;$i<=$key;$i++)
                                            <td><input nilai="0" class="form-control penomoran hasil" value="{!! @$pakang[$i]->sni !!}" name="hasil[{!! $pak[$i] !!}][0]" type="text" style="text-align: center;"/></td>
                                            <td><input nilai="0" class="form-control penomoran hasil" value="{!! @$pakang[$i]->nilai !!}" name="hasil[{!! $pak[$i] !!}][1]" type="text" style="text-align: center;"/></td>
                                        @endfor
                                    </tr>
                                </table>
                                @endforeach
                                <br>
                                <br>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan_hasil" class="col-sm-2 col-form-label">Catatan/Saran :</label>
                            <div class="col-sm-10">
                                <textarea name="catatan_hasil" id="catatan_hasil" class="form-control" rows="2" placeholder="Catatan/Saran">{{ $pakan->catatan_hasil ?? '' }}</textarea>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="box-footer flexbox">                     
                    <div class="text-right flex-grow">
                        <a  href="#" class="btn tombol-kembali btn-secondary">Kembali</a>
                        <a href="{!! URL::to('/lab/pakan/'.$pakan->id.'/cetakhasil') !!}" id="tombol-cetak" target="_blank" class="btn btn-primary">Cetak</a>
                        <a id="tombol-simpan" href="#" class="btn btn-info">Simpan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
</form>
<script>
    var jumlah_contoh = {!! $jumlah_contoh !!};

    $(document).ready(function(){
         $('#form-pakan').validate({
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

        jQuery.validator.addClassRules('penomoran', {
            required: true
        });


        $('.select2').select2();
    });

    $('#konten_utama').on('change','.hasil', function(){
        var classname = 'hasilkey'+$(this).attr('indx');
        sumClass(classname, function(result) {
            if(result!=jumlah_contoh){
            // if(result!=jumlah_contoh && result !=0){
                $('.'+classname).addClass('field-salah');
            }else{
                $('.'+classname).removeClass('field-salah');
            }
        });
    });

    $('.tombol-kembali').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/pakan/{!! $pakan->id !!}/form04');
    });


    $('.tombol-home').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/pakan');
    });

    $('#tombol-simpan').click(function(e){
        $preloader.fadeIn();
        store(function(result) {
            if(result==1){
                $preloader.fadeOut();
            }else{
                $preloader.fadeOut();
                notif("Gagal!", "Periksa kembali isian.!",'error')
            }
        });
    });

    function store(callback) {
        var formData = new FormData($('#form-pakan')[0]);
        if(!$('.hasil').hasClass('field-salah')){
            $.ajax({
                url : "{{ url('lab/pakan/formhasil') }}",
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
                        notif("Suksess!", data.pesan,'success')
                    }else{
                        notif("Gagal!", data.pesan,'error')
                    }
                    callback(data.kode);
                }
            });
            callback(1);
        }else{
            callback(0);
        }
      
    }
</script>