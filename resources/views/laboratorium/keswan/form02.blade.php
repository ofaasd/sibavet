<section class="content-header">
    <h1>
        <a href="#" class="tombol-home"><i class="fa fa-angle-left" style="font-size: 20pt"></i>&nbsp;Lab-Keswan<a><small> FORM 02 - PENOMORAN CONTOH</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! URL::to('/lab/keswan') !!}"><i class="fa fa-hospital-o"/>Lab-Keswan</a></li>
        <li class="breadcrumb-item active">FORM 02</li>
    </ol>
</section>
<form id="form-keswan" method="POST" action="/lab/keswan/create" class="validation-wizard wizard-circle" enctype="multipart/form-data">
@csrf
<input type="hidden" id="id" name="id" value="{!! $keswan->id !!}">
<section class="content">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">FORM 02 - PENOMORAN CONTOH <b>{!! $keswan->no_epid !!}</b></h4>
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
                                <input type="text" name="no_epid" id="no_epid" class="form-control" style="font-weight:bold;" value="{{ $keswan->no_epid ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Laboratorium :</label>
                            <div class="col-sm-7">
                                <input class="form-control" readonly type="text" value="{{ $keswan->subSatuankerja->sub_satuan_kerja }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="permintaan_uji" class="col-sm-2 col-form-label" style="font-weight:bold;">Permintaan Uji :</label>
                            <div class="col-sm-10">
                                @php
                                $pengujian = "";
                                foreach($keswan->labPengujian as $key=>$uji){
                                        $pengujian .= ($key==0?'':', ').$uji->jenis_pengujian;
                                }
                                @endphp                                
                                <textarea class="form-control" rows="2" readonly>{{ $pengujian }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Contoh :</label>
                            <div class="col-sm-10">
                                <table class="table table-bordered mb-0" id='tabel_contoh'>
                                    <tr>
                                        <th style="width: 20pt;">NO</th>
                                        <th style="">JENIS</th>
                                        <th style="width: 40pt;">JUMLAH</th>
                                        <th style="width: 20%;">NOMOR ASAL</th>
                                        <th style="width: 20%;">NOMOR BARU</th>
                                    </tr>
                                    @foreach($keswan->labContoh as $key=>$contoh)
                                    <tr>
                                        <td class="center">{!! $key+1 !!}</td>
                                        <td class="">{!! $contoh->nama_sampel !!}</td>
                                        <td class="center">{!! $contoh->pcontoh->jumlah !!}</td>
                                        <td class="center">                                            
                                            <input class="penomoran form-control" value="{!! @$contoh->pcontoh->nomor_asal !!}" name="nomor_asal[{{ $contoh->id }}]" type="text" style="text-align: center;"/>
                                        </td>
                                        <td class="center">                                            
                                            <input class="penomoran form-control" value="{!! @$contoh->pcontoh->nomor_baru !!}" name="nomor_baru[{{ $contoh->id }}]" type="text" style="text-align: center;"/>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="asal_contoh_id" class="col-sm-2 col-form-label">Asal Contoh</label>
                            <div class="col-sm-10">
                                {!! viewSelectKota('asal_contoh_id', isset($keswan) ? $keswan->asal_contoh_id : '', 'col-sm-5') !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penerima_02" class="col-sm-2 col-form-label">Petugas penerima contoh :</label>
                            <div class="col-sm-10">
                                <input type="text" name="penerima_02" id="penerima_02" class="form-control" value="{{ $keswan->penerima_02 ?? '' }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan_02" class="col-sm-2 col-form-label">Catatan/Saran :</label>
                            <div class="col-sm-10">
                                <textarea name="catatan_02" id="catatan_02" class="form-control" rows="2" placeholder="Catatan/Saran">{{ $keswan->catatan_02 ?? '' }}</textarea>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="box-footer flexbox">                     
                    <div class="text-right flex-grow">
                        <a href="#" class="tombol-kembali btn btn-secondary">Kembali</a>
                        <a href="{!! URL::to('/lab/keswan/'.$keswan->id.'/cetak02') !!}" id="tombol-cetak" target="_blank" class="btn btn-primary">Cetak</a>
                        <a id="tombol-simpan" href="#" class="btn btn-info">Simpan</a>
                        <a id="tombol-form03" href="#" class="btn btn-info">FORM 03</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
</form>
<script>
    $(document).ready(function() {
        $('#form-keswan').validate({
            rules: {
                asal_contoh_id: "required",
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

        jQuery.validator.addClassRules('penomoran', {
            required: true /*,
            other rules */
        });

        $('.select2').select2();
    });


    $('.tombol-kembali').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/keswan/{!! $keswan->id !!}/form01');
    });


    $('.tombol-home').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/keswan');
    });

    $('#tombol-simpan').click(function(e){
        $preloader.fadeIn();
        store(function(result) {
            $preloader.fadeOut();
        });
    });

    $('#tombol-form03').click(function(e){
        $preloader.fadeIn();
        store(function(result) {
            if(result==1){
                gotoUrl('/lab/keswan/{!! $keswan->id !!}/form03');
                $preloader.fadeOut();
            }else{
                $preloader.fadeOut();
            }
        });
    });

    function store(callback) {
        var formData = new FormData($('#form-keswan')[0]);
        if($('#form-keswan').valid()){
            $.ajax({
                url : "{{ url('lab/keswan/form02') }}",
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
                        notif("Fafal!", data.pesan,'error')
                    }else{
                        notif("Suksess!", data.pesan,'success')
                    }
                    callback(data.kode);
                }
            });
        }else{
            callback(0);
        }
    }
</script>