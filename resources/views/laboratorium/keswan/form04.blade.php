<section class="content-header">
    <h1>
        <a href="#" class="tombol-home"><i class="fa fa-angle-left" style="font-size: 20pt"></i>&nbsp;Lab-Keswan<a><small> FORM 04 - PERINTAH PENGUJIAN</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! URL::to('/lab/keswan') !!}"><i class="fa fa-hospital-o"/>Lab-Keswan</a></li>
        <li class="breadcrumb-item active">FORM 04</li>
    </ol>
</section>
{!! Form::model($keswan,['id'=>'form-keswan', 'method'=>'POST', 'url'=>'/lab/keswan/create', 'class'=>'validation-wizard wizard-circle', 'files'=>true]) !!}
@csrf
<input type="hidden" id="id" name="id" value="{!! $keswan->id !!}">
<section class="content">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">FORM 04 - PERINTAH PENGUJIAN <b>{!! $keswan->no_epid !!}</b></h4>
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
                                <input class="form-control" readonly="" type="text" value="{!! $keswan->subSatuankerja->sub_satuan_kerja !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('seksi_laboratorium_id', 'Seksi Laboratorium', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-7">
                                <input class="form-control" readonly="" type="text" value="{!! @$keswan->seksiLaboratorium->kode !!} - {!! @$keswan->seksiLaboratorium->seksi_laboratorium !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('tanggal_penerimaan', 'Tanggal Diterima Contoh :', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-4">
                                <input class="form-control" readonly="" type="text" value="{!! $keswan->tanggal_penerimaan !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('', 'Contoh :', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-8">
                                <table class="table table-bordered mb-0" id='tabel_contoh'>
                                    <tr>
                                        <th style="width: 20pt;">NO</th>
                                        <th style="">JENIS</th>
                                        <th style="width: 40pt;">JUMLAH</th>
                                    </tr>
                                    @foreach($keswan->labContoh as $key=>$contoh)
                                    <tr>
                                        <td class="center">{!! $key+1 !!}</td>
                                        <td class="">{!! $contoh->nama_sampel !!}</td>
                                        <td class="center">{!! $contoh->pcontoh->jumlah !!}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('permintaan_uji', 'Permintaan Uji :', ['class' => 'col-sm-2 col-form-label', 'style' => 'font-weight:bold;']) !!}
                            <div class="col-sm-10">
                                @php
                                $pengujian = "";
                                foreach($keswan->labPengujian as $key=>$uji){
                                        $pengujian .= ($key==0?'':', ').$uji->jenis_pengujian;
                                }
                                @endphp
                                {!! Form::textarea('', $pengujian, array('class'=> 'form-control', 'rows' => '2','readonly')) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('penguji_ditunjuk', 'Penguji yang Ditunjuk', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-10">
                                {!! viewSelectPegawai(1,'penguji_ditunjuk',$keswan->penguji_ditunjuk) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('catatan_04', 'Catatan/Saran :', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('catatan_04', $keswan->catatan_04, array('class'=> 'form-control', 'rows' => '2','placeholder'=>'Catatan/Saran')) !!}
                            </div>
                        </div>
                    </section>
                </div>
                <div class="box-footer flexbox">                     
                    <div class="text-right flex-grow">
                        <a  href="#" class="btn tombol-kembali btn-secondary">Kembali</a>
                        <a href="{!! URL::to('/lab/keswan/'.$keswan->id.'/cetak04') !!}" id="tombol-cetak" target="_blank" class="btn btn-primary">Cetak</a>
                        <a id="tombol-simpan" href="#" class="btn btn-info">Simpan</a>
                        <a id="tombol-formhasil" href="#" class="btn btn-info">FORM HASIL</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{!! Form::close() !!}
<script>
    $(document).ready(function(){
        $('.select2').select2();
    });


    $('.tombol-kembali').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/keswan/{!! $keswan->id !!}/form03');
    });


    $('.tombol-home').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/keswan');
    });

    $('#tombol-simpan').click(function(e){
        $preloader.fadeIn();
        store(function(result) {
            if(result==1){
                $preloader.fadeOut();
            }
        });
    });

    $('#tombol-formhasil').click(function(e){
        $preloader.fadeIn();
        store(function(result) {
            if(result==1){
                gotoUrl('/lab/keswan/{!! $keswan->id !!}/formhasil');
            }
        });
    });

    function store(callback) {
        var formData = new FormData($('#form-keswan')[0]);
        if($('#form-keswan').valid()){
            $.ajax({
                url : "{{ url('lab/keswan/form04') }}",
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