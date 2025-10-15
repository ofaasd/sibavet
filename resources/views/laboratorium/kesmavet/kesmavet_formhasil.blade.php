@php
$a=0;
$b=0;
@endphp
<section class="content-header">
    <h1>
        <a href="#" class="tombol-home"><i class="fa fa-angle-left" style="font-size: 20pt"></i>&nbsp;Lab-Kesmavet<a> <small> FORM HASIL PENGUJIAN</small>
    </h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{!! URL::to('/lab/kesmavet') !!}"><i class="fa fa-hospital-o"/>Lab-Kesmavet</a></li>
        <li class="breadcrumb-item active">HASIL PENGUJIAN</li>
    </ol>
</section>
<form id="form-kesmavet" method="POST" action="/lab/kesmavet/create" class="validation-wizard wizard-circle" enctype="multipart/form-data">
@csrf
<input type="hidden" id="id" name="id" value="{!! $kesmavet->id !!}">
<section class="content">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">FORM HASIL PENGUJIAN <b>{!! $kesmavet->no_epid !!}</b></h4>
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
                                <input type="text" name="no_epid" id="no_epid" class="form-control" style="font-weight:bold;" value="{{ $kesmavet->no_epid ?? '' }}" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sub_satuan_kerja_id" class="col-sm-2 col-form-label">Nama Laboratorium :</label>
                            <div class="col-sm-7">
                                <input class="form-control" readonly="" type="text" value="{!! $kesmavet->subSatuankerja->sub_satuan_kerja !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="seksi_laboratorium_id" class="col-sm-2 col-form-label">Seksi Laboratorium</label>
                            <div class="col-sm-7">
                                <input class="form-control" readonly="" type="text" value="{!! @$kesmavet->seksiLaboratorium->kode !!} - {!! @$kesmavet->seksiLaboratorium->seksi_laboratorium !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal_penerimaan" class="col-sm-2 col-form-label">Tanggal Diterima Contoh :</label>
                            <div class="col-sm-4">
                                <input class="form-control" readonly="" type="text" value="{!! $kesmavet->tanggal_penerimaan !!}">
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('penguji_ditunjuk', 'Penguji yang Ditunjuk', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-10">
                                <input type="text" name="penguji_ditunjuk" id="penguji_ditunjuk" class="form-control" value="{{ $kesmavet->penguji_ditunjuk ?? '' }}" readonly placeholder="Inputkan Penguji yang Ditunjuk">
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('', 'Hasil Pengujian :', ['class' => 'col-sm-2 col-form-label']) !!}
                            <div class="col-sm-10">
                                @if($kesmavet->labPengujian->count()>0)
                                <table class="table table-bordered mb-0">
                                    @foreach($kesmavet->labPengujian as $key=>$uji)
                                        @if($uji->tipe_hasil==0)
                                            @if($a<1)
                                                @php
                                                    $a++;
                                                @endphp
                                                <tr>
                                                    <th style="width: 20pt;">NO</th>
                                                    <th style="">Jenis Pengujian</th>
                                                    <th style="width: 40pt">JUMLAH</th>
                                                    <th style="width: 100pt">K</th>
                                                    <th style="width: 100pt">B</th>
                                                </tr>
                                            @endif
                                        <tr>
                                            <td class="center">{!! $key+1 !!}</td>
                                            <td class="">{!! $uji->jenis_pengujian !!}</td>
                                            <td class="center">{!! $jumlah_contoh !!}</td>
                                            <td class="center"><input nilai="0" class="form-control hasil hasilkey{!! $uji->id !!}" indx="{!! $uji->id !!}" value="{!! @$uji->pPengujian->negatif !!}" name="hasil[{!! $uji->id !!}][negatif]" type="number" style="text-align: center;"/></td>
                                            <td class="center">
                                                <input nilai="0" class="form-control hasil hasilkey{!! $uji->id !!}" indx="{!! $uji->id !!}" value="{!! @$uji->pPengujian->positif !!}" name="hasil[{!! $uji->id !!}][positif]" type="number" style="text-align: center;"/>
                                                <input type="hidden" name="hasil[{!! $uji->id !!}][kelompok_uji]" value="{!! @$uji->seksi_laboratorium_id !!}">
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </table>
                                @endif
                                <br>
                                <table class="table table-bordered mb-0">
                                    @foreach($kesmavet->labPengujian as $key=>$uji)
                                    @if($uji->tipe_hasil==1)
                                        @if($b<1)
                                            @php
                                                $b++;
                                            @endphp
                                            <tr>
                                                <th style="width: 20pt;">NO</th>
                                                <th style="">Jenis Pengujian</th>
                                                <th style="width: 40pt;">JUMLAH</th>
                                                <th style="width: 100pt">Titer 0</th>
                                                <th style="width: 100pt">Titer Rendah</th>
                                                <th style="width: 100pt">Titer Tinggi</th>
                                            </tr>
                                        @endif
                                    <tr>
                                        <td class="center">{!! $key+1 !!}</td>
                                        <td class="">{!! $uji->jenis_pengujian !!}</td>
                                        <td class="center">{!! $jumlah_contoh !!}</td>
                                        <td class="center"><input nilai="0" class="form-control hasil hasilkey{!! $key !!}" indx="{!! $key !!}" value="{!! @$uji->pPengujian->nol !!}" name="hasil[{!! $uji->id !!}][nol]" type="number" style="text-align: center;"/></td>
                                        <td class="center"><input nilai="0" class="form-control hasil hasilkey{!! $key !!}" indx="{!! $key !!}" value="{!! @$uji->pPengujian->rendah !!}" name="hasil[{!! $uji->id !!}][rendah]" type="number" style="text-align: center;"/></td>
                                        <td class="center">
                                            <input nilai="0" class="form-control hasil hasilkey{!! $key !!}" indx="{!! $key !!}" value="{!! @$uji->pPengujian->tinggi !!}" name="hasil[{!! $uji->id !!}][tinggi]" type="number" style="text-align: center;"/>
                                            <input type="hidden" name="hasil[{!! $uji->id !!}][kelompok_uji]" value="{!! @$uji->seksi_laboratorium_id !!}">
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">                            <label for="catatan_hasil" class="col-sm-2 col-form-label">Catatan/Saran :</label>
                            <div class="col-sm-10">
                                <textarea name="catatan_hasil" id="catatan_hasil" class="form-control" rows="2" placeholder="Catatan/Saran">{{ $kesmavet->catatan_hasil ?? '' }}</textarea>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="box-footer flexbox">                     
                    <div class="text-right flex-grow">
                        <a  href="#" class="btn tombol-kembali btn-secondary">Kembali</a>
                        <a href="{!! URL::to('/lab/kesmavet/'.$kesmavet->id.'/cetakhasil') !!}" id="tombol-cetak" target="_blank" class="btn btn-primary">Cetak</a>
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
        gotoUrl('/lab/kesmavet/{!! $kesmavet->id !!}/form04');
    });


    $('.tombol-home').click(function(e){
        $preloader.fadeIn();
        gotoUrl('/lab/kesmavet');
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
        var formData = new FormData($('#form-kesmavet')[0]);
        if(!$('.hasil').hasClass('field-salah')){
            $.ajax({
                url : "{{ url('lab/kesmavet/formhasil') }}",
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