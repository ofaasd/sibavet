<section class="content-header">
    <h1>
        <a href="#" class="tombol-home"><i class="fa fa-angle-left" style="font-size: 20pt"></i>&nbsp;Lab-Pakan<a><small> FORM 03 - SURAT PENGANTAR PENGIRIMAN CONTOH KE LABORATORIUM</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! URL::to('/lab/pakan') !!}"><i class="fa fa-hospital-o"/>Lab-Pakan</a></li>
        <li class="breadcrumb-item active">FORM 03</li>
    </ol>
</section>
{!! Form::model($pakan,['id'=>'form-pakan', 'method'=>'POST', 'url'=>'/lab/pakan/create', 'class'=>'validation-wizard wizard-circle', 'files'=>true]) !!}
@csrf
<input type="hidden" id="id" name="id" value="{!! $pakan->id !!}">
<section class="content">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">FORM 03 - SURAT PENGANTAR PENGIRIMAN CONTOH KE LABORATORIUM <b>{!! $pakan->no_epid !!}</b></h4>
                    <ul class="box-controls pull-right">
                      <li><a class="box-btn-fullscreen" href="#"></a></li>
                      <li><a class="box-btn-slide" href="#"></a></li>   
                    </ul>
                </div>
                <div class="box-body wizard-content">
                    <section>
                        <div class="form-group row">
                            {!! Form::label('no_epid', 'No. EPID :', ['class' => 'col-sm-2 col-form-label', 'style' => 'font-weight:bold;']) !!}
                            <div class="col-sm-2">
                                {!! Form::text('no_epid', null, ['class'=>'form-control', 'style'=> 'font-weight:bold;','readonly']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('sub_satuan_kerja_id', 'Nama Laboratorium :', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-7">
                                <input class="form-control" readonly="" type="text" value="{!! $pakan->subSatuankerja->sub_satuan_kerja !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('tanggal_penerimaan', 'Tanggal Diterima Contoh :', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-4">
                                <input class="form-control" readonly="" type="text" value="{!! $pakan->tanggal_penerimaan !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('', 'Contoh :', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-8">
                                <table class="table table-bordered mb-0" id='tabel_contoh'>
                                    <tr>
                                        <th style="width: 20pt;">NO</th>
                                        <th style="">JENIS</th>
                                        <th >PENGUJIAN</th>
                                    </tr>
                                    @php
                                        $pakangroup = $pakan->pakanTr->groupBy('urut');
                                    @endphp
                                    @foreach($pakangroup as $key=>$contoh)
                                    @php
                                        $pkn = $contoh->first();
                                    @endphp
                                    <tr>
                                        <td class="center">{!! $key+1 !!}</td>
                                        <td class="">{!! @$pkn->contoh->nama_sampel !!}</td>
                                        <td class="">{!! @$contoh->implode('pengujian.jenis_pengujian',", ") !!}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('seksi_laboratorium_id', 'Seksi Laboratorium', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-10">
                                {!! viewSelectSeksiLab(2,'seksi_laboratorium_id',$pakan->seksi_laboratorium_id) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('manajer_teknis', 'Manajer Teknis :', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-10">
                                {!! viewSelectPegawai(2,'manajer_teknis',$pakan->manajer_teknis) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('catatan_03', 'Catatan/Saran :', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('catatan_03', $pakan->catatan_03, array('class'=> 'form-control', 'rows' => '2','placeholder'=>'Catatan/Saran')) !!}
                            </div>
                        </div>
                    </section>
                </div>
                <div class="box-footer flexbox">                     
                    <div class="text-right flex-grow">
                        <a href="#" class="btn tombol-kembali btn-secondary">Kembali</a>
                        <a href="{!! URL::to('/lab/pakan/'.$pakan->id.'/cetak03') !!}" id="tombol-cetak" target="_blank" class="btn btn-primary">Cetak</a>
                        <a id="tombol-simpan" href="#" class="btn btn-info">Simpan</a>
                        <a id="tombol-form04" href="#" class="btn btn-info">FORM 04</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{!! Form::close() !!}
<script>
    $(document).ready(function(){
        $('#form-pakan').validate({
            rules: {
                seksi_laboratorium_id: "required",
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


    $('.tombol-kembali').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/pakan/{!! $pakan->id !!}/form02');
    });


    $('.tombol-home').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/pakan');
    });

    $('#tombol-simpan').click(function(e){
        $preloader.fadeIn();
        store(function(result) {
            $preloader.fadeOut();
        });
    });

    $('#tombol-form04').click(function(e){
        $preloader.fadeIn();
        store(function(result) {
            if(result==1){
                gotoUrl('/lab/pakan/{!! $pakan->id !!}/form04');
            }
            $preloader.fadeOut();
        });
    });

    function store(callback) {
        var formData = new FormData($('#form-pakan')[0]);
        if($('#form-pakan').valid()){
            $.ajax({
                url : "{{ url('lab/pakan/form03') }}",
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